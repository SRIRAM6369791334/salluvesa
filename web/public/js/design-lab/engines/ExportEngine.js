/**
 * ExportEngine — Production-ready checkout: correct payload, response.ok guard,
 * finally-guarded isProcessing, route injection, real size/color, roster quantity.
 * Extends BaseEngine.
 */
class ExportEngine extends DesignLab.BaseEngine {
    constructor(canvasManager, app) {
        super(canvasManager);
        this.app = app;
        this.isProcessing = false;
        this.designId = document.getElementById('design_id')?.value || null;
        this._init();
    }

    /* ── Init ─────────────────────────────────────────────────────── */
    _init() {
        const checkoutBtn = document.getElementById('add-to-cart-btn');
        if (checkoutBtn) {
            checkoutBtn.addEventListener('click', () => this.handleCheckout());
        }

        const saveBtn = document.getElementById('save-design-btn');
        if (saveBtn) {
            saveBtn.addEventListener('click', () => this._saveAsDraft());
        }
    }

    /* ── Checkout flow ────────────────────────────────────────────── */
    async handleCheckout() {
        if (this.isProcessing) return;

        const canvases = this.canvasManager.canvases;
        let totalObjects = 0;
        Object.values(canvases).forEach(c => {
            c.getObjects().forEach(o => { if (!o.isSystem) totalObjects++; });
        });

        if (totalObjects === 0) {
            this.bus.emit('ui:notify', { msg: 'Please add some design elements first!', icon: 'warning' });
            return;
        }

        // App Setting Validation
        const qty = parseInt(document.getElementById('quantity-input')?.value, 10) || 1;
        if (window.__appSetting) {
            const setting = window.__appSetting;
            if (qty < setting.min_quantity) {
                this.bus.emit('ui:notify', { msg: `Minimum ${setting.min_quantity} quantity required for this product.`, icon: 'warning' });
                return;
            }
            if (setting.max_quantity && qty > setting.max_quantity) {
                this.bus.emit('ui:notify', { msg: `Maximum ${setting.max_quantity} quantity allowed for this product.`, icon: 'warning' });
                return;
            }
        }

        this.isProcessing = true;
        this.bus.emit('ui:notify', { msg: 'Preparing design…', icon: 'info' });

        try {
            if (document.fonts?.ready) await document.fonts.ready;

            const designData = await this._prepareDesignData();
            const saveResp = await this._saveDesign(designData);
            if (!saveResp.success) throw new Error(saveResp.message || 'Failed to save design');

            // Use design_id from response, OR fall back to the already-known this.designId
            const resolvedDesignId = saveResp.design_id || this.designId;
            if (!resolvedDesignId) {
                throw new Error('Could not determine design ID — please try again.');
            }

            const cartResp = await this._addToCart(resolvedDesignId);
            if (!cartResp.success) throw new Error(cartResp.message || 'Failed to add to cart');

            this.bus.emit('ui:notify', { msg: 'Redirecting to checkout…', icon: 'success' });
            setTimeout(() => {
                window.location.href = window.__routes?.checkout || '/checkout';
            }, 600);

        } catch (err) {
            console.error('[ExportEngine] Checkout error:', err);
            this.bus.emit('ui:notify', { msg: err.message || 'An error occurred during checkout.', icon: 'error' });
        } finally {
            this.isProcessing = false;
        }
    }

    /* ── Save as draft ────────────────────────────────────────────── */
    async _saveAsDraft() {
        if (this.isProcessing) return;
        this.isProcessing = true;
        try {
            const designData = await this._prepareDesignData();
            designData.status = 'draft';
            await this._saveDesign(designData);
            this.bus.emit('ui:notify', { msg: 'Design saved!', icon: 'success' });
        } catch (err) {
            this.bus.emit('ui:notify', { msg: 'Save failed: ' + err.message, icon: 'error' });
        } finally {
            this.isProcessing = false;
        }
    }

    /* ── Prepare data ─────────────────────────────────────────────── */
    async _prepareDesignData() {
        const canvases = this.canvasManager.canvases;
        const mainCanvas = this.canvasManager.getCanvas();
        const productId = document.getElementById('customproduct_id')?.value;
        const colorId = this.app.productEngine?.activeColorId || null;

        const views = ['front', 'back', 'right-shoulder', 'left-shoulder'];
        const previews = {};
        const canvasJsons = {};

        // Remember starting view to restore it later
        const originalView = this.canvasManager.activeView || 'front';

        try {
            // First loop: Grab canvas JSons so we don't need UI visibility
            for (const view of views) {
                const c = canvases[view];
                if (!c) continue;

                c.discardActiveObject();
                c.renderAll();

                canvasJsons[view] = JSON.stringify(c.toDatalessJSON([
                    'isRosterElement', 'rosterType', 'customType',
                    'excludeFromPrice', 'isSystem', 'customLayer', 'customLabel',
                    'sourcePath', 'layerName'
                ]));
            }

            // Second loop: Capture the actual visual composite using html2canvas
            for (const view of views) {
                const c = canvases[view];
                if (!c) continue;

                const hasObjects = c.getObjects().filter(o => !o.isSystem).length > 0;

                if (hasObjects) {
                    // Switch view to ensure the mockup matches
                    if (this.canvasManager.activeView !== view) {
                        document.querySelector(`.cs_view_btn[data-view="${view}"]`)?.click();
                        // Wait for image and canvas to update
                        await new Promise(r => setTimeout(r, 150));
                    }

                    const container = document.querySelector('.cs_product_display_container');
                    if (container && typeof html2canvas !== 'undefined') {
                        // Temporarily hide UI bounds
                        const helpers = ['.cs_print_area_bound', '.cs_safe_zone', '#print-area-second'];
                        helpers.forEach(selector => {
                            const el = document.querySelector(selector);
                            if (el) el.style.opacity = '0';
                        });

                        const canvasEl = await html2canvas(container, {
                            backgroundColor: null,
                            scale: 1, // keeping payload size manageable
                            useCORS: true,
                            logging: false
                        });

                        previews[view] = canvasEl.toDataURL('image/png', 0.8);

                        // Restore bounds
                        helpers.forEach(selector => {
                            const el = document.querySelector(selector);
                            if (el) el.style.opacity = '1';
                        });
                    } else {
                        // Fallback
                        previews[view] = c.toDataURL({ format: 'png', quality: 1, multiplier: 1 });
                    }
                } else {
                    previews[view] = null;
                }
            }
        } finally {
            // Restore original view
            if (this.canvasManager.activeView !== originalView) {
                document.querySelector(`.cs_view_btn[data-view="${originalView}"]`)?.click();
                await new Promise(r => setTimeout(r, 50));
            }
        }

        // Gather layers
        const layers = [];
        views.forEach(viewKey => {
            const c = canvases[viewKey];
            if (!c) return;
            c.getObjects().forEach((obj, idx) => {
                if (obj.isSystem) return;
                layers.push({
                    layer_type: (obj.type === 'i-text' || obj.type === 'text') ? 'text' : (obj.customType === 'clipart' ? 'icon' : 'image'),
                    text_content: obj.text || null,
                    x_position: obj.left,
                    y_position: obj.top,
                    width: obj.width * (obj.scaleX || 1),
                    height: obj.height * (obj.scaleY || 1),
                    rotation: obj.angle || 0,
                    scale_x: obj.scaleX || 1,
                    scale_y: obj.scaleY || 1,
                    print_position: viewKey,
                    // NEW: Source and Name tracking
                    source_path: obj.sourcePath || null,
                    layer_name: obj.layerName || null,

                    z_index: idx,
                    layer_json: JSON.stringify(obj.toObject([
                        'isRosterElement', 'rosterType', 'customType',
                        'excludeFromPrice', 'isSystem', 'customLabel',
                        'sourcePath', 'layerName'
                    ])),
                });
            });
        });

        return {
            customproduct_id: productId,
            product_color_id: colorId,
            canvas_width: mainCanvas?.width,
            canvas_height: mainCanvas?.height,
            front_canvas_json: canvasJsons.front,
            back_canvas_json: canvasJsons.back,
            right_shoulder_canvas_json: canvasJsons['right-shoulder'],
            left_shoulder_canvas_json: canvasJsons['left-shoulder'],
            front_preview_base64: previews.front,
            back_preview_base64: previews.back,
            right_shoulder_preview_base64: previews['right-shoulder'],
            left_shoulder_preview_base64: previews['left-shoulder'],
            layers,
            design_name: document.getElementById('design-name-input')?.value || 'Untitled Design',
            id: this.designId
        };
    }

    async initDesign() {
        if (this.designId) return this.designId;
        const productId = document.getElementById('customproduct_id')?.value;
        if (!productId) return null;

        try {
            const res = await fetch(window.__routes?.initDesign || '/api/designs/init', {
                method: 'POST',
                headers: this._headers(),
                body: JSON.stringify({ customproduct_id: productId })
            });
            const data = await res.json();
            if (data.success) {
                this.designId = data.design_id;
                document.getElementById('design_id').value = data.design_id;
                return data.design_id;
            }
        } catch (err) {
            console.error('Init Design Error:', err);
        }
        return null;
    }

    /* ── API calls ────────────────────────────────────────────────── */
    async _saveDesign(data) {
        if (!this.designId) await this.initDesign();
        data.id = this.designId;

        const url = this.designId
            ? `${window.__routes?.updateDesign || '/api/designs'}/${this.designId}`
            : (window.__routes?.saveDesign || '/api/designs/save');

        const method = this.designId ? 'PUT' : 'POST';

        const res = await fetch(url, {
            method: method,
            headers: this._headers(),
            body: JSON.stringify(data),
        });
        const result = await res.json().catch(() => ({}));
        if (!res.ok) {
            const msg = result?.message || (result?.errors ? Object.values(result.errors).flat().join(', ') : `Save design failed (HTTP ${res.status})`);
            throw new Error(msg);
        }
        if (result.design_id) {
            this.designId = result.design_id;
            const designIdEl = document.getElementById('design_id');
            if (designIdEl) designIdEl.value = result.design_id;
        }
        return result;
    }

    async _addToCart(designId) {
        const roster = this.app.teamEngine?.getRosterData() || [];
        const quantity = roster.length > 0
            ? roster.length
            : (parseInt(document.getElementById('quantity-input')?.value, 10) || 1);

        const size = this.app.productEngine?.getSelectedSize() || 'M';
        const color = this.app.productEngine?.getSelectedColor() || 'Default';
        const extraPrice = this.app.productEngine?.getExtraPrice() || 0;

        const url = window.__routes?.addToCart || '/cart/add';
        const res = await fetch(url, {
            method: 'POST',
            headers: this._headers(),
            body: JSON.stringify({
                type: 'custom',
                id: document.getElementById('customproduct_id')?.value,
                design_id: designId,
                extra_price: extraPrice,
                quantity,
                size,
                color,
                roster_data: roster,
            }),
        });
        const json = await res.json().catch(() => ({}));
        if (!res.ok) {
            // Surface exact validation message if available
            const msg = json?.message || (json?.errors ? Object.values(json.errors).flat().join(', ') : `Add to cart failed (HTTP ${res.status})`);
            throw new Error(msg);
        }
        return json;
    }

    /* ── Helpers ──────────────────────────────────────────────────── */
    _headers() {
        const csrf = document.querySelector('meta[name="csrf-token"]')?.content;
        if (!csrf) console.warn('[ExportEngine] CSRF token meta tag missing!');
        return {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-CSRF-TOKEN': csrf || ''
        };
    }

    /* ── Cleanup ──────────────────────────────────────────────────── */
    destroy() {
        super.destroy();
    }
}

window.DesignLab = window.DesignLab || {};
window.DesignLab.ExportEngine = ExportEngine;

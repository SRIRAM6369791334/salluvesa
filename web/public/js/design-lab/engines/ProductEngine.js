/**
 * ProductEngine — Product data loading, color/size selection, live pricing.
 * Extends BaseEngine.
 */
class ProductEngine extends DesignLab.BaseEngine {
    constructor(canvasManager, app) {
        super(canvasManager);
        this.app = app;
        this.productData = null;
        this.activeColorId = null;
        this.activeSize = null;

        // Read product ID from DOM — fail hard if missing
        const hiddenInput = document.getElementById('customproduct_id');
        if (!hiddenInput || !hiddenInput.value) {
            this.bus.emit('ui:notify', { msg: 'No product selected. Please go back and choose a product.', icon: 'error' });
            console.error('[ProductEngine] Missing #customproduct_id hidden input.');
            return;
        }
        this.productId = hiddenInput.value; // keep as string (supports UUID)
    }

    /* ── Async init (called from TShirtCustomizer) ────────────────── */
    async init() {
        await this._fetchProductData();
        this._setupEventListeners();
    }

    /* ── Fetch ────────────────────────────────────────────────────── */
    async _fetchProductData() {
        this._showLoading(true);
        try {
            const response = await fetch(`/api/customproducts/${this.productId}/designer-data-v2`);
            if (!response.ok) throw new Error(`HTTP ${response.status}`);

            const data = await response.json();
            if (!data.success) throw new Error(data.message || 'API returned success:false');

            this.productData = data;
            console.log('[ProductEngine] Loaded product data:', data);

            this._renderProductDetails();
            const initialColorId = (data.colors && data.colors.length > 0) ? data.colors[0].id : null;
            this._applyColor(initialColorId);

            // Set initial mockup
            const mockupImg = document.getElementById('product-mockup-main');
            const firstView = data.colors?.[0]?.views?.front;
            console.log('[ProductEngine] Initial mockup image source:', firstView);

            if (mockupImg && firstView) mockupImg.src = firstView;


            // ══════════════════════════════════════════════════════════════
            // STATIC PRINT-AREA CONFIG — edit numbers here, then refresh.
            // x/y  = px from top-left corner of the mockup image.
            // All values are independent per view.
            // ══════════════════════════════════════════════════════════════
            this._printAreaRects = {
                'front': {
                    x: 195, y: 120, width: 210, height: 350,
                    // Second box on front view (e.g. left-chest pocket area)
                    second: { x: 290, y: 120, width: 115, height: 115 },
                },
                'back': {
                    x: 195, y: 130, width: 210, height: 330,
                },
                'right-shoulder': {
                    x: 180, y: 100, width: 190, height: 280,
                },
                'left-shoulder': {
                    x: 250, y: 110, width: 150, height: 200,
                },
            };

            // Apply initial front rect
            this._applyPrintAreaRect('front');

            this.bus.emit('product:loaded', data);
        } catch (err) {
            console.error('[ProductEngine] fetchProductData failed:', err);
            this.bus.emit('ui:notify', { msg: `Failed to load product: ${err.message}`, icon: 'error' });
        } finally {
            this._showLoading(false);
        }
    }

    /* ── Loading overlay ──────────────────────────────────────────── */
    _showLoading(state) {
        let overlay = document.getElementById('_product_loading');
        if (state) {
            if (!overlay) {
                overlay = document.createElement('div');
                overlay.id = '_product_loading';
                Object.assign(overlay.style, {
                    position: 'fixed', inset: '0', background: 'rgba(255,255,255,0.7)',
                    zIndex: '9000', display: 'flex', alignItems: 'center', justifyContent: 'center',
                    fontFamily: 'sans-serif', fontSize: '16px', color: '#333',
                });
                overlay.innerHTML = '<div style="text-align:center"><div class="spinner" style="margin:0 auto 12px;width:36px;height:36px;border:4px solid #e5e7eb;border-top-color:#1C30A3;border-radius:50%;animation:spin 0.7s linear infinite"></div>Loading product…</div>';
                // Inject spinner animation once
                if (!document.getElementById('_spin_css')) {
                    const s = document.createElement('style');
                    s.id = '_spin_css';
                    s.textContent = '@keyframes spin{to{transform:rotate(360deg)}}';
                    document.head.appendChild(s);
                }
                document.body.appendChild(overlay);
            }
        } else {
            overlay?.remove();
        }
    }

    /* ── Render product details ───────────────────────────────────── */
    _renderProductDetails() {
        const nameEl = document.getElementById('footer-product-name');
        if (nameEl) nameEl.textContent = this.productData.product_name || '';

        const symbol = window.__currency?.symbol || '$';
        const rate = window.__currency?.rate || 1.0;
        const priceEl = document.getElementById('total-price');
        if (priceEl) {
            const convertedPrice = (parseFloat(this.productData.base_price || 0) * rate).toFixed(2);
            priceEl.textContent = `${symbol}${convertedPrice}`;
        }

        this._renderColorGrid();
        this._renderSizeGrid();
        this._renderQuantitySettings();
        this._toggleViewButtons();
    }

    /**
     * Show/Hide view buttons (Back, Shoulder) based on product data
     */
    _toggleViewButtons() {
        if (!this.productData) return;
        const isTwoSided = !!this.productData.is_two_sided;
        
        // Hide/Show Back button
        const backBtn = document.querySelector('.cs_view_btn[data-view="back"]');
        if (backBtn) {
            backBtn.style.display = isTwoSided ? 'flex' : 'none';
        }

        // Hide Shoulder buttons (unless specifically enabled in data later)
        // document.querySelectorAll('.cs_view_btn[data-view*="shoulder"]').forEach(btn => {
        //     btn.style.display = 'none'; 
        // });
    }

    _renderQuantitySettings() {
        const input = document.getElementById('quantity-input');
        if (!input || !window.__appSetting) return;

        const setting = window.__appSetting;
        input.min = setting.min_quantity;
        if (setting.max_quantity) input.max = setting.max_quantity;

        // Only set value if current value is 1 (default)
        if (parseInt(input.value) === 1) {
            input.value = setting.min_quantity;
        }
    }

    /* ── Color grid ───────────────────────────────────────────────── */
    _renderColorGrid() {
        const grid = document.getElementById('color-grid'); // matches Blade ID
        if (!grid) return;

        grid.innerHTML = (this.productData.colors || []).map(color => `
            <div class="cs_color_item ${this.activeColorId === color.id ? 'active' : ''}"
                 data-id="${color.id}"
                 style="background-color:${color.color_code}"
                 title="${color.color_name}"></div>
        `).join('');

        grid.querySelectorAll('.cs_color_item').forEach(el => {
            el.addEventListener('click', () => this._applyColor(el.dataset.id));
        });
    }

    /* ── Apply color ──────────────────────────────────────────────── */
    _applyColor(colorId) {
        // Use strict checks because '0' is a valid ID
        if (colorId === null || colorId === undefined || !this.productData) return;
        
        const color = this.productData.colors.find(c => String(c.id) === String(colorId));
        if (!color) return;

        this.activeColorId = colorId;

        // Update main mockup for active view
        const activeView = this.canvasManager.activeView;
        const mockupImg = document.getElementById('product-mockup-main');
        if (mockupImg && color.views?.[activeView]) {
            mockupImg.src = color.views[activeView];
        }

        // Update side-view thumbnails
        Object.entries(color.views || {}).forEach(([viewKey, url]) => {
            const thumb = document.querySelector(`.cs_view_btn[data-view="${viewKey}"] .view_thumb_mini`);
            if (thumb && url) thumb.style.backgroundImage = `url(${url})`;
        });

        // Update footer color label
        const colorLabel = document.getElementById('footer-product-color-name');
        if (colorLabel) colorLabel.textContent = color.color_name;

        // Re-render grid to update active dot
        this._renderColorGrid();

        this.bus.emit('color:changed', color);
    }

    /* ── Size grid ────────────────────────────────────────────────── */
    _renderSizeGrid() {
        const grid = document.getElementById('product-size-grid');
        if (!grid) return;
        const sizes = this.productData.sizes || ['XS', 'S', 'M', 'L', 'XL', 'XXL'];

        grid.innerHTML = sizes.map(size => `
            <button class="cs_size_btn ${this.activeSize === size ? 'active' : ''}" data-size="${size}">${size}</button>
        `).join('');

        grid.querySelectorAll('.cs_size_btn').forEach(btn => {
            btn.addEventListener('click', () => {
                this.activeSize = btn.dataset.size;
                grid.querySelectorAll('.cs_size_btn').forEach(b => b.classList.toggle('active', b === btn));
            });
        });

        // Auto-select first size
        if (!this.activeSize && sizes.length) {
            this.activeSize = sizes[0];
            grid.querySelector('.cs_size_btn')?.classList.add('active');
        }
    }

    /* ── Event listeners ──────────────────────────────────────────── */
    _setupEventListeners() {
        const onModified = () => this._updatePrice();
        const onLoaded = () => this._updatePrice();
        this.listenBus('canvas:modified', onModified);
        this.listenBus('product:loaded', onLoaded);

        // When CanvasManager switches view — update mockup + price
        this.listenBus('view:changed', (view) => {
            this._updateMockupForView(view);
            this._updatePrice();
        });

        // Also listen to the pre-switch event — update mockup + print area rect
        this.listenBus('view:change', (view) => {
            this._updateMockupForView(view);
            this._applyPrintAreaRect(view);
        });
    }

    /* ── Apply static print-area rect for a given view ────────────── */
    _applyPrintAreaRect(view) {
        const rects = this._printAreaRects;
        if (!rects) return;

        // Get rect for this view, fall back to front
        const rect = rects[view] || rects['front'];
        this.canvasManager.updatePrintArea(rect, view);

        // Second print-area box — only visible on front
        const secondBox = document.getElementById('print-area-second');
        if (secondBox) {
            if (view === 'front' && rect.second) {
                const s = rect.second;
                // Position relative to the mockup image (same coordinate system as primary)
                const mockup = document.getElementById('product-mockup-main');
                const mRect = mockup ? mockup.getBoundingClientRect() : { left: 0, top: 0 };
                const parent = secondBox.offsetParent ? secondBox.offsetParent.getBoundingClientRect() : { left: 0, top: 0 };
                secondBox.style.display = 'block';
                secondBox.style.left = `${s.x}px`;
                secondBox.style.top = `${s.y}px`;
                secondBox.style.width = `${s.width}px`;
                secondBox.style.height = `${s.height}px`;
            } else {
                secondBox.style.display = 'none';
            }
        }
    }

    /* ── Update mockup image for a given view ───────────────────── */
    _updateMockupForView(view) {
        if (!this.productData || !view) return;

        const mockupImg = document.getElementById('product-mockup-main');
        
        // Find color: prioritize activeColorId, fallback to first color
        let color = this.productData.colors?.find(c => String(c.id) === String(this.activeColorId));
        if (!color && this.productData.colors?.length > 0) {
            color = this.productData.colors[0];
        }

        if (!color || !mockupImg) {
            console.warn('[ProductEngine] Cannot update mockup: no color data or image element.');
            return;
        }

        // Try exact view key; fall back to 'front'
        const imgUrl = color.views?.[view] || color.views?.['front'];
        
        if (imgUrl) {
            console.log(`[ProductEngine] Switching mockup to view: "${view}" | URL: ${imgUrl}`);
            
            // Apply a quick fade transition
            mockupImg.style.transition = 'opacity 0.2s ease-in-out';
            mockupImg.style.opacity = '0.5';
            
            const tempImg = new Image();
            tempImg.src = imgUrl;
            tempImg.onload = () => {
                console.log(`[ProductEngine] Successfully loaded view: "${view}"`);
                mockupImg.src = imgUrl;
                mockupImg.style.opacity = '1';
            };
            tempImg.onerror = () => {
                const errorMsg = `[ProductEngine] Failed to load view "${view}" at URL: ${imgUrl}`;
                console.error(errorMsg);
                mockupImg.style.opacity = '1';
                this.bus.emit('ui:notify', { msg: `Failed to load ${view} image. Please check if the image exists in the dashboard.`, icon: 'error' });
            };
        } else {
            console.warn(`[ProductEngine] No image URL found for view: "${view}"`);
        }
    }

    /* ── Pricing ──────────────────────────────────────────────────── */
    _updatePrice() {
        if (!this.productData) return;
        const basePrice = parseFloat(this.productData.base_price) || 0;
        const extraPrice = parseFloat(this.productData.extra_element_price) || 50;
        let totalObjs = 0;

        Object.values(this.canvasManager.canvases).forEach(canvas => {
            canvas.getObjects().forEach(o => {
                if (!o.isSystem && !o.excludeFromPrice && o.type !== 'rect') totalObjs++;
            });
        });

        const symbol = window.__currency?.symbol || '$';
        const rate = window.__currency?.rate || 1.0;
        const total = (basePrice + totalObjs * extraPrice) * rate;
        const priceEl = document.getElementById('total-price');
        if (priceEl) {
            priceEl.textContent = `${symbol}${total.toFixed(2)}`;
            priceEl.classList.remove('highlight');
            void priceEl.offsetWidth; // reflow
            priceEl.classList.add('highlight');
        }

        this.bus.emit('price:updated', { total, base: basePrice, extra: extraPrice, count: totalObjs });
    }

    /* ── Public getters for ExportEngine ─────────────────────────── */
    getSelectedSize() { return this.activeSize || 'M'; }
    getSelectedColor() {
        return this.productData?.colors?.find(c => String(c.id) === String(this.activeColorId))?.color_name || 'Default';
    }
    getExtraPrice() {
        const extraPrice = parseFloat(this.productData?.extra_element_price) || 50;
        let totalObjs = 0;
        Object.values(this.canvasManager.canvases).forEach(canvas => {
            canvas.getObjects().forEach(o => {
                if (!o.isSystem && !o.excludeFromPrice && o.type !== 'rect') totalObjs++;
            });
        });
        return totalObjs * extraPrice;
    }

    /* ── Cleanup ──────────────────────────────────────────────────── */
    destroy() {
        super.destroy();
    }
}

window.DesignLab = window.DesignLab || {};
window.DesignLab.ProductEngine = ProductEngine;

/**
 * CanvasManager — Multi-view Fabric.js canvas controller.
 * Fully stabilized: single-init controls, correct boundary checks,
 * debounced events, no global coupling, safe-zone overlay, view guard.
 */
class CanvasManager {
    constructor() {
        this.canvases = {};
        this.activeView = 'front';
        this.bus = window.DesignLab.EventBus;
        this._modifiedTimers = {};   // per-view debounce timers
        this._busHandlers = [];   // for destroy()
        this._printRects = {};   // print area per view
        this._viewList = ['front', 'back', 'right-shoulder', 'left-shoulder'];
    }

    /* ═══════════════════ PUBLIC INIT (called by TShirtCustomizer) ══ */
    init() {
        this._viewList.forEach(view => this._initCanvas(view));
        this._initCustomControls();

        const onViewChange = (view) => this.switchView(view);
        this.bus.on('view:change', onViewChange);
        this._busHandlers.push({ event: 'view:change', handler: onViewChange });

        // Window resize: reposition safe-zone
        this._resizeHandler = () => this._repositionSafeZone();
        window.addEventListener('resize', this._resizeHandler);
    }

    /* ═══════════════════ CANVAS INIT ══════════════════════════════ */
    _initCanvas(view) {
        const canvasEl = document.getElementById(`design-canvas-${view}`);
        const containerEl = document.getElementById(`canvas-container-${view}`);
        if (!canvasEl || !containerEl) {
            console.warn(`[CanvasManager] Missing canvas or container for view "${view}"`);
            return;
        }

        const canvas = new fabric.Canvas(`design-canvas-${view}`, {
            width: 300,
            height: 400,
            preserveObjectStacking: true,
            backgroundColor: 'transparent',
        });

        this.canvases[view] = canvas;

        // Selection events
        canvas.on('selection:created', (e) => this._onSelection(e));
        canvas.on('selection:updated', (e) => this._onSelection(e));
        canvas.on('selection:cleared', () => this.bus.emit('object:deselected'));

        // Debounced canvas:modified (300ms per view)
        canvas.on('object:added', () => this._debounceModified(view));
        canvas.on('object:removed', () => this._debounceModified(view));
        canvas.on('object:modified', () => this._debounceModified(view));

        // Boundary warning
        canvas.on('object:moving', (e) => this._checkBoundaries(e.target));
        canvas.on('object:scaling', (e) => this._checkBoundaries(e.target));
        canvas.on('selection:cleared', () => this._resetBoundaries());
    }

    /* ═══════════════════ CUSTOM CONTROLS (once globally) ══════════ */
    _initCustomControls() {
        if (CanvasManager._controlsInitialized) return;
        CanvasManager._controlsInitialized = true;

        // Delete control — top-left
        fabric.Object.prototype.controls.deleteControl = new fabric.Control({
            x: -0.5, y: -0.5,
            offsetX: -16, offsetY: -16,
            cursorStyle: 'pointer',
            mouseUpHandler: (_ev, transform) => {
                const target = transform.target;
                const canvas = target.canvas;
                if (!canvas) return true;
                canvas.remove(target);
                canvas.requestRenderAll();
                this.bus.emit('canvas:modified', { view: this.activeView });
                return true;
            },
            render: this._makeControlRenderer('\uf00d', '#ef4444'), // fa-times (FA5)
        });

        // Clone control — bottom-left
        fabric.Object.prototype.controls.cloneControl = new fabric.Control({
            x: -0.5, y: 0.5,
            offsetX: -16, offsetY: 16,
            cursorStyle: 'pointer',
            mouseUpHandler: (_ev, transform) => {
                const target = transform.target;
                target.clone((cloned) => {
                    cloned.set({ left: target.left + 20, top: target.top + 20 });
                    target.canvas.add(cloned);
                    target.canvas.setActiveObject(cloned);
                    target.canvas.requestRenderAll();
                });
                return true;
            },
            render: this._makeControlRenderer('\uf0c5', '#1C30A3'), // fa-copy (FA5)
        });
    }

    /* ── Control icon renderer ────────────────────────────────────── */
    _makeControlRenderer(unicodeChar, color) {
        return (ctx, left, top) => {
            const size = 24;
            ctx.save();
            ctx.translate(left, top);

            // Circle background
            ctx.beginPath();
            ctx.arc(0, 0, size / 2, 0, 2 * Math.PI);
            ctx.fillStyle = '#ffffff';
            ctx.fill();
            ctx.strokeStyle = color;
            ctx.lineWidth = 2;
            ctx.stroke();

            // FA5 icon — must set bold weight inside ctx.font string
            ctx.fillStyle = color;
            ctx.font = '900 13px "Font Awesome 5 Free"';
            ctx.textAlign = 'center';
            ctx.textBaseline = 'middle';
            ctx.fillText(unicodeChar, 0, 1);
            ctx.restore();
        };
    }

    /* ═══════════════════ SELECTION ═════════════════════════════════ */
    _onSelection(e) {
        if (!e.selected || e.selected.length === 0) return;
        // Emit first selected object (multi-select exposes activeSelection)
        const target = e.selected.length === 1
            ? e.selected[0]
            : this.canvases[this.activeView]?.getActiveObject();
        if (target) this.bus.emit('object:selected', target);
    }

    /* ═══════════════════ BOUNDARY CHECK ════════════════════════════ */
    _checkBoundaries(obj) {
        if (!obj) return;
        // Use actual bounding rect (accounts for rotation, origin, scale)
        const br = obj.getBoundingRect(true, true);
        const canvas = obj.canvas;
        if (!canvas) return;
        const isOut =
            br.left < 0 ||
            br.top < 0 ||
            (br.left + br.width) > canvas.width ||
            (br.top + br.height) > canvas.height;

        const boundEl = document.querySelector('.cs_print_area_bound');
        if (!boundEl) return;
        if (isOut) {
            boundEl.style.borderColor = '#ef4444';
            boundEl.style.borderWidth = '2px';
            boundEl.classList.add('warning-pulse');
        } else {
            this._resetBoundaries();
        }
    }

    _resetBoundaries() {
        const boundEl = document.querySelector('.cs_print_area_bound');
        if (!boundEl) return;
        boundEl.style.borderColor = 'rgba(28, 48, 163, 0.3)';
        boundEl.style.borderWidth = '1px';
        boundEl.classList.remove('warning-pulse');
    }

    /* ═══════════════════ DEBOUNCED canvas:modified ═════════════════ */
    _debounceModified(view) {
        clearTimeout(this._modifiedTimers[view]);
        this._modifiedTimers[view] = setTimeout(() => {
            this.bus.emit('canvas:modified', { view });
        }, 300);
    }

    /* ═══════════════════ VIEW SWITCHING ════════════════════════════ */
    switchView(view) {
        if (view === this.activeView) return;            // no-op guard
        if (!this.canvases[view]) return;

        // Hide all containers
        this._viewList.forEach(v => {
            document.getElementById(`canvas-container-${v}`)?.classList.remove('active');
        });

        // Show target
        document.getElementById(`canvas-container-${view}`)?.classList.add('active');

        this.activeView = view;

        // Update mockup from stored product data (via bus — ProductEngine listens)
        this.bus.emit('view:changed', view);

        // Update print area for the new view
        const rect = this._printRects[view] || this._printRects['front'];
        if (rect) this.updatePrintArea(rect, view);
    }

    /* ═══════════════════ PRINT AREA ════════════════════════════════ */
    updatePrintArea(rect, view) {
        if (!rect) return;

        const targetView = view || this.activeView;

        // Store per-view
        this._printRects[targetView] = rect;

        // Resize only the target canvas
        const canvas = this.canvases[targetView];
        if (canvas) {
            canvas.setDimensions({ width: rect.width, height: rect.height });
            canvas.clipPath = new fabric.Rect({
                width: rect.width, height: rect.height,
                top: 0, left: 0, absolutePositioned: true,
            });
            canvas.renderAll();
        }

        // Reposition the canvas-stack wrapper (only on active view change)
        if (targetView === this.activeView) {
            const stack = document.getElementById('canvas-stack');
            if (stack) {
                stack.style.left = `${rect.x + rect.width / 2}px`;
                stack.style.top = `${rect.y + rect.height / 2}px`;
                stack.style.width = `${rect.width}px`;
                stack.style.height = `${rect.height}px`;
                stack.style.transform = 'translate(-50%, -50%)';
            }
            this._updateSafeZone(rect);
        }
    }

    /* ═══════════════════ SAFE ZONE OVERLAY ═════════════════════════ */
    _updateSafeZone(rect) {
        const safeEl = document.querySelector('.cs_safe_zone');
        if (!safeEl) return;
        const padding = 10; // 10px safe margin inside print area
        Object.assign(safeEl.style, {
            position: 'absolute',
            left: `${padding}px`,
            top: `${padding}px`,
            width: `${rect.width - padding * 2}px`,
            height: `${rect.height - padding * 2}px`,
            pointerEvents: 'none',
        });
    }

    _repositionSafeZone() {
        const rect = this._printRects[this.activeView];
        if (rect) this._updateSafeZone(rect);
    }

    /* ═══════════════════ BACKGROUND IMAGE ══════════════════════════ */
    setBackgroundImage(url, view) {
        const canvas = this.canvases[view || this.activeView];
        if (!canvas) return;
        fabric.Image.fromURL(url, (img) => {
            if (!img) { console.warn('[CanvasManager] Background image failed to load:', url); return; }
            canvas.setBackgroundImage(img, canvas.renderAll.bind(canvas), {
                scaleX: canvas.width / img.width,
                scaleY: canvas.height / img.height,
                originX: 'left', originY: 'top',
            });
        }, (err) => {
            console.error('[CanvasManager] Background image error:', err);
        }, { crossOrigin: 'anonymous' });
    }

    /* ═══════════════════ CANVAS HELPERS ════════════════════════════ */
    getCanvas(view) {
        return this.canvases[view || this.activeView] || null;
    }

    getActiveCanvas() {
        return this.canvases[this.activeView] || null;
    }

    setActiveView(view) {
        this.switchView(view);
    }

    /* ═══════════════════ OBJECT OPERATIONS ═════════════════════════ */
    addObject(obj) {
        const canvas = this.getActiveCanvas();
        if (!canvas) return;
        canvas.add(obj);
        canvas.centerObject(obj);
        obj.setCoords();
        canvas.setActiveObject(obj);
        canvas.renderAll();
    }

    clearCanvas() {
        const canvas = this.getActiveCanvas();
        if (!canvas) return;
        // Remove user objects only — preserve background
        const bg = canvas.backgroundImage;
        canvas.getObjects().forEach(o => canvas.remove(o));
        if (bg) canvas.setBackgroundImage(bg, canvas.renderAll.bind(canvas));
        canvas.renderAll();
    }

    deleteSelected() {
        const canvas = this.getActiveCanvas();
        if (!canvas) return;
        const active = canvas.getActiveObject();
        if (!active) return;
        if (active.type === 'activeSelection') {
            active.forEachObject(o => canvas.remove(o));
            canvas.discardActiveObject();
        } else {
            canvas.remove(active);
        }
        canvas.renderAll();
    }

    duplicateSelected() {
        const canvas = this.getActiveCanvas();
        if (!canvas) return;
        const active = canvas.getActiveObject();
        if (!active) return;

        active.clone((cloned) => {
            canvas.discardActiveObject();
            // Smart offset: nudge 20px, wrap to center if out of bounds
            let offX = cloned.left + 20;
            let offY = cloned.top + 20;
            if (offX + cloned.width > canvas.width) offX = 20;
            if (offY + cloned.height > canvas.height) offY = 20;
            cloned.set({ left: offX, top: offY, evented: true });
            if (cloned.type === 'activeSelection') {
                cloned.canvas = canvas;
                cloned.forEachObject(o => canvas.add(o));
                cloned.setCoords();
            } else {
                canvas.add(cloned);
            }
            canvas.setActiveObject(cloned);
            canvas.requestRenderAll();
        });
    }

    setCanvasSize(width, height) {
        Object.values(this.canvases).forEach(c => {
            c.setDimensions({ width, height });
            c.renderAll();
        });
        const stack = document.getElementById('canvas-stack');
        if (stack) { stack.style.width = `${width}px`; stack.style.height = `${height}px`; }
    }

    /* ═══════════════════ DESTROY ═══════════════════════════════════ */
    destroy() {
        this._busHandlers.forEach(({ event, handler }) => this.bus.off(event, handler));
        this._busHandlers = [];
        window.removeEventListener('resize', this._resizeHandler);
        Object.values(this.canvases).forEach(c => c.dispose());
        this.canvases = {};
        Object.values(this._modifiedTimers).forEach(t => clearTimeout(t));
    }
}

// Static flag — prevents duplicate control prototype patching
CanvasManager._controlsInitialized = false;

window.DesignLab = window.DesignLab || {};
window.DesignLab.CanvasManager = CanvasManager;

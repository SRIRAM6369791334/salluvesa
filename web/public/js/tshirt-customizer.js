/**
 * TShirtCustomizer — Main application bootstrap.
 * Enforces strict async init order, dirty-flag autosave,
 * destroy lifecycle, no window.customizer in engines.
 */
class TShirtCustomizer {
    constructor() {
        this.bus = window.DesignLab.EventBus;
        this._autosaveTimer = null;
        this._isDirty = false;
        this._busHandlers = [];

        // All engines declared as null — populated by async init()
        this.canvasManager = null;
        this.uiManager = null;
        this.textEngine = null;
        this.imageEngine = null;
        this.clipartEngine = null;
        this.layerEngine = null;
        this.productEngine = null;
        this.colorEngine = null;
        this.historyEngine = null;
        this.teamEngine = null;
        this.exportEngine = null;
        this.draftEngine = null;
    }

    /* ── Async init chain ─────────────────────────────────────────── */
    async init() {
        // 1. Canvas infrastructure (must be first)
        this.canvasManager = new DesignLab.CanvasManager();
        this.canvasManager.init();

        // 2. Product data (async — everything waits for this)
        this.productEngine = new DesignLab.ProductEngine(this.canvasManager, this);
        await this.productEngine.init();

        // 3. UI Manager
        this.uiManager = new DesignLab.UIManager();

        // 4. Tool engines
        this.textEngine = new DesignLab.TextEngine(this.canvasManager);
        this.imageEngine = new DesignLab.ImageEngine(this.canvasManager);
        this.clipartEngine = new DesignLab.ClipartEngine(this.canvasManager);
        this.layerEngine = new DesignLab.LayerEngine(this.canvasManager);
        this.colorEngine = new DesignLab.ColorEngine(this.canvasManager, this);
        this.teamEngine = new DesignLab.TeamEngine(this.canvasManager, this);

        // 5. History (after canvases and product data are ready)
        this.historyEngine = new DesignLab.HistoryEngine(this.canvasManager);

        // 6. Export
        this.exportEngine = new DesignLab.ExportEngine(this.canvasManager, this);

        // 7. Draft restore (after history engine is ready)
        if (DesignLab.DraftEngine) {
            this.draftEngine = new DesignLab.DraftEngine(this.canvasManager, this);
            await this.draftEngine.restore();
        }

        // 8. App-level controls
        this._setupHeaderControls();
        this._setupDirtyTracking();
        this._startAutosave();

        // Done
        this.bus.emit('ui:notify', { msg: 'Design Lab is ready! Start creating.', icon: 'success' });
        console.info('[TShirtCustomizer] Initialized successfully.');
    }

    /* ── Dirty tracking ───────────────────────────────────────────── */
    _setupDirtyTracking() {
        const onModified = () => { this._isDirty = true; };
        this.bus.on('canvas:modified', onModified);
        this._busHandlers.push({ event: 'canvas:modified', handler: onModified });
    }

    /* ── Autosave ─────────────────────────────────────────────────── */
    _startAutosave() {
        this._autosaveTimer = setInterval(async () => {
            if (!this._isDirty || this.exportEngine?.isProcessing) return;
            const canvases = this.canvasManager?.canvases || {};
            const hasContent = Object.values(canvases).some(c => c.getObjects().length > 0);
            if (!hasContent) return;

            try {
                const data = await this.exportEngine._prepareDesignData();
                data.status = 'draft';
                await this.exportEngine._saveDesign(data);
                this._isDirty = false;
                console.info('[TShirtCustomizer] Autosaved draft.');
            } catch (err) {
                console.warn('[TShirtCustomizer] Autosave failed:', err);
                this.bus.emit('ui:notify', { msg: 'Autosave failed — your work may not be saved.', icon: 'warning' });
            }
        }, 30000); // 30 seconds
    }

    /* ── Header controls ──────────────────────────────────────────── */
    _setupHeaderControls() {
        // Undo / Redo
        const undoBtn = document.getElementById('undo-btn');
        const redoBtn = document.getElementById('redo-btn');
        if (undoBtn) undoBtn.addEventListener('click', () => this.historyEngine?.undo());
        if (redoBtn) redoBtn.addEventListener('click', () => this.historyEngine?.redo());

        // Zoom
        const zoomInBtn = document.getElementById('zoom-in-btn');
        const zoomOutBtn = document.getElementById('zoom-out-btn');
        const zoomLabel = document.getElementById('zoom-level');
        this._currentZoom = 1;

        const updateZoom = (z) => {
            this._currentZoom = Math.max(0.5, Math.min(3, z));
            const canvas = this.canvasManager?.getActiveCanvas();
            if (canvas) {
                canvas.setZoom(this._currentZoom);
                canvas.setDimensions({
                    width: canvas.getWidth() * this._currentZoom,
                    height: canvas.getHeight() * this._currentZoom,
                });
                canvas.renderAll();
            }
            if (zoomLabel) zoomLabel.textContent = `${Math.round(this._currentZoom * 100)}%`;
        };

        if (zoomInBtn) zoomInBtn.addEventListener('click', () => updateZoom(this._currentZoom + 0.1));
        if (zoomOutBtn) zoomOutBtn.addEventListener('click', () => updateZoom(this._currentZoom - 0.1));

        // Duplicate / Clear
        const dupBtn = document.getElementById('duplicate-btn');
        const clearBtn = document.getElementById('clear-btn');
        if (dupBtn) dupBtn.addEventListener('click', () => this.canvasManager?.duplicateSelected());
        if (clearBtn) clearBtn.addEventListener('click', () => {
            if (confirm('Clear all design elements on this side?')) {
                this.canvasManager?.clearCanvas();
            }
        });

        // Alignment buttons (data-align attribute)
        document.querySelectorAll('[data-align]').forEach(btn => {
            btn.addEventListener('click', () => this.alignObject(btn.dataset.align));
        });

        // ── View switcher buttons ──────────────────────────────────────────
        document.querySelectorAll('.cs_view_btn').forEach(btn => {
            btn.addEventListener('click', () => {
                const view = btn.dataset.view;
                if (!view) return;
                // Update active highlight on switcher
                document.querySelectorAll('.cs_view_btn').forEach(b => b.classList.remove('active'));
                btn.classList.add('active');
                // Tell CanvasManager and all engines (ColorEngine, ProductEngine, etc.)
                this.bus.emit('view:change', view);
            });
        });

        // ── Change-product button ──────────────────────────────────────────
        document.getElementById('change-product-btn')?.addEventListener('click', () => {
            window.location.href = window.__routes?.customize || '/customize-products';
        });
    }

    /* ── Alignment ────────────────────────────────────────────────── */
    alignObject(pos) {
        const canvas = this.canvasManager?.getActiveCanvas();
        const active = canvas?.getActiveObject();
        if (!canvas || !active) return;

        const br = active.getBoundingRect(true, true);

        switch (pos) {
            case 'left': active.set('left', active.left - br.left); break;
            case 'center': canvas.centerObjectH(active); break;
            case 'right': active.set('left', active.left + (canvas.width - (br.left + br.width))); break;
            case 'top': active.set('top', active.top - br.top); break;
            case 'middle': canvas.centerObjectV(active); break;
            case 'bottom': active.set('top', active.top + (canvas.height - (br.top + br.height))); break;
        }
        active.setCoords();
        canvas.renderAll();
    }

    /* ── Destroy ──────────────────────────────────────────────────── */
    destroy() {
        clearInterval(this._autosaveTimer);
        this._busHandlers.forEach(({ event, handler }) => this.bus.off(event, handler));
        this._busHandlers = [];

        const engines = [
            'textEngine', 'imageEngine', 'clipartEngine', 'layerEngine',
            'productEngine', 'historyEngine', 'teamEngine', 'exportEngine',
            'uiManager', 'canvasManager', 'draftEngine',
        ];
        engines.forEach(key => {
            if (this[key]?.destroy) this[key].destroy();
            this[key] = null;
        });
        console.info('[TShirtCustomizer] Destroyed.');
    }
}

window.TShirtCustomizer = TShirtCustomizer;

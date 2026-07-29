/**
 * DraftEngine — LocalStorage draft persistence per product.
 * CustomInk-style: auto-save on canvas:modified (debounced),
 * restore on load, supports all 4 views, safe JSON parse.
 * Extends BaseEngine.
 */
class DraftEngine extends DesignLab.BaseEngine {
    constructor(canvasManager, app) {
        super(canvasManager);
        this.app = app;
        this._saveTimer = null;
        this._DEBOUNCE = 1500; // ms
        this._customProps = [
            'isRosterElement', 'rosterType', 'customType',
            'excludeFromPrice', 'isSystem', 'customLayer', 'customLabel',
        ];
    }

    /* ── Storage key per product ──────────────────────────────────── */
    _key() {
        const id = document.getElementById('customproduct_id')?.value;
        return id ? `design_lab_draft_${id}` : null;
    }

    /* ── Restore: call during init (async) ────────────────────────── */
    async restore() {
        const designId = document.getElementById('design_id')?.value;
        if (designId) {
            this.bus.emit('ui:notify', { msg: 'Loading your design…', icon: 'info' });
            try {
                const res = await fetch(`${window.__routes?.getDesign || '/api/designs'}/${designId}`, {
                    headers: { 'Accept': 'application/json' }
                });
                const data = await res.json();
                if (data.success && data.design) {
                    await this._loadDesignData(data.design);
                    this.bus.emit('ui:notify', { msg: 'Design loaded successfully.', icon: 'success' });
                    this._startListening();
                    return;
                }
            } catch (err) {
                console.warn('[DraftEngine] Backend restore failed:', err);
            }
        }

        const key = this._key();
        if (!key) return;

        const raw = localStorage.getItem(key);
        if (!raw) return;

        let draft;
        try {
            draft = JSON.parse(raw);
        } catch {
            console.warn('[DraftEngine] Corrupted draft — clearing.');
            localStorage.removeItem(key);
            return;
        }

        await this._loadDesignData(draft);

        this.bus.emit('ui:notify', { msg: 'Your previous draft has been restored.', icon: 'info' });
        console.info('[DraftEngine] Draft restored from localStorage.');

        // Start listening for new changes after restore
        this._startListening();
    }

    async _loadDesignData(data) {
        // Map backend fields to view keys
        const draft = {
            'front': data.front_canvas_json || data.front || null,
            'back': data.back_canvas_json || data.back || null,
            'right-shoulder': data.right_shoulder_canvas_json || data['right-shoulder'] || null,
            'left-shoulder': data.left_shoulder_canvas_json || data['left-shoulder'] || null
        };

        if (data.design_name) {
            const nameInput = document.getElementById('design-name-input');
            if (nameInput) nameInput.value = data.design_name;
        }

        const views = Object.keys(draft);
        const loads = views.map(view => new Promise(resolve => {
            const canvas = this.canvasManager.canvases[view];
            const state = draft[view];
            if (!canvas || !state) return resolve();

            // Handle both stringified and object JSON
            const json = typeof state === 'string' ? JSON.parse(state) : state;

            canvas.loadFromJSON(json, () => {
                canvas.renderAll();
                // Integrate with HistoryEngine
                if (this.app.historyEngine) {
                    this.app.historyEngine._saveState(view);
                }
                resolve();
            });
        }));

        await Promise.all(loads);
    }

    /* ── Listen for canvas changes ────────────────────────────────── */
    _startListening() {
        const onModified = () => {
            clearTimeout(this._saveTimer);
            this._saveTimer = setTimeout(() => this._saveDraft(), this._DEBOUNCE);
        };
        this.listenBus('canvas:modified', onModified);
    }

    /* ── Save draft ───────────────────────────────────────────────── */
    _saveDraft() {
        const key = this._key();
        if (!key) return;

        const draft = {};
        Object.entries(this.canvasManager.canvases).forEach(([view, canvas]) => {
            try {
                draft[view] = canvas.toDatalessJSON(this._customProps);
            } catch (err) {
                console.warn(`[DraftEngine] Could not serialize canvas "${view}":`, err);
            }
        });

        try {
            localStorage.setItem(key, JSON.stringify(draft));
        } catch (err) {
            // Storage quota exceeded
            console.warn('[DraftEngine] LocalStorage write failed:', err);
        }
    }

    /* ── Clear draft (e.g. after successful checkout) ─────────────── */
    clearDraft() {
        const key = this._key();
        if (key) localStorage.removeItem(key);
    }

    /* ── Cleanup ──────────────────────────────────────────────────── */
    destroy() {
        clearTimeout(this._saveTimer);
        super.destroy();
    }
}

window.DesignLab = window.DesignLab || {};
window.DesignLab.DraftEngine = DraftEngine;

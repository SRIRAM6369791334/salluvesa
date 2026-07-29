/**
 * HistoryEngine — Reliable undo/redo with custom prop preservation,
 * keyboard shortcuts, debounced state capture, and UI state emission.
 */
class HistoryEngine extends DesignLab.BaseEngine {
    constructor(canvasManager) {
        super(canvasManager);

        this._history = { front: [], back: [], 'right-shoulder': [], 'left-shoulder': [] };
        this._redoStack = { front: [], back: [], 'right-shoulder': [], 'left-shoulder': [] };
        this._isWorking = false;
        this._maxHistory = 30;
        this._saveTimer = null;

        // Custom Fabric properties to preserve across undo/redo
        this._customProps = [
            'isRosterElement', 'rosterType', 'customType',
            'excludeFromPrice', 'isSystem', 'customLayer', 'customLabel',
        ];

        this._init();
    }

    /* ── Init ─────────────────────────────────────────────────────── */
    _init() {
        // Save state on canvas change (debounced)
        const onModified = ({ view }) => {
            if (this._isWorking) return;
            this._debounceSave(view, 400);
        };
        this.listenBus('canvas:modified', onModified);

        // Save initial states after product load
        const onLoaded = () => {
            Object.keys(this._history).forEach(view => this._saveState(view));
            this._emitStatus();
        };
        this.listenBus('product:loaded', onLoaded);

        // Keyboard shortcuts
        this._keyHandler = (e) => {
            const tag = document.activeElement?.tagName?.toLowerCase();
            if (tag === 'input' || tag === 'textarea' || tag === 'select') return;
            if ((e.ctrlKey || e.metaKey) && e.key === 'z' && !e.shiftKey) {
                e.preventDefault();
                this.undo();
            }
            if ((e.ctrlKey || e.metaKey) && (e.key === 'y' || (e.key === 'z' && e.shiftKey))) {
                e.preventDefault();
                this.redo();
            }
        };
        document.addEventListener('keydown', this._keyHandler);
    }

    /* ── Debounced save ───────────────────────────────────────────── */
    _debounceSave(view, delay) {
        clearTimeout(this._saveTimer);
        this._saveTimer = setTimeout(() => this._saveState(view), delay);
    }

    /* ── Save state ───────────────────────────────────────────────── */
    _saveState(view) {
        const canvas = this.canvasManager.canvases[view];
        if (!canvas) return;

        const json = JSON.stringify(canvas.toDatalessJSON(this._customProps));
        const stack = this._history[view];

        // Skip if identical to last state
        if (stack.length > 0 && stack[stack.length - 1] === json) return;

        stack.push(json);
        if (stack.length > this._maxHistory) stack.shift();

        // New action clears redo stack
        this._redoStack[view] = [];
        this._emitStatus();
    }

    /* ── Undo ─────────────────────────────────────────────────────── */
    undo() {
        const view = this.canvasManager.activeView;
        const stack = this._history[view];
        if (stack.length <= 1) return; // keep at least 1 (initial) state

        this._isWorking = true;
        const current = stack.pop();                         // remove current
        this._redoStack[view].push(current);                   // push to redo
        const prev = stack[stack.length - 1];             // peek previous

        this._loadState(view, prev, () => {
            this._isWorking = false;
            this._emitStatus();
        });
    }

    /* ── Redo ─────────────────────────────────────────────────────── */
    redo() {
        const view = this.canvasManager.activeView;
        const redo = this._redoStack[view];
        if (redo.length === 0) return;

        this._isWorking = true;
        const next = redo.pop();
        this._history[view].push(next);

        this._loadState(view, next, () => {
            this._isWorking = false;
            this._emitStatus();
        });
    }

    /* ── Load state ───────────────────────────────────────────────── */
    _loadState(view, state, done = () => { }) {
        const canvas = this.canvasManager.canvases[view];
        if (!canvas || !state) {
            this._isWorking = false;
            done();
            return;
        }

        canvas.loadFromJSON(state, () => {
            canvas.renderAll();
            done();
        });
    }

    /* ── Emit button state ────────────────────────────────────────── */
    _emitStatus() {
        const view = this.canvasManager.activeView;
        this.bus.emit('history:updated', {
            canUndo: (this._history[view]?.length || 0) > 1,
            canRedo: (this._redoStack[view]?.length || 0) > 0,
            view,
        });
    }

    /* ── Cleanup ──────────────────────────────────────────────────── */
    destroy() {
        clearTimeout(this._saveTimer);
        document.removeEventListener('keydown', this._keyHandler);
        super.destroy();
    }
}

window.DesignLab = window.DesignLab || {};
window.DesignLab.HistoryEngine = HistoryEngine;

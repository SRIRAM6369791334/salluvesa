/**
 * BaseEngine — Abstract base class for all Design Lab engines
 * Provides: abstract enforcement, canvas helpers, destroy lifecycle
 */
class BaseEngine {
    constructor(canvasManager) {
        if (new.target === BaseEngine) {
            throw new Error('[BaseEngine] Cannot instantiate abstract class BaseEngine directly.');
        }
        if (!canvasManager) {
            throw new Error(`[${new.target.name}] canvasManager is required.`);
        }

        this.canvasManager = canvasManager;
        this.bus = window.DesignLab.EventBus;
        this._busHandlers = []; // track all bus subscriptions for destroy()
    }

    /* ── Canvas Helpers ──────────────────────────────────────────── */

    /**
     * Get canvas for a given view (or active view if none given)
     * @param {string} [view]
     * @returns {fabric.Canvas|null}
     */
    getCanvas(view) {
        const v = view || this.canvasManager.activeView;
        return this.canvasManager.canvases[v] || null;
    }

    /**
     * Get the currently active canvas
     * @returns {fabric.Canvas|null}
     */
    getActiveCanvas() {
        return this.canvasManager.getCanvas();
    }

    /* ── Bus Helper (tracked for cleanup) ────────────────────────── */

    /**
     * Subscribe to bus event — handler is tracked for destroy()
     */
    listenBus(event, handler) {
        this.bus.on(event, handler);
        this._busHandlers.push({ event, handler });
    }

    /* ── Lifecycle ───────────────────────────────────────────────── */

    /**
     * Default destroy — removes all tracked bus listeners.
     * Subclasses should call super.destroy() if they override.
     */
    destroy() {
        this._busHandlers.forEach(({ event, handler }) => this.bus.off(event, handler));
        this._busHandlers = [];
    }
}

window.DesignLab = window.DesignLab || {};
window.DesignLab.BaseEngine = BaseEngine;

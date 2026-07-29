/**
 * ColorEngine — Handles product background color application to canvas.
 * (Previously a stub. ProductEngine handles API color data; this class
 * handles the canvas-side application of those colors.)
 * Extends BaseEngine.
 */
class ColorEngine extends DesignLab.BaseEngine {
    constructor(canvasManager, app) {
        super(canvasManager);
        this.app = app;

        const onColorChanged = (color) => this._applyColorToCanvas(color);
        this.listenBus('color:changed', onColorChanged);
    }

    /* ── Apply mockup image per view ──────────────────────────────── */
    _applyColorToCanvas(color) {
        if (!color?.views) return;
        Object.entries(color.views).forEach(([viewKey, imageUrl]) => {
            if (imageUrl) {
                this.canvasManager.setBackgroundImage(imageUrl, viewKey);
            }
        });
    }

    /* ── Cleanup ──────────────────────────────────────────────────── */
    destroy() {
        super.destroy();
    }
}

window.DesignLab = window.DesignLab || {};
window.DesignLab.ColorEngine = ColorEngine;

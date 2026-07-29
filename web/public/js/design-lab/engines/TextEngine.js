/**
 * TextEngine — Full typography editing, shadow, stroke, font-ready guard.
 * Extends BaseEngine.
 */
class TextEngine extends DesignLab.BaseEngine {
    constructor(canvasManager) {
        super(canvasManager);
        this._init();
    }

    /* ── Init ─────────────────────────────────────────────────────── */
    _init() {
        const addBtn = document.getElementById('add-text-btn');
        if (addBtn) addBtn.addEventListener('click', () => this._addNewText());

        this._setupStylingListeners();

        // Sync side panel when an i-text is selected
        const onSelected = (obj) => {
            if (obj && (obj.type === 'i-text' || obj.type === 'text')) {
                this._syncUIToObject(obj);
                this._showTextArea();
            }
        };
        this.listenBus('object:selected', onSelected);

        // Sync live edits back to panel
        const onModified = ({ view }) => {
            const canvas = this.canvasManager.canvases[view];
            const active = canvas?.getActiveObject();
            if (active && (active.type === 'i-text' || active.type === 'text')) {
                this._syncUIToObject(active);
            }
        };
        this.listenBus('canvas:modified', onModified);

        // Hide textarea on deselect
        const onDeselected = () => this._hideTextArea();
        this.listenBus('object:deselected', onDeselected);
    }

    /* ── Add Text ─────────────────────────────────────────────────── */
    async _addNewText() {
        // Wait for fonts to be ready to avoid fallback rendering
        if (document.fonts?.ready) await document.fonts.ready;

        const canvas = this.canvasManager.getCanvas();
        const center = canvas.getCenter();
        const offset = (canvas.getObjects().length * 12) % 60;

        // Read current panel values
        const content = (document.getElementById('text-content')?.value || '').trim() || 'Your Text Here';
        const fontFamily = document.getElementById('font-family')?.value || 'Red Hat Display';
        const fontSizeIn = parseFloat(document.getElementById('font-size')?.value || '1');
        const fill = document.getElementById('text-color')?.value || '#000000';
        const spacing = parseInt(document.getElementById('char-spacing')?.value || '0', 10);

        // Convert inches to canvas pixels (canvas is typically ~300px = 3in → 100px/in)
        const fontSize = Math.round(fontSizeIn * 100);

        const textObj = new fabric.IText(content, {
            left: center.left + offset,
            top: center.top + offset,
            originX: 'center',
            originY: 'center',
            fontFamily,
            fontSize: Math.max(8, Math.min(fontSize, 400)),
            fill,
            charSpacing: spacing,
            cornerColor: '#1C30A3',
            cornerSize: 10,
            transparentCorners: false,
        });

        // Apply stroke if enabled
        const strokeEnabled = document.getElementById('text-stroke-enabled')?.checked;
        if (strokeEnabled) {
            textObj.set({
                stroke: document.getElementById('text-stroke-color')?.value || '#ffffff',
                strokeWidth: parseFloat(document.getElementById('text-stroke-width')?.value || '0') * 10,
            });
        }

        // Apply shadow if enabled
        const shadowEnabled = document.getElementById('text-shadow-enabled')?.checked;
        if (shadowEnabled) {
            textObj.set('shadow', this._buildShadow());
        }

        this.canvasManager.addObject(textObj);
        this._showTextArea();
        this.bus.emit('ui:switch-tab', 'text');
    }

    /* ── Styling listeners ────────────────────────────────────────── */
    _setupStylingListeners() {
        // Simple property mappings
        const controls = {
            'font-family': { prop: 'fontFamily', event: 'change', transform: v => v },
            'text-color': { prop: 'fill', event: 'input', transform: v => v },
            'font-size': { prop: 'fontSize', event: 'input', transform: v => Math.max(8, Math.round(parseFloat(v) * 100)) },
            'char-spacing': { prop: 'charSpacing', event: 'input', transform: v => parseInt(v, 10) },
        };

        Object.entries(controls).forEach(([id, { prop, event, transform }]) => {
            const el = document.getElementById(id);
            if (!el) return;
            el.addEventListener(event, () => {
                const active = this.canvasManager.getCanvas()?.getActiveObject();
                if (!active || (active.type !== 'i-text' && active.type !== 'text')) return;
                active.set(prop, transform(el.value));
                this.canvasManager.getCanvas().renderAll();
            });
        });

        // Text content live update
        const textArea = document.getElementById('text-content');
        if (textArea) {
            textArea.addEventListener('input', () => {
                const active = this.canvasManager.getCanvas()?.getActiveObject();
                if (!active || active.type !== 'i-text') return;
                active.set('text', textArea.value);
                this.canvasManager.getCanvas().renderAll();
            });
        }

        // Stroke controls
        const strokeEnabled = document.getElementById('text-stroke-enabled');
        const strokeColor = document.getElementById('text-stroke-color');
        const strokeWidth = document.getElementById('text-stroke-width');
        const strokePanel = document.getElementById('text-stroke-controls');

        const applyStroke = () => {
            const active = this.canvasManager.getCanvas()?.getActiveObject();
            if (!active || (active.type !== 'i-text' && active.type !== 'text')) return;
            if (strokeEnabled?.checked) {
                active.set({
                    stroke: strokeColor?.value || '#ffffff',
                    strokeWidth: parseFloat(strokeWidth?.value || '0') * 10,
                });
                if (strokePanel) strokePanel.style.display = 'block';
            } else {
                active.set({ stroke: null, strokeWidth: 0 });
                if (strokePanel) strokePanel.style.display = 'none';
            }
            this.canvasManager.getCanvas().renderAll();
        };

        [strokeEnabled, strokeColor, strokeWidth].forEach(el => {
            if (el) el.addEventListener('input', applyStroke);
        });

        // Shadow controls
        const shadowEnabled = document.getElementById('text-shadow-enabled');
        const shadowPanel = document.getElementById('text-shadow-controls');

        const applyShadow = () => {
            const active = this.canvasManager.getCanvas()?.getActiveObject();
            if (!active || (active.type !== 'i-text' && active.type !== 'text')) return;
            if (shadowEnabled?.checked) {
                active.set('shadow', this._buildShadow());
                if (shadowPanel) shadowPanel.style.display = 'block';
            } else {
                active.set('shadow', null);
                if (shadowPanel) shadowPanel.style.display = 'none';
            }
            this.canvasManager.getCanvas().renderAll();
        };

        const shadowColor = document.getElementById('text-shadow-color');
        const shadowBlur = document.getElementById('text-shadow-blur');
        const shadowOffset = document.getElementById('text-shadow-offset');

        [shadowEnabled, shadowColor, shadowBlur, shadowOffset].forEach(el => {
            if (el) el.addEventListener('input', applyShadow);
        });
    }

    /* ── Build fabric.Shadow ──────────────────────────────────────── */
    _buildShadow() {
        const color = document.getElementById('text-shadow-color')?.value || '#000000';
        const blur = parseFloat(document.getElementById('text-shadow-blur')?.value || '4');
        const offset = parseFloat(document.getElementById('text-shadow-offset')?.value || '0.05') * 100;
        return new fabric.Shadow({ color, blur, offsetX: offset, offsetY: offset });
    }

    /* ── Sync UI ──────────────────────────────────────────────────── */
    _syncUIToObject(obj) {
        this._setVal('text-content', obj.text || '');
        this._setVal('font-family', obj.fontFamily || 'Red Hat Display');
        this._setVal('text-color', typeof obj.fill === 'string' ? obj.fill : '#000000');
        this._setVal('font-size', String(+(((obj.fontSize || 40) / 100).toFixed(2))));
        this._setVal('char-spacing', String(obj.charSpacing || 0));

        // Stroke
        const hasStroke = !!obj.stroke && obj.strokeWidth > 0;
        const strokeEl = document.getElementById('text-stroke-enabled');
        if (strokeEl) strokeEl.checked = hasStroke;
        if (obj.stroke) this._setVal('text-stroke-color', obj.stroke);
        this._setVal('text-stroke-width', String((obj.strokeWidth || 0) / 10));
        const strokePanel = document.getElementById('text-stroke-controls');
        if (strokePanel) strokePanel.style.display = hasStroke ? 'block' : 'none';

        // Shadow
        const shadow = obj.shadow;
        const hasShadow = !!shadow;
        const shadowEl = document.getElementById('text-shadow-enabled');
        if (shadowEl) shadowEl.checked = hasShadow;
        if (shadow) {
            this._setVal('text-shadow-color', shadow.color || '#000000');
            this._setVal('text-shadow-blur', String(shadow.blur || 4));
            this._setVal('text-shadow-offset', String(+(((shadow.offsetX || 5) / 100).toFixed(2))));
        }
        const shadowPanel = document.getElementById('text-shadow-controls');
        if (shadowPanel) shadowPanel.style.display = hasShadow ? 'block' : 'none';
    }

    _setVal(id, value) {
        const el = document.getElementById(id);
        if (el) el.value = value;
    }

    _showTextArea() {
        const ta = document.getElementById('text-content');
        if (ta) ta.style.display = 'block';
    }

    _hideTextArea() {
        const ta = document.getElementById('text-content');
        if (ta) ta.style.display = 'none';
    }

    /* ── Cleanup ──────────────────────────────────────────────────── */
    destroy() {
        super.destroy();
    }
}

window.DesignLab = window.DesignLab || {};
window.DesignLab.TextEngine = TextEngine;

/**
 * LayerEngine — Layer list UI + layer actions via EventBus
 * Fixes: reversed-index bug, no globals, debounced updates,
 *        canvas:modified emit on visibility toggle, whitespace trim.
 */
class LayerEngine extends DesignLab.BaseEngine {
    constructor(canvasManager) {
        super(canvasManager);
        this._updateDebounceTimer = null;
        this._init();
    }

    /* ── Init ─────────────────────────────────────────────────────── */
    _init() {
        const onModified = () => this._scheduleUpdate();
        const onChanged = () => this._scheduleUpdate();

        this.listenBus('canvas:modified', onModified);
        this.listenBus('view:changed', onChanged);
        this.listenBus('object:selected', () => this._scheduleUpdate());

        // Bus-driven layer actions (no global window.customizer needed)
        this.listenBus('layer:moveUp', ({ index }) => this._moveUp(index));
        this.listenBus('layer:moveDown', ({ index }) => this._moveDown(index));
        this.listenBus('layer:toggleLock', ({ index }) => this._toggleLock(index));
        this.listenBus('layer:toggleVis', ({ index }) => this._toggleVis(index));
        this.listenBus('layer:delete', ({ index }) => this._delete(index));
    }

    /* ── Debounced update ─────────────────────────────────────────── */
    _scheduleUpdate() {
        clearTimeout(this._updateDebounceTimer);
        this._updateDebounceTimer = setTimeout(() => this._updateLayersUI(), 80);
    }

    /* ── UI Render ────────────────────────────────────────────────── */
    _updateLayersUI() {
        const grid = document.getElementById('layers-list');
        if (!grid) return;

        const canvas = this.canvasManager.getCanvas();
        if (!canvas) return;

        // Get objects in stack order (bottom → top), then reverse for display (top first)
        const objects = canvas.getObjects();
        const displayOrder = [...objects].reverse(); // visual top-first order
        const total = objects.length;

        if (total === 0) {
            grid.innerHTML = '<div class="cs_empty_msg">No layers yet</div>';
            return;
        }

        const activeObj = canvas.getActiveObject();

        grid.innerHTML = displayOrder.map((obj) => {
            // Real canvas index = total - 1 - displayIndex
            const realIndex = objects.indexOf(obj);
            const isActive = activeObj === obj;
            return `
            <div class="cs_layer_item ${isActive ? 'active' : ''}" data-index="${realIndex}">
                <span class="cs_layer_icon"><i class="${this._getTypeIcon(obj)}"></i></span>
                <span class="cs_layer_name">${this._getObjectName(obj)}</span>
                <div class="cs_layer_actions">
                    <button class="cs_layer_btn" data-action="moveUp"     data-index="${realIndex}" title="Bring Forward"><i class="fas fa-chevron-up"></i></button>
                    <button class="cs_layer_btn" data-action="moveDown"   data-index="${realIndex}" title="Send Backward"><i class="fas fa-chevron-down"></i></button>
                    <button class="cs_layer_btn" data-action="toggleLock" data-index="${realIndex}" title="${obj.lockMovementX ? 'Unlock' : 'Lock'}">
                        <i class="fas ${obj.lockMovementX ? 'fa-lock' : 'fa-lock-open'}"></i>
                    </button>
                    <button class="cs_layer_btn" data-action="toggleVis"  data-index="${realIndex}" title="Toggle Visibility">
                        <i class="fas ${obj.visible === false ? 'fa-eye-slash' : 'fa-eye'}"></i>
                    </button>
                    <button class="cs_layer_btn" data-action="delete"     data-index="${realIndex}" title="Delete"><i class="fas fa-trash"></i></button>
                </div>
            </div>`;
        }).join('');

        // Attach event delegation on the grid
        grid.querySelectorAll('.cs_layer_btn').forEach(btn => {
            btn.addEventListener('click', (e) => {
                e.stopPropagation();
                const action = btn.dataset.action;
                const index = parseInt(btn.dataset.index, 10);
                this.bus.emit(`layer:${action}`, { index });
            });
        });

        // Click on layer item → select that object
        grid.querySelectorAll('.cs_layer_item').forEach(item => {
            item.addEventListener('click', (e) => {
                if (e.target.closest('.cs_layer_btn')) return;
                const index = parseInt(item.dataset.index, 10);
                const canvas = this.canvasManager.getCanvas();
                const obj = canvas?.getObjects()[index];
                if (obj && canvas) {
                    canvas.setActiveObject(obj);
                    canvas.renderAll();
                }
            });
        });
    }

    /* ── Layer Actions ────────────────────────────────────────────── */
    _getCanvas() { return this.canvasManager.getCanvas(); }
    _getObj(index) { return this._getCanvas()?.getObjects()[index] || null; }
    _view() { return this.canvasManager.activeView; }

    _moveUp(index) {
        const canvas = this._getCanvas();
        const obj = this._getObj(index);
        if (!canvas || !obj) return;
        canvas.bringForward(obj);
        canvas.renderAll();
        this.bus.emit('canvas:modified', { view: this._view() });
    }

    _moveDown(index) {
        const canvas = this._getCanvas();
        const obj = this._getObj(index);
        if (!canvas || !obj) return;
        canvas.sendBackwards(obj);
        canvas.renderAll();
        this.bus.emit('canvas:modified', { view: this._view() });
    }

    _toggleLock(index) {
        const canvas = this._getCanvas();
        const obj = this._getObj(index);
        if (!canvas || !obj) return;
        const isLocked = !!obj.lockMovementX;
        obj.set({
            lockMovementX: !isLocked,
            lockMovementY: !isLocked,
            lockRotation: !isLocked,
            lockScalingX: !isLocked,
            lockScalingY: !isLocked,
            hasControls: isLocked, // show controls only when unlocked
        });
        canvas.discardActiveObject();
        canvas.renderAll();
        this._scheduleUpdate();
    }

    _toggleVis(index) {
        const canvas = this._getCanvas();
        const obj = this._getObj(index);
        if (!canvas || !obj) return;
        obj.visible = !obj.visible;
        canvas.renderAll();
        this.bus.emit('canvas:modified', { view: this._view() });
    }

    _delete(index) {
        const canvas = this._getCanvas();
        const obj = this._getObj(index);
        if (!canvas || !obj) return;
        canvas.remove(obj);
        canvas.renderAll();
        this.bus.emit('canvas:modified', { view: this._view() });
    }

    /* ── Helpers ──────────────────────────────────────────────────── */
    _getTypeIcon(obj) {
        if (obj.type === 'i-text' || obj.type === 'text') return 'fas fa-font';
        if (obj.type === 'image') return 'fas fa-image';
        if (obj.type === 'group') return 'fas fa-object-group';
        return 'fas fa-shapes';
    }

    _getObjectName(obj) {
        if (obj.customLabel) return obj.customLabel.substring(0, 18);
        if (obj.type === 'i-text' || obj.type === 'text') {
            return (obj.text || '').trim().substring(0, 18) || 'Text';
        }
        if (obj.type === 'image') return 'Uploaded Image';
        if (obj.customType === 'clipart') return 'Clipart';
        return 'Object';
    }

    /* ── Cleanup ──────────────────────────────────────────────────── */
    destroy() {
        clearTimeout(this._updateDebounceTimer);
        super.destroy();
    }
}

window.DesignLab = window.DesignLab || {};
window.DesignLab.LayerEngine = LayerEngine;

/**
 * TeamEngine — Roster management for team personalization.
 * Extends BaseEngine. Fixes: variable naming, DRY parsing, fonts.ready,
 * clears only back view, emits canvas:modified.
 */
class TeamEngine extends DesignLab.BaseEngine {
    constructor(canvasManager, app) {
        super(canvasManager);
        this.app = app;
        this.roster = [];
        this._init();
    }

    /* ── Init ─────────────────────────────────────────────────────── */
    _init() {
        const onLoaded = () => { this.roster = []; };
        this.listenBus('product:loaded', onLoaded);

        // Blade button emits via EventBus (no window.customizer needed)
        const onApply = () => this.updateRoster();
        this.listenBus('roster:apply', onApply);
    }

    /* ── Parse roster rows (single source of truth) ───────────────── */
    _parseRosterRows() {
        const rows = document.querySelectorAll('#roster-tbody tr');
        const data = [];
        rows.forEach(row => {
            const nameVal = row.querySelector('.roster-name')?.value?.trim() || '';
            const numberVal = row.querySelector('.roster-number')?.value?.trim() || '';
            const sizeVal = row.querySelector('.roster-size')?.value || 'M';
            if (nameVal || numberVal) {
                data.push({ name: nameVal, number: numberVal, size: sizeVal });
            }
        });
        return data;
    }

    /* ── updateRoster — called from Blade button ──────────────────── */
    updateRoster() {
        this.roster = this._parseRosterRows();

        if (this.roster.length === 0) {
            this._clearRosterElements();
            this.bus.emit('ui:notify', { msg: 'Roster cleared.', icon: 'info' });
            return;
        }

        // Wait for fonts before rendering canvas text
        const apply = () => {
            this._applyRosterToCanvas();
            this.bus.emit('ui:notify', { msg: 'Team personalization applied to Back.', icon: 'success' });
            // Switch to back view to show result
            if (this.canvasManager.activeView !== 'back') {
                this.bus.emit('view:change', 'back');
            }
        };

        if (document.fonts?.ready) {
            document.fonts.ready.then(apply);
        } else {
            apply();
        }
    }

    /* ── Apply representative to back canvas ──────────────────────── */
    _applyRosterToCanvas() {
        const backCanvas = this.canvasManager.canvases['back'];
        if (!backCanvas) {
            this.bus.emit('ui:notify', { msg: 'Back canvas not available.', icon: 'warning' });
            return;
        }

        this._clearRosterElements();

        const rep = this.roster[0]; // representative first member
        const center = backCanvas.getCenter();

        const nameObj = new fabric.IText(rep.name || 'NAME', {
            left: center.left,
            top: center.top - 60,
            originX: 'center',
            originY: 'center',
            fontSize: 40,
            fontFamily: 'Bebas Neue',
            fill: '#333333',
            isRosterElement: true,
            rosterType: 'name',
            selectable: true,
            hasControls: true,
        });

        const numObj = new fabric.IText(rep.number || '00', {
            left: center.left,
            top: center.top + 20,
            originX: 'center',
            originY: 'center',
            fontSize: 100,
            fontFamily: 'Bebas Neue',
            fill: '#333333',
            isRosterElement: true,
            rosterType: 'number',
            selectable: true,
            hasControls: true,
        });

        backCanvas.add(nameObj, numObj);
        backCanvas.setActiveObject(nameObj);
        backCanvas.renderAll();

        this.bus.emit('canvas:modified', { view: 'back' });
    }

    /* ── Clear roster elements (back canvas only) ─────────────────── */
    _clearRosterElements() {
        const backCanvas = this.canvasManager.canvases['back'];
        if (!backCanvas) return;
        const toRemove = backCanvas.getObjects().filter(o => o.isRosterElement);
        toRemove.forEach(o => backCanvas.remove(o));
        backCanvas.renderAll();
    }

    /* ── Public: return current roster (used by ExportEngine) ─────── */
    getRosterData() {
        this.roster = this._parseRosterRows();
        return this.roster;
    }

    /* ── Cleanup ──────────────────────────────────────────────────── */
    destroy() {
        super.destroy();
    }
}

window.DesignLab = window.DesignLab || {};
window.DesignLab.TeamEngine = TeamEngine;

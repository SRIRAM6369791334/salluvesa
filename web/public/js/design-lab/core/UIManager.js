/**
 * UIManager — Sidebar tabs, drawer panels, undo/redo state, notifications
 */
class UIManager {
    constructor() {
        this.bus = window.DesignLab.EventBus;
        this.activeTool = null;
        this._handlers = []; // tracked bus handlers

        this._init();
    }

    /* ── Init ─────────────────────────────────────────────────────── */
    _init() {
        // Sidebar tab switching
        document.querySelectorAll('.cs_sidebar_tab').forEach(tab => {
            tab.addEventListener('click', () => this.switchTool(tab.dataset.tool));
        });

        // Close drawer button
        const closeBtn = document.getElementById('close-drawer');
        if (closeBtn) {
            closeBtn.addEventListener('click', () => this._closeDrawer());
        }


        // Object selected → auto-switch panel
        const onSelected = (obj) => {
            if (!obj) return;
            if (obj.type === 'i-text' || obj.type === 'text') {
                this.switchTool('text');
            } else if (obj.type === 'activeSelection') {
                // multi-select: no auto-switch
            }
        };
        this.bus.on('object:selected', onSelected);
        this._handlers.push({ event: 'object:selected', handler: onSelected });

        // Global notify
        const onNotify = (data) => this.notify(data.msg, data.icon);
        this.bus.on('ui:notify', onNotify);
        this._handlers.push({ event: 'ui:notify', handler: onNotify });

        // External tab switch request
        const onSwitch = (tool) => this.switchTool(tool);
        this.bus.on('ui:switch-tab', onSwitch);
        this._handlers.push({ event: 'ui:switch-tab', handler: onSwitch });

        // Undo/Redo button state from HistoryEngine
        const onHistoryUpdated = ({ canUndo, canRedo }) => {
            const undoBtn = document.getElementById('undo-btn');
            const redoBtn = document.getElementById('redo-btn');
            if (undoBtn) undoBtn.disabled = !canUndo;
            if (redoBtn) redoBtn.disabled = !canRedo;
        };
        this.bus.on('history:updated', onHistoryUpdated);
        this._handlers.push({ event: 'history:updated', handler: onHistoryUpdated });
    }

    /* ── Tool switching ───────────────────────────────────────────── */
    switchTool(tool) {
        if (!tool) return;
        const drawer = document.getElementById('design-drawer');

        // Toggle: clicking the same tool closes the drawer
        if (tool === this.activeTool && drawer && drawer.classList.contains('active')) {
            this._closeDrawer();
            return;
        }

        this.activeTool = tool;

        // Update sidebar active state
        document.querySelectorAll('.cs_sidebar_tab').forEach(tab => {
            tab.classList.toggle('active', tab.dataset.tool === tool);
        });

        // Open drawer
        if (drawer) drawer.classList.add('active');

        // Switch panel
        document.querySelectorAll('.cs_tool_panel').forEach(panel => {
            panel.classList.toggle('active', panel.id === `tool-panel-${tool}`);
        });

        // Update drawer title — read from tab dataset first, then fallback map
        const tab = document.querySelector(`.cs_sidebar_tab[data-tool="${tool}"]`);
        const titleFromTab = tab?.dataset.title || tab?.title || tab?.querySelector('span')?.textContent?.trim();
        const fallbackMap = {
            'upload': 'Upload Image',
            'text': 'Edit Text',
            'clipart': 'Add Art',
            'product': 'Product Options',
            'names-numbers': 'Personalize',
            'layers': 'Manage Layers',
        };
        const titleEl = document.getElementById('drawer-title');
        if (titleEl) titleEl.textContent = titleFromTab || fallbackMap[tool] || 'Design Lab';

        this.bus.emit('tool:switched', tool);
    }

    /* ── Drawer ───────────────────────────────────────────────────── */
    _closeDrawer() {
        const drawer = document.getElementById('design-drawer');
        if (drawer) drawer.classList.remove('active');
        this.activeTool = null;
        document.querySelectorAll('.cs_sidebar_tab').forEach(t => t.classList.remove('active'));
    }

    /* ── Notifications ────────────────────────────────────────────── */
    notify(msg, icon = 'info') {
        if (window.Swal) {
            Swal.fire({
                text: msg,
                icon: icon,
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
            });
            return;
        }

        // DOM fallback toast
        this._showDOMToast(msg, icon);
    }

    _showDOMToast(msg, icon) {
        const existing = document.getElementById('_dl_toast');
        if (existing) existing.remove();

        const colours = { success: '#16a34a', error: '#dc2626', warning: '#d97706', info: '#2563eb' };
        const toast = document.createElement('div');
        toast.id = '_dl_toast';
        Object.assign(toast.style, {
            position: 'fixed',
            top: '16px',
            right: '16px',
            background: colours[icon] || colours.info,
            color: '#fff',
            padding: '12px 20px',
            borderRadius: '8px',
            fontFamily: 'sans-serif',
            fontSize: '14px',
            zIndex: '99999',
            boxShadow: '0 4px 12px rgba(0,0,0,0.15)',
            transition: 'opacity .3s',
            maxWidth: '320px',
        });
        toast.textContent = msg;
        document.body.appendChild(toast);
        setTimeout(() => { toast.style.opacity = '0'; setTimeout(() => toast.remove(), 300); }, 3000);
    }

    /* ── Cleanup ──────────────────────────────────────────────────── */
    destroy() {
        this._handlers.forEach(({ event, handler }) => this.bus.off(event, handler));
        this._handlers = [];
    }
}

window.DesignLab = window.DesignLab || {};
window.DesignLab.UIManager = UIManager;

/**
 * ClipartEngine — Emoji/Art panel with real search, category tracking,
 * index-based data-id, fabric.Text (non-editable), debounced search.
 * Extends BaseEngine.
 */
class ClipartEngine extends DesignLab.BaseEngine {
    constructor(canvasManager) {
        super(canvasManager);

        // Structured library: { category: [{ char, name }] }
        this._library = {
            sports: [
                { char: '⚽', name: 'soccer football' },
                { char: '🏀', name: 'basketball' },
                { char: '⚾', name: 'baseball' },
                { char: '🏈', name: 'american football' },
                { char: '🎾', name: 'tennis' },
                { char: '🏐', name: 'volleyball' },
                { char: '🏒', name: 'hockey' },
                { char: '🥊', name: 'boxing gloves' },
                { char: '🎯', name: 'dart target' },
                { char: '⛳', name: 'golf' },
                { char: '🏊', name: 'swimming' },
                { char: '🚴', name: 'cycling' },
                { char: '🏋️', name: 'weightlifting' },
                { char: '🤺', name: 'fencing' },
                { char: '🥋', name: 'martial arts' },
            ],
            symbols: [
                { char: '❤️', name: 'heart love' },
                { char: '⭐', name: 'star' },
                { char: '🔥', name: 'fire flame' },
                { char: '💎', name: 'diamond gem' },
                { char: '🌟', name: 'glowing star' },
                { char: '💫', name: 'dizzy star' },
                { char: '✨', name: 'sparkles' },
                { char: '⚡', name: 'lightning bolt' },
                { char: '☀️', name: 'sun' },
                { char: '🌈', name: 'rainbow' },
                { char: '🎵', name: 'music note' },
                { char: '🎶', name: 'music notes' },
                { char: '🏆', name: 'trophy winner' },
                { char: '🥇', name: 'gold medal first' },
                { char: '👑', name: 'crown king queen' },
            ],
            business: [
                { char: '💼', name: 'briefcase business' },
                { char: '📈', name: 'chart growth' },
                { char: '🏢', name: 'office building' },
                { char: '💻', name: 'laptop computer' },
                { char: '💡', name: 'lightbulb idea' },
                { char: '🤝', name: 'handshake deal' },
                { char: '📅', name: 'calendar' },
                { char: '✉️', name: 'email message' },
                { char: '🛡️', name: 'shield security' },
                { char: '🚀', name: 'rocket launch startup' },
                { char: '🎯', name: 'target goal' },
                { char: '📊', name: 'bar chart' },
                { char: '🔑', name: 'key access' },
                { char: '⚙️', name: 'settings gear' },
                { char: '🌐', name: 'globe web' },
            ],
        };

        this._allItems = Object.values(this._library).flat();
        this._activeCategory = 'sports';
        this._searchTimer = null;

        this._init();
    }

    /* ── Init ─────────────────────────────────────────────────────── */
    _init() {
        // Category buttons
        document.querySelectorAll('.cs_clipart_category_btn').forEach(btn => {
            btn.addEventListener('click', () => {
                document.querySelectorAll('.cs_clipart_category_btn')
                    .forEach(b => b.classList.remove('active'));
                btn.classList.add('active');
                this._activeCategory = btn.dataset.category;
                this._renderItems(this._library[this._activeCategory] || []);
            });
        });

        // Debounced search
        const searchInput = document.querySelector('#tool-panel-clipart .cs_search_box input');
        if (searchInput) {
            searchInput.addEventListener('input', (e) => {
                clearTimeout(this._searchTimer);
                this._searchTimer = setTimeout(() => this._search(e.target.value), 200);
            });
        }

        // Initial render
        this._renderItems(this._library[this._activeCategory]);
    }

    /* ── Render ───────────────────────────────────────────────────── */
    _renderItems(items) {
        const grid = document.getElementById('clipart-list');
        if (!grid) return;

        // Store current items for index lookup
        this._currentItems = items;

        grid.innerHTML = items.map((item, index) => `
            <div class="cs_clipart_item" data-index="${index}" title="${item.name}">
                <span>${item.char}</span>
            </div>
        `).join('');

        grid.querySelectorAll('.cs_clipart_item').forEach(el => {
            el.addEventListener('click', () => {
                const idx = parseInt(el.dataset.index, 10);
                const item = this._currentItems[idx];
                if (item) this._addEmoji(item.char);
            });
        });
    }

    /* ── Search ───────────────────────────────────────────────────── */
    _search(query) {
        const q = (query || '').trim().toLowerCase();
        if (!q) {
            this._renderItems(this._library[this._activeCategory] || []);
            return;
        }
        const results = this._allItems.filter(item =>
            item.name.includes(q) || item.char.includes(q)
        );
        this._renderItems(results.length ? results : []);
    }

    /* ── Add emoji to canvas ──────────────────────────────────────── */
    _addEmoji(char) {
        const canvas = this.canvasManager.getCanvas();
        const center = canvas.getCenter();
        const offset = (canvas.getObjects().length * 12) % 60;

        // fabric.Text (non-editable) — not IText
        const text = new fabric.Text(char, {
            left: center.left + offset,
            top: center.top + offset,
            originX: 'center',
            originY: 'center',
            fontSize: 80,
            fontFamily: 'Segoe UI Emoji',
            selectable: true,
            hasControls: true,
            customType: 'clipart',
            excludeFromPrice: false,
            // Source tracking for emojis
            sourcePath: 'emoji:' + char,
            layerName: 'Emoji: ' + char
        });

        this.canvasManager.addObject(text);
        this.bus.emit('ui:notify', { msg: 'Art added to design!', icon: 'success' });
    }

    /* ── Add real SVG ─────────────────────────────────────────────── */
    addSVG(url) {
        fabric.loadSVGFromURL(url, (objects, options) => {
            if (!objects || objects.length === 0) {
                this.bus.emit('ui:notify', { msg: 'Could not load SVG file.', icon: 'error' });
                return;
            }
            const obj = fabric.util.groupSVGElements(objects, options);
            obj.scaleToWidth(150);
            obj.set({ 
                customType: 'clipart',
                sourcePath: url,
                layerName: 'Icon: ' + (url.split('/').pop() || 'Art')
            });
            this.canvasManager.addObject(obj); // addObject centers it
        }, (err) => {
            console.error('[ClipartEngine] SVG load error:', err);
            this.bus.emit('ui:notify', { msg: 'Failed to load SVG art.', icon: 'error' });
        }, { crossOrigin: 'anonymous' });
    }

    /* ── Cleanup ──────────────────────────────────────────────────── */
    destroy() {
        clearTimeout(this._searchTimer);
        super.destroy();
    }
}

window.DesignLab = window.DesignLab || {};
window.DesignLab.ClipartEngine = ClipartEngine;

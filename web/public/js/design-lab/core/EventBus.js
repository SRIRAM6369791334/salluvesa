/**
 * EventBus — Production-grade Pub/Sub for Design Lab
 * Features: on, off, once, emit (safe), debug mode, memory-leak prevention
 */
class EventBus {
    constructor(options = {}) {
        this._listeners = {};
        this._debug = options.debug === true;
    }

    /* ───────────────────────── subscribe ───────────────────────── */
    on(event, callback) {
        if (typeof callback !== 'function') {
            console.warn(`[EventBus] on("${event}"): callback must be a function`);
            return this;
        }
        if (!this._listeners[event]) this._listeners[event] = [];
        // Prevent duplicate listeners
        if (!this._listeners[event].includes(callback)) {
            this._listeners[event].push(callback);
        }
        if (this._debug) console.debug(`[EventBus] on("${event}") — listeners: ${this._listeners[event].length}`);
        return this;
    }

    /* ───────────────────────── unsubscribe ─────────────────────── */
    off(event, callback) {
        if (!this._listeners[event]) return this;
        this._listeners[event] = this._listeners[event].filter(cb => cb !== callback);
        // Clean up empty arrays to prevent memory leaks
        if (this._listeners[event].length === 0) delete this._listeners[event];
        if (this._debug) console.debug(`[EventBus] off("${event}")`);
        return this;
    }

    /* ───────────────────────── subscribe once ───────────────────── */
    once(event, callback) {
        if (typeof callback !== 'function') {
            console.warn(`[EventBus] once("${event}"): callback must be a function`);
            return this;
        }
        const wrapper = (data) => {
            this.off(event, wrapper);
            callback(data);
        };
        wrapper._original = callback; // allow off() with original fn reference
        this.on(event, wrapper);
        return this;
    }

    /* ───────────────────────── publish ──────────────────────────── */
    emit(event, data) {
        if (!this._listeners[event]) return this;
        if (this._debug) console.debug(`[EventBus] emit("${event}")`, data);
        // Snapshot listeners array so mid-emit removals don't break iteration
        const listeners = [...this._listeners[event]];
        listeners.forEach(cb => {
            try {
                cb(data);
            } catch (err) {
                console.error(`[EventBus] Error in listener for "${event}":`, err);
            }
        });
        return this;
    }

    /* ───────────────────────── utilities ───────────────────────── */
    /** Remove all listeners for an event (or all events if none given) */
    clear(event) {
        if (event) {
            delete this._listeners[event];
        } else {
            this._listeners = {};
        }
        return this;
    }

    /** Check how many listeners an event has */
    listenerCount(event) {
        return (this._listeners[event] || []).length;
    }

    /** Enable / disable debug logging at runtime */
    setDebug(flag) {
        this._debug = !!flag;
        return this;
    }
}

// ── Global singleton ─────────────────────────────────────────────
window.DesignLab = window.DesignLab || {};
window.DesignLab.EventBus = new EventBus({ debug: false });

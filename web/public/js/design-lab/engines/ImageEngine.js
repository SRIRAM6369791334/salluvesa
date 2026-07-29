/**
 * ImageEngine — Secure image upload with MIME whitelist, size limit,
 * proper scaling, full error handling. Extends BaseEngine.
 * MODIFIED: Immediate server upload and source tracking.
 */
class ImageEngine extends DesignLab.BaseEngine {
    constructor(canvasManager) {
        super(canvasManager);
        this._MAX_BYTES = 10 * 1024 * 1024; // 10 MB
        this._ALLOWED = ['image/png', 'image/jpeg', 'image/webp', 'image/gif'];
        this._init();
    }

    /* ── Init ─────────────────────────────────────────────────────── */
    _init() {
        const uploadArea = document.getElementById('upload-area');
        const fileInput = document.getElementById('file-input');
        if (!uploadArea || !fileInput) return;

        // Click to browse
        uploadArea.addEventListener('click', () => fileInput.click());

        // File selected via dialog
        fileInput.addEventListener('change', (e) => {
            if (e.target.files.length) this._processFile(e.target.files[0]);
            e.target.value = ''; // reset so same file can be re-uploaded
        });

        // Drag-over styling
        uploadArea.addEventListener('dragover', (e) => {
            e.preventDefault();
            uploadArea.classList.add('dragging');
        });
        uploadArea.addEventListener('dragleave', () => uploadArea.classList.remove('dragging'));

        // Drop
        uploadArea.addEventListener('drop', (e) => {
            e.preventDefault();
            uploadArea.classList.remove('dragging');
            const files = e.dataTransfer?.files;
            if (!files || files.length === 0) return;
            if (files.length > 1) {
                this.bus.emit('ui:notify', { msg: 'Only one image at a time is supported.', icon: 'warning' });
                return;
            }
            this._processFile(files[0]);
        });
    }

    /* ── Validation ───────────────────────────────────────────────── */
    _validate(file) {
        if (!this._ALLOWED.includes(file.type)) {
            this.bus.emit('ui:notify', { msg: `File type "${file.type}" is not allowed. Use PNG, JPG, WEBP or GIF.`, icon: 'error' });
            return false;
        }
        if (file.size > this._MAX_BYTES) {
            this.bus.emit('ui:notify', { msg: 'File exceeds 10 MB limit. Please compress your image first.', icon: 'error' });
            return false;
        }
        return true;
    }

    /* ── Process ──────────────────────────────────────────────────── */
    async _processFile(file) {
        if (!this._validate(file)) return;

        // Show loading notification
        this.bus.emit('ui:notify', { msg: 'Uploading image...', icon: 'info' });

        try {
            // 1. Upload to server immediately
            const formData = new FormData();
            formData.append('image', file);

            const uploadUrl = window.__routes?.uploadUserImage || '/api/designs/upload-user-image';

            const response = await fetch(uploadUrl, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content
                },
                body: formData
            });

            const result = await response.json();

            if (!result.success) {
                throw new Error(result.message || 'Upload failed');
            }

            // 2. Use the returned URL to add to canvas
            const imageUrl = result.url;
            const sourcePath = result.path;

            fabric.Image.fromURL(imageUrl, (img) => {
                if (!img) {
                    this.bus.emit('ui:notify', { msg: 'Could not load uploaded image.', icon: 'error' });
                    return;
                }

                const canvas = this.canvasManager.getCanvas();
                const cWidth = canvas.width;
                const cHeight = canvas.height;

                // Scale to fit within the canvas, preserving aspect ratio
                const maxW = cWidth * 0.8;
                const maxH = cHeight * 0.8;
                if (img.width > maxW || img.height > maxH) {
                    const ratio = Math.min(maxW / img.width, maxH / img.height);
                    img.scale(ratio);
                }

                img.set({
                    originX: 'center',
                    originY: 'center',
                    cornerColor: '#1C30A3',
                    cornerSize: 10,
                    transparentCorners: false,
                    // CUSTOM PROPERTIES FOR PERSISTENCE
                    sourcePath: sourcePath,
                    customType: 'image'
                });

                this.canvasManager.addObject(img);
                this.bus.emit('ui:notify', { msg: 'Image uploaded and added!', icon: 'success' });
            }, { crossOrigin: 'anonymous' });

        } catch (error) {
            console.error('[ImageEngine] Upload error:', error);
            this.bus.emit('ui:notify', { msg: 'Upload failed: ' + error.message, icon: 'error' });
        }
    }

    /* ── Cleanup ──────────────────────────────────────────────────── */
    destroy() {
        super.destroy();
    }
}

window.DesignLab = window.DesignLab || {};
window.DesignLab.ImageEngine = ImageEngine;

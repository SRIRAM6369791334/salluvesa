// Design Gallery JavaScript with Premium Animations
document.addEventListener('DOMContentLoaded', function () {
    // Check if required elements exist
    if (!document.getElementById('cs_design_lightbox')) return;

    // Lightbox functionality
    const lightbox = document.getElementById('cs_design_lightbox');
    const lightboxImg = document.getElementById('cs_lightbox_img');
    const lightboxTitle = document.getElementById('cs_lightbox_title');
    const lightboxTag = document.getElementById('cs_lightbox_tag');
    const lightboxDescription = document.getElementById('cs_lightbox_description');
    const lightboxOverlay = document.getElementById('cs_lightbox_overlay');
    const lightboxClose = document.getElementById('cs_lightbox_close');

    const designItems = document.querySelectorAll('.cs_design_item');
    let currentIndex = 0;
    let isAnimating = false;

    // Premium lightbox opening with smooth scaling
    function openLightbox(index) {
        if (isAnimating) return;
        isAnimating = true;

        const item = designItems[index];
        const img = item.querySelector('img');
        const title = item.querySelector('.cs_design_title');
        const tag = item.querySelector('.cs_design_tag');

        lightboxImg.src = img.src;
        lightboxImg.style.opacity = '0';
        lightboxImg.style.transform = 'scale(0.95) translateY(10px)';

        lightboxTitle.textContent = title ? title.textContent : '';
        lightboxTag.textContent = tag ? tag.textContent : '';

        const priceEl = document.getElementById('cs_lightbox_price');
        const descEl = document.getElementById('cs_lightbox_description');
        if (priceEl) {
            const price = parseFloat(item.getAttribute('data-price')) || 0;
            const symbol = window.__currency?.symbol || '$';
            const rate = window.__currency?.rate || 1;
            priceEl.innerHTML = `${symbol}${(price * rate).toFixed(2)} <span style="font-size: 14px; font-weight: 500; color: #888; text-decoration: line-through; opacity: 0.6;">Incl. GST</span>`;
        }
        if (descEl && item.getAttribute('data-description')) {
            descEl.textContent = item.getAttribute('data-description');
        }

        // --- NEW: Populate Sizes and Cloth Types ---
        const sizeContainer = document.getElementById('cs_lightbox_sizes');
        const clothSelect = document.getElementById('cs_lightbox_cloth');
        const selectedSizeInput = document.getElementById('selected_size');
        const sizeSection = document.getElementById('cs_size_section');
        const clothSection = document.getElementById('cs_cloth_section');

        if (sizeContainer) {
            sizeContainer.innerHTML = '';
            const sizes = item.getAttribute('data-size') ? item.getAttribute('data-size').split(',') : [];

            if (sizes.length > 0) {
                sizeSection.style.display = 'block';
                sizes.forEach((size, idx) => {
                    const s = size.trim();
                    if (!s) return;
                    const btn = document.createElement('button');
                    btn.type = 'button';
                    btn.className = 'size-btn';
                    btn.textContent = s;
                    btn.addEventListener('click', function () {
                        document.querySelectorAll('.size-btn').forEach(b => b.classList.remove('active'));
                        this.classList.add('active');
                        selectedSizeInput.value = s;
                    });

                    // Auto-select first size
                    if (idx === 0) {
                        btn.classList.add('active');
                        selectedSizeInput.value = s;
                    }

                    sizeContainer.appendChild(btn);
                });
            } else {
                sizeSection.style.display = 'none';
                selectedSizeInput.value = '';
            }
        }

        if (clothSelect) {
            clothSelect.innerHTML = '';
            const cloths = item.getAttribute('data-cloth') ? item.getAttribute('data-cloth').split(',') : [];

            if (cloths.length > 0) {
                clothSection.style.display = 'block';
                cloths.forEach(cloth => {
                    const c = cloth.trim();
                    if (!c) return;
                    const option = document.createElement('option');
                    option.value = c;
                    option.textContent = c;
                    clothSelect.appendChild(option);
                });
            } else {
                clothSection.style.display = 'none';
            }
        }
        // --- END NEW ---

        lightbox.classList.add('active');
        document.body.style.overflow = 'hidden';
        currentIndex = index;

        // Animate lightbox content with staggered entrance
        setTimeout(() => {
            lightboxImg.style.transition = 'all 0.6s cubic-bezier(0.2, 0.8, 0.2, 1)';
            lightboxImg.style.opacity = '1';
            lightboxImg.style.transform = 'scale(1) translateY(0)';
            isAnimating = false;
        }, 300);
    }

    // Smooth lightbox closing
    function closeLightbox() {
        if (isAnimating) return;
        isAnimating = true;

        lightboxImg.style.transition = 'all 0.4s cubic-bezier(0.4, 0, 1, 1)';
        lightboxImg.style.opacity = '0';
        lightboxImg.style.transform = 'scale(0.95)';

        setTimeout(() => {
            lightbox.classList.remove('active');
            document.body.style.overflow = '';
            isAnimating = false;
        }, 400);
    }

    // Make closeLightbox globally accessible for inline scripts
    window.closeLightboxGlobal = closeLightbox;

    // Event listeners for design items
    designItems.forEach((item, index) => {
        item.addEventListener('click', () => openLightbox(index));
    });

    lightboxOverlay.addEventListener('click', closeLightbox);
    lightboxClose.addEventListener('click', closeLightbox);

    // NOTE: Buy Now button handler is intentionally NOT set here.
    // It is handled by inline script in own-design.blade.php with proper AJAX add-to-cart logic.

    // Keyboard navigation
    document.addEventListener('keydown', (e) => {
        if (!lightbox.classList.contains('active')) return;
        if (e.key === 'Escape') closeLightbox();
    });

    // Premium filter functionality with staggered Isotope-like effect
    const filterLinks = document.querySelectorAll('.cs_design_filters li a');
    const galleryItems = document.querySelectorAll('.cs_design_item');

    filterLinks.forEach(link => {
        link.addEventListener('click', function (e) {
            e.preventDefault();

            filterLinks.forEach(l => l.parentElement.classList.remove('active'));
            this.parentElement.classList.add('active');

            const filterValue = this.getAttribute('href').substring(1);

            let visibleIndex = 0;
            galleryItems.forEach((item) => {
                if (filterValue === 'all' || item.classList.contains(filterValue)) {
                    item.style.display = 'block';
                    setTimeout(() => {
                        item.style.opacity = '1';
                        item.style.transform = 'scale(1) translateY(0)';
                    }, visibleIndex * 50);
                    visibleIndex++;
                } else {
                    item.style.opacity = '0';
                    item.style.transform = 'scale(0.9) translateY(20px)';
                    setTimeout(() => {
                        item.style.display = 'none';
                    }, 400);
                }
            });
        });
    });

    // Initial entrance animations
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach((entry, index) => {
            if (entry.isIntersecting) {
                setTimeout(() => {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0) scale(1)';
                }, index % 3 * 100); // Stagger based on column index approximation
                observer.unobserve(entry.target);
            }
        });
    }, observerOptions);

    galleryItems.forEach(item => {
        item.style.opacity = '0';
        item.style.transform = 'translateY(40px) scale(0.95)';
        item.style.transition = 'all 0.8s cubic-bezier(0.2, 0.8, 0.2, 1)';
        observer.observe(item);
    });

    // Parallax effect for header
    const pageHeading = document.querySelector('.cs_page_heading');
    if (pageHeading) {
        window.addEventListener('scroll', () => {
            const scrolled = window.pageYOffset;
            const rate = scrolled * 0.4;
            pageHeading.style.backgroundPosition = `center ${rate}px`;
        });
    }

    // Hero Text Reveal Animation
    const heroTitle = document.querySelector('.cs_page_heading h1');
    if (heroTitle) {
        const text = heroTitle.textContent;
        heroTitle.innerHTML = '';
        const wrapper = document.createElement('span');
        wrapper.className = 'cs_hero_title_wrapper';

        // Split text by words first to preserve spacing
        const words = text.split(' ');
        words.forEach((word, wordIndex) => {
            const wordSpan = document.createElement('span');
            wordSpan.style.display = 'inline-block';
            wordSpan.style.whiteSpace = 'pre';

            // Split word into characters
            const chars = word.split('');
            chars.forEach((char, charIndex) => {
                const charSpan = document.createElement('span');
                charSpan.className = 'cs_hero_title_char';
                charSpan.textContent = char;
                charSpan.style.animationDelay = `${(wordIndex * 100) + (charIndex * 50)}ms`;
                wordSpan.appendChild(charSpan);
            });

            // Add space after word unless it's the last one
            if (wordIndex < words.length - 1) {
                const spaceSpan = document.createElement('span');
                spaceSpan.className = 'cs_hero_title_char';
                spaceSpan.innerHTML = '&nbsp;';
                spaceSpan.style.animationDelay = `${(wordIndex * 100) + (chars.length * 50)}ms`;
                wordSpan.appendChild(spaceSpan);
            }

            wrapper.appendChild(wordSpan);
        });

        heroTitle.appendChild(wrapper);
    }
});

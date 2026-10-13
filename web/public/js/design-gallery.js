// Design Gallery JavaScript with Premium Studio Animations, Filtering, & Search
document.addEventListener('DOMContentLoaded', function () {
    // Check if required elements exist
    if (!document.getElementById('cs_design_lightbox')) return;

    // Lightbox elements
    const lightbox = document.getElementById('cs_design_lightbox');
    const lightboxImg = document.getElementById('cs_lightbox_img');
    const lightboxTitle = document.getElementById('cs_lightbox_title');
    const lightboxTag = document.getElementById('cs_lightbox_tag');
    const lightboxDescription = document.getElementById('cs_lightbox_description');
    const lightboxOverlay = document.getElementById('cs_lightbox_overlay');
    const lightboxClose = document.getElementById('cs_lightbox_close');
    const lightboxSubtotal = document.getElementById('cs_lightbox_subtotal');
    const qtyInput = document.getElementById('cs_lightbox_qty');

    const designItems = document.querySelectorAll('.cs_design_item');
    const gridContainer = document.getElementById('cs_design_grid');
    const emptyState = document.getElementById('cs_no_results');
    
    let currentIndex = 0;
    let isAnimating = false;
    let currentBasePrice = 0;

    // Recalculate Subtotal inside Modal
    function updateSubtotal() {
        if (!lightboxSubtotal || !qtyInput) return;
        const qty = parseInt(qtyInput.value) || 1;
        const symbol = window.__currency?.symbol || '$';
        const rate = window.__currency?.rate || 1;
        const total = (currentBasePrice * rate * qty).toFixed(2);
        lightboxSubtotal.textContent = `Subtotal: ${symbol}${total}`;
    }

    // Premium lightbox opening with smooth scaling
    function openLightbox(index) {
        if (isAnimating) return;
        isAnimating = true;

        const item = designItems[index];
        if (!item) return;

        const img = item.querySelector('img');
        const title = item.querySelector('.cs_design_title');
        const tag = item.querySelector('.badge-tag-pill') || item.querySelector('.cs_design_tag');

        lightboxImg.src = img ? img.src : item.getAttribute('data-src');
        lightboxImg.style.opacity = '0';
        lightboxImg.style.transform = 'scale(0.95) translateY(10px)';

        lightboxTitle.textContent = title ? title.textContent : '';
        lightboxTag.textContent = tag ? tag.textContent : (item.getAttribute('data-tag') || '');

        const priceEl = document.getElementById('cs_lightbox_price');
        const descEl = document.getElementById('cs_lightbox_description');

        currentBasePrice = parseFloat(item.getAttribute('data-price')) || 0;
        
        if (priceEl) {
            const symbol = window.__currency?.symbol || '$';
            const rate = window.__currency?.rate || 1;
            const formattedPrice = (currentBasePrice * rate).toFixed(2);
            priceEl.innerHTML = `${symbol}${formattedPrice} <span class="badge bg-light text-muted font-weight-normal border ms-2" style="font-size: 11px;">Incl. GST</span>`;
        }

        if (descEl) {
            const desc = item.getAttribute('data-description');
            if (desc && desc.trim().length > 2) {
                descEl.textContent = desc.trim();
                descEl.style.display = 'block';
            } else {
                descEl.style.display = 'none';
            }
        }

        if (qtyInput) {
            qtyInput.value = 1;
        }
        updateSubtotal();

        // Populate Sizes and Cloth Types
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
                    btn.setAttribute('data-size', s);
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

        lightbox.classList.add('active');
        document.body.style.overflow = 'hidden';
        currentIndex = index;

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

    window.closeLightboxGlobal = closeLightbox;

    // Event listeners for design items
    designItems.forEach((item, index) => {
        item.addEventListener('click', () => openLightbox(index));
    });

    if (lightboxOverlay) lightboxOverlay.addEventListener('click', closeLightbox);
    if (lightboxClose) lightboxClose.addEventListener('click', closeLightbox);

    if (qtyInput) {
        qtyInput.addEventListener('input', updateSubtotal);
        qtyInput.addEventListener('change', updateSubtotal);
    }

    // Keyboard navigation
    document.addEventListener('keydown', (e) => {
        if (!lightbox.classList.contains('active')) return;
        if (e.key === 'Escape') closeLightbox();
    });

    // ==========================================
    // STUDIO TOOLBAR: FILTER, SEARCH, & SORT
    // ==========================================
    const filterPills = document.querySelectorAll('.cs_filter_pill_btn');
    const searchInput = document.getElementById('cs_design_search');
    const sortSelect = document.getElementById('cs_design_sort');

    let activeFilter = 'all';
    let searchQuery = '';

    function applyFilterAndSearch() {
        let visibleCount = 0;

        designItems.forEach(item => {
            const matchesFilter = (activeFilter === 'all') || item.classList.contains(activeFilter);
            
            const title = (item.getAttribute('data-title') || item.querySelector('.cs_design_title')?.textContent || '').toLowerCase();
            const tag = (item.querySelector('.badge-tag-pill')?.textContent || '').toLowerCase();
            const matchesSearch = !searchQuery || title.includes(searchQuery) || tag.includes(searchQuery);

            if (matchesFilter && matchesSearch) {
                item.style.display = 'flex';
                setTimeout(() => {
                    item.style.opacity = '1';
                    item.style.transform = 'translateY(0) scale(1)';
                }, visibleCount * 40);
                visibleCount++;
            } else {
                item.style.opacity = '0';
                item.style.transform = 'scale(0.95) translateY(10px)';
                setTimeout(() => {
                    item.style.display = 'none';
                }, 300);
            }
        });

        if (emptyState) {
            emptyState.style.display = (visibleCount === 0) ? 'block' : 'none';
        }
    }

    // Category Pills Click
    filterPills.forEach(pill => {
        pill.addEventListener('click', function (e) {
            e.preventDefault();
            filterPills.forEach(p => {
                p.classList.remove('active');
                p.parentElement.classList.remove('active');
            });
            this.classList.add('active');
            this.parentElement.classList.add('active');

            activeFilter = this.getAttribute('data-filter') || 'all';
            applyFilterAndSearch();
        });
    });

    // Search Input
    if (searchInput) {
        searchInput.addEventListener('input', function () {
            searchQuery = this.value.trim().toLowerCase();
            applyFilterAndSearch();
        });
    }

    // Sorting Selection
    if (sortSelect && gridContainer) {
        sortSelect.addEventListener('change', function () {
            const sortVal = this.value;
            const itemsArray = Array.from(designItems);

            itemsArray.sort((a, b) => {
                const priceA = parseFloat(a.getAttribute('data-price')) || 0;
                const priceB = parseFloat(b.getAttribute('data-price')) || 0;
                const titleA = (a.querySelector('.cs_design_title')?.textContent || '').toLowerCase();
                const titleB = (b.querySelector('.cs_design_title')?.textContent || '').toLowerCase();

                if (sortVal === 'price-low') return priceA - priceB;
                if (sortVal === 'price-high') return priceB - priceA;
                if (sortVal === 'title-asc') return titleA.localeCompare(titleB);
                return parseInt(a.getAttribute('data-id')) - parseInt(b.getAttribute('data-id'));
            });

            itemsArray.forEach(item => gridContainer.appendChild(item));
            applyFilterAndSearch();
        });
    }

    // Entrance animation observer
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -40px 0px'
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach((entry, index) => {
            if (entry.isIntersecting) {
                setTimeout(() => {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0) scale(1)';
                }, (index % 3) * 80);
                observer.unobserve(entry.target);
            }
        });
    }, observerOptions);

    designItems.forEach(item => {
        item.style.opacity = '0';
        item.style.transform = 'translateY(30px) scale(0.96)';
        item.style.transition = 'all 0.6s cubic-bezier(0.2, 0.8, 0.2, 1)';
        observer.observe(item);
    });
});

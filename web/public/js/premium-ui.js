document.addEventListener('DOMContentLoaded', () => {
    // --- 1. SweetAlert2 Theme Configuration ---
    const saaluvesaAlert = Swal.mixin({
        customClass: {
            confirmButton: 'cs_btn cs_style_1 cs_accent_btn',
            cancelButton: 'cs_btn cs_style_1'
        },
        buttonsStyling: false,
        backdrop: `rgba(0,0,0,0.4)`
    });

    const saaluvesaToast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer)
            toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
    });

    // Global Notification Helper
    window.notify = {
        success: (msg) => saaluvesaToast.fire({ icon: 'success', title: msg }),
        error: (msg) => saaluvesaToast.fire({ icon: 'error', title: msg }),
        info: (msg) => saaluvesaToast.fire({ icon: 'info', title: msg }),
        confirm: (title, text, icon = 'warning') => {
            return saaluvesaAlert.fire({
                title: title,
                text: text,
                icon: icon,
                showCancelButton: true,
                confirmButtonText: 'Yes, proceed!',
                cancelButtonText: 'No, cancel'
            });
        }
    };

    // --- 2. Intercept Key Actions ---

    // Add to Cart Buttons
    document.addEventListener('click', (e) => {
        // Handle Case 1: Elements with .cs_cart_btn class
        const cartBtnClass = e.target.closest('.cs_cart_btn');

        // Handle Case 2: .cs_btn elements containing "Add to Cart" text
        const genericBtn = e.target.closest('.cs_btn');
        const isAddToCartText = genericBtn && genericBtn.textContent.toLowerCase().includes('add to cart');

        const isAddToCart = cartBtnClass || isAddToCartText;

        if (isAddToCart) {
            e.preventDefault();
            const target = cartBtnClass || genericBtn;
            const form = target.closest('form');
            const productName = target.closest('.cs_product, .cs_product_info, .cs_single_product_details')?.querySelector('.cs_product_title a, h2')?.textContent || 'item';

            if (form) {
                const formData = new FormData(form);
                const url = form.getAttribute('action');

                // Show loading state
                const originalText = target.innerHTML;
                target.disabled = true;
                target.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i>';

                fetch(url, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                })
                    .then(response => response.json())
                    .then(data => {
                        target.disabled = false;
                        target.innerHTML = originalText;

                        if (data.success) {
                            saaluvesaToast.fire({
                                icon: 'success',
                                title: data.message || `Added ${productName} to cart successfully!`
                            });

                            // Redirect to cart page after a short delay
                            setTimeout(() => {
                                window.location.href = '/cart';
                            }, 800);

                            // Update cart count if exists
                            const cartCountEl = document.querySelector('.cs_cart_count');
                            if (cartCountEl && data.cart_count !== undefined) {
                                cartCountEl.textContent = data.cart_count;
                            }
                        } else {
                            saaluvesaToast.fire({
                                icon: 'error',
                                title: data.message || 'Failed to add item to cart.'
                            });
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        target.disabled = false;
                        target.innerHTML = originalText;
                        saaluvesaToast.fire({
                            icon: 'error',
                            title: 'An error occurred. Please try again.'
                        });
                    });
            } else {
                // Fallback if no form found (e.g. from some gallery)
                saaluvesaToast.fire({
                    icon: 'info',
                    title: `Viewing ${productName}`
                });
            }
        }

        // Wishlist Buttons
        const wishlistBtn = e.target.closest('.cs_heart_btn, .cs_cart_icon i.fa-heart')?.parentElement || e.target.closest('.cs_heart_btn');
        if (wishlistBtn && (wishlistBtn.classList.contains('cs_heart_btn') || wishlistBtn.querySelector('.fa-heart'))) {
            e.preventDefault();
            saaluvesaToast.fire({
                icon: 'info',
                title: 'Added to your wishlist!'
            });
        }

        // Checkout Button
        const checkoutBtn = e.target.closest('.cs_btn') && (e.target.textContent.toLowerCase().includes('place order') || e.target.textContent.toLowerCase().includes('pay now'));
        if (checkoutBtn) {
            e.preventDefault();
            saaluvesaAlert.fire({
                title: 'Confirm Order',
                text: "Are you sure you want to place this order?",
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Yes, Order Now!',
                cancelButtonText: 'Review Order'
            }).then((result) => {
                if (result.isConfirmed) {
                    saaluvesaAlert.fire(
                        'Ordered!',
                        'Your order has been placed successfully.',
                        'success'
                    ).then(() => {
                        // In real app, submit form or redirect
                        window.location.href = '/';
                    });
                }
            });
        }
    });

    // --- 3. Intersection Observer for Reveal Animations ---
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };

    const revealObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('is-visible');
            }
        });
    }, observerOptions);

    // Apply observer to elements
    const animateElements = document.querySelectorAll('.reveal-text, .fade-in-up');
    animateElements.forEach(el => {
        if (el.classList.contains('reveal-text') && !el.querySelector('span')) {
            const content = el.innerHTML;
            el.innerHTML = `<span>${content}</span>`;
        }
        revealObserver.observe(el);
    });

    // --- 4. Parallax Effect ---
    const parallaxContainers = document.querySelectorAll('.parallax-container');
    window.addEventListener('scroll', () => {
        const scrolled = window.pageYOffset;
        parallaxContainers.forEach(container => {
            const img = container.querySelector('.parallax-img');
            if (!img) return;
            const speed = 0.2;
            const rect = container.getBoundingClientRect();
            const offset = rect.top + scrolled;
            if (rect.top < window.innerHeight && rect.bottom > 0) {
                const yPos = (scrolled - offset) * speed;
                img.style.transform = `translateY(${yPos}px)`;
            }
        });
    });

    // --- 5. Smooth Header Transition ---
    const header = document.querySelector('.cs_sticky_header');
    if (header) {
        window.addEventListener('scroll', () => {
            if (window.scrollY > 50) header.classList.add('glass-header');
            else header.classList.remove('glass-header');
        });
    }

    // --- 6. Staggered animations for lists/grids ---
    const staggeredGrids = document.querySelectorAll('.staggered-grid');
    staggeredGrids.forEach(grid => {
        const children = grid.children;
        Array.from(children).forEach((child, index) => {
            child.classList.add('fade-in-up');
            child.style.transitionDelay = `${index * 0.1}s`;
            revealObserver.observe(child);
        });
    });

    // --- 7. Magnetic Buttons ---
    const magneticBtns = document.querySelectorAll('.cs_btn, .cs_cart_icon');
    magneticBtns.forEach(btn => {
        btn.addEventListener('mousemove', (e) => {
            const rect = btn.getBoundingClientRect();
            const x = e.clientX - rect.left - rect.width / 2;
            const y = e.clientY - rect.top - rect.height / 2;
            const strength = 15;
            btn.style.transform = `translate(${x / strength}px, ${y / strength}px)`;
        });
        btn.addEventListener('mouseleave', () => {
            btn.style.transform = 'translate(0px, 0px)';
        });
    });

    // --- 8. 3D Tilt for cards ---
    const tiltCards = document.querySelectorAll('.premium-card');
    tiltCards.forEach(card => {
        if (card.closest('.featured-items-section')) return;
        card.addEventListener('mousemove', (e) => {
            const rect = card.getBoundingClientRect();
            const x = e.clientX - rect.left;
            const y = e.clientY - rect.top;
            const centerX = rect.width / 2;
            const centerY = rect.height / 2;
            const rotateX = (centerY - y) / 10;
            const rotateY = (x - centerX) / 10;
            card.style.transform = `perspective(1000px) rotateX(${rotateX}deg) rotateY(${rotateY}deg) translateY(-5px)`;
        });
        card.addEventListener('mouseleave', () => {
            card.style.transform = 'perspective(1000px) rotateX(0deg) rotateY(0deg) translateY(0px)';
        });
    });

    // --- 9. Scroll Progress & Parallax ---
    const progressBar = document.createElement('div');
    progressBar.className = 'scroll-progress';
    document.body.appendChild(progressBar);

    window.addEventListener('scroll', () => {
        const winScroll = document.body.scrollTop || document.documentElement.scrollTop;
        const height = document.documentElement.scrollHeight - document.documentElement.clientHeight;
        const scrolled = (winScroll / height) * 100;
        progressBar.style.width = scrolled + "%";

        const parallaxBgs = document.querySelectorAll('.parallax-bg');
        parallaxBgs.forEach(bg => {
            const rect = bg.parentElement.getBoundingClientRect();
            if (rect.top < window.innerHeight && rect.bottom > 0) {
                const speed = 0.5;
                const yPos = (window.innerHeight - rect.top) * speed * 0.1;
                bg.style.transform = `translateY(${yPos}px)`;
            }
        });
    });

    // --- 10. Attach Observer to Parallax Sections ---
    const parallaxSections = document.querySelectorAll('.parallax-section');
    parallaxSections.forEach(section => {
        revealObserver.observe(section);
    });
});

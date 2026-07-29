// Categories Page JavaScript
document.addEventListener('DOMContentLoaded', function() {
    // Initialize categories functionality
    class CategoriesPage {
        constructor() {
            this.init();
        }

        init() {
            this.bindEvents();
            this.setupLazyLoading();
            this.setupKeyboardNavigation();
        }

        bindEvents() {
            // Category expand/collapse buttons
            document.querySelectorAll('.cs_category_expand').forEach(btn => {
                btn.addEventListener('click', (e) => {
                    e.stopPropagation();
                    this.toggleCategory(e.currentTarget.closest('.cs_category_card'));
                });
            });

            // Category image clicks (expand)
            document.querySelectorAll('.cs_category_image').forEach(img => {
                img.addEventListener('click', () => {
                    this.toggleCategory(img.closest('.cs_category_card'));
                });
            });

            // Subcategory item clicks
            document.querySelectorAll('.cs_subcategory_item').forEach(item => {
                item.addEventListener('click', (e) => {
                    this.handleSubcategoryClick(e.currentTarget);
                });
            });

            // Close on outside click
            document.addEventListener('click', (e) => {
                if (!e.target.closest('.cs_category_card')) {
                    this.closeAllCategories();
                }
            });

            // Keyboard navigation
            document.addEventListener('keydown', (e) => {
                if (e.key === 'Escape') {
                    this.closeAllCategories();
                }
            });
        }

        toggleCategory(categoryCard) {
            const isExpanded = categoryCard.classList.contains('expanded');

            // Close all other categories
            this.closeAllCategories();

            if (!isExpanded) {
                // Expand this category
                categoryCard.classList.add('expanded');
                this.animateExpand(categoryCard);

                // Update expand button
                const expandBtn = categoryCard.querySelector('.cs_category_expand');
                if (expandBtn) {
                    expandBtn.setAttribute('aria-expanded', 'true');
                }
            } else {
                // Collapse this category
                this.collapseCategory(categoryCard);
            }
        }

        closeAllCategories() {
            document.querySelectorAll('.cs_category_card.expanded').forEach(card => {
                this.collapseCategory(card);
            });
        }

        collapseCategory(categoryCard) {
            categoryCard.classList.remove('expanded');

            // Update expand button
            const expandBtn = categoryCard.querySelector('.cs_category_expand');
            if (expandBtn) {
                expandBtn.setAttribute('aria-expanded', 'false');
            }
        }

        animateExpand(categoryCard) {
            const subcategories = categoryCard.querySelector('.cs_subcategories');
            if (subcategories) {
                // Trigger reflow for animation
                subcategories.offsetHeight;

                // Add fade-in animation to subcategory items
                const items = subcategories.querySelectorAll('.cs_subcategory_item');
                items.forEach((item, index) => {
                    item.style.opacity = '0';
                    item.style.transform = 'translateX(-20px)';

                    setTimeout(() => {
                        item.style.transition = 'all 0.3s ease';
                        item.style.opacity = '1';
                        item.style.transform = 'translateX(0)';
                    }, index * 50);
                });
            }
        }

        handleSubcategoryClick(subcategoryItem) {
            const categoryName = subcategoryItem.closest('.cs_category_card').dataset.category;
            const subcategoryName = subcategoryItem.querySelector('span').textContent;

            // In a real application, this would navigate to a filtered product page
            console.log(`Navigating to: ${categoryName} > ${subcategoryName}`);

            // For demo purposes, show an alert
            this.showNotification(`Exploring ${subcategoryName} in ${this.capitalizeFirst(categoryName)}`);

            // Close the category
            this.collapseCategory(subcategoryItem.closest('.cs_category_card'));
        }

        showNotification(message) {
            // Create notification element
            const notification = document.createElement('div');
            notification.className = 'cs_notification';
            notification.innerHTML = `
                <div class="cs_notification_content">
                    <i class="fa-solid fa-check-circle"></i>
                    <span>${message}</span>
                </div>
            `;

            // Add to page
            document.body.appendChild(notification);

            // Style the notification
            Object.assign(notification.style, {
                position: 'fixed',
                top: '20px',
                right: '20px',
                backgroundColor: '#fc5f49',
                color: '#fff',
                padding: '15px 20px',
                borderRadius: '8px',
                boxShadow: '0 4px 12px rgba(0,0,0,0.15)',
                zIndex: '10000',
                opacity: '0',
                transform: 'translateX(100%)',
                transition: 'all 0.3s ease',
                fontSize: '14px',
                maxWidth: '300px'
            });

            // Animate in
            setTimeout(() => {
                notification.style.opacity = '1';
                notification.style.transform = 'translateX(0)';
            }, 10);

            // Auto remove after 3 seconds
            setTimeout(() => {
                notification.style.opacity = '0';
                notification.style.transform = 'translateX(100%)';
                setTimeout(() => {
                    document.body.removeChild(notification);
                }, 300);
            }, 3000);
        }

        setupLazyLoading() {
            // Simple lazy loading implementation
            const images = document.querySelectorAll('.cs_category_image img');

            const imageObserver = new IntersectionObserver((entries, observer) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const img = entry.target;
                        // In a real implementation, you would set the src here
                        // For now, we'll just add the loaded class
                        img.classList.add('loaded');
                        observer.unobserve(img);
                    }
                });
            });

            images.forEach(img => {
                imageObserver.observe(img);
            });
        }

        setupKeyboardNavigation() {
            // Add keyboard navigation for accessibility
            document.querySelectorAll('.cs_category_card').forEach(card => {
                card.setAttribute('tabindex', '0');

                card.addEventListener('keydown', (e) => {
                    if (e.key === 'Enter' || e.key === ' ') {
                        e.preventDefault();
                        this.toggleCategory(card);
                    }
                });
            });
        }

        capitalizeFirst(string) {
            return string.charAt(0).toUpperCase() + string.slice(1);
        }
    }

    // Optional: Category filtering functionality
    class CategoryFilters {
        constructor() {
            this.categories = document.querySelectorAll('.cs_category_card');
            this.init();
        }

        init() {
            // Create filter buttons if needed
            this.createFilters();

            // Add search functionality
            this.createSearch();
        }

        createFilters() {
            // Create a filter section (optional enhancement)
            const filterSection = document.createElement('div');
            filterSection.className = 'cs_category_filters';
            filterSection.innerHTML = `
                <div class="container">
                    <div class="cs_filters_wrapper">
                        <input type="text" class="cs_category_search" placeholder="Search categories...">
                        <div class="cs_filter_buttons">
                            <button class="cs_filter_btn active" data-filter="all">All Categories</button>
                            <button class="cs_filter_btn" data-filter="popular">Popular</button>
                            <button class="cs_filter_btn" data-filter="new">New Arrivals</button>
                        </div>
                    </div>
                </div>
            `;

            // Insert before the categories gallery
            const gallery = document.querySelector('.cs_categories_gallery');
            if (gallery) {
                gallery.parentNode.insertBefore(filterSection, gallery);

                // Bind filter events
                this.bindFilterEvents();
            }
        }

        createSearch() {
            const searchInput = document.querySelector('.cs_category_search');
            if (searchInput) {
                searchInput.addEventListener('input', (e) => {
                    this.filterCategories(e.target.value);
                });
            }
        }

        bindFilterEvents() {
            document.querySelectorAll('.cs_filter_btn').forEach(btn => {
                btn.addEventListener('click', () => {
                    // Remove active class from all buttons
                    document.querySelectorAll('.cs_filter_btn').forEach(b => b.classList.remove('active'));
                    // Add active class to clicked button
                    btn.classList.add('active');

                    // Filter categories (placeholder functionality)
                    console.log('Filtering by:', btn.dataset.filter);
                });
            });
        }

        filterCategories(searchTerm) {
            const term = searchTerm.toLowerCase();

            this.categories.forEach(category => {
                const title = category.querySelector('.cs_category_title').textContent.toLowerCase();
                const isVisible = title.includes(term);

                category.style.display = isVisible ? 'block' : 'none';

                // Add fade animation
                if (isVisible) {
                    category.style.opacity = '0';
                    setTimeout(() => {
                        category.style.transition = 'opacity 0.3s ease';
                        category.style.opacity = '1';
                    }, 10);
                }
            });
        }
    }

    // Initialize the categories page
    new CategoriesPage();

    // Optional: Initialize filters (comment out if not needed)
    // new CategoryFilters();

    // Performance optimization: Preload visible images
    function preloadVisibleImages() {
        const images = document.querySelectorAll('.cs_category_image img');
        const observerOptions = {
            root: null,
            rootMargin: '50px',
            threshold: 0.1
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const img = entry.target;
                    // Simulate loading
                    setTimeout(() => {
                        img.classList.add('loaded');
                    }, 200);
                    observer.unobserve(img);
                }
            });
        }, observerOptions);

        images.forEach(img => observer.observe(img));
    }

    // Call preload function
    preloadVisibleImages();

    // Add smooth scrolling for subcategory navigation
    document.querySelectorAll('.cs_subcategory_item').forEach(item => {
        item.addEventListener('click', function(e) {
            // Smooth scroll to top if needed
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });
    });
});

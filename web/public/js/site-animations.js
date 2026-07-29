/**
 * About Page Animations
 * Handles staggered "parallel" loading and parallax effects
 */

document.addEventListener('DOMContentLoaded', function () {

    // 1. Hero Text Reveal (Generic)
    const heroTitle = document.querySelector('.cs_page_heading h2, .cs_hero_text h1'); // Added hero h1 selector
    if (heroTitle) {
        heroTitle.style.opacity = '0';
        heroTitle.style.transform = 'translateY(30px)';
        heroTitle.style.transition = 'all 1s cubic-bezier(0.2, 0.8, 0.2, 1)';

        setTimeout(() => {
            heroTitle.style.opacity = '1';
            heroTitle.style.transform = 'translateY(0)';
        }, 300);
    }

    // 2. Parallax Background Effect
    const parallaxSections = document.querySelectorAll('.cs_bg_filed:not(.cs_video_block)');
    if (parallaxSections.length > 0) { // Added error handling
        window.addEventListener('scroll', () => {
            const scrolled = window.pageYOffset;
            parallaxSections.forEach(section => {
                const speed = 0.5;
                const yPos = -(scrolled * speed);
                // Limit the parallax effect to avoid background running out
                if (section.getBoundingClientRect().top < window.innerHeight) {
                    section.style.backgroundPosition = `center ${yPos}px`;
                }
            });
        });
    }

    // 3. Staggered "Parallel" Loading using IntersectionObserver
    const observerOptions = {
        threshold: 0.15,
        rootMargin: '0px 0px -50px 0px'
    };

    const staggerObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                // Add the visible class to trigger CSS animation
                entry.target.classList.add('cs_anim_visible');
                entry.target.classList.remove('cs_anim_hidden');

                // Stop observing once visible
                staggerObserver.unobserve(entry.target);
            }
        });
    }, observerOptions);

    // Elements to animate
    const animatedElements = document.querySelectorAll(
        '.cs_card_thumb, .cs_card_info, .cs_store_feature, .cs_iconbox, .cs_video_block, .cs_section_heading, .cs_testimonial, .cs_product, .cs_location_map, .cs_category'
    );

    animatedElements.forEach((el, index) => {
        // Add base style for animation
        el.classList.add('cs_anim_hidden');

        // Add delay based on index within its container (simulating parallel load)
        const parent = el.closest('.row') || el.closest('.cs_featured_container') || el.closest('.cs_slider_wrapper');
        if (parent) {
            const siblings = Array.from(parent.children);
            // Find index among animated siblings
            const animIndex = siblings.indexOf(el.closest('div') || el);
            // Cap the delay index to avoid very long waits on long lists
            const delay = (animIndex % 4) * 150;
            el.style.transitionDelay = `${delay}ms`;
        }

        staggerObserver.observe(el);
    });
});

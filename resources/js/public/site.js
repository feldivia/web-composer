/**
 * WebComposer Public Site JS — Effects Library
 *
 * All effects are activated via data-* attributes on HTML elements.
 * No configuration needed — just add the attribute.
 *
 * Effects included:
 * - Scroll animations (data-animate)
 * - Typewriter (data-typewriter)
 * - Parallax (data-parallax)
 * - Lightbox (data-lightbox)
 * - Carousel (data-carousel)
 * - Tabs (data-tabs)
 * - Sticky navbar (data-sticky)
 * - Progress bar (data-progress)
 * - Marquee (data-marquee)
 * - Hover effects (data-hover)
 * - Counter (data-count)
 * - Accordion (data-accordion)
 * - Contact form (data-contact-form)
 * - Dark mode (toggle + system preference)
 * - Cookie consent banner
 * - Smooth scroll, mobile menu, scroll-to-top, lazy images
 */
(function () {
    'use strict';

    /* ================================================================
       UTILITY: Detect prefers-reduced-motion
       ================================================================ */
    const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

    /* ================================================================
       UTILITY: Throttle for scroll handlers
       ================================================================ */
    function throttle(fn, wait) {
        let last = 0;
        let raf = null;
        return function () {
            const now = performance.now();
            if (now - last >= wait) {
                last = now;
                if (raf) cancelAnimationFrame(raf);
                raf = requestAnimationFrame(fn);
            }
        };
    }

    /* ================================================================
       CORE: DOMContentLoaded bootstrap
       ================================================================ */
    document.addEventListener('DOMContentLoaded', function () {

        /* ============================================================
           1. SMOOTH SCROLL for anchor links
           ============================================================ */
        document.querySelectorAll('a[href^="#"]').forEach(function (anchor) {
            anchor.addEventListener('click', function (e) {
                var href = this.getAttribute('href');
                if (href === '#') return;
                var target = document.querySelector(href);
                if (target) {
                    e.preventDefault();
                    target.scrollIntoView({ behavior: 'smooth', block: 'start' });
                }
            });
        });

        /* ============================================================
           2. LAZY LOAD images (native loading="lazy")
           ============================================================ */
        document.querySelectorAll('img:not([loading])').forEach(function (img) {
            img.setAttribute('loading', 'lazy');
        });

        /* ============================================================
           3. MOBILE MENU TOGGLE (data-menu-toggle / data-mobile-menu)
           ============================================================ */
        var menuToggle = document.querySelector('[data-menu-toggle]');
        var mobileMenu = document.querySelector('[data-mobile-menu]');
        if (menuToggle && mobileMenu) {
            menuToggle.addEventListener('click', function () {
                mobileMenu.classList.toggle('hidden');
                var isOpen = !mobileMenu.classList.contains('hidden');
                menuToggle.setAttribute('aria-expanded', isOpen);
            });
        }

        /* ============================================================
           4. SCROLL TO TOP (data-scroll-top)
           ============================================================ */
        var scrollTopBtn = document.querySelector('[data-scroll-top]');
        if (scrollTopBtn) {
            window.addEventListener('scroll', throttle(function () {
                scrollTopBtn.style.display = window.scrollY > 300 ? 'flex' : 'none';
            }, 100));
            scrollTopBtn.addEventListener('click', function () {
                window.scrollTo({ top: 0, behavior: 'smooth' });
            });
        }

        /* ============================================================
           5. SCROLL ANIMATIONS (data-animate="type")
              Back-compat: data-reveal maps to data-animate="fade-up"
           ============================================================ */
        initAnimations();

        /* ============================================================
           6. COUNTER (data-count)
           ============================================================ */
        initCounters();

        /* ============================================================
           7. TYPEWRITER (data-typewriter)
           ============================================================ */
        initTypewriters();

        /* ============================================================
           8. PARALLAX (data-parallax="0.3")
           ============================================================ */
        initParallax();

        /* ============================================================
           9. LIGHTBOX (data-lightbox)
           ============================================================ */
        initLightbox();

        /* ============================================================
           10. CAROUSEL (data-carousel)
           ============================================================ */
        initCarousels();

        /* ============================================================
           11. TABS (data-tabs)
           ============================================================ */
        initTabs();

        /* ============================================================
           12. STICKY NAVBAR (data-sticky)
           ============================================================ */
        initSticky();

        /* ============================================================
           13. PROGRESS BAR (data-progress)
           ============================================================ */
        initProgressBars();

        /* ============================================================
           14. MARQUEE (data-marquee)
           ============================================================ */
        initMarquees();

        /* ============================================================
           15. HOVER EFFECTS (data-hover)
           ============================================================ */
        initHoverEffects();

        /* ============================================================
           16. ACCORDION (data-accordion)
           ============================================================ */
        document.querySelectorAll('[data-accordion] details').forEach(function (detail) {
            detail.addEventListener('toggle', function () {
                if (detail.open) {
                    var parent = detail.closest('[data-accordion]');
                    if (parent) {
                        parent.querySelectorAll('details[open]').forEach(function (d) {
                            if (d !== detail) d.open = false;
                        });
                    }
                }
            });
        });

        /* ============================================================
           17. CONTACT FORM (data-contact-form)
           ============================================================ */
        initContactForms();

        /* ============================================================
           18. DARK MODE
           ============================================================ */
        initDarkMode();

        /* ============================================================
           19. COOKIE CONSENT BANNER
           ============================================================ */
        initCookieConsent();

        /* ============================================================
           20. BEFORE/AFTER SLIDER (data-before-after)
           ============================================================ */
        initBeforeAfter();

        /* ============================================================
           21. VIDEO THUMBNAIL (data-video-src)
           ============================================================ */
        initVideoThumbnails();

        /* ============================================================
           22. PRICING TOGGLE (data-pricing-toggle)
           ============================================================ */
        initPricingToggle();

        /* ============================================================
           23. DISMISS (data-dismiss)
           ============================================================ */
        initDismiss();

    }); // end DOMContentLoaded


    /* ================================================================
       SCROLL ANIMATIONS
       ================================================================ */
    function initAnimations() {
        // Back-compat: map data-reveal to data-animate="fade-up"
        document.querySelectorAll('[data-reveal]:not([data-animate])').forEach(function (el) {
            el.setAttribute('data-animate', 'fade-up');
        });

        var animElements = document.querySelectorAll('[data-animate]');
        if (!animElements.length) return;

        // If user prefers reduced motion, show everything immediately
        if (prefersReducedMotion) {
            animElements.forEach(function (el) {
                el.classList.add('animated');
            });
            return;
        }

        var observer = new IntersectionObserver(function (entries) {
            entries.forEach(function (entry) {
                if (entry.isIntersecting) {
                    var el = entry.target;
                    var delay = parseInt(el.getAttribute('data-animate-delay') || '0', 10);
                    var duration = parseInt(el.getAttribute('data-animate-duration') || '600', 10);
                    var once = el.getAttribute('data-animate-once');
                    var animateOnce = once === null || once === 'true' || once === '';

                    el.style.transitionDuration = duration + 'ms';

                    if (delay > 0) {
                        el.style.transitionDelay = delay + 'ms';
                    }

                    // Force a reflow so the transition fires
                    void el.offsetWidth;
                    el.classList.add('animated');

                    if (animateOnce) {
                        observer.unobserve(el);
                    }
                } else {
                    // Re-animate on scroll back if data-animate-once="false"
                    var onceAttr = entry.target.getAttribute('data-animate-once');
                    if (onceAttr === 'false') {
                        entry.target.classList.remove('animated');
                        entry.target.style.transitionDelay = '';
                    }
                }
            });
        }, { threshold: 0.1, rootMargin: '0px 0px -50px 0px' });

        animElements.forEach(function (el) {
            observer.observe(el);
        });
    }


    /* ================================================================
       COUNTER (data-count)
       ================================================================ */
    function initCounters() {
        var counters = document.querySelectorAll('[data-count]');
        if (!counters.length) return;

        var observer = new IntersectionObserver(function (entries) {
            entries.forEach(function (entry) {
                if (!entry.isIntersecting) return;

                var el = entry.target;
                var targetVal = parseInt(el.getAttribute('data-count') || el.textContent, 10);
                if (isNaN(targetVal)) return;

                var duration = parseInt(el.getAttribute('data-count-duration') || '1200', 10);
                var suffix = el.getAttribute('data-count-suffix') || '';
                var prefix = el.getAttribute('data-count-prefix') || '';
                var startTime = null;

                if (prefersReducedMotion) {
                    el.textContent = prefix + targetVal.toLocaleString() + suffix;
                    observer.unobserve(el);
                    return;
                }

                function step(timestamp) {
                    if (!startTime) startTime = timestamp;
                    var progress = Math.min((timestamp - startTime) / duration, 1);
                    // Ease out quad
                    var eased = 1 - (1 - progress) * (1 - progress);
                    var current = Math.floor(eased * targetVal);

                    el.textContent = prefix + current.toLocaleString() + suffix;

                    if (progress < 1) {
                        requestAnimationFrame(step);
                    } else {
                        el.textContent = prefix + targetVal.toLocaleString() + suffix;
                    }
                }

                requestAnimationFrame(step);
                observer.unobserve(el);
            });
        }, { threshold: 0.5 });

        counters.forEach(function (el) {
            observer.observe(el);
        });
    }


    /* ================================================================
       TYPEWRITER (data-typewriter)
       ================================================================ */
    function initTypewriters() {
        var elements = document.querySelectorAll('[data-typewriter]');
        if (!elements.length) return;

        if (prefersReducedMotion) return; // Show text as-is

        var observer = new IntersectionObserver(function (entries) {
            entries.forEach(function (entry) {
                if (!entry.isIntersecting) return;

                var el = entry.target;
                if (el._twStarted) return;
                el._twStarted = true;

                var text = el.getAttribute('data-typewriter') || el.textContent || '';
                var speed = parseInt(el.getAttribute('data-typewriter-speed') || '50', 10);
                var initialDelay = parseInt(el.getAttribute('data-typewriter-delay') || '0', 10);
                var showCursor = el.getAttribute('data-typewriter-cursor') !== 'false';

                // Store and clear text
                el.textContent = '';
                el.style.visibility = 'visible';

                // Create cursor element
                var cursor = null;
                if (showCursor) {
                    cursor = document.createElement('span');
                    cursor.className = 'typewriter-cursor';
                    cursor.textContent = '|';
                    el.appendChild(cursor);
                }

                var textNode = document.createTextNode('');
                if (cursor) {
                    el.insertBefore(textNode, cursor);
                } else {
                    el.appendChild(textNode);
                }

                var i = 0;
                function type() {
                    if (i < text.length) {
                        textNode.textContent += text.charAt(i);
                        i++;
                        setTimeout(type, speed);
                    } else if (cursor) {
                        // Keep cursor blinking for 2s, then remove
                        setTimeout(function () {
                            cursor.style.opacity = '0';
                            setTimeout(function () { cursor.remove(); }, 500);
                        }, 2000);
                    }
                }

                setTimeout(type, initialDelay);
                observer.unobserve(el);
            });
        }, { threshold: 0.3 });

        elements.forEach(function (el) {
            observer.observe(el);
        });
    }


    /* ================================================================
       PARALLAX (data-parallax="0.3")
       ================================================================ */
    function initParallax() {
        var elements = document.querySelectorAll('[data-parallax]');
        if (!elements.length || prefersReducedMotion) return;

        function updateParallax() {
            var scrollY = window.scrollY;
            var windowHeight = window.innerHeight;

            elements.forEach(function (el) {
                var rect = el.getBoundingClientRect();
                // Only process if in/near viewport
                if (rect.bottom < -200 || rect.top > windowHeight + 200) return;

                var speed = parseFloat(el.getAttribute('data-parallax')) || 0.3;
                // Calculate offset from element center to viewport center
                var elementCenter = rect.top + rect.height / 2;
                var viewportCenter = windowHeight / 2;
                var offset = (elementCenter - viewportCenter) * speed;

                el.style.transform = 'translateY(' + offset + 'px)';
                el.style.willChange = 'transform';
            });
        }

        window.addEventListener('scroll', throttle(updateParallax, 16), { passive: true });
        updateParallax(); // Initial call
    }


    /* ================================================================
       LIGHTBOX (data-lightbox)
       ================================================================ */
    function initLightbox() {
        var triggers = document.querySelectorAll('[data-lightbox]');
        if (!triggers.length) return;

        var overlay = null;
        var currentGroup = [];
        var currentIndex = 0;
        var touchStartX = 0;
        var touchEndX = 0;

        function getImageSrc(el) {
            if (el.tagName === 'IMG') return el.src;
            if (el.tagName === 'A') return el.href;
            var img = el.querySelector('img');
            if (img) return img.src;
            return el.getAttribute('data-lightbox-src') || '';
        }

        function createOverlay() {
            if (overlay) return;

            overlay = document.createElement('div');
            overlay.className = 'wc-lightbox-overlay';
            overlay.innerHTML =
                '<div class="wc-lightbox-content">' +
                    '<img class="wc-lightbox-image" src="" alt="">' +
                    '<div class="wc-lightbox-caption"></div>' +
                '</div>' +
                '<button class="wc-lightbox-close" aria-label="Cerrar">&times;</button>' +
                '<button class="wc-lightbox-prev" aria-label="Anterior">&#10094;</button>' +
                '<button class="wc-lightbox-next" aria-label="Siguiente">&#10095;</button>';

            document.body.appendChild(overlay);

            // Close
            overlay.querySelector('.wc-lightbox-close').addEventListener('click', closeLightbox);
            overlay.addEventListener('click', function (e) {
                if (e.target === overlay) closeLightbox();
            });

            // Prev / Next
            overlay.querySelector('.wc-lightbox-prev').addEventListener('click', function (e) {
                e.stopPropagation();
                navigate(-1);
            });
            overlay.querySelector('.wc-lightbox-next').addEventListener('click', function (e) {
                e.stopPropagation();
                navigate(1);
            });

            // Touch swipe
            overlay.addEventListener('touchstart', function (e) {
                touchStartX = e.changedTouches[0].screenX;
            }, { passive: true });
            overlay.addEventListener('touchend', function (e) {
                touchEndX = e.changedTouches[0].screenX;
                var diff = touchStartX - touchEndX;
                if (Math.abs(diff) > 50) {
                    navigate(diff > 0 ? 1 : -1);
                }
            }, { passive: true });
        }

        function openLightbox(triggerEl) {
            createOverlay();

            var group = triggerEl.getAttribute('data-lightbox-group');
            if (group) {
                currentGroup = Array.from(document.querySelectorAll('[data-lightbox-group="' + group + '"]'));
                currentIndex = currentGroup.indexOf(triggerEl);
            } else {
                currentGroup = [triggerEl];
                currentIndex = 0;
            }

            showImage(currentIndex);

            // Show/hide nav arrows
            var showNav = currentGroup.length > 1;
            overlay.querySelector('.wc-lightbox-prev').style.display = showNav ? 'flex' : 'none';
            overlay.querySelector('.wc-lightbox-next').style.display = showNav ? 'flex' : 'none';

            overlay.classList.add('active');
            document.body.style.overflow = 'hidden';
        }

        function closeLightbox() {
            if (!overlay) return;
            overlay.classList.remove('active');
            document.body.style.overflow = '';
        }

        function navigate(dir) {
            if (currentGroup.length <= 1) return;
            currentIndex = (currentIndex + dir + currentGroup.length) % currentGroup.length;
            showImage(currentIndex);
        }

        function showImage(index) {
            var el = currentGroup[index];
            var src = getImageSrc(el);
            var caption = el.getAttribute('data-lightbox-caption') || '';

            var img = overlay.querySelector('.wc-lightbox-image');
            var cap = overlay.querySelector('.wc-lightbox-caption');

            img.src = src;
            img.alt = caption || 'Image';
            cap.textContent = caption;
            cap.style.display = caption ? 'block' : 'none';
        }

        // Keyboard navigation
        document.addEventListener('keydown', function (e) {
            if (!overlay || !overlay.classList.contains('active')) return;
            if (e.key === 'Escape') closeLightbox();
            if (e.key === 'ArrowLeft') navigate(-1);
            if (e.key === 'ArrowRight') navigate(1);
        });

        // Attach click handlers
        triggers.forEach(function (el) {
            el.style.cursor = 'pointer';
            el.addEventListener('click', function (e) {
                e.preventDefault();
                openLightbox(el);
            });
        });
    }


    /* ================================================================
       CAROUSEL (data-carousel)
       ================================================================ */
    function initCarousels() {
        var carousels = document.querySelectorAll('[data-carousel]');
        if (!carousels.length) return;

        carousels.forEach(function (container) {
            var autoplay = parseInt(container.getAttribute('data-carousel-autoplay') || '0', 10);
            var loop = container.getAttribute('data-carousel-loop') !== 'false';
            var showDots = container.getAttribute('data-carousel-dots') !== 'false';
            var showArrows = container.getAttribute('data-carousel-arrows') !== 'false';

            // Wrap children as slides
            var slides = Array.from(container.children);
            if (slides.length === 0) return;

            // Create track
            var track = document.createElement('div');
            track.className = 'wc-carousel-track';
            slides.forEach(function (slide) {
                slide.classList.add('wc-carousel-slide');
                track.appendChild(slide);
            });

            // Clear and rebuild
            container.innerHTML = '';
            container.classList.add('wc-carousel');
            container.appendChild(track);

            var currentSlide = 0;
            var totalSlides = slides.length;
            var autoplayTimer = null;
            var touchStartX = 0;

            function goTo(index) {
                if (loop) {
                    currentSlide = (index + totalSlides) % totalSlides;
                } else {
                    currentSlide = Math.max(0, Math.min(index, totalSlides - 1));
                }
                track.style.transform = 'translateX(-' + (currentSlide * 100) + '%)';
                updateDots();
            }

            function updateDots() {
                if (!dotsContainer) return;
                var dots = dotsContainer.querySelectorAll('.wc-carousel-dot');
                dots.forEach(function (dot, i) {
                    dot.classList.toggle('active', i === currentSlide);
                });
            }

            // Arrows
            if (showArrows && totalSlides > 1) {
                var prevBtn = document.createElement('button');
                prevBtn.className = 'wc-carousel-arrow wc-carousel-arrow-prev';
                prevBtn.innerHTML = '&#10094;';
                prevBtn.setAttribute('aria-label', 'Anterior');
                prevBtn.addEventListener('click', function () {
                    goTo(currentSlide - 1);
                    resetAutoplay();
                });

                var nextBtn = document.createElement('button');
                nextBtn.className = 'wc-carousel-arrow wc-carousel-arrow-next';
                nextBtn.innerHTML = '&#10095;';
                nextBtn.setAttribute('aria-label', 'Siguiente');
                nextBtn.addEventListener('click', function () {
                    goTo(currentSlide + 1);
                    resetAutoplay();
                });

                container.appendChild(prevBtn);
                container.appendChild(nextBtn);
            }

            // Dots
            var dotsContainer = null;
            if (showDots && totalSlides > 1) {
                dotsContainer = document.createElement('div');
                dotsContainer.className = 'wc-carousel-dots';
                for (var i = 0; i < totalSlides; i++) {
                    var dot = document.createElement('button');
                    dot.className = 'wc-carousel-dot' + (i === 0 ? ' active' : '');
                    dot.setAttribute('aria-label', 'Ir a slide ' + (i + 1));
                    dot.dataset.index = i;
                    dot.addEventListener('click', function () {
                        goTo(parseInt(this.dataset.index, 10));
                        resetAutoplay();
                    });
                    dotsContainer.appendChild(dot);
                }
                container.appendChild(dotsContainer);
            }

            // Touch/swipe
            track.addEventListener('touchstart', function (e) {
                touchStartX = e.changedTouches[0].screenX;
            }, { passive: true });
            track.addEventListener('touchend', function (e) {
                var diff = touchStartX - e.changedTouches[0].screenX;
                if (Math.abs(diff) > 50) {
                    goTo(currentSlide + (diff > 0 ? 1 : -1));
                    resetAutoplay();
                }
            }, { passive: true });

            // Autoplay
            function startAutoplay() {
                if (autoplay <= 0 || totalSlides <= 1) return;
                autoplayTimer = setInterval(function () {
                    goTo(currentSlide + 1);
                }, autoplay);
            }

            function resetAutoplay() {
                if (autoplayTimer) clearInterval(autoplayTimer);
                startAutoplay();
            }

            startAutoplay();

            // Pause on hover
            if (autoplay > 0) {
                container.addEventListener('mouseenter', function () {
                    if (autoplayTimer) clearInterval(autoplayTimer);
                });
                container.addEventListener('mouseleave', function () {
                    startAutoplay();
                });
            }
        });
    }


    /* ================================================================
       TABS (data-tabs)
       ================================================================ */
    function initTabs() {
        var tabContainers = document.querySelectorAll('[data-tabs]');
        if (!tabContainers.length) return;

        tabContainers.forEach(function (container) {
            var triggers = container.querySelectorAll('[data-tab-trigger]');
            var panels = container.querySelectorAll('[data-tab-content]');

            if (!triggers.length || !panels.length) return;

            function activate(tabId) {
                // Deactivate all
                triggers.forEach(function (t) {
                    t.classList.toggle('tab-active', t.getAttribute('data-tab-trigger') === tabId);
                });
                panels.forEach(function (p) {
                    var isActive = p.getAttribute('data-tab-content') === tabId;
                    p.classList.toggle('tab-active', isActive);
                    if (isActive) {
                        p.style.display = 'block';
                        if (!prefersReducedMotion) {
                            p.style.opacity = '0';
                            requestAnimationFrame(function () {
                                p.style.transition = 'opacity 0.3s ease';
                                p.style.opacity = '1';
                            });
                        }
                    } else {
                        p.style.display = 'none';
                    }
                });
            }

            triggers.forEach(function (trigger) {
                trigger.addEventListener('click', function (e) {
                    e.preventDefault();
                    activate(trigger.getAttribute('data-tab-trigger'));
                });
            });

            // Activate first tab
            var firstTabId = triggers[0].getAttribute('data-tab-trigger');
            activate(firstTabId);
        });
    }


    /* ================================================================
       STICKY NAVBAR (data-sticky)
       ================================================================ */
    function initSticky() {
        var stickyElements = document.querySelectorAll('[data-sticky]');
        if (!stickyElements.length) return;

        stickyElements.forEach(function (el) {
            var offset = parseInt(el.getAttribute('data-sticky-offset') || '0', 10);
            var stickyClass = el.getAttribute('data-sticky-class') || 'is-sticky';

            // Store original position info
            var placeholder = document.createElement('div');
            placeholder.style.display = 'none';
            el.parentNode.insertBefore(placeholder, el);

            var originalTop = el.getBoundingClientRect().top + window.scrollY;
            var originalHeight = el.offsetHeight;
            var isSticky = false;

            function checkSticky() {
                var scrollY = window.scrollY;

                if (scrollY > originalTop + offset && !isSticky) {
                    isSticky = true;
                    placeholder.style.display = 'block';
                    placeholder.style.height = originalHeight + 'px';
                    el.classList.add(stickyClass);
                } else if (scrollY <= originalTop + offset && isSticky) {
                    isSticky = false;
                    placeholder.style.display = 'none';
                    el.classList.remove(stickyClass);
                }
            }

            window.addEventListener('scroll', throttle(checkSticky, 16), { passive: true });
            checkSticky();
        });
    }


    /* ================================================================
       PROGRESS BAR (data-progress="75")
       ================================================================ */
    function initProgressBars() {
        var bars = document.querySelectorAll('[data-progress]');
        if (!bars.length) return;

        bars.forEach(function (el) {
            // Create internal bar structure if not already set up
            if (!el.querySelector('.wc-progress-bar')) {
                el.classList.add('wc-progress');
                var bar = document.createElement('div');
                bar.className = 'wc-progress-bar';

                var color = el.getAttribute('data-progress-color');
                if (color) {
                    bar.style.background = color;
                }

                el.appendChild(bar);
            }
        });

        var observer = new IntersectionObserver(function (entries) {
            entries.forEach(function (entry) {
                if (!entry.isIntersecting) return;

                var el = entry.target;
                var pct = parseInt(el.getAttribute('data-progress') || '0', 10);
                var duration = parseInt(el.getAttribute('data-progress-duration') || '1500', 10);
                var bar = el.querySelector('.wc-progress-bar');

                if (!bar) return;

                if (prefersReducedMotion) {
                    bar.style.width = pct + '%';
                } else {
                    bar.style.transition = 'width ' + duration + 'ms cubic-bezier(0.22,1,0.36,1)';
                    // Force reflow
                    void bar.offsetWidth;
                    bar.style.width = pct + '%';
                }

                observer.unobserve(el);
            });
        }, { threshold: 0.3 });

        bars.forEach(function (el) {
            observer.observe(el);
        });
    }


    /* ================================================================
       MARQUEE (data-marquee)
       ================================================================ */
    function initMarquees() {
        var marquees = document.querySelectorAll('[data-marquee]');
        if (!marquees.length) return;

        if (prefersReducedMotion) return; // Skip marquees for reduced motion

        marquees.forEach(function (el) {
            var speed = parseInt(el.getAttribute('data-marquee-speed') || '30', 10);
            var direction = el.getAttribute('data-marquee-direction') || 'left';
            var pauseHover = el.getAttribute('data-marquee-pause-hover') !== 'false';

            el.classList.add('wc-marquee');

            // Create track wrapping all content
            var track = document.createElement('div');
            track.className = 'wc-marquee-track';

            // Move children into track
            while (el.firstChild) {
                track.appendChild(el.firstChild);
            }

            // Duplicate for seamless loop
            var clone = track.cloneNode(true);
            clone.setAttribute('aria-hidden', 'true');

            var wrapper = document.createElement('div');
            wrapper.className = 'wc-marquee-wrapper';
            wrapper.appendChild(track);
            wrapper.appendChild(clone);
            el.appendChild(wrapper);

            // Calculate animation duration based on content width
            // Use a reasonable default; actual width is computed after render
            requestAnimationFrame(function () {
                var contentWidth = track.scrollWidth;
                if (contentWidth === 0) contentWidth = 500;
                var animDuration = contentWidth / speed;

                wrapper.style.animationDuration = animDuration + 's';
                wrapper.style.animationDirection = direction === 'right' ? 'reverse' : 'normal';
                wrapper.classList.add('wc-marquee-animate');
            });

            if (pauseHover) {
                el.addEventListener('mouseenter', function () {
                    var w = el.querySelector('.wc-marquee-wrapper');
                    if (w) w.style.animationPlayState = 'paused';
                });
                el.addEventListener('mouseleave', function () {
                    var w = el.querySelector('.wc-marquee-wrapper');
                    if (w) w.style.animationPlayState = 'running';
                });
            }
        });
    }


    /* ================================================================
       HOVER EFFECTS (data-hover="type")
       ================================================================ */
    function initHoverEffects() {
        var hoverElements = document.querySelectorAll('[data-hover]');
        if (!hoverElements.length) return;

        // Inject hover class style only if not already present
        if (!document.getElementById('wc-hover-styles')) {
            var style = document.createElement('style');
            style.id = 'wc-hover-styles';
            style.textContent =
                '[data-hover]{transition:transform 0.3s ease,box-shadow 0.3s ease,border-color 0.3s ease;}' +
                '[data-hover="scale"]:hover{transform:scale(1.05);}' +
                '[data-hover="shadow"]:hover{box-shadow:0 10px 40px rgba(0,0,0,0.15);}' +
                '[data-hover="lift"]:hover{transform:translateY(-4px);box-shadow:0 12px 32px rgba(0,0,0,0.12);}' +
                '[data-hover="glow"]:hover{box-shadow:0 0 20px var(--color-primary,#6366F1),0 0 40px rgba(99,102,241,0.15);}' +
                '[data-hover="border"]:hover{border-color:var(--color-primary,#6366F1) !important;}';
            document.head.appendChild(style);
        }
    }


    /* ================================================================
       CONTACT FORM (data-contact-form)
       ================================================================ */
    function initContactForms() {
        document.querySelectorAll('form[data-contact-form]').forEach(function (form) {
            // Inject honeypot field if not present
            if (!form.querySelector('input[name="website"]')) {
                var honeypot = document.createElement('input');
                honeypot.type = 'text';
                honeypot.name = 'website';
                honeypot.value = '';
                honeypot.autocomplete = 'off';
                honeypot.tabIndex = -1;
                honeypot.style.cssText = 'position:absolute;left:-9999px;top:-9999px;opacity:0;height:0;width:0;';
                form.appendChild(honeypot);
            }

            form.addEventListener('submit', async function (e) {
                e.preventDefault();

                var submitBtn = form.querySelector('[type="submit"]');
                var originalText = submitBtn ? submitBtn.textContent : '';

                // Remove previous messages
                var prevMsg = form.querySelector('[data-form-message]');
                if (prevMsg) prevMsg.remove();

                // Disable button
                if (submitBtn) {
                    submitBtn.disabled = true;
                    submitBtn.textContent = 'Enviando...';
                    submitBtn.style.opacity = '0.7';
                }

                // CSRF token
                var csrfMeta = document.querySelector('meta[name="csrf-token"]');
                var csrfToken = csrfMeta ? csrfMeta.getAttribute('content') : '';

                var formData = new FormData(form);
                var data = Object.fromEntries(formData.entries());

                try {
                    var response = await fetch('/contact', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': csrfToken,
                        },
                        body: JSON.stringify(data),
                    });

                    var result = await response.json();
                    var msgEl = document.createElement('div');
                    msgEl.setAttribute('data-form-message', '');
                    msgEl.style.cssText = 'padding:12px 16px;border-radius:8px;margin-top:12px;font-size:14px;';

                    if (response.ok && result.success) {
                        msgEl.style.background = '#ecfdf5';
                        msgEl.style.color = '#065f46';
                        msgEl.style.border = '1px solid #6ee7b7';
                        msgEl.textContent = result.message || 'Mensaje enviado correctamente';
                        form.reset();
                    } else if (response.status === 422 && result.errors) {
                        var firstError = Object.values(result.errors)[0];
                        msgEl.style.background = '#fef2f2';
                        msgEl.style.color = '#991b1b';
                        msgEl.style.border = '1px solid #fca5a5';
                        msgEl.textContent = Array.isArray(firstError) ? firstError[0] : firstError;
                    } else if (response.status === 429) {
                        msgEl.style.background = '#fffbeb';
                        msgEl.style.color = '#92400e';
                        msgEl.style.border = '1px solid #fcd34d';
                        msgEl.textContent = 'Has enviado demasiados mensajes. Intenta de nuevo más tarde.';
                    } else {
                        msgEl.style.background = '#fef2f2';
                        msgEl.style.color = '#991b1b';
                        msgEl.style.border = '1px solid #fca5a5';
                        msgEl.textContent = result.message || 'Error al enviar el mensaje. Inténtalo de nuevo.';
                    }

                    form.appendChild(msgEl);
                } catch (err) {
                    var msgEl = document.createElement('div');
                    msgEl.setAttribute('data-form-message', '');
                    msgEl.style.cssText = 'padding:12px 16px;border-radius:8px;margin-top:12px;font-size:14px;background:#fef2f2;color:#991b1b;border:1px solid #fca5a5;';
                    msgEl.textContent = 'Error de conexión. Verifica tu internet e inténtalo de nuevo.';
                    form.appendChild(msgEl);
                } finally {
                    if (submitBtn) {
                        submitBtn.disabled = false;
                        submitBtn.textContent = originalText;
                        submitBtn.style.opacity = '1';
                    }
                }
            });
        });
    }

    /* ================================================================
       DARK MODE
       ================================================================ */
    function initDarkMode() {
        var root = document.documentElement;
        var toggleBtn = document.getElementById('wc-dark-mode-toggle');
        var storedTheme = localStorage.getItem('theme');
        var systemPrefersDark = window.matchMedia('(prefers-color-scheme: dark)');

        // Apply theme on load
        function applyTheme(theme) {
            if (theme === 'dark' || theme === 'light') {
                root.setAttribute('data-theme', theme);
            } else {
                // No manual preference: remove attribute so CSS media query takes over
                root.removeAttribute('data-theme');
            }
        }

        // Determine initial theme
        if (storedTheme) {
            applyTheme(storedTheme);
        }
        // If no stored theme, system preference handles it via CSS media query

        // Toggle button
        if (toggleBtn) {
            toggleBtn.addEventListener('click', function () {
                var currentTheme = root.getAttribute('data-theme');
                var isDark;

                if (currentTheme === 'dark') {
                    isDark = false;
                } else if (currentTheme === 'light') {
                    isDark = true;
                } else {
                    // No explicit theme set; check what's currently showing
                    isDark = !systemPrefersDark.matches;
                }

                var newTheme = isDark ? 'dark' : 'light';
                localStorage.setItem('theme', newTheme);
                applyTheme(newTheme);
            });
        }

        // Listen for system preference changes
        try {
            systemPrefersDark.addEventListener('change', function () {
                // Only respond if user hasn't set a manual preference
                if (!localStorage.getItem('theme')) {
                    root.removeAttribute('data-theme');
                }
            });
        } catch (e) {
            // Fallback for older browsers
            try {
                systemPrefersDark.addListener(function () {
                    if (!localStorage.getItem('theme')) {
                        root.removeAttribute('data-theme');
                    }
                });
            } catch (e2) { /* ignore */ }
        }
    }


    /* ================================================================
       COOKIE CONSENT BANNER
       ================================================================ */
    function initCookieConsent() {
        var banner = document.getElementById('wc-cookie-banner');
        var acceptBtn = document.getElementById('wc-cookie-accept');
        var rejectBtn = document.getElementById('wc-cookie-reject');

        if (!banner) return;

        // Check if user has already made a choice
        var consent = localStorage.getItem('wc_cookie_consent');
        if (consent) return; // Already chose, don't show banner

        // Show the banner
        banner.style.display = 'block';

        function hideBanner() {
            banner.style.animation = 'none';
            banner.style.transition = 'transform 0.3s ease, opacity 0.3s ease';
            banner.style.transform = 'translateY(100%)';
            banner.style.opacity = '0';
            setTimeout(function () {
                banner.style.display = 'none';
            }, 300);
        }

        if (acceptBtn) {
            acceptBtn.addEventListener('click', function () {
                localStorage.setItem('wc_cookie_consent', 'accepted');
                hideBanner();
                // Enable analytics by reloading (scripts check localStorage on load)
                // For immediate effect, try to load analytics now
                loadAnalyticsAfterConsent();
            });
        }

        if (rejectBtn) {
            rejectBtn.addEventListener('click', function () {
                localStorage.setItem('wc_cookie_consent', 'rejected');
                hideBanner();
            });
        }
    }

    /**
     * Attempt to load analytics scripts after consent is given
     * without requiring a page reload.
     */
    function loadAnalyticsAfterConsent() {
        // This is a best-effort approach. The analytics scripts in the layout
        // check localStorage on page load. On the next page navigation they
        // will load automatically. For the current page, we trigger a
        // custom event that the page can listen to.
        try {
            window.dispatchEvent(new CustomEvent('wc:cookie-consent-accepted'));
        } catch (e) { /* ignore */ }
    }


    /* ================================================================
       BEFORE/AFTER SLIDER (data-before-after)
       ================================================================ */
    function initBeforeAfter() {
        var sliders = document.querySelectorAll('[data-before-after]');
        if (!sliders.length) return;

        sliders.forEach(function (slider) {
            var afterImg = slider.querySelector('.ba-image-after');
            var handle = slider.querySelector('.ba-handle');
            if (!afterImg || !handle) return;

            var isDragging = false;

            function updatePosition(clientX) {
                var rect = slider.getBoundingClientRect();
                var x = clientX - rect.left;
                var pct = Math.max(0, Math.min(x / rect.width * 100, 100));
                afterImg.style.clipPath = 'inset(0 0 0 ' + pct + '%)';
                handle.style.left = pct + '%';
            }

            slider.addEventListener('mousedown', function (e) {
                e.preventDefault();
                isDragging = true;
                updatePosition(e.clientX);
            });

            document.addEventListener('mousemove', function (e) {
                if (!isDragging) return;
                e.preventDefault();
                updatePosition(e.clientX);
            });

            document.addEventListener('mouseup', function () {
                isDragging = false;
            });

            slider.addEventListener('touchstart', function (e) {
                isDragging = true;
                updatePosition(e.touches[0].clientX);
            }, { passive: true });

            slider.addEventListener('touchmove', function (e) {
                if (!isDragging) return;
                updatePosition(e.touches[0].clientX);
            }, { passive: true });

            slider.addEventListener('touchend', function () {
                isDragging = false;
            }, { passive: true });
        });
    }


    /* ================================================================
       VIDEO THUMBNAIL (data-video-src)
       ================================================================ */
    function initVideoThumbnails() {
        var elements = document.querySelectorAll('[data-video-src]');
        if (!elements.length) return;

        elements.forEach(function (el) {
            el.style.cursor = 'pointer';
            el.addEventListener('click', function () {
                var src = el.getAttribute('data-video-src');
                if (!src) return;

                // Append autoplay param
                var separator = src.indexOf('?') !== -1 ? '&' : '?';
                src = src + separator + 'autoplay=1';

                var iframe = document.createElement('iframe');
                iframe.src = src;
                iframe.setAttribute('frameborder', '0');
                iframe.setAttribute('allow', 'accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture');
                iframe.setAttribute('allowfullscreen', '');
                iframe.style.cssText = 'position:absolute;inset:0;width:100%;height:100%;border:none;';

                // Clear content and add iframe
                el.innerHTML = '';
                el.style.position = 'relative';
                el.appendChild(iframe);

                // Remove the data attribute so it won't fire again
                el.removeAttribute('data-video-src');
                el.style.cursor = 'default';
            });
        });
    }


    /* ================================================================
       PRICING TOGGLE (data-pricing-toggle)
       ================================================================ */
    function initPricingToggle() {
        var containers = document.querySelectorAll('[data-pricing-toggle]');
        if (!containers.length) return;

        containers.forEach(function (container) {
            var switchBtn = container.querySelector('[data-pricing-switch]');
            if (!switchBtn) return;

            var isAnnual = false;
            var amounts = container.querySelectorAll('[data-price-monthly]');
            var labelMonthly = container.querySelector('[data-pricing-label="monthly"]');
            var labelAnnual = container.querySelector('[data-pricing-label="annual"]');

            function updatePrices() {
                amounts.forEach(function (el) {
                    if (isAnnual) {
                        el.textContent = el.getAttribute('data-price-annual');
                    } else {
                        el.textContent = el.getAttribute('data-price-monthly');
                    }
                });

                if (labelMonthly) {
                    labelMonthly.classList.toggle('ptoggle-label-active', !isAnnual);
                }
                if (labelAnnual) {
                    labelAnnual.classList.toggle('ptoggle-label-active', isAnnual);
                }

                switchBtn.classList.toggle('active', isAnnual);
            }

            switchBtn.addEventListener('click', function () {
                isAnnual = !isAnnual;
                updatePrices();
            });
        });
    }


    /* ================================================================
       DISMISS (data-dismiss)
       ================================================================ */
    function initDismiss() {
        document.querySelectorAll('[data-dismiss]').forEach(function (btn) {
            btn.addEventListener('click', function () {
                // Find closest dismissible parent: section, div with class, or direct parent
                var target = btn.closest('.calert') || btn.closest('.notifbar') || btn.closest('section') || btn.parentElement;
                if (!target) return;

                // Slide-up / fade-out animation
                target.style.transition = 'max-height 0.4s ease, padding 0.4s ease, opacity 0.3s ease, margin 0.3s ease';
                target.style.overflow = 'hidden';
                target.style.maxHeight = target.offsetHeight + 'px';

                // Force reflow
                void target.offsetHeight;

                target.style.maxHeight = '0';
                target.style.paddingTop = '0';
                target.style.paddingBottom = '0';
                target.style.marginTop = '0';
                target.style.marginBottom = '0';
                target.style.opacity = '0';

                setTimeout(function () {
                    target.style.display = 'none';
                }, 400);
            });
        });
    }

})();

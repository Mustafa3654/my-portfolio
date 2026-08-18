/**
 * Portfolio Main JavaScript
 * Contains theme toggle, animations, and interactive features
 */

// ==============================
// THEME TOGGLE FUNCTIONALITY
// ==============================

/**
 * Initialize theme based on user preference or system setting
 */
function initTheme() {
    const savedTheme = localStorage.getItem('theme');
    const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
    
    if (savedTheme) {
        document.documentElement.setAttribute('data-theme', savedTheme);
        updateThemeIcon(savedTheme);
    } else if (prefersDark) {
        document.documentElement.setAttribute('data-theme', 'dark');
        updateThemeIcon('dark');
    } else {
        document.documentElement.setAttribute('data-theme', 'dark');
        updateThemeIcon('dark');
    }
}

/**
 * Toggle between light and dark themes
 */
function toggleTheme() {
    const currentTheme = document.documentElement.getAttribute('data-theme');
    const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
    
    document.documentElement.setAttribute('data-theme', newTheme);
    localStorage.setItem('theme', newTheme);
    updateThemeIcon(newTheme);
}

/**
 * Update the theme toggle button icon
 */
function updateThemeIcon(theme) {
    const themeIcon = document.getElementById('theme-icon');
    if (themeIcon) {
        if (theme === 'dark') {
            themeIcon.className = 'fas fa-moon';
        } else {
            themeIcon.className = 'fas fa-sun';
        }
    }
}

// ==============================
// SECTION ANIMATIONS
// ==============================

/**
 * Initialize intersection observer for section animations
 */
function initSectionAnimations() {
    const sections = document.querySelectorAll('.mini-section');
    const revealTargets = document.querySelectorAll('.project-card, .service-card, .skill-item, .about-bio, .contact-list, .detail-item, .contact-form-wrapper');
    
    if (sections.length === 0 && revealTargets.length === 0) return;

    revealTargets.forEach(target => target.classList.add('reveal-item'));
    
    const observer = new IntersectionObserver(entries => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                if (entry.target.classList.contains('mini-section')) {
                    entry.target.classList.add('visible');
                } else {
                    entry.target.classList.add('reveal-visible');
                }
                observer.unobserve(entry.target);
            }
        });
    }, { threshold: 0.14, rootMargin: '0px 0px -40px 0px' });
    
    sections.forEach(section => {
        observer.observe(section);
    });

    revealTargets.forEach(target => {
        observer.observe(target);
    });
}

/**
 * Initialize hero parallax for desktop
 */
function initHeroParallax() {
    const hero = document.querySelector('.home-section');
    const heroImage = document.querySelector('.profile-pic');

    if (!hero || !heroImage || window.innerWidth <= 992) return;
    if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) return;

    hero.addEventListener('mousemove', function(event) {
        const rect = hero.getBoundingClientRect();
        const x = event.clientX - rect.left;
        const y = event.clientY - rect.top;
        const offsetX = (x / rect.width - 0.5) * 14;
        const offsetY = (y / rect.height - 0.5) * 14;

        heroImage.style.transform = `translate(${offsetX}px, ${offsetY}px) scale(1.03)`;
    });

    hero.addEventListener('mouseleave', function() {
        heroImage.style.transform = '';
    });
}

/**
 * Initialize magnetic hover effect for primary buttons
 */
function initMagneticButtons() {
    const buttons = document.querySelectorAll('.btn-primary, .btn-secondary');

    if (buttons.length === 0 || window.matchMedia('(prefers-reduced-motion: reduce)').matches) return;

    buttons.forEach(button => {
        button.addEventListener('mousemove', function(event) {
            if (window.innerWidth <= 992) return;

            const rect = this.getBoundingClientRect();
            const x = event.clientX - rect.left;
            const y = event.clientY - rect.top;
            const moveX = (x - rect.width / 2) * 0.14;
            const moveY = (y - rect.height / 2) * 0.16;

            this.style.transform = `translate(${moveX}px, ${moveY}px)`;
        });

        button.addEventListener('mouseleave', function() {
            this.style.transform = '';
        });
    });
}

// ==============================
// SMOOTH SCROLL
// ==============================

/**
 * Initialize smooth scrolling for anchor links
 */
function initSmoothScroll() {
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });
}

// ==============================
// MOBILE NAVIGATION
// ==============================

/**
 * Initialize mobile navigation toggle
 */
function initMobileNav() {
    const menuToggle = document.getElementById('menu-toggle');
    const navLinks = document.querySelector('.nav-links');
    
    if (menuToggle && navLinks) {
        const closeMenu = () => {
            navLinks.classList.remove('active');
            menuToggle.classList.remove('active');
            menuToggle.setAttribute('aria-expanded', 'false');
        };

        menuToggle.setAttribute('aria-expanded', 'false');

        menuToggle.addEventListener('click', function() {
            const isOpen = navLinks.classList.toggle('active');
            this.classList.toggle('active', isOpen);
            this.setAttribute('aria-expanded', String(isOpen));
        });

        navLinks.querySelectorAll('a').forEach(link => {
            link.addEventListener('click', () => {
                if (window.innerWidth <= 768) {
                    closeMenu();
                }
            });
        });

        document.addEventListener('click', event => {
            if (!navLinks.contains(event.target) && !menuToggle.contains(event.target)) {
                closeMenu();
            }
        });

        document.addEventListener('keydown', event => {
            if (event.key === 'Escape') {
                closeMenu();
            }
        });

        window.addEventListener('resize', () => {
            if (window.innerWidth > 768) {
                closeMenu();
            }
        });
    }
}

// ==============================
// FORM VALIDATION
// ==============================

/**
 * Initialize contact form validation
 */
function initFormValidation() {
    const contactForm = document.querySelector('.contact-form');
    
    if (contactForm) {
        contactForm.addEventListener('submit', function(e) {
            const name = this.querySelector('input[name="name"]');
            const email = this.querySelector('input[name="email"]');
            const message = this.querySelector('textarea[name="message"]');
            
            let isValid = true;
            
            // Clear previous errors
            this.querySelectorAll('.error-message').forEach(el => el.remove());
            
            // Validate name
            if (name && name.value.trim().length < 2) {
                showError(name, 'Please enter a valid name');
                isValid = false;
            }
            
            // Validate email
            if (email && !isValidEmail(email.value)) {
                showError(email, 'Please enter a valid email address');
                isValid = false;
            }
            
            // Validate message
            if (message && message.value.trim().length < 10) {
                showError(message, 'Message must be at least 10 characters');
                isValid = false;
            }
            
            if (!isValid) {
                e.preventDefault();
            }
        });
    }
}

/**
 * Validate email format
 */
function isValidEmail(email) {
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return emailRegex.test(email);
}

/**
 * Show error message below input
 */
function showError(input, message) {
    const errorDiv = document.createElement('div');
    errorDiv.className = 'error-message';
    errorDiv.textContent = message;
    input.parentNode.insertBefore(errorDiv, input.nextSibling);
}

// ==============================
// TYPING EFFECT
// ==============================

/**
 * Initialize typing effect for hero section
 */
function initTypingEffect() {
    const typingElement = document.querySelector('.typing-text');
    
    if (typingElement) {
        const text = typingElement.getAttribute('data-text');
        let index = 0;
        
        function type() {
            if (index < text.length) {
                typingElement.textContent += text.charAt(index);
                index++;
                setTimeout(type, 100);
            }
        }
        
        type();
    }
}

// ==============================
// SCROLL TO TOP
// ==============================

/**
 * Initialize scroll to top button
 */
function initScrollToTop() {
    const scrollBtn = document.getElementById('scroll-to-top');
    
    if (scrollBtn) {
        window.addEventListener('scroll', function() {
            if (window.pageYOffset > 300) {
                scrollBtn.classList.add('visible');
            } else {
                scrollBtn.classList.remove('visible');
            }
        });
        
        scrollBtn.addEventListener('click', function() {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });
    }
}

// ==============================
// INITIALIZATION
// ==============================

/**
 * Initialize all functionality when DOM is loaded
 */
document.addEventListener('DOMContentLoaded', function() {
    initTheme();
    initSectionAnimations();
    initSmoothScroll();
    initMobileNav();
    initHeroParallax();
    initMagneticButtons();
    initFormValidation();
    initScrollToTop();
});

// Initialize theme immediately to prevent flash
initTheme();

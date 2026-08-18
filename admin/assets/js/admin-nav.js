// Admin Navigation JavaScript
document.addEventListener('DOMContentLoaded', function() {
    // DOM Elements
    const sidebar = document.getElementById('sidebar');
    const sidebarToggle = document.getElementById('sidebarToggle');
    const mobileMenuToggle = document.getElementById('mobileMenuToggle');
    const mobileMenuOverlay = document.getElementById('mobileMenuOverlay');
    const userDropdown = document.getElementById('userDropdown');
    const userDropdownMenu = document.getElementById('userDropdownMenu');
    const themeToggle = document.getElementById('themeToggle');
    const mainContent = document.querySelector('.main-content-wrapper');
    
    // Sidebar Toggle (Desktop)
    if (sidebarToggle) {
        sidebarToggle.addEventListener('click', function() {
            sidebar.classList.toggle('collapsed');
            
            // Update toggle icon
            const icon = this.querySelector('i');
            if (sidebar.classList.contains('collapsed')) {
                icon.className = 'fas fa-chevron-right';
            } else {
                icon.className = 'fas fa-chevron-left';
            }
            
            // Save preference to localStorage
            localStorage.setItem('sidebarCollapsed', sidebar.classList.contains('collapsed'));
        });
    }
    
    // Mobile Menu Toggle
    if (mobileMenuToggle && mobileMenuOverlay) {
        mobileMenuToggle.addEventListener('click', function() {
            toggleMobileMenu();
        });
        
        mobileMenuOverlay.addEventListener('click', function() {
            closeMobileMenu();
        });
    }
    
    function toggleMobileMenu() {
        sidebar.classList.toggle('mobile-open');
        mobileMenuOverlay.classList.toggle('active');
        document.body.classList.toggle('no-scroll');
    }
    
    function closeMobileMenu() {
        sidebar.classList.remove('mobile-open');
        mobileMenuOverlay.classList.remove('active');
        document.body.classList.remove('no-scroll');
    }
    
    // User Dropdown
    if (userDropdown && userDropdownMenu) {
        userDropdown.addEventListener('click', function(e) {
            e.stopPropagation();
            userDropdownMenu.classList.toggle('show');
            
            // Update dropdown arrow
            const arrow = this.querySelector('.dropdown-arrow');
            if (userDropdownMenu.classList.contains('show')) {
                arrow.style.transform = 'rotate(180deg)';
            } else {
                arrow.style.transform = 'rotate(0deg)';
            }
        });
        
        // Close dropdown when clicking outside
        document.addEventListener('click', function() {
            userDropdownMenu.classList.remove('show');
            if (userDropdown.querySelector('.dropdown-arrow')) {
                userDropdown.querySelector('.dropdown-arrow').style.transform = 'rotate(0deg)';
            }
        });
        
        // Prevent dropdown from closing when clicking inside
        userDropdownMenu.addEventListener('click', function(e) {
            e.stopPropagation();
        });
    }
    
    // Theme Toggle
    if (themeToggle) {
        themeToggle.addEventListener('click', function() {
            const currentTheme = document.body.getAttribute('data-theme');
            const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
            
            document.body.setAttribute('data-theme', newTheme);
            localStorage.setItem('theme', newTheme);
            
            // Update theme icon
            const icon = this.querySelector('i');
            if (newTheme === 'dark') {
                icon.className = 'fas fa-sun';
            } else {
                icon.className = 'fas fa-moon';
            }
        });
    }
    
    // Load saved preferences
    function loadSavedPreferences() {
        // Load sidebar state
        const sidebarCollapsed = localStorage.getItem('sidebarCollapsed') === 'true';
        if (sidebarCollapsed && window.innerWidth > 768) {
            sidebar.classList.add('collapsed');
            if (sidebarToggle) {
                const icon = sidebarToggle.querySelector('i');
                icon.className = 'fas fa-chevron-right';
            }
        }
        
        // Load theme
        const savedTheme = localStorage.getItem('theme') || 'light';
        document.body.setAttribute('data-theme', savedTheme);
        
        if (themeToggle) {
            const icon = themeToggle.querySelector('i');
            if (savedTheme === 'dark') {
                icon.className = 'fas fa-sun';
            } else {
                icon.className = 'fas fa-moon';
            }
        }
    }
    
    // Handle window resize
    function handleResize() {
        if (window.innerWidth > 768) {
            closeMobileMenu();
        }
    }
    
    // Initialize
    loadSavedPreferences();
    window.addEventListener('resize', handleResize);
    
    // Page transition animations
    function animatePageContent() {
        const content = document.querySelector('.content-wrapper');
        if (content) {
            content.style.opacity = '0';
            content.style.transform = 'translateY(20px)';
            
            setTimeout(() => {
                content.style.transition = 'opacity 0.3s ease, transform 0.3s ease';
                content.style.opacity = '1';
                content.style.transform = 'translateY(0)';
            }, 100);
        }
    }
    
    // Animate content on page load
    animatePageContent();
    
    // Handle navigation clicks for smooth transitions
    const navLinks = document.querySelectorAll('.nav-link');
    navLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            if (this.getAttribute('href') && !this.getAttribute('target')) {
                e.preventDefault();
                const href = this.getAttribute('href');
                
                // Fade out current content
                const content = document.querySelector('.content-wrapper');
                if (content) {
                    content.style.transition = 'opacity 0.2s ease';
                    content.style.opacity = '0';
                    
                    setTimeout(() => {
                        window.location.href = href;
                    }, 200);
                } else {
                    window.location.href = href;
                }
            }
        });
    });
    
    // Keyboard navigation support
    document.addEventListener('keydown', function(e) {
        // ESC key closes mobile menu and dropdowns
        if (e.key === 'Escape') {
            closeMobileMenu();
            if (userDropdownMenu) {
                userDropdownMenu.classList.remove('show');
                if (userDropdown.querySelector('.dropdown-arrow')) {
                    userDropdown.querySelector('.dropdown-arrow').style.transform = 'rotate(0deg)';
                }
            }
        }
    });
    
    // Accessibility: Focus management for mobile menu
    if (mobileMenuToggle) {
        mobileMenuToggle.addEventListener('keydown', function(e) {
            if (e.key === 'Enter' || e.key === ' ') {
                e.preventDefault();
                toggleMobileMenu();
            }
        });
    }
    
    // Add focus trap for mobile menu
    function trapFocus(element) {
        const focusableElements = element.querySelectorAll(
            'a[href], button, textarea, input[type="text"], input[type="email"], input[type="password"], input[type="search"], [tabindex]:not([tabindex="-1"])'
        );
        const firstFocusableElement = focusableElements[0];
        const lastFocusableElement = focusableElements[focusableElements.length - 1];
        
        element.addEventListener('keydown', function(e) {
            if (e.key === 'Tab') {
                if (e.shiftKey) {
                    if (document.activeElement === firstFocusableElement) {
                        lastFocusableElement.focus();
                        e.preventDefault();
                    }
                } else {
                    if (document.activeElement === lastFocusableElement) {
                        firstFocusableElement.focus();
                        e.preventDefault();
                    }
                }
            }
        });
    }
    
    // Apply focus trap to sidebar when mobile menu is open
    const observer = new MutationObserver(function(mutations) {
        mutations.forEach(function(mutation) {
            if (mutation.attributeName === 'class') {
                if (sidebar.classList.contains('mobile-open')) {
                    trapFocus(sidebar);
                }
            }
        });
    });
    
    if (sidebar) {
        observer.observe(sidebar, { attributes: true });
    }
});
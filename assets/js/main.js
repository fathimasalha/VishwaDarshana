/* =====================================================
   MAIN WEBSITE JAVASCRIPT
   File: assets/js/main.js
   ===================================================== */

// Global Variables
const SITE_URL = window.location.origin + '/vishwadarshana';


// DOM Ready
document.addEventListener('DOMContentLoaded', function() {
    // Initialize components
    initMobileMenu();
    initSmoothScroll();
    initFormHandlers();
    initSliders();
    initCounters();
    initLazyLoad();
});



// Mobile Menu
function initMobileMenu() {
    const menuBtn = document.querySelector('.menu-btn');
    const mobileMenu = document.getElementById('mobileMenu');
    const mobileMenuOverlay = document.getElementById('mobileMenuOverlay');
    const nav = document.querySelector('nav');
    
    if (menuBtn && mobileMenu) {
        menuBtn.addEventListener('click', function() {
            this.classList.toggle('active');
            mobileMenu.classList.toggle('active');
            mobileMenuOverlay.classList.toggle('active');
            document.body.style.overflow = mobileMenu.classList.contains('active') ? 'hidden' : '';
        });
        
        // Close menu when clicking overlay
        if (mobileMenuOverlay) {
            mobileMenuOverlay.addEventListener('click', function() {
                menuBtn.classList.remove('active');
                mobileMenu.classList.remove('active');
                this.classList.remove('active');
                document.body.style.overflow = '';
            });
        }
        
        // Close menu when clicking on menu links
        const mobileMenuLinks = mobileMenu.querySelectorAll('a');
        mobileMenuLinks.forEach(link => {
            link.addEventListener('click', function() {
                // Don't close menu if clicking on dropdown toggle
                if (this.classList.contains('dropdown-toggle')) {
                    return;
                }
                menuBtn.classList.remove('active');
                mobileMenu.classList.remove('active');
                mobileMenuOverlay.classList.remove('active');
                document.body.style.overflow = '';
            });
        });
        
        // Mobile dropdown functionality
        const mobileDropdowns = mobileMenu.querySelectorAll('.mobile-dropdown');
        mobileDropdowns.forEach(dropdown => {
            const toggle = dropdown.querySelector('.dropdown-toggle');
            if (toggle) {
                toggle.addEventListener('click', function(e) {
                    e.preventDefault();
                    dropdown.classList.toggle('active');
                    
                    // Rotate chevron icon
                    const icon = this.querySelector('i');
                    if (icon) {
                        icon.style.transform = dropdown.classList.contains('active') ? 'rotate(180deg)' : 'rotate(0deg)';
                    }
                });
            }
        });
    }
    
    // Navigation scroll
    let lastScroll = 0;
    window.addEventListener('scroll', () => {
        const nav = document.getElementById('nav');
        const currentScroll = window.pageYOffset;
        
        if (currentScroll > 100) {
            nav.classList.add('scrolled');
        } else {
            nav.classList.remove('scrolled');
        }
        
        lastScroll = currentScroll;
    });


     // Hero Carousel
     let currentCarouselSlide = 1;
     const carouselItems = document.querySelectorAll('.carousel-item');
     const carouselDots = document.querySelectorAll('.carousel-dot');

     function showCarouselSlide(n) {
         if (n > carouselItems.length) currentCarouselSlide = 1;
         if (n < 1) currentCarouselSlide = carouselItems.length;
         
         carouselItems.forEach(item => item.classList.remove('active'));
         carouselDots.forEach(dot => dot.classList.remove('active'));
         
         carouselItems[currentCarouselSlide - 1].classList.add('active');
         carouselDots[currentCarouselSlide - 1].classList.add('active');
     }

     function changeCarouselSlide(n) {
         showCarouselSlide(currentCarouselSlide = n);
     }

     // Auto-play carousel
     setInterval(() => {
         currentCarouselSlide++;
         showCarouselSlide(currentCarouselSlide);
     }, 5000);
}


// Gallery navigation
let galleryPosition = 0;
const gallery = document.getElementById('gallery');
const galleryItems = document.querySelectorAll('.gallery-item');
const galleryItemWidth = window.innerWidth < 768 ? 320 : window.innerWidth < 1200 ? 540 : 640;
const maxScroll = -(galleryItems.length - 1) * galleryItemWidth;

function updateGalleryPosition() {
    gallery.style.transform = `translateX(${galleryPosition}px)`;
}

function galleryNext() {
    if (galleryPosition > maxScroll) {
        galleryPosition -= galleryItemWidth;
        if (galleryPosition < maxScroll) galleryPosition = maxScroll;
        updateGalleryPosition();
    }
}

function galleryPrev() {
    if (galleryPosition < 0) {
        galleryPosition += galleryItemWidth;
        if (galleryPosition > 0) galleryPosition = 0;
        updateGalleryPosition();
    }
}

// Counter Animation
const counters = document.querySelectorAll('.stat-count');
const speed = 200;

const countUp = (counter) => {
    const target = +counter.getAttribute('data-count');
    const count = +counter.innerText;
    const increment = target / speed;

    if (count < target) {
        counter.innerText = Math.ceil(count + increment);
        setTimeout(() => countUp(counter), 10);
    } else {
        counter.innerText = target;
    }
};

// Intersection Observer for animations
const observerOptions = {
    threshold: 0.5,
    rootMargin: '0px 0px -100px 0px'
};

const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            if (entry.target.classList.contains('stat-count')) {
                countUp(entry.target);
                observer.unobserve(entry.target);
            }
            
            entry.target.style.opacity = '0';
            entry.target.style.transform = 'translateY(50px)';
            
            setTimeout(() => {
                entry.target.style.transition = 'all 1s cubic-bezier(0.25, 0.46, 0.45, 0.94)';
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
            }, 100);
        }
    });
}, observerOptions);

// Observe elements
document.querySelectorAll('.stat-count, .vm-card, .testimonial-card, .update-card, .feature-box').forEach(el => {
    observer.observe(el);
});

// Smooth scroll
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        e.preventDefault();
        const target = document.querySelector(this.getAttribute('href'));
        if (target) {
            const headerOffset = 80;
            const elementPosition = target.getBoundingClientRect().top;
            const offsetPosition = elementPosition + window.pageYOffset - headerOffset;

            window.scrollTo({
                top: offsetPosition,
                behavior: 'smooth'
            });
        }
    });
});

// Update gallery on window resize
let resizeTimer;
window.addEventListener('resize', () => {
    clearTimeout(resizeTimer);
    resizeTimer = setTimeout(() => {
        galleryPosition = 0;
        updateGalleryPosition();
    }, 250);
});

// Smooth Scroll
function initSmoothScroll() {
    const links = document.querySelectorAll('a[href^="#"]');
    
    links.forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            
            const targetId = this.getAttribute('href');
            const targetSection = document.querySelector(targetId);
            
            if (targetSection) {
                const headerOffset = 80;
                const elementPosition = targetSection.getBoundingClientRect().top;
                const offsetPosition = elementPosition + window.pageYOffset - headerOffset;
                
                window.scrollTo({
                    top: offsetPosition,
                    behavior: 'smooth'
                });
            }
        });
    });
}

// Form Handlers
function initFormHandlers() {
    // Contact Form
    const contactForm = document.getElementById('contactForm');
    if (contactForm) {
        contactForm.addEventListener('submit', handleContactForm);
    }
    
    // Newsletter Form
    const newsletterForm = document.getElementById('newsletterForm');
    if (newsletterForm) {
        newsletterForm.addEventListener('submit', handleNewsletterForm);
    }
}

// Handle Contact Form
function handleContactForm(e) {
    e.preventDefault();
    
    const form = e.target;
    const submitBtn = form.querySelector('button[type="submit"]');
    const originalText = submitBtn.textContent;
    
    // Show loading state
    submitBtn.disabled = true;
    submitBtn.innerHTML = '<span class="spinner"></span> Sending...';
    
    // Get form data
    const formData = new FormData(form);
    
    // Simulate API call (replace with actual AJAX)
    setTimeout(() => {
        // Show success message
        showMessage('success', 'Your message has been sent successfully!');
        
        // Reset form
        form.reset();
        
        // Reset button
        submitBtn.disabled = false;
        submitBtn.textContent = originalText;
    }, 2000);
}

// Handle Newsletter Form
function handleNewsletterForm(e) {
    e.preventDefault();
    
    const form = e.target;
    const email = form.querySelector('input[type="email"]').value;
    
    if (validateEmail(email)) {
        showMessage('success', 'Thank you for subscribing!');
        form.reset();
    } else {
        showMessage('error', 'Please enter a valid email address.');
    }
}

// Sliders
function initSliders() {
    // Testimonial Slider
    const testimonialSlider = document.querySelector('.testimonial-slider');
    if (testimonialSlider) {
        // Simple slider implementation
        let currentSlide = 0;
        const slides = testimonialSlider.querySelectorAll('.testimonial-card');
        
        if (slides.length > 1) {
            setInterval(() => {
                slides[currentSlide].style.display = 'none';
                currentSlide = (currentSlide + 1) % slides.length;
                slides[currentSlide].style.display = 'block';
            }, 5000);
        }
    }
}

// Number Counters
function initCounters() {
    const counters = document.querySelectorAll('.stat-box h3');
    
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const counter = entry.target;
                const target = parseInt(counter.innerText);
                let count = 0;
                
                const updateCount = () => {
                    const increment = target / 100;
                    if (count < target) {
                        count += increment;
                        counter.innerText = Math.ceil(count);
                        setTimeout(updateCount, 20);
                    } else {
                        counter.innerText = target;
                    }
                };
                
                updateCount();
                observer.unobserve(counter);
            }
        });
    });
    
    counters.forEach(counter => observer.observe(counter));
}

// Lazy Load Images
function initLazyLoad() {
    const images = document.querySelectorAll('img[data-src]');
    
    const imageObserver = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const img = entry.target;
                img.src = img.dataset.src;
                img.removeAttribute('data-src');
                imageObserver.unobserve(img);
            }
        });
    });
    
    images.forEach(img => imageObserver.observe(img));
}

// Utility Functions
function showMessage(type, message) {
    const messageDiv = document.createElement('div');
    messageDiv.className = `alert alert-${type}`;
    messageDiv.textContent = message;
    
    // Insert at top of page
    const container = document.querySelector('.container');
    container.insertBefore(messageDiv, container.firstChild);
    
    // Auto remove after 5 seconds
    setTimeout(() => {
        messageDiv.remove();
    }, 5000);
}

function validateEmail(email) {
    const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return re.test(email);
}

function formatDate(date) {
    const options = { year: 'numeric', month: 'long', day: 'numeric' };
    return new Date(date).toLocaleDateString('en-IN', options);
}


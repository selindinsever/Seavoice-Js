document.addEventListener('DOMContentLoaded', function() {
    initTimelineAnimations();
    initScrollAnimations();
});

function initTimelineAnimations() {
    const timelineDots = document.querySelectorAll('.timeline-dot');
    
    timelineDots.forEach((dot, index) => {
        dot.addEventListener('click', function() {
            timelineDots.forEach(d => d.classList.remove('active'));
            this.classList.add('active');
            
            const content = this.closest('.timeline-item').querySelector('.timeline-content');
            content.style.animation = 'none';
            setTimeout(() => {
                content.style.animation = 'pulse 0.6s ease';
            }, 10);
        });

        dot.addEventListener('mouseenter', function() {
            this.style.transform = 'translateX(-50%) scale(1.3)';
        });

        dot.addEventListener('mouseleave', function() {
            if (!this.classList.contains('active')) {
                this.style.transform = 'translateX(-50%) scale(1)';
            }
        });
    });

    const style = document.createElement('style');
    style.textContent = `
        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }
    `;
    document.head.appendChild(style);
}

function initScrollAnimations() {
    const items = document.querySelectorAll('.timeline-item');
    
    const observerOptions = {
        threshold: 0.3,
        rootMargin: '0px 0px -50px 0px'
    };

    const observer = new IntersectionObserver(function(entries) {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('reveal');
                observer.unobserve(entry.target);
            }
        });
    }, observerOptions);

    items.forEach(item => {
        observer.observe(item);
    });
}

document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function(e) {
        e.preventDefault();
        const target = document.querySelector(this.getAttribute('href'));
        if (target) {
            target.scrollIntoView({ behavior: 'smooth' });
        }
    });
});

window.addEventListener('scroll', function() {
    const scrollY = window.scrollY;
    const timelineItems = document.querySelectorAll('.timeline-item');
    
    timelineItems.forEach((item, index) => {
        const itemTop = item.offsetTop;
        const distance = itemTop - scrollY;
        
        if (distance > -500 && distance < window.innerHeight) {
            const opacity = Math.min(1, (distance + 300) / 500);
            item.style.opacity = opacity;
        }
    });
});

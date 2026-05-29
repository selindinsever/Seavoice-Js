document.addEventListener('DOMContentLoaded', function() {
    const aboutSection = document.querySelector('.about-section');
    const cards = document.querySelectorAll('.card');
    const statBoxes = document.querySelectorAll('.stat-box'); 

    const observerOptions = {
        threshold: 0.15, 
        rootMargin: "0px 0px -50px 0px" 
    };

    
    const aboutObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('visible');
                aboutObserver.unobserve(entry.target);
            }
        });
    }, observerOptions);

    if (aboutSection) {
        aboutObserver.observe(aboutSection);
    }

    statBoxes.forEach((box, index) => {
        const statObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    setTimeout(() => {
                        entry.target.classList.add('visible');
                    }, index * 100); 
                    statObserver.unobserve(entry.target);
                }
            });
        }, observerOptions);
        statObserver.observe(box);
    });

    cards.forEach((card, index) => {
        const cardObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    setTimeout(() => {
                        entry.target.classList.add('visible');
                    }, index * 150); 
                    cardObserver.unobserve(entry.target);
                }
            });
        }, observerOptions);
        cardObserver.observe(card);
    });
});
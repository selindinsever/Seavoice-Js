document.addEventListener('DOMContentLoaded', function() {
    const contactForm = document.getElementById('contactForm');
    const contactModal = document.getElementById('contactModal');
    const openContactBtn = document.getElementById('openContactBtn');
    const closeContactBtn = document.querySelector('.contact-modal .close-btn');
    const contactModalForm = document.getElementById('contactModalForm');

    if (openContactBtn) {
        openContactBtn.addEventListener('click', () => {
            contactModal.classList.add('show');
        });
    }

    
    if (closeContactBtn) {
        closeContactBtn.addEventListener('click', () => {
            contactModal.classList.remove('show');
        });
    }

    if (contactModal) {
        contactModal.addEventListener('click', (e) => {
            if (e.target === contactModal) {
                contactModal.classList.remove('show');
            }
        });
    }

    if (contactForm) {
        contactForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            
            const formData = new FormData(contactForm);
            
            try {
                const response = await fetch('/gonder', {
                    method: 'POST',
                    body: formData
                });

                if (response.ok) {
                    alert('Mesajınız başarıyla gönderildi!');
                    contactForm.reset();
                } else {
                    alert('Bir hata oluştu. Lütfen tekrar deneyiniz.');
                }
            } catch (error) {
                console.error('Hata:', error);
                alert('Bir hata oluştu. Lütfen tekrar deneyiniz.');
            }
        });
    }

    if (contactModalForm) {
        contactModalForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            
            const formData = new FormData(contactModalForm);
            
            try {
                const response = await fetch('/gonder', {
                    method: 'POST',
                    body: formData
                });

                if (response.ok) {
                    alert('Mesajınız başarıyla gönderildi!');
                    contactModalForm.reset();
                    if (contactModal) {
                        contactModal.classList.remove('show');
                    }
                } else {
                    alert('Bir hata oluştu. Lütfen tekrar deneyiniz.');
                }
            } catch (error) {
                console.error('Hata:', error);
                alert('Bir hata oluştu. Lütfen tekrar deneyiniz.');
            }
        });
    }
});

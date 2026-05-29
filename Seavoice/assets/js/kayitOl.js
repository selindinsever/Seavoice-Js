document.addEventListener('DOMContentLoaded', () => {
    // 1. Baloncuk Animasyonu
    const container = document.getElementById('bubbles');
    const bubbleCount = 45;
    if (container) {
        for (let i = 0; i < bubbleCount; i++) {
            const bubble = document.createElement('div');
            bubble.className = 'bubble';
            const size = Math.random() * 40 + 15;
            const duration = Math.random() * 10 + 10;
            const delay = Math.random() * -20;
            let posX = Math.random() < 0.5 ? Math.random() * 15 : Math.random() * 15 + 85;
            bubble.style.width = `${size}px`;
            bubble.style.height = `${size}px`;
            bubble.style.left = `${posX}%`;
            bubble.style.animationDuration = `${duration}s`;
            bubble.style.animationDelay = `${delay}s`;
            container.appendChild(bubble);
        }
    }
});

// 2. Yunus Etkileşim Fonksiyonları
function toggleYunusMessage() {
    document.getElementById('yunusMessage').classList.toggle('active');
}

function closeYunusMessage() {
    document.getElementById('yunusMessage').classList.remove('active');
}

// Otomatik karşılama (opsiyonel)
setTimeout(() => {
    const msg = document.getElementById('yunusMessage');
    if(msg) msg.classList.add('active');
}, 1000);
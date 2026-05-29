document.addEventListener('DOMContentLoaded', () => {
    const container = document.getElementById('bubbles');
    if (container) {
        for (let i = 0; i < 45; i++) { // 45 balon
            const bubble = document.createElement('div');
            bubble.className = 'bubble';
            const size = Math.random() * 40 + 15;
            let posX = Math.random() < 0.5 ? Math.random() * 15 : Math.random() * 15 + 85;
            
            bubble.style.width = `${size}px`;
            bubble.style.height = `${size}px`;
            bubble.style.left = `${posX}%`;
            bubble.style.animationDuration = `${Math.random() * 10 + 10}s`;
            bubble.style.animationDelay = `${Math.random() * -20}s`;
            container.appendChild(bubble);
        }
    }

    
    const yunusInfo = document.querySelector('.yunusInfo');
    const yunusMessage = document.getElementById('yunusMessage');

    if (yunusInfo && yunusMessage) {
        
        setTimeout(() => {
            yunusMessage.classList.add('active');
        }, 1000);

        setTimeout(() => {
            yunusMessage.classList.remove('active');
        }, 4000);

        yunusInfo.addEventListener('click', (e) => {
            e.stopPropagation();
            yunusMessage.classList.toggle('active');
        });

        document.addEventListener('click', (e) => {
            if (!yunusMessage.contains(e.target) && e.target !== yunusInfo) {
                yunusMessage.classList.remove('active');
            }
        });
    }
});

function closeYunusMessage() {
    document.getElementById('yunusMessage').classList.remove('active');
}
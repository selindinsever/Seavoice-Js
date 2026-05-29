//Harita Başlatma (İzmir Odaklı)
var map = L.map('map').setView([38.4237, 27.1428], 10);
L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '© OpenStreetMap'
}).addTo(map);

//Markerları tutacak ana dizi
let communities = [];

document.addEventListener('DOMContentLoaded', () => {
    if (typeof phpData !== 'undefined') {
        communities = phpData.map(t => {
            const lat = parseFloat(t.Latitude);
            const lng = parseFloat(t.Longitude);
            
            // Google Yol Tarifi URL
            const googleMapsUrl = `https://www.google.com/maps/dir/?api=1&destination=${lat},${lng}&travelmode=driving`;

            return {
                name: t.ToplulukAdi,
                marker: L.marker([lat, lng])
                         .addTo(map)
                         .bindPopup(`
                            <div style="text-align:center; min-width:150px;">
                                <h6 style="margin:0 0 8px 0; color:#0284c7;">${t.ToplulukAdi}</h6>
                                <a href="${googleMapsUrl}" target="_blank" 
                                   style="display:block; padding:8px 12px; background:#0ea5e9; color:white; 
                                          text-decoration:none; border-radius:8px; font-size:12px; font-weight:bold;">
                                   <i class="bi bi-map"></i> Yol Tarifi Al
                                </a>
                            </div>
                         `)
            };
        });
    }

    //  ARAMA VE FİLTRELEME
    const searchInput = document.getElementById('searchInput');
    const cards = document.querySelectorAll('.community-card');

    if (searchInput) {
        searchInput.addEventListener('input', (e) => {
            const searchTerm = e.target.value.toLowerCase().trim();

            cards.forEach(card => {
                const title = card.querySelector('.card-title').textContent.toLowerCase();
                card.closest('.col-md-4').style.display = title.includes(searchTerm) ? 'block' : 'none';
            });

            communities.forEach(community => {
                const nameLower = community.name.toLowerCase();
                if (nameLower.includes(searchTerm)) {
                    if (!map.hasLayer(community.marker)) community.marker.addTo(map);
                } else {
                    if (map.hasLayer(community.marker)) map.removeLayer(community.marker);
                }
            });
        });
    }

    document.querySelectorAll('.btn-members').forEach(button => {
        button.addEventListener('click', function() {
            const toplulukID = this.getAttribute('data-topluluk-id');
            const modalBody = document.getElementById('membersContent');
            
            modalBody.innerHTML = "Üyeler yükleniyor...";

            fetch(`../includes/get_members.php?id=${toplulukID}`)
                .then(response => response.text())
                .then(data => {
                    modalBody.innerHTML = data;
                })
                .catch(() => {
                    modalBody.innerHTML = "Üyeler yüklenirken bir hata oluştu.";
                });
        });
    });
});
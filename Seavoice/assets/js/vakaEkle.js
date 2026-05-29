// Vaka Ekleme Sayfası Etkileşimleri
document.addEventListener('DOMContentLoaded', function () {
    initLeafletMap();
    initUploadArea();
});

// HARİTA VE KOORDİNAT YÖNETİMİ
function initLeafletMap() {
    const mapElement = document.getElementById('map');
    if (!mapElement || typeof L === 'undefined') return;

    const map = L.map(mapElement, {
        scrollWheelZoom: true,
        zoomControl: true
    }).setView([38.4237, 27.1428], 10); // İzmir Odaklı

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; OpenStreetMap contributors',
        maxZoom: 18
    }).addTo(map);

    let marker;

    // HARİTAYA TIKLAMA
    map.on('click', function (event) {
        const { lat, lng } = event.latlng;
        if (marker) {
            marker.setLatLng(event.latlng);
        } else {
            marker = L.marker(event.latlng).addTo(map);
        }

        document.getElementById('lat').value = lat.toFixed(6);
        document.getElementById('lng').value = lng.toFixed(6);

        getWeather(lat, lng);
    });

    getWeather(38.4237, 27.1428);
}

async function getWeather(lat, lon) {
    try {
        const response = await fetch(
            `https://api.open-meteo.com/v1/forecast?latitude=${lat}&longitude=${lon}&daily=weathercode,temperature_2m_max&timezone=auto`
        );
        const data = await response.json();
        const weatherContainer = document.getElementById('weatherCards');
        if (!weatherContainer) return;

        weatherContainer.innerHTML = "";

        const weatherCodes = {
            0: "Güneşli", 1: "Az Bulutlu", 2: "Parçalı Bulutlu", 3: "Bulutlu",
            45: "Sisli", 48: "Kırağı Sis", 51: "Hafif Çiseleme", 53: "Çiseleme",
            55: "Yoğun Çiseleme", 61: "Hafif Yağmur", 63: "Yağmurlu", 65: "Şiddetli Yağmur",
            71: "Kar", 80: "Sağanak", 95: "Fırtına"
        };

        for (let i = 0; i < 4; i++) {
            const date = new Date(data.daily.time[i]);
            const dayName = date.toLocaleDateString("tr-TR", { weekday: "long" });
            const temp = Math.round(data.daily.temperature_2m_max[i]);
            const code = data.daily.weathercode[i];
            const desc = weatherCodes[code] || "Bilinmiyor";

            weatherContainer.innerHTML += `
                <div class="weather-card">
                    <h4>${dayName}</h4>
                    <div class="weather-icon">${getWeatherEmoji(code)}</div>
                    <p>${temp}°C</p>
                    <span>${desc}</span>
                </div>
            `;
        }
    } catch (error) {
        console.log("Hava durumu alınamadı:", error);
    }
}

function getWeatherEmoji(code) {
    if (code === 0) return "☀️";
    if (code <= 3) return "⛅";
    if (code <= 55) return "🌫️";
    if (code <= 65) return "🌧️";
    if (code <= 75) return "❄️";
    if (code <= 82) return "🌦️";
    return "⛈️";
}

function initUploadArea() {
    const dropArea = document.getElementById('dropArea');
    const fileInput = document.getElementById('photo');
    const fileName = document.getElementById('fileName');

    if (!dropArea || !fileInput || !fileName) return;

    ['dragenter', 'dragover'].forEach(eventName => {
        dropArea.addEventListener(eventName, (e) => { e.preventDefault(); dropArea.classList.add('active'); });
    });

    ['dragleave', 'drop'].forEach(eventName => {
        dropArea.addEventListener(eventName, (e) => { e.preventDefault(); dropArea.classList.remove('active'); });
    });

    dropArea.addEventListener('drop', (e) => {
        const files = e.dataTransfer.files;
        if (files.length > 0) {
            fileInput.files = files;
            fileName.textContent = files[0].name;
        }
    });

    fileInput.addEventListener('change', () => {
        if (fileInput.files.length > 0) {
            fileName.textContent = fileInput.files[0].name;
        }
    });
}
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Vaka Ekle | SeaVoice</title>

    <link rel="stylesheet" href="../assets/css/vakaEkle.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css">
</head>

<body>

<?php include '../includes/header.php'; ?>

<div class="container">

    <form id="uploadForm" action="../includes/kaydet.php" method="POST" enctype="multipart/form-data">

        <input type="text" id="lat" name="latitude" hidden required>
        <input type="text" id="lng" name="longitude" hidden required>

        <div class="content-wrapper">

            <!-- HARİTA -->
            <div class="map-section">

                <div class="map-label">
                    Konum Seçin
                </div>

                <div id="map"></div>

            </div>

            <!-- SAĞ TARAF -->
            <div class="right-side">

                <!-- FORM -->
                <div class="form-section">

                    <div class="form-fields">

                        <div class="field-group">

                            <div class="upload-label">
                                Topluluk Adı
                            </div>

                            <input
                                type="text"
                                id="communityName"
                                name="community_name"
                                placeholder="Topluluk adını giriniz..."
                                required
                                class="text-input"
                            >

                        </div>

                        <div class="field-group">

                            <div class="upload-label">
                                Temizleme Zamanı
                            </div>

                            <input
                                type="datetime-local"
                                id="cleaningTime"
                                name="cleaning_time"
                                required
                                class="text-input"
                            >

                        </div>

                        <div class="field-group">

                            <div class="upload-label">
                                Vaka Görselini Yükleyin
                            </div>

                            <label for="photo">

                                <div class="upload-box" id="dropArea">

                                    <img
                                        src="https://cdn-icons-png.flaticon.com/512/2921/2921222.png"
                                        alt="Upload"
                                    >

                                    <p>
                                        Fotoğrafı sürükleyin veya üzerine
                                        tıklayıp dosya gezgininden seçiniz
                                    </p>

                                    <div
                                        class="file-name"
                                        id="fileName"
                                        style="margin-top:10px;
                                               color:#78b6ff;
                                               font-weight:bold;">
                                    </div>

                                </div>

                            </label>

                            <input
                                type="file"
                                id="photo"
                                name="photo"
                                accept="image/*"
                                required
                            >

                        </div>

                    </div>

                    <button id="submitBtn" type="submit">
                        Gönder
                    </button>

                </div>

                <!-- HAVA DURUMU -->
                <div class="weather-section">

                    <div class="weather-title">
                        4 Günlük Hava Durumu
                    </div>

                    <div id="weatherCards" class="weather-cards">

                        <!-- JS BURAYI DOLDURACAK -->

                        <div class="weather-card">

                            <h4>Pazartesi</h4>

                            <div class="weather-icon">
                                ☀️
                            </div>

                            <p>24°C</p>

                            <span>Güneşli</span>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </form>

</div>

<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
<script src="../assets/js/vakaEkle.js"></script>

</body>
</html>
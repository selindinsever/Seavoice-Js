<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>İletişim | Seavoice</title>
    <link rel="stylesheet" href="../assets/css/iletisim.css">
</head>
<body>
<?php include '../includes/header.php'; ?>

    <main class="page-content">
        <div class="contact-form-container">
            <h1>Bize Ulaşın</h1>
            <p>Herhangi bir sorunuz veya öneriniz varsa, lütfen aşağıdaki formu doldurun.</p>
            
            <?php if (isset($_GET['durum']) && $_GET['durum'] == 'gonderildi'): ?>
                <div id="feedback-box" style="background: #d1fae5; color: #065f46; padding: 15px; border-radius: 10px; margin-bottom: 20px; text-align: center; font-weight: 600;">
                    Mesajınız başarıyla iletildi! Ekibimiz en kısa sürede dönüş yapacaktır.
                </div>
                <script>setTimeout(() => { document.getElementById('feedback-box').style.display = 'none'; }, 4000);</script>
            <?php endif; ?>

            <form action="../includes/islem.php" method="POST">
                <input type="hidden" name="islem" value="mesaj_gonder">
                
                <div class="form-group">
                    <label for="subject">Konu Başlığı:</label>
                    <input type="text" id="subject" name="konu" maxlength="100" required>
                </div>

                <div class="form-group">
                    <label for="message">Mesajınız:</label>
                    <textarea id="message" name="mesaj" rows="6" required></textarea>
                </div>

                <button type="submit" class="submit-btn">Gönder</button>
            </form>
        </div>
    </main>

    <?php include '../includes/footer.php'; ?>
    <script src="../assets/js/iletisim.js"></script>
</body>
</html>
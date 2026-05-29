<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kayıt Ol | SeaVoice</title>
    <link rel="stylesheet" href="../assets/css/kayitOl.css">
</head>
<body>

<div class="wrapper">
    <div id="bubbles"></div>

    <div class="form-box">
        <img src="../assets/images/logo4.png" alt="Logo" class="logo">
        <p class="subtitle">Platformumuza Katılın</p>

        <?php if(isset($_GET['hata'])): ?>
            <div style="background: rgba(255, 255, 255, 0.7); border-left: 4px solid #f59e0b; padding: 10px; margin-bottom: 15px; border-radius: 8px; font-size: 13px; text-align: center; color: #92400e;">
                <?php 
                    if($_GET['hata'] == 'zaten_kayitli') echo "Bu e-posta adresi zaten kayıtlı! <br> Lütfen <a href='girisYap.php' style='color:#0284c7; font-weight:bold;'>Giriş Yap</a>.";
                    else echo "Bir hata oluştu, lütfen tekrar deneyin.";
                ?>
            </div>
        <?php endif; ?>

        <form action="../includes/islem.php" method="POST">
            <input type="hidden" name="islem" value="kayitol">

            <div class="row-2">
                <div class="form-group">
                    <label>Ad</label>
                    <input type="text" name="ad" placeholder="Ad" required />
                </div>
                <div class="form-group">
                    <label>Soyad</label>
                    <input type="text" name="soyad" placeholder="Soyad" required />
                </div>
            </div>
            
            <div class="form-group">
                <label>E-posta</label>
                <input type="email" name="email" placeholder="ornek@mail.com" required />
            </div>
            
            <div class="form-group">
                <label>Telefon</label>
                <input type="tel" name="telefon" placeholder="05XX XXX XX XX" />
            </div>
            
            <div class="form-group">
                <label>Şifre</label>
                <input type="password" name="sifre" placeholder="••••••••" required />
            </div>
            
            <button type="submit" class="submit-btn">Kayıt Ol</button>
        </form>
        
        <div class="register-link">
            Zaten hesabınız var mı? <a href="girisYap.php">Giriş Yap</a>
        </div>
    </div>

    <img src="../assets/images/yunusInfo.png" alt="yunusInfo" class="yunusInfo yunusInfo1" onclick="toggleYunusMessage()">

    <div class="yunus-message" id="yunusMessage">
        <p>Merhaba! Ben Seavoice Rehberiyim :)</p>
        <p>"Kıyılarımızı birlikte korumaya hazır mısın?"</p>
        <button class="close-btn" onclick="closeYunusMessage()">×</button>
    </div>
</div>

<script src="../assets/js/kayitOl.js"></script>
</body>
</html>
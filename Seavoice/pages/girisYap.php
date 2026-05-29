<?php if (isset($_GET['hata'])): ?>
    <div class="hata-mesaji" style="color: red; text-align: center; margin-bottom: 10px;">
        E-posta veya şifre hatalı!
    </div>
<?php endif; ?>


<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Giriş Yap | SeaVoice</title>
    <link rel="stylesheet" href="../assets/css/girisYap.css">
</head>
<body>

<div class="wrapper">
    <div id="bubbles"></div>

    <div class="form-box">
        <img src="../assets/images/logo4.png" alt="Logo" class="logo">
        <p class="subtitle">Platformumuza yeniden katıl</p>

        <?php if(isset($_GET['hata'])): ?>
            <p style="color: #ef4444; text-align: center; font-size: 13px; margin-bottom: 1rem;">
                E-posta veya şifre hatalı!
            </p>
        <?php endif; ?>

        <form action="../includes/islem.php" method="POST">
    <input type="hidden" name="islem" value="girisYap">

    <div class="form-group">
        <label>E-posta</label>
        <input type="email" name="email" placeholder="ornek@mail.com" required />
    </div>

    <div class="form-group">
        <label>Şifre</label>
        <input type="password" name="sifre" placeholder="••••••••" required />
    </div>
    
    <button type="submit" class="submit-btn">Giriş Yap</button>
</form>
        <p class="register-link">Hesabın yok mu? <a href="kayitOl.php">Kayıt ol</a></p>
    </div>

    <img src="../assets/images/yunusInfo.png" alt="yunusInfo" class="yunusInfo">
    <div class="yunus-message" id="yunusMessage">
        <p>Merhaba! Ben Seavoice Rehberiyim :)</p>
        <p>"Kıyılarımızı birlikte korumaya hazır mısın? Ben ve ekibim, kıyı bölgelerimizi atıklardan temizlemek için buradayız."</p>
        <button class="close-btn" onclick="closeYunusMessage()">×</button>
    </div>
</div>

<script src="../assets/js/girisYap.js"></script>
</body>
</html>
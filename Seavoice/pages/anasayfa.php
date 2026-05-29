<?php
session_start();
require_once '../includes/db.php';

// Veritabanı sorgularını, senin ekran görüntündeki tablo isimlerine göre düzenledim
try {
    // Topluluklar tablosundan vaka sayısını çekiyoruz
    $vakaSorgu = $conn->query("SELECT COUNT(*) FROM topluluklar");
    $vakaSayisi = $vakaSorgu ? $vakaSorgu->fetchColumn() : 0;

    // Kullanıcılar tablosundan üye sayısını çekiyoruz
    $gonulluSorgu = $conn->query("SELECT COUNT(*) FROM kullanicilar");
    $gonulluSayisi = $gonulluSorgu ? $gonulluSorgu->fetchColumn() : 0;
} catch (PDOException $e) {
    $vakaSayisi = 0;
    $gonulluSayisi = 0;
}
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Anasayfa | Seavoice</title>
    <link rel="stylesheet" href="../assets/css/anasayfa.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
</head>
<body>
    <?php include '../includes/header.php'; ?>

    <img src="../assets/images/yunusInfo.png" alt="yunusInfo" class="yunusInfo yunusInfo1">

    <div class="yunus-message" id="yunusMessage">
        <p class="yunus-title">Aramıza Hoş Geldiniz! Ben Seavoice Rehberiyim :)</p>
        <p class="yunus-text">Kıyılarımızı daha mavi ve temiz tutmak için bugün harika bir gün. Çevrende bir kirlilik mi fark ettin? Hemen haritaya bir vaka ekleyerek veya bir topluluğa katılarak fark yaratmaya başlayabilirsin!</p>
        <button onclick="closeYunusMessage()" class="btn-close-yunus">×</button>
    </div>

    <main class="page-content">
        <div class="about-section">
            <h1>Biz Kimiz?</h1>
            <p class="sub-slogan">Kıyılarımızın Sesi, Toplumun Gücü</p>
            <p class="about-text">Kıyı bölgelerindeki kirlilik vakalarının dağınık ve sınırlı şekilde takip edilmesi sorununa dijital bir çözüm sunmak amacıyla yola çıktık. Seavoice olarak, kullanıcılarımızın karşılaştıkları kirlilik vakalarını konum ve görsel kanıtlarla sisteme ekleyebildiği, bu veriler ışığında temizlik topluluklarının organize edilebildiği bir platform sunuyoruz. Sahil şeridindeki kirliliği sadece raporlamakla kalmıyor, bu sorunların görünürlüğünü artırarak topluluk temelli aksiyonlar için bir köprü görevi görüyoruz.</p>
            
            <div class="cta-container">
                <a href="vakaEkle.php" class="vaka-banner-btn">
                    <span class="banner-hashtag">#HareketeGeç</span>
                    <div class="banner-main-title">
                        Hemen Vaka Bildir
                    </div>
                    <p class="banner-subtext">Kıyılarımızı korumak ve çevrene farkındalık sağlamak için haritaya anlık bildirim bırak.</p>
                </a>
            </div>
            <p class="banner-bottom-note">Hemen bildirim yaparak doğayı korumaya başla!</p>
        </div>
        
        <section class="live-stats">
            <div class="stat-box">
                <i class="bi bi-geo-alt-fill"></i>
                <div class="stat-info">
                    <span class="stat-num"><?php echo (int)$vakaSayisi; ?></span>
                    <span class="stat-txt">Raporlanan Vaka</span>
                </div>
            </div>
            <div class="stat-box">
                <i class="bi bi-people-fill"></i>
                <div class="stat-info">
                    <span class="stat-num"><?php echo (int)$gonulluSayisi; ?></span>
                    <span class="stat-txt">Aktif Gönüllü</span>
                </div>
            </div>
        </section>
        
        <section class="about-cards">
            <div class="card">
                <span class="emoji"><img src="../assets/images/location.png" alt="world" /></span>
                <h3>Anlık Takip Haberdar Oluyoruz</h3>
                <p>Kıyı bölgelerindeki vakaları girilen konumlar sayesinde mapte görünür hale getiriyoruz.</p>
            </div>
                
            <div class="card">
                <span class="emoji"><img src="../assets/images/team.png" alt="team" /></span>
                <h3>Topluluk Oluşturuyoruz</h3>
                <p>Gönüllü ekiplerle temizlik ve farkındalık için organize ederek harekete geçiyoruz.</p>
            </div>
                    
            <div class="card">
                <span class="emoji"><img src="../assets/images/heart.png" alt="heart" /></span>
                <h3>Geleceğe Sahip Çıkıyoruz</h3>
                <p>Verilerle sürdürülebilirlik çalışmalarına destek sağlıyoruz.</p>
            </div>
        </section>
    </main> 

    <script src="../assets/js/anasayfa.js"></script>
    <script>
        const yunusInfo = document.querySelector('.yunusInfo');
        const yunusMessage = document.getElementById('yunusMessage');

        document.addEventListener('DOMContentLoaded', () => {
            if (yunusMessage) {
                setTimeout(() => {
                    yunusMessage.classList.add('active');
                    setTimeout(() => {
                        if(yunusMessage.classList.contains('active')) {
                            yunusMessage.classList.remove('active');
                        }
                    }, 3000);
                }, 500);
            }
        });

        if (yunusInfo && yunusMessage) {
            yunusInfo.addEventListener('click', () => {
                yunusMessage.classList.toggle('active');
            });
        }

        function closeYunusMessage() {
            if (yunusMessage) {
                yunusMessage.classList.remove('active');
            }
        }
    </script>
</body>
</html>
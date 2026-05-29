<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once __DIR__ . '/db.php'; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // 1. KAYIT OLMA İŞLEMİ
    if (isset($_POST['islem']) && $_POST['islem'] == 'kayitol') {
        try {
            $stmt = $conn->prepare("INSERT INTO kullanicilar (Ad, Soyad, Email, Telefon, Sifre) VALUES (?, ?, ?, ?, ?)");
            $stmt->execute([$_POST['ad'], $_POST['soyad'], $_POST['email'], $_POST['telefon'], $_POST['sifre']]);
            
            header("Location: ../pages/girisYap.php?kayit=basarili");
            exit();
        } catch (PDOException $e) {
            // E-posta zaten kayıtlıysa hata kodu 23000 döner
            if ($e->getCode() == 23000) {
                header("Location: ../pages/kayitOl.php?hata=zaten_kayitli");
            } else {
                // Burada da kayit.php yerine kayitOl.php yazmalısın
                header("Location: ../pages/kayitOl.php?hata=bilinmeyen");
            }
            exit();
        }
    }

    // 2. GİRİŞ YAPMA İŞLEMİ
    elseif (isset($_POST['islem']) && $_POST['islem'] == 'girisYap') {
        $email = trim($_POST['email']);
        $sifre = trim($_POST['sifre']);

        // Admin kontrolü
        $stmt_admin = $conn->prepare("SELECT * FROM admin WHERE Admin = ?");
        $stmt_admin->execute([$email]);
        $admin = $stmt_admin->fetch(PDO::FETCH_ASSOC);
        
        if ($admin && trim($admin['AdminSifre']) === $sifre) {
            $_SESSION['admin_id'] = $admin['ID'];
            header("Location: ../admin/index.php");
            exit();
        }

        // Kullanıcı kontrolü
        $stmt_kullanici = $conn->prepare("SELECT * FROM kullanicilar WHERE Email = ?");
        $stmt_kullanici->execute([$email]);
        $kullanici = $stmt_kullanici->fetch(PDO::FETCH_ASSOC);
        
        if ($kullanici && trim($kullanici['Sifre']) === $sifre) {
            $_SESSION['user_id'] = $kullanici['ID'];
            header("Location: ../pages/anasayfa.php");
            exit();
        } else {
            header("Location: ../pages/girisYap.php?hata=1");
            exit();
        }
    }

    // 3. İLETİŞİM MESAJI GÖNDERME
    elseif (isset($_POST['islem']) && $_POST['islem'] == 'mesaj_gonder') {
        if (isset($_SESSION['user_id'])) {
            $stmt = $conn->prepare("INSERT INTO iletisim (KullaniciID, Konu, MesajMetni, isProcessed) VALUES (?, ?, ?, 0)");
            $stmt->execute([$_SESSION['user_id'], $_POST['konu'], $_POST['mesaj']]);
            header("Location: ../pages/iletisim.php?durum=gonderildi");
            exit();
        }
    }

    // 4. MESAJI İŞLENMİŞ OLARAK İŞARETLE
    elseif (isset($_POST['islem']) && $_POST['islem'] == 'mesaj_islenmis') {
        if (!empty($_POST['id'])) {
            $conn->prepare("UPDATE iletisim SET isProcessed = 1 WHERE ID = ?")->execute([$_POST['id']]);
            
            if (!empty($_POST['email'])) {
                @mail($_POST['email'], "SeaVoice Destek Talebiniz", "Talebiniz işleme alınmıştır.", "From: destek@seavoice.com");
            }
        }
        header("Location: ../admin/iletisim.php");
        exit();
    }
}
?>
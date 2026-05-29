<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
require_once 'db.php'; 

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SESSION['user_id'])) {
    
    // 1. Klasör ve Dosya Hazırlığı
    $uploadDir = '../uploads/';
    if (!file_exists($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    $fileName = time() . '_' . basename($_FILES["photo"]["name"]);
    $targetFilePath = $uploadDir . $fileName;
    
    // 2. Resmi Yükle
    if (move_uploaded_file($_FILES["photo"]["tmp_name"], $targetFilePath)) {
        
        // 3. Topluluğu Veritabanına Kaydet
        $sql = "INSERT INTO Topluluklar (ToplulukAdi, Latitude, Longitude, TemizlikZamani, FotoYol, OlusturanKisiID) 
                VALUES (?, ?, ?, ?, ?, ?)";
        
        $stmt = $conn->prepare($sql);
        $stmt->execute([
            $_POST['community_name'],
            $_POST['latitude'],
            $_POST['longitude'],
            $_POST['cleaning_time'],
            $fileName,
            $_SESSION['user_id']
        ]);

        // 4. Kurucuyu Otomatik Olarak Üye Listesine Ekle
        $lastId = $conn->lastInsertId(); 
        $insertUye = $conn->prepare("INSERT INTO ToplulukUyeleri (ToplulukID, KullaniciID) VALUES (?, ?)");
        $insertUye->execute([$lastId, $_SESSION['user_id']]);

        // 5. Başarılı Yönlendirme
        header("Location: ../pages/topluluklar.php?durum=basarili");
        exit();
        
    } else {
        echo "Resim yüklenirken bir hata oluştu.";
    }
} else {
    // Yetkisiz erişim veya hatalı metod
    header("Location: ../pages/girisYap.php");
    exit();
}
?>
<?php
session_start();
require_once 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SESSION['user_id'])) {
    $userID = $_SESSION['user_id'];
    $toplulukID = $_POST['topluluk_id'];

    // 1. Zaten üye mi kontrolü?
    $check = $conn->prepare("SELECT * FROM ToplulukUyeleri WHERE ToplulukID = ? AND KullaniciID = ?");
    $check->execute([$toplulukID, $userID]);

    if ($check->rowCount() > 0) {
        // Zaten üye ise
        header("Location: ../pages/topluluklar.php?hata=zaten_uye");
    } else {
        // Üye değilse ekle
        $insert = $conn->prepare("INSERT INTO ToplulukUyeleri (ToplulukID, KullaniciID) VALUES (?, ?)");
        $insert->execute([$toplulukID, $userID]);
        header("Location: ../pages/topluluklar.php?durum=katildi");
    }
}
exit();
?>
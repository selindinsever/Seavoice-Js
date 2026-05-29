<?php
$host = "127.0.0.1"; 
$port = "3307";      
$db   = "seavoice";
$user = "root";
$pass = "Selyn2035eko."; 
try {
    
    $conn = new PDO("mysql:host=$host;port=$port;dbname=$db;charset=utf8", $user, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Bağlantı hatası: " . $e->getMessage());
}
?>
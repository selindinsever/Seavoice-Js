<?php
session_start();
require_once '../includes/db.php';

if (!isset($_SESSION['admin_id'])) { header("Location: ../pages/girisYap.php"); exit(); }

// Veritabanından verileri çekiyoruz
$toplamTopluluk = $conn->query("SELECT COUNT(*) FROM Topluluklar")->fetchColumn();
$toplamUye = $conn->query("SELECT COUNT(*) FROM toplulukuyeleri")->fetchColumn();
$toplamKullanici = $conn->query("SELECT COUNT(*) FROM kullanicilar")->fetchColumn();

include 'adminheader.php';
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>SeaVoice Admin | Dashboard</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        body { 
            
            background-attachment: fixed;
            min-height: 100vh;
            font-family: 'Segoe UI', sans-serif;
        }

        .dashboard-container { padding: 40px; }

        
        .stat-card { 
            background: rgba(255, 255, 255, 0.7); 
            backdrop-filter: blur(20px); 
            border-radius: 25px; 
            padding: 35px;
            box-shadow: 0 10px 30px rgba(0, 70, 150, 0.1);
            text-align: center;
            border: 1px solid rgba(255, 255, 255, 0.8);
            transition: transform 0.3s ease;
        }
        
        .stat-card:hover { transform: translateY(-5px); }

        .stat-card h3 { color: #4a5568; font-size: 0.95rem; font-weight: 600; text-transform: uppercase; letter-spacing: 1px; }
        .stat-card p { font-size: 3rem; font-weight: 800; color: #2b6cb0; margin-top: 10px; }

        h2 { color: #1a365d; font-weight: 800; }
        h4 { color: #2d3748; font-weight: 600; margin-top: 50px; }

        .btn-primary { background: #78b6ff; border: none; border-radius: 12px; padding: 10px 25px; transition: 0.3s; }
        .btn-primary:hover { background: #5aa1f7; }
        .btn-outline-primary { border: 2px solid #78b6ff; color: #78b6ff; border-radius: 12px; padding: 10px 25px; }
        .btn-outline-primary:hover { background: #78b6ff; color: white; }
    </style>
</head>
<body>

<main class="dashboard-container">
    <h2 class="mb-4">Hoş Geldin, Yönetici</h2>

    <div class="row g-4">
        <div class="col-md-4">
            <div class="stat-card">
                <h3>Toplam Topluluk</h3>
                <p><?php echo $toplamTopluluk; ?></p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stat-card">
                <h3>Aktif Üyelikler</h3>
                <p><?php echo $toplamUye; ?></p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stat-card">
                <h3>Toplam Kullanıcı</h3>
                <p><?php echo $toplamKullanici; ?></p>
            </div>
        </div>
    </div>

    <div class="quick-actions">
        <h4>Hızlı İşlemler</h4>
        <div class="d-flex gap-3 mt-3">
            <a href="vakalar.php" class="btn btn-primary">Vakaları Yönet</a>
            <a href="kullanicilar.php" class="btn btn-outline-primary">Kullanıcıları Görüntüle</a>
        </div>
    </div>
</main>

</body>
</html>
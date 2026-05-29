<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
require_once '../includes/db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../pages/girisYap.php");
    exit();
}

$userID = $_SESSION['user_id'];
$stmt = $conn->prepare("SELECT * FROM kullanicilar WHERE ID = ?");
$stmt->execute([$userID]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

// 1. Kurduğum Topluluklar
$kurdugumSorgu = $conn->prepare("SELECT * FROM Topluluklar WHERE OlusturanKisiID = ? ORDER BY KayitTarih DESC");
$kurdugumSorgu->execute([$userID]);
$kurulanlar = $kurdugumSorgu->fetchAll(PDO::FETCH_ASSOC);

// 2. Üye Olduğum Topluluklar (Kurucu bilgilerini JOIN ile çekiyoruz)
$uyeSorgu = $conn->prepare("
    SELECT t.*, k.Ad, k.Soyad, k.Email 
    FROM Topluluklar t 
    JOIN ToplulukUyeleri tu ON t.ID = tu.ToplulukID 
    JOIN kullanicilar k ON t.OlusturanKisiID = k.ID 
    WHERE tu.KullaniciID = ? 
    ORDER BY t.KayitTarih DESC
");
$uyeSorgu->execute([$userID]);
$uyelikler = $uyeSorgu->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Profilim | Seavoice</title>
    <link rel="stylesheet" href="../assets/css/profil.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        .user-actions { display: flex; align-items: center; gap: 12px; margin-top: 15px; }
        .btn-logout { display: inline-flex; align-items: center; gap: 8px; padding: 8px 16px; background: rgba(255, 71, 87, 0.15); border: 1px solid rgba(255, 71, 87, 0.3); color: #ff4757; text-decoration: none; border-radius: 8px; font-size: 0.85rem; }
        .tab-pane { display: none; }
        .tab-pane.active { display: block; }
        .vaka-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 20px; padding: 20px 0; }
        .community-card { border-radius: 15px; overflow: hidden; border: none; box-shadow: 0 4px 10px rgba(0,0,0,0.1); }
    </style>
</head>
<body>
<?php include '../includes/header.php'; ?>

<div class="container profile-container">
    <div class="profile-header card-glass">
        <div class="profile-info">
            <div class="avatar-wrapper">
                <img src="https://ui-avatars.com/api/?name=<?php echo urlencode($user['Ad'] . '+' . $user['Soyad']); ?>&background=78b6ff&color=fff" alt="Avatar">
            </div>
            <div class="user-details">
                <h1><?php echo htmlspecialchars($user['Ad'] . ' ' . $user['Soyad']); ?></h1>
                <p><i class="bi bi-envelope"></i> <?php echo htmlspecialchars($user['Email']); ?></p>
                <div class="user-actions">
                    <a href="../logout.php" class="btn-logout"><i class="bi bi-box-arrow-right"></i> Çıkış Yap</a>
                </div>
            </div>
        </div>
    </div>

    <div class="profile-content">
        <div class="tabs-wrapper card-glass">
            <div class="content-tabs">
                <button class="tab-btn active" data-target="kurdugum-topluluklar">Kurduğum Topluluklar</button>
                <button class="tab-btn" data-target="uye-oldugum-topluluklar">Üye Olduğum Topluluklar</button>
            </div>
        </div>

        <div class="tab-pane active" id="kurdugum-topluluklar">
            <div class="vaka-grid">
                <?php foreach($kurulanlar as $t): ?>
                    <div class="card community-card">
                        <img src="../uploads/<?php echo htmlspecialchars($t['FotoYol']); ?>" class="card-img-top" height="150" style="object-fit:cover;">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo htmlspecialchars($t['ToplulukAdi']); ?></h5>
                            <p class="card-text"><i class="bi bi-clock"></i> <?php echo date('d.m.Y H:i', strtotime($t['TemizlikZamani'])); ?></p>
                            <div class="d-grid gap-2">
                                <button class="btn btn-secondary btn-sm btn-members" data-bs-toggle="modal" data-bs-target="#membersModal" data-topluluk-id="<?php echo $t['ID']; ?>">Üyeleri Gör</button>
                                <a href="https://www.google.com/maps/dir/?api=1&destination=<?= htmlspecialchars($t['Latitude']) ?>,<?= htmlspecialchars($t['Longitude']) ?>" 
                                target="_blank" style="display:block; padding:8px 12px; background:#0ea5e9; color:white; text-decoration:none; border-radius:8px; font-size:14px; font-weight:bold; text-align:center; margin-top:5px;">
                                <i class="bi bi-map"></i> Yol Tarifi Al</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <div class="tab-pane" id="uye-oldugum-topluluklar">
            <div class="vaka-grid">
                <?php foreach($uyelikler as $u): ?>
                    <div class="card community-card">
                        <img src="../uploads/<?php echo htmlspecialchars($u['FotoYol']); ?>" class="card-img-top" height="150" style="object-fit:cover;">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo htmlspecialchars($u['ToplulukAdi']); ?></h5>
                            <p class="card-text mb-1"><i class="bi bi-clock"></i> <?php echo date('d.m.Y H:i', strtotime($u['TemizlikZamani'])); ?></p>
                            <p class="card-text small text-muted">
                                <i class="bi bi-person-badge"></i> Kurucu: <?php echo htmlspecialchars($u['Ad'] . ' ' . $u['Soyad']); ?><br>
                                <i class="bi bi-envelope"></i> <?php echo htmlspecialchars($u['Email']); ?>
                            </p>
                            <div class="d-grid gap-2">
                                <button class="btn btn-secondary btn-sm btn-members" data-bs-toggle="modal" data-bs-target="#membersModal" data-topluluk-id="<?php echo $u['ID']; ?>">Üyeleri Gör</button>
                                <a href="https://www.google.com/maps/dir/?api=1&destination=LAT,LONG<?= htmlspecialchars($u['Latitude']) ?>,<?= htmlspecialchars($u['Longitude']) ?>" target="_blank" class="btn btn-outline-info btn-sm"><i class="bi bi-map"></i> Yol Tarifi</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="membersModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content shadow-lg">
      <div class="modal-header border-0">
        <h5 class="modal-title">Topluluk Üyeleri</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body" id="membersContent"></div>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.querySelectorAll('.tab-btn').forEach(btn => {
        btn.addEventListener('click', () => {
            document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
            document.querySelectorAll('.tab-pane').forEach(p => p.classList.remove('active'));
            btn.classList.add('active');
            document.getElementById(btn.dataset.target).classList.add('active');
        });
    });

    document.querySelectorAll('.btn-members').forEach(button => {
        button.addEventListener('click', function() {
            const toplulukID = this.getAttribute('data-topluluk-id');
            const modalBody = document.getElementById('membersContent');
            modalBody.innerHTML = "Üyeler yükleniyor...";
            fetch(`../includes/get_members.php?id=${toplulukID}`)
                .then(response => response.text())
                .then(data => modalBody.innerHTML = data);
        });
    });
</script>
</body>
</html>
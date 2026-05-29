<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
require_once '../includes/db.php';

// Toplulukları ve kurucu bilgilerini JOIN ile çekiyoruz
$stmt = $conn->query("
    SELECT t.*, k.Ad, k.Soyad 
    FROM Topluluklar t 
    JOIN kullanicilar k ON t.OlusturanKisiID = k.ID 
    ORDER BY t.KayitTarih DESC
");
$topluluklar = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Topluluklar | Seavoice</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="../assets/css/topluluklar.css">
</head>
<body>
<?php include '../includes/header.php'; ?>

<div class="container main-container">
   <?php if(isset($_GET['durum']) && $_GET['durum'] == 'basarili'): ?>
       <div class="alert alert-success text-center">Topluluğunuz başarıyla oluşturuldu!</div>
   <?php elseif(isset($_GET['durum']) && $_GET['durum'] == 'katildi'): ?>
       <div class="alert alert-success text-center">Topluluğa başarıyla katıldınız!</div>
   <?php elseif(isset($_GET['hata']) && $_GET['hata'] == 'zaten_uye'): ?>
       <div class="alert alert-warning text-center">Zaten bu topluluğun bir üyesisiniz!</div>
   <?php endif; ?>

   <div class="page-header">
    <h1 id="waveHeader">Vakalar ve Topluluk Haritası</h1>
    <p>Bölgendeki deniz temizliği hareketlerine göz at</p>
   </div>

    <div id="map"></div>

    <div class="search-wrapper">
        <input type="text" id="searchInput" placeholder="Topluluk Ara..." class="form-control">
    </div>

    <div id="communityList" class="row">
        <?php foreach($topluluklar as $t): ?>
        <div class="col-md-4 mb-4">
            <div class="card community-card">
                <img src="../uploads/<?php echo htmlspecialchars($t['FotoYol']); ?>" class="card-img-top" alt="Topluluk">
                <div class="card-body">
                    <h5 class="card-title"><?php echo htmlspecialchars($t['ToplulukAdi']); ?></h5>
                    <p class="card-text mb-1">
                        <i class="bi bi-clock"></i> Temizlik: <?php echo date('d.m.Y H:i', strtotime($t['TemizlikZamani'])); ?>
                    </p>
                    <p class="card-text small text-muted">
                        <i class="bi bi-person"></i> Kurucu: <?php echo htmlspecialchars($t['Ad'] . ' ' . $t['Soyad']); ?> 
                        <span class="badge bg-info">Oluşturucu</span>
                    </p>
                    
                    <div class="d-grid gap-2">
                        <form action="../includes/katil.php" method="POST">
                            <input type="hidden" name="topluluk_id" value="<?php echo $t['ID']; ?>">
                            <button type="submit" class="btn btn-primary w-100">Katıl</button>
                        </form>
                        
                        <button class="btn btn-secondary btn-members w-100" 
                                data-bs-toggle="modal" 
                                data-bs-target="#membersModal" 
                                data-topluluk-id="<?php echo $t['ID']; ?>">Üyeleri Gör</button>
                        
                        <a href="https://www.google.com/maps/dir/?api=1&destination=<?= htmlspecialchars($t['Latitude']) ?>,<?= htmlspecialchars($t['Longitude']) ?>" 
   target="_blank" 
   style="display:block; padding:8px 12px; background:#0ea5e9; color:white; 
          text-decoration:none; border-radius:8px; font-size:14px; font-weight:bold; text-align:center; margin-top:5px;">
   <i class="bi bi-map"></i> Yol Tarifi Al
</a>
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>

<div class="modal fade" id="membersModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content shadow-lg">
      <div class="modal-header border-0">
        <h5 class="modal-title">Topluluk Üyeleri</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body" id="membersContent">
          </div>
    </div>
  </div>
</div>

<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
<script>
    const phpData = <?php echo json_encode($topluluklar); ?>;
</script>
<script src="../assets/js/topluluklar.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
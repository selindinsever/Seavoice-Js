<?php
require_once 'db.php';
$toplulukID = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($toplulukID > 0) {
    $stmtKurucu = $conn->prepare("SELECT OlusturanKisiID FROM Topluluklar WHERE ID = ?");
    $stmtKurucu->execute([$toplulukID]);
    $kurucuID = $stmtKurucu->fetchColumn();

    $stmt = $conn->prepare("
        SELECT k.Ad, k.Soyad, k.Email, k.ID as KullaniciID 
        FROM ToplulukUyeleri tu 
        JOIN kullanicilar k ON tu.KullaniciID = k.ID 
        WHERE tu.ToplulukID = ?
    ");
    $stmt->execute([$toplulukID]);
    $uyeler = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo '<ul class="list-group list-group-flush">';
    foreach($uyeler as $uye) {
        $rol = ($uye['KullaniciID'] == $kurucuID) ? '<span class="badge bg-info">Oluşturucu</span>' : '<span class="badge bg-success">Üye</span>';
        
        echo '<li class="list-group-item bg-transparent text-dark border-secondary">';
        echo '<strong>' . htmlspecialchars($uye['Ad'] . ' ' . $uye['Soyad']) . '</strong><br>';
        echo '<small class="text-muted">' . htmlspecialchars($uye['Email']) . '</small> ';
        echo $rol;
        echo '</li>';
    }
    echo '</ul>';
}
?>
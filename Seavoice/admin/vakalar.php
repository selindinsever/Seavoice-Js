<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
require_once '../includes/db.php';


if (!isset($_SESSION['admin_id'])) { 
    header("Location: ../pages/girisYap.php"); 
    exit(); 
}

// Silme İşlemleri
if (isset($_GET['sil_topluluk'])) {
    $conn->prepare("DELETE FROM topluluklar WHERE ID = ?")->execute([$_GET['sil_topluluk']]);
    header("Location: vakalar.php"); exit();
}
if (isset($_GET['sil_uye'])) {
    $conn->prepare("DELETE FROM toplulukuyeleri WHERE ID = ?")->execute([$_GET['sil_uye']]);
    header("Location: vakalar.php"); exit();
}

include 'adminheader.php'; 
?>
<link rel="stylesheet" href="vakalar.css">

<main>
<section class="content-body">
    
    <div class="table-card">
        <h3 class="section-title">Aktif Topluluklar</h3>
        <table class="retro-table">
            <thead>
                <tr><th>Görsel</th><th>Ad</th><th>Zaman</th><th>Oluşturan (Ad Soyad - EMAIL)</th><th>İşlem</th></tr>
            </thead>
            <tbody>
                <?php
                $sorgu = $conn->query("SELECT t.*, k.Ad, k.Soyad, k.Email FROM topluluklar t LEFT JOIN kullanicilar k ON t.OlusturanKisiID = k.ID");
                while($row = $sorgu->fetch(PDO::FETCH_ASSOC)) {
                    $resim = "../uploads/" . $row['FotoYol'];
                    echo "<tr>
                        <td><img src='{$resim}' style='width:40px; height:40px; border-radius:8px; object-fit:cover;'></td>
                        <td>{$row['ToplulukAdi']}</td>
                        <td>{$row['TemizlikZamani']}</td>
                        <td>{$row['Ad']} {$row['Soyad']} <br><small class='text-muted'>{$row['Email']}</small></td>
                        <td>
                            <a href='duzenle_topluluk.php?id={$row['ID']}' class='btn-edit'>Düzenle</a>
                            <a href='?sil_topluluk={$row['ID']}' class='btn-delete' onclick='return confirm(\"Silinsin mi?\")'>Sil</a>
                        </td>
                    </tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <div class="table-card" style="margin-top: 30px;">
        <h3 class="section-title">Topluluk Üyeleri</h3>
        <table class="retro-table">
            <thead>
                <tr><th>Topluluk</th><th>Kullanıcı (Ad Soyad - EMAIL)</th><th>Rol</th><th>Katılma</th><th>İşlem</th></tr>
            </thead>
            <tbody>
                <?php
                $sorgu = $conn->query("SELECT tu.*, t.ToplulukAdi, t.OlusturanKisiID, k.Ad, k.Soyad, k.Email 
                                       FROM toplulukuyeleri tu 
                                       JOIN topluluklar t ON tu.ToplulukID = t.ID 
                                       JOIN kullanicilar k ON tu.KullaniciID = k.ID");
                
                while($row = $sorgu->fetch(PDO::FETCH_ASSOC)) {
                    // Kurucu kontrolü: Eğer üyenin ID'si topluluğun kurucusunun ID'si ile aynıysa "Oluşturucu" yaz
                    if ($row['KullaniciID'] == $row['OlusturanKisiID']) {
                        $rolGoster = '<span class="badge bg-primary">Oluşturucu</span>';
                    } else {
                        $rolGoster = !empty($row['Rol']) ? htmlspecialchars($row['Rol']) : '<span class="badge bg-secondary">Üye</span>';
                    }
                    
                    echo "<tr>
                        <td>{$row['ToplulukAdi']}</td>
                        <td>{$row['Ad']} {$row['Soyad']} <br><small class='text-muted'>{$row['Email']}</small></td>
                        <td>{$rolGoster}</td>
                        <td>{$row['KatilmaTarihi']}</td>
                        <td>
                            <a href='duzenle_uye.php?id={$row['ID']}' class='btn-edit'>Düzelt</a>
                            <a href='?sil_uye={$row['ID']}' class='btn-delete' onclick='return confirm(\"Çıkarılsın mı?\")'>Sil</a>
                        </td>
                    </tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</section>
</main>
</div></body></html>
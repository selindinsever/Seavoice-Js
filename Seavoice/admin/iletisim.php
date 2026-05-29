<?php
session_start();
require_once '../includes/db.php';
if (!isset($_SESSION['admin_id'])) { header("Location: ../pages/girisYap.php"); exit(); }

include 'adminheader.php'; 
?>
<link rel="stylesheet" href="vakalar.css">

<section class="content-body">
    <div class="table-card">
        <h3 class="section-title">Gelen Mesaj Kutusu</h3>
        <table class="retro-table">
            <thead>
                <tr><th>Kullanıcı</th><th>Konu</th><th>Mesaj</th><th>Tarih</th><th>Durum</th><th>İşlem</th></tr>
            </thead>
            <tbody>
                <?php
                $sorgu = $conn->query("SELECT i.*, k.Ad, k.Email FROM iletisim i JOIN kullanicilar k ON i.KullaniciID = k.ID ORDER BY i.GonderimTarihi DESC");
                while($row = $sorgu->fetch(PDO::FETCH_ASSOC)) {
                    $durumClass = $row['isProcessed'] ? 'badge-success' : 'badge-pending';
                    $durumYazi = $row['isProcessed'] ? 'Okundu' : 'Yeni';
                    
                    echo "<tr>
                        <td>{$row['Ad']}</td>
                        <td>{$row['Konu']}</td>
                        <td style='max-width:200px; overflow:hidden; text-overflow:ellipsis;'>{$row['MesajMetni']}</td>
                        <td>{$row['GonderimTarihi']}</td>
                        <td><span class='badge {$durumClass}'>{$durumYazi}</span></td>
                        <td>";
                            if (!$row['isProcessed']) {
                                echo "<form action='../includes/islem.php' method='POST'>
                                        <input type='hidden' name='islem' value='mesaj_islenmis'>
                                        <input type='hidden' name='id' value='{$row['ID']}'>
                                        <input type='hidden' name='email' value='{$row['Email']}'>
                                        <button type='submit' class='btn-edit'>İşlendi</button>
                                      </form>";
                            } else {
                                echo "<span style='color:green; font-size: 0.8rem;'>Okundu</span>";
                            }
                    echo "</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</section>
</main></div></body></html>
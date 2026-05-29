<?php
session_start();
require_once '../includes/db.php';

// Admin kontrolü
if (!isset($_SESSION['admin_id'])) { 
    header("Location: ../pages/girisYap.php"); 
    exit(); 
}

// Silme İşlemi
if (isset($_GET['sil'])) {
    $silID = $_GET['sil'];
    $stmt = $conn->prepare("DELETE FROM kullanicilar WHERE ID = ?");
    $stmt->execute([$silID]);
    header("Location: kullanicilar.php");
    exit();
}

// 1. HEADER (Sidebar ve Wrapper başlangıcı burada)
include 'adminheader.php'; 
?>

<header class="content-header">
    <h2>Kullanıcı Listesi</h2>
</header>
<link rel="stylesheet" href="kullanicilar.css">
<section class="content-body">
    <table class="retro-table">
        <thead>
            <tr>
                <th>ID</th><th>Ad</th><th>Soyad</th><th>EMAIL</th><th>Şifre</th><th>İşlem</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $sorgu = $conn->query("SELECT * FROM kullanicilar");
            while($row = $sorgu->fetch(PDO::FETCH_ASSOC)) {
                echo "<tr>
                    <td>{$row['ID']}</td>
                    <td>{$row['Ad']}</td>
                    <td>{$row['Soyad']}</td>
                    <td>{$row['Email']}</td>
                    <td class='password-cell'>{$row['Sifre']}</td>
                    <td>
                        <a href='?sil={$row['ID']}' class='btn-delete' onclick='return confirm(\"Bu kullanıcıyı silmek istediğine emin misin?\")'>Sil</a>
                    </td>
                </tr>";
            }
            ?>
        </tbody>
    </table>
</section>

</main> </div> </body>
</html>
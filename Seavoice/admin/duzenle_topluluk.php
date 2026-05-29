<?php
session_start();
require_once '../includes/db.php';

if (!isset($_GET['id'])) { header("Location: vakalar.php"); exit(); }
$id = $_GET['id'];

$stmt = $conn->prepare("SELECT * FROM Topluluklar WHERE ID = ?");
$stmt->execute([$id]);
$t = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$t) { header("Location: vakalar.php"); exit(); }

$kullanicilar = $conn->query("SELECT ID, Ad, Soyad FROM kullanicilar")->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $yeniAd = $_POST['topluluk_adi'];
    $yeniZaman = $_POST['temizlik_zamani'];
    $yeniKurucu = $_POST['olusturan_id'];

    $fotoYol = $t['FotoYol']; 
    if (!empty($_FILES['gorsel']['name'])) {
        $uploadDir = '../uploads/';
        $fotoYol = time() . '_' . basename($_FILES['gorsel']['name']);
        move_uploaded_file($_FILES['gorsel']['tmp_name'], $uploadDir . $fotoYol);
    }

    $update = $conn->prepare("UPDATE Topluluklar SET ToplulukAdi = ?, TemizlikZamani = ?, OlusturanKisiID = ?, FotoYol = ? WHERE ID = ?");
    $update->execute([$yeniAd, $yeniZaman, $yeniKurucu, $fotoYol, $id]);
    
    header("Location: vakalar.php?durum=guncellendi");
    exit();
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Düzenle | Admin</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        body { background: #eef6ff; font-family: 'Segoe UI', sans-serif; height: 100vh; display: flex; align-items: center; justify-content: center; overflow: hidden; }
        
        .edit-card { 
            background: rgba(255, 255, 255, 0.95); 
            backdrop-filter: blur(20px); 
            border-radius: 25px; 
            box-shadow: 0 10px 40px rgba(120, 182, 255, 0.2);
            padding: 30px;
            width: 100%;
            max-width: 500px;
            max-height: 90vh;
            display: flex;
            flex-direction: column;
            border: 1px solid rgba(255, 255, 255, 0.8);
        }

        .form-scroll-area { overflow-y: auto; padding-right: 10px; }
        .form-scroll-area::-webkit-scrollbar { width: 6px; }
        .form-scroll-area::-webkit-scrollbar-thumb { background: #cce5ff; border-radius: 10px; }

        h2 { color: #2c3e50; font-weight: 700; font-size: 1.3rem; margin-bottom: 20px; text-align: center; }
        .preview-img { width: 100%; height: 160px; object-fit: cover; border-radius: 15px; margin-bottom: 15px; border: 2px solid #eef6ff; cursor: pointer; }
        .form-label { font-weight: 600; color: #555; font-size: 0.9rem; margin-bottom: 5px; }
        .form-control, .form-select { border-radius: 12px; padding: 10px; border: 1px solid #d1e3fa; font-size: 0.9rem; }
        .btn { border-radius: 12px; padding: 10px; font-weight: 600; }
    </style>
</head>
<body>
    <div class="edit-card">
        <h2><i class="bi bi-pencil-square"></i> Düzenleme Paneli</h2>
        
        <form method="POST" enctype="multipart/form-data" class="form-scroll-area">
            <div class="mb-3 text-center">
                <img src="../uploads/<?php echo htmlspecialchars($t['FotoYol']); ?>" class="preview-img" id="imgPreview">
                <input type="file" name="gorsel" class="form-control form-control-sm" accept="image/*" onchange="previewImage(event)">
            </div>

            <div class="mb-3">
                <label class="form-label">Topluluk Adı</label>
                <input type="text" name="topluluk_adi" class="form-control" value="<?php echo htmlspecialchars($t['ToplulukAdi']); ?>" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Oluşturucu</label>
                <select name="olusturan_id" class="form-select">
                    <?php foreach($kullanicilar as $k): ?>
                        <option value="<?php echo $k['ID']; ?>" <?php echo ($k['ID'] == $t['OlusturanKisiID']) ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($k['Ad'] . ' ' . $k['Soyad']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Temizlik Zamanı</label>
                <input type="datetime-local" name="temizlik_zamani" class="form-control" value="<?php echo date('Y-m-d\TH:i', strtotime($t['TemizlikZamani'])); ?>" required>
            </div>

            <div class="d-grid gap-2 mt-4">
                <button type="submit" class="btn btn-primary">Kaydet</button>
                <a href="vakalar.php" class="btn btn-outline-secondary">İptal</a>
            </div>
        </form>
    </div>

    <script>
        function previewImage(event) {
            const reader = new FileReader();
            const preview = document.getElementById('imgPreview');
            reader.onload = function() {
                preview.src = reader.result;
            }
            reader.readAsDataURL(event.target.files[0]);
        }
    </script>
</body>
</html>
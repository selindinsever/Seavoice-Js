<?php
session_start();
require_once '../includes/db.php';

if (!isset($_GET['id'])) { header("Location: vakalar.php"); exit(); }

$id = $_GET['id'];
$stmt = $conn->prepare("SELECT * FROM toplulukuyeleri WHERE ID = ?");
$stmt->execute([$id]);
$u = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$u) { header("Location: vakalar.php"); exit(); }

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $yeniRol = $_POST['rol'];
    $izinliRoller = ['Yönetici', 'Üye'];

    if (in_array($yeniRol, $izinliRoller)) {
        $update = $conn->prepare("UPDATE toplulukuyeleri SET Rol = ? WHERE ID = ?");
        $update->execute([$yeniRol, $id]);
        header("Location: vakalar.php?durum=guncellendi");
        exit();
    } else {
        $hata = "Geçersiz rol seçimi!";
    }
}
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Üye Düzenle | Admin</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        body { 
            background-color: #eef6ff; 
            font-family: 'Segoe UI', sans-serif; 
        }
        .edit-card { 
            background: rgba(255, 255, 255, 0.85); 
            backdrop-filter: blur(20px); 
            border-radius: 25px; 
            box-shadow: 0 10px 40px rgba(120, 182, 255, 0.15);
            padding: 40px;
            max-width: 450px;
            margin: 80px auto;
            border: 1px solid rgba(255, 255, 255, 0.5);
        }
        h2 { 
            color: #4a90e2; 
            margin-bottom: 25px; 
            font-weight: 700; 
            font-size: 1.4rem;
            text-align: center;
        }
        .form-label { font-weight: 600; color: #555; }
        .form-select { 
            border-radius: 12px; 
            padding: 12px; 
            border: 1px solid #d1e3fa;
        }
        .btn-primary { 
            background-color: #78b6ff; 
            border: none; 
            border-radius: 12px;
            padding: 10px 25px;
            transition: 0.3s;
        }
        .btn-primary:hover { background-color: #5aa1f7; }
        .btn-outline-secondary { 
            border-radius: 12px; 
            padding: 10px 25px;
        }
        .alert { border-radius: 12px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="edit-card">
            <h2><i class="bi bi-person-gear"></i> Rol Düzenleme</h2>
            
            <?php if(isset($hata)): ?>
                <div class="alert alert-danger"><?php echo $hata; ?></div>
            <?php endif; ?>

            <form method="POST">
                <div class="mb-4">
                    <label class="form-label">Sistem Rolü</label>
                    <select name="rol" class="form-select" required>
                        <option value="Üye" <?php echo ($u['Rol'] == 'Üye') ? 'selected' : ''; ?>>Üye</option>
                        <option value="Yönetici" <?php echo ($u['Rol'] == 'Yönetici') ? 'selected' : ''; ?>>Yönetici</option>
                    </select>
                </div>
                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-primary">Değişiklikleri Kaydet</button>
                    <a href="vakalar.php" class="btn btn-outline-secondary">Vazgeç</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
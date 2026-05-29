<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SeaVoice Admin | Yönetim Paneli</title>
    <style>
        :root {
            --accent-blue: #0284c7;
            --panel-bg: rgba(255, 255, 255, 0.75);
        }

        body {
            margin: 0;
            font-family: 'Segoe UI', sans-serif;
            background: radial-gradient(circle at 15% 20%, #e0f2fe 0%, transparent 55%),
                        radial-gradient(circle at 85% 65%, #bae6fd 0%, transparent 60%),
                        linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 50%, #bae6fd 100%);
            background-attachment: fixed;
            min-height: 100vh;
        }

        .admin-wrapper { display: flex; min-height: 100vh; }

        .sidebar {
            width: 260px;
            background: var(--panel-bg);
            backdrop-filter: blur(15px);
            border-right: 1px solid rgba(14, 165, 233, 0.2);
            padding: 30px 20px;
            display: flex;
            flex-direction: column;
        }

        .sidebar-logo { margin-bottom: 40px; text-align: center; pointer-events: none; }

        .menu-group { margin-bottom: 30px; }
        .menu-group small {
            display: block; color: #64748b; font-size: 0.7rem; font-weight: 800;
            text-transform: uppercase; letter-spacing: 2px; margin-bottom: 12px; padding-left: 10px;
        }

        .sidebar ul { list-style: none; }

        .sidebar a {
            display: block; padding: 14px 20px; color: #0f172a; text-decoration: none;
            font-weight: 600; border-radius: 12px; opacity: 0.7; transition: all 0.3s ease;
        }

        .sidebar a:hover {
            opacity: 1; background: rgba(2, 132, 199, 0.1); padding-left: 30px;
        }

        .logout-btn { color: #e11d48 !important; }

        .admin-content { flex: 1; padding: 40px; }
        .content-header h2 { color: #0f172a; margin-bottom: 20px; }
    </style>
</head>
<body>

    <div class="admin-wrapper">
        <nav class="sidebar">
            <div class="sidebar-logo">
                <img src="../assets/images/logo4.png" width="160" alt="Logo">
            </div>
            
            <section class="menu-group">
                <small>SİSTEM</small>
                <ul>
                    <li><a href="index.php">Dashboard</a></li>
                    <li><a href="kullanicilar.php">Kullanıcı Listesi</a></li>
                </ul>
            </section>

            <section class="menu-group">
                <small>OPERASYON</small>
                <ul>
                    <li><a href="vakalar.php">Vaka Yönetimi</a></li>
                    <li><a href="iletisim.php">Mesaj Kutusu</a></li>
                </ul>
            </section>

            <section class="menu-group">
                <small>HESAP</small>
                <ul>
                    <li><a href="../logout.php" class="logout-btn">Çıkış Yap</a></li>
                </ul>
            </section>
        </nav>

        <main class="admin-content">
            <header class="content-header">
                <h2></h2>
            </header>
            <section class="content-body">
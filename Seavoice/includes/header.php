<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SeaVoice</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html {
            -webkit-font-variant-ligatures: common-ligatures;
            font-variant-ligatures: common-ligatures;
        }

        html, body {
            min-height: 100%;
            background: radial-gradient(circle at 15% 20%, #e0f2fe 0%, transparent 55%),
                        radial-gradient(circle at 85% 65%, #bae6fd 0%, transparent 60%),
                        linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 50%, #bae6fd 100%);
            background-attachment: fixed;
            color: #0f172a; 
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            overflow-x: hidden;
        }

        :root {
            --accent-blue: #0284c7;
            --light-blue: #38bdf8;  
        }

       
        header {
            width: 100%;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 1000;
            padding: 10px 0;
            transition: all 0.3s ease;
            overflow: visible;
        }

       
        header::after {
            content: '';
            position: absolute;
            left: 0;
            right: 0;
            bottom: 0;
            height: 2px;
            background: linear-gradient(90deg, rgba(56, 189, 248, 0), rgba(255,255,255,0.95), rgba(56, 189, 248, 0));
            background-size: 200% 100%;
            box-shadow: 0 0 15px rgba(56, 189, 248, 0.3);
            opacity: 0.85;
            animation: shimmer 8s linear infinite;
        }

        @keyframes shimmer {
            0% { background-position: -200% 0; }
            100% { background-position: 200% 0; }
        }

        header.scrolled {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(15px);
            -webkit-backdrop-filter: blur(15px);
            padding: 5px 0;
            box-shadow: 0 4px 20px rgba(2, 132, 199, 0.08);
        }

        .nav-container {
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 5%;
            height: 80px;
        }

        .logo {
            display: flex;
            align-items: center;
            flex-shrink: 0;
        }

        .logo img {
            height: 70px;
            width: auto;
            display: block;
            transition: transform 0.3s ease;
        }

       

        .nav-menu {
            display: flex !important;
            list-style: none !important;
            gap: 25px !important;
            align-items: center !important;
            margin: 0 !important;
            padding: 0 !important;
        }

        .nav-menu li {
            margin: 0 !important;
            padding: 0 !important;
            width: auto;
        }

        .nav-link {
            text-decoration: none;
            color: #1e293b;
            font-size: 14px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            transition: all 0.3s ease;
            position: relative;
            white-space: nowrap;
            display: inline-block !important;
            padding: 0 !important;
        }

        .nav-link:hover {
            color: var(--accent-blue);
            text-shadow: 0 0 10px rgba(14, 165, 233, 0.3);
        }

        .nav-link::after {
            content: '';
            position: absolute;
            width: 0;
            height: 2px;
            bottom: -5px;
            left: 0;
            background-color: var(--accent-blue);
            transition: width 0.3s ease;
        }

        .nav-link:hover::after {
            width: 100%;
        }

        .nav-link.link-iletisim {
            text-transform: none !important;
        }
        
        .btn-vaka {
            background: linear-gradient(135deg, #0ea5e9 0%, #38bdf8 100%);
            padding: 12px 28px !important;
            border-radius: 30px;
            color: #fff !important;
            box-shadow: 0 4px 15px rgba(14, 165, 233, 0.2);
            border: 1px solid rgba(255,255,255,0.2);
        }

        .btn-vaka:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(14, 165, 233, 0.35);
            filter: brightness(1.03);
        }

        .btn-vaka::after { display: none; }

        .mobile-toggle {
            display: none;
            cursor: pointer;
            color: #0f172a;
            font-size: 32px;
            transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
            z-index: 1200;
        }
        
        .mobile-toggle:hover {
            color: var(--accent-blue);
        }

        @media (max-width: 992px) {
            .nav-menu { gap: 15px !important; }
            .nav-link { font-size: 12px; }
        }

        @media (max-width: 768px) {
            .mobile-toggle { display: block; }
            .nav-menu {
                position: fixed;
                top: 0; right: -100%; width: 300px; height: 100vh;
                background: linear-gradient(145deg, rgba(240, 249, 255, 0.98) 0%, rgba(224, 242, 254, 0.99) 100%) !important;
                backdrop-filter: blur(25px);
                border-left: 1px solid rgba(14, 165, 233, 0.15);
                flex-direction: column !important;
                justify-content: flex-start !important;
                align-items: center !important; 
                padding: 110px 35px 40px 35px !important; gap: 0 !important;
                transition: right 0.4s cubic-bezier(0.16, 1, 0.3, 1) !important;
                box-shadow: -15px 0 35px rgba(0, 0, 0, 0.05);
            }
            .nav-menu.active { right: 0 !important; }
            .nav-menu li { width: 100% !important; border-bottom: 1px solid rgba(14, 165, 233, 0.08); padding: 16px 0 !important; text-align: center; }
            .nav-menu li:has(.btn-vaka) { border-bottom: none !important; padding-top: 24px !important; padding-bottom: 24px !important; }
            .nav-link { font-size: 14px !important; font-weight: 700 !important; letter-spacing: 1.5px; width: 100%; display: block !important; color: #334155; text-align: center; transition: transform 0.3s ease; }
            .nav-link:hover { transform: scale(1.03); color: var(--accent-blue); }
            .nav-link::after { display: none !important; }
            .btn-vaka { text-align: center !important; padding: 12px 0 !important; border-radius: 12px; display: block !important; width: 100% !important; }
            .mobile-toggle.active { position: fixed; right: 35px; top: 24px; transform: rotate(180deg); }
        }
    </style>
</head>
<body>

<header id="main-header">
    <nav class="nav-container">
        <div class="logo">
            <a href="anasayfa.php">
                <img src="../assets/images/logo4.png" alt="Seavoice Logo" width="180" height="55">
            </a>
        </div>

        <div class="mobile-toggle" id="mobile-menu">
            <span id="menu-icon-char">&#9776;</span>
        </div>

        <ul class="nav-menu">
            <li><a href="/pages/anasayfa.php" class="nav-link">Anasayfa</a></li>
            <li><a href="/pages/hakkimizda.php" class="nav-link">Hakkımızda</a></li>
            <li><a href="/pages/topluluklar.php" class="nav-link">Topluluklar</a></li>
            <li><a href="/pages/vakaEkle.php" class="nav-link btn-vaka">Vaka Ekle</a></li>
            <li><a href="/pages/iletisim.php" class="nav-link link-iletisim">İLETİŞİM</a></li>
            <li><a href="/pages/profil.php" class="nav-link">PROFİL</a></li>
        </ul>
    </nav>
</header>

<script>
    // Scroll Efekti
    window.addEventListener('scroll', function() {
        const header = document.getElementById('main-header');
        if (window.scrollY > 30) {
            header.classList.add('scrolled');
        } else {
            header.classList.remove('scrolled');
        }
    });

    const menuIcon = document.getElementById('mobile-menu');
    const menuIconChar = document.getElementById('menu-icon-char');
    const navMenu = document.querySelector('.nav-menu');

    menuIcon.addEventListener('click', () => {
        navMenu.classList.toggle('active');
        menuIcon.classList.toggle('active');
        if (navMenu.classList.contains('active')) {
            menuIconChar.innerHTML = '&#10005;'; 
        } else {
            menuIconChar.innerHTML = '&#9776;';
        }
    });

    document.addEventListener('click', (e) => {
        if (!menuIcon.contains(e.target) && !navMenu.contains(e.target)) {
            navMenu.classList.remove('active');
            menuIcon.classList.remove('active');
            menuIconChar.innerHTML = '&#9776;';
        }
    });
</script>
</body>
</html>
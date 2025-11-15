<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Web Du Lịch</title>
    <style>
        * { margin:0; padding:0; box-sizing:border-box; }
        body, html { height:100%; font-family: Arial, sans-serif; background:#fff; color:#000; }
        .wrapper { display:flex; flex-direction:column; min-height:100vh; }

        /* Header */
        header {
            background:#f8f8f8;
            padding:15px 30px;
            display:flex;
            justify-content: space-between;
            align-items: center;
            border-bottom:1px solid #ddd;
        }
        header h2 { font-size:24px; }
        nav ul { list-style:none; display:flex; gap:25px; }
        nav a { text-decoration:none; color:#000; font-weight:500; }
        nav a:hover { color:#0071c2; }

        /* Main */
        main { flex:1; padding:40px 30px; }

        /* Hero section */
        .hero {
            text-align:center;
            padding:60px 20px;
            background:#f5f5f5;
            border-radius:10px;
            margin-bottom:40px;
        }
        .hero h1 { font-size:36px; margin-bottom:20px; }
        .hero p { font-size:18px; margin-bottom:30px; color:#333; }
        .btn-primary {
            text-decoration:none;
            background:#0071c2;
            color:#fff;
            padding:10px 25px;
            border-radius:5px;
            font-weight:500;
        }
        .btn-primary:hover { background:#005a9c; }

        /* Tour section */
        .section { max-width:1200px; margin:0 auto 40px auto; }
        .tour-grid { display:flex; flex-wrap:wrap; gap:20px; }
        .tour-card {
            border:1px solid #ddd; border-radius:8px;
            padding:15px; flex:1 1 calc(33% - 20px);
            background:#fff;
            text-align:center;
        }
        .tour-card img { max-width:100%; border-radius:5px; margin-bottom:10px; }
        .tour-card h3 { margin-bottom:10px; }
        .tour-card p { font-size:14px; color:#555; margin-bottom:10px; }

        /* Footer */
        footer.site-footer {
            background:#f8f8f8;
            padding:20px 30px;
            border-top:1px solid #ddd;
            font-size:14px;
            color:#555;
        }
        
        .footer-links ul { list-style:none; display:flex; gap:15px; padding:0; }
        .footer-links a { text-decoration:none; color:#000; font-weight:500; }
        .footer-links a:hover { color:#0071c2; }
        .footer-bottom { text-align:center; margin-top:15px; }
        
    </style>
</head>
<body>
<div class="wrapper">
<header>
    <h2>Web Du Lịch</h2>
    <nav>
        <ul>
            <li><a href="index.php">Trang chủ</a></li>
            <li><a href="index.php?page=admin_tours&action=list">Tour</a></li>
            <li><a href="index.php?page=admin_bookings&action=list">Booking</a></li>
            <li><a href="#">Liên hệ</a></li>
            <li><a href="#">Đăng nhập</a></li>
        </ul>
    </nav>
</header>
<main>

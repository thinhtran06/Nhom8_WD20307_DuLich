<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Web Du Lịch</title>
    <style>
        html, body {
            height: 100%;
            margin: 0;
            padding: 0;
        }

        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            font-family: Arial, sans-serif;
        }

        /* div bao quanh nội dung chính, giãn ra để đẩy footer xuống */
        .content {
            flex: 1;
        }

        footer.site-footer {
            background: #f5f5f5;
            color: #333;
            font-size: 14px;
            padding: 20px 0;
            bottom: 0px;
        }

        .footer-container {
            display: flex;
            justify-content: center;
            align-items: flex-start;
            gap: 50px;
            flex-wrap: wrap;
            padding: 20px 0;
        }

        .footer-about, .footer-links {
            text-align: center;
        }

        .footer-about h3 {
            margin-bottom: 10px;
        }

        .footer-links ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .footer-links li {
            margin: 5px 0;
        }

        .footer-links a {
            text-decoration: none;
            color: #000;
            transition: color 0.3s;
        }

        .footer-links a:hover {
            color: #007BFF;
        }

        .footer-bottom {
            text-align: center;
            padding: 10px 0;
            border-top: 1px solid #ddd;
            background: #eaeaea;
        }

        @media (max-width: 600px) {
            .footer-container {
                flex-direction: column;
                gap: 20px;
            }
        }
    </style>
</head>
<body>
    <footer class="site-footer">
        <div class="footer-container">
            <div class="footer-about">
                <h3>Web Du Lịch</h3>
                <p>Khám phá những tour hấp dẫn, đặt tour nhanh chóng và tiện lợi.</p>
            </div>
            <div class="footer-links">
                <ul>
                    <li><a href="index.php">Trang chủ</a></li>
                    <li><a href="index.php?page=admin_tours&action=list">Tour</a></li>
                    <li><a href="index.php?page=admin_bookings&action=list">Booking</a></li>
                    <li><a href="#">Liên hệ</a></li>
                </ul>
            </div>
        </div>
        <div class="footer-bottom">
            <p>© 2025 Web Du Lịch. All rights reserved.</p>
        </div>
        <!-- cnsancasc -->
    </footer>
</body>
</html>

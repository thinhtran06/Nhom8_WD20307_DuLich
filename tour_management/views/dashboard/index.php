<!-- views/dashboard/index.php -->
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Quản Lý Tour Du Lịch</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f5f6fa;
            color: #2c3e50;
        }
        
        .dashboard-container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 20px;
        }
        
        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px;
            border-radius: 10px;
            margin-bottom: 30px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }
        
        .header h1 {
            font-size: 28px;
            margin-bottom: 10px;
        }
        
        .header p {
            opacity: 0.9;
            font-size: 14px;
        }
        
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }
        
        .stat-card {
            background: white;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.08);
            transition: transform 0.2s, box-shadow 0.2s;
        }
        
        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        }
        
        .stat-card .icon {
            font-size: 40px;
            margin-bottom: 15px;
        }
        
        .stat-card h3 {
            color: #7f8c8d;
            font-size: 14px;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 10px;
        }
        
        .stat-card .number {
            font-size: 36px;
            font-weight: bold;
            color: #2c3e50;
            margin-bottom: 10px;
        }
        
        .stat-card .change {
            font-size: 13px;
            padding: 4px 8px;
            border-radius: 4px;
            display: inline-block;
        }
        
        .stat-card .change.positive {
            background: #d4edda;
            color: #155724;
        }
        
        .stat-card .change.negative {
            background: #f8d7da;
            color: #721c24;
        }
        
        .content-grid {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 20px;
            margin-bottom: 30px;
        }
        
        .card {
            background: white;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.08);
        }
        
        .card h2 {
            font-size: 20px;
            margin-bottom: 20px;
            color: #2c3e50;
            border-bottom: 2px solid #667eea;
            padding-bottom: 10px;
        }
        
        .tour-list {
            list-style: none;
        }
        
        .tour-item {
            padding: 15px;
            border-bottom: 1px solid #ecf0f1;
            display: flex;
            justify-content: space-between;
            align-items: center;
            transition: background 0.2s;
        }
        
        .tour-item:hover {
            background: #f8f9fa;
        }
        
        .tour-item:last-child {
            border-bottom: none;
        }
        
        .tour-info {
            flex: 1;
        }
        
        .tour-name {
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 5px;
        }
        
        .tour-meta {
            font-size: 13px;
            color: #7f8c8d;
        }
        
        .tour-status {
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }
        
        .status-active {
            background: #d4edda;
            color: #155724;
        }
        
        .status-pending {
            background: #fff3cd;
            color: #856404;
        }
        
        .status-completed {
            background: #d1ecf1;
            color: #0c5460;
        }
        
        .quick-actions {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }
        
        .action-btn {
            display: block;
            padding: 15px;
            text-align: center;
            text-decoration: none;
            color: white;
            border-radius: 8px;
            font-weight: 600;
            transition: transform 0.2s, box-shadow 0.2s;
        }
        
        .action-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.2);
        }
        
        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        
        .btn-success {
            background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
        }
        
        .btn-info {
            background: linear-gradient(135deg, #3494e6 0%, #ec6ead 100%);
        }
        
        .btn-warning {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        }
        
        @media (max-width: 768px) {
            .content-grid {
                grid-template-columns: 1fr;
            }
            
            .stats-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="dashboard-container">
        <!-- Header -->
        <div class="header">
            <h1>🌍 Quản Lý Tour Du Lịch</h1>
            <p>Chào mừng bạn trở lại! Đây là tổng quan hoạt động của hệ thống.</p>
        </div>
        
        <!-- Statistics Cards -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="icon">🎯</div>
                <h3>Tổng Số Tour</h3>
                <div class="number">48</div>
                <span class="change positive">↑ 12% so với tháng trước</span>
            </div>
            
            <div class="stat-card">
                <div class="icon">📅</div>
                <h3>Booking Hôm Nay</h3>
                <div class="number">23</div>
                <span class="change positive">↑ 8 booking mới</span>
            </div>
            
            <div class="stat-card">
                <div class="icon">💰</div>
                <h3>Doanh Thu Tháng Này</h3>
                <div class="number">₫850M</div>
                <span class="change positive">↑ 25% so với tháng trước</span>
            </div>
            
            <div class="stat-card">
                <div class="icon">👥</div>
                <h3>Khách Hàng</h3>
                <div class="number">1,248</div>
                <span class="change positive">↑ 156 khách mới</span>
            </div>
        </div>
        
        <!-- Content Grid -->
        <div class="content-grid">
            <!-- Recent Tours -->
            <div class="card">
                <h2>Tour Gần Đây</h2>
                <ul class="tour-list">
                    <li class="tour-item">
                        <div class="tour-info">
                            <div class="tour-name">Tour Hạ Long - Sapa 4N3Đ</div>
                            <div class="tour-meta">Khởi hành: 25/11/2025 • 35 khách</div>
                        </div>
                        <span class="tour-status status-active">Đang hoạt động</span>
                    </li>
                    <li class="tour-item">
                        <div class="tour-info">
                            <div class="tour-name">Tour Phú Quốc Trọn Gói 5N4Đ</div>
                            <div class="tour-meta">Khởi hành: 28/11/2025 • 42 khách</div>
                        </div>
                        <span class="tour-status status-active">Đang hoạt động</span>
                    </li>
                    <li class="tour-item">
                        <div class="tour-info">
                            <div class="tour-name">Tour Đà Nẵng - Hội An 3N2Đ</div>
                            <div class="tour-meta">Khởi hành: 30/11/2025 • 28 khách</div>
                        </div>
                        <span class="tour-status status-pending">Chờ xác nhận</span>
                    </li>
                    <li class="tour-item">
                        <div class="tour-info">
                            <div class="tour-name">Tour Nha Trang Biển Xanh 4N3Đ</div>
                            <div class="tour-meta">Khởi hành: 15/11/2025 • 50 khách</div>
                        </div>
                        <span class="tour-status status-completed">Hoàn thành</span>
                    </li>
                    <li class="tour-item">
                        <div class="tour-info">
                            <div class="tour-name">Tour Miền Tây Sông Nước 2N1Đ</div>
                            <div class="tour-meta">Khởi hành: 02/12/2025 • 20 khách</div>
                        </div>
                        <span class="tour-status status-active">Đang hoạt động</span>
                    </li>
                </ul>
            </div>
            
            <!-- Quick Actions -->
            <div class="card">
                <h2>Thao Tác Nhanh</h2>
                <div class="quick-actions">
                    <a href="index.php?action=tour_create" class="action-btn btn-primary">➕ Tạo Tour Mới</a>
                    <a href="index.php?action=tour_index" class="action-btn btn-success">🎯 Quản Lý Tour</a>
                    <a href="index.php?action=supplier_index" class="action-btn btn-info">🏢 Quản Lý Nhà Cung Cấp</a>
                    
                    <a href="index.php?action=dashboard" class="action-btn btn-warning">📊 Dashboard</a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
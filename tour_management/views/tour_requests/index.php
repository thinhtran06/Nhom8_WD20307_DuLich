<?php require_once 'views/layout/header.php'; ?>

<div class="container">
    
    <h1>💡 Quản Lý Tour Theo Yêu Cầu</h1>
    <p class="lead">Trang này liệt kê các yêu cầu tour tùy chỉnh được khách hàng gửi đến. Bạn có thể xem chi tiết, báo giá và chuyển đổi chúng thành tour chính thức.</p>
    <div class="d-flex justify-content-between align-items-center mb-3">
        
        <a href="index.php?action=tour_request_create" class="btn btn-primary">
            ➕ Tạo Yêu Cầu Mới
        </a>
    </div>
    
    <?php if(isset($_GET['message'])): ?>
        <div class="alert alert-success"><?php echo htmlspecialchars($_GET['message']); ?></div>
    <?php endif; ?>

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Tên Khách hàng</th>
                <th>Điện thoại</th>
                <th>Ngày khởi hành mong muốn</th>
                <th>Số lượng khách</th>
                <th>Điểm đến</th>
                <th>Trạng thái</th>
                <th>Ngày gửi Yêu cầu</th>
                <th>Thao tác</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            if (isset($requests) && is_array($requests) && !empty($requests)): 
            ?>
                <?php foreach($requests as $request): 
                    $status = htmlspecialchars($request['trang_thai'] ?? 'Mới');
                    $badgeClass = 'badge-secondary';
                    if ($status == 'Mới') $badgeClass = 'badge-primary';
                    if ($status == 'Đang xử lý') $badgeClass = 'badge-warning';
                    if ($status == 'Đã báo giá') $badgeClass = 'badge-success';
                ?>
                <tr>
                    <td><?php echo htmlspecialchars($request['id']); ?></td>
                    <td><?php echo htmlspecialchars($request['ten_khach_hang']); ?></td>
                    <td><?php echo htmlspecialchars($request['dien_thoai']); ?></td>
                    <td>
                        <?php 
                        // Lấy giá trị ngày tháng từ DB
                        $date = $request['ngay_khoi_hanh_mong_luon']; 
                        
                        // Kiểm tra: Nếu là NULL, rỗng, hoặc chứa chuỗi '0000' (giá trị lỗi)
                        if (empty($date) || strpos($date, '0000') !== false) {
                            echo 'N/A';
                        } else {
                            // Định dạng ngày tháng
                            // Sử dụng strtotime() để xử lý cả kiểu DATE và DATETIME
                            echo htmlspecialchars(date('d/m/Y', strtotime($date))); 
                        }
                        ?>
                    </td>
                    <td><?php echo htmlspecialchars($request['so_luong_khach']); ?></td>
                    <td><?php echo htmlspecialchars($request['diem_den_mong_muon']); ?></td>
                    <td><span class="badge <?php echo $badgeClass; ?>"><?php echo $status; ?></span></td>
                    <td><?php echo htmlspecialchars(date('d/m/Y', strtotime($request['ngay_tao']))); ?></td>
                    <td>
                        <a href="index.php?action=tour_request_show&id=<?php echo $request['id']; ?>" class="btn btn-sm btn-info">Xem/Báo giá</a>
                        <a href="index.php?action=tour_request_destroy&id=<?php echo $request['id']; ?>" 
                            onclick="return confirm('Xóa yêu cầu này?')" 
                            class="btn btn-sm btn-danger">Xóa</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="9" class="text-center">Hiện chưa có yêu cầu tour tùy chỉnh nào.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
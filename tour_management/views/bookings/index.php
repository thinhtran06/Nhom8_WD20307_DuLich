<?php 
// Giả định: các tệp layout/header.php, layout/footer.php đã tồn tại
include 'views/layout/header.php'; 
?>

<div class="container-fluid " style="margin-top: 16px;">
    <h2>🎫 Quản Lý Đặt Chỗ</h2>
    <p>Tổng cộng có **<?php echo count($bookings); ?>** đơn đặt chỗ.</p>

    <?php if (isset($_GET['msg'])): ?>
        <div class="alert alert-success"><?php echo htmlspecialchars($_GET['msg']); ?></div>
    <?php endif; ?>
    <?php if (isset($_GET['error'])): ?>
        <div class="alert alert-danger"><?php echo htmlspecialchars($_GET['error']); ?></div>
    <?php endif; ?>

    <a href="index.php?action=booking_create" class="btn btn-primary mb-3">
        <i class="fas fa-plus"></i> Thêm Đặt Chỗ Mới
    </a>

    <div class="table-responsive">
        <table class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Mã Đơn</th>
                    <th>Tour</th>
                    <th>Khách Hàng</th>
                    <th>Ngày Đặt</th>
                    <th>Tổng Tiền</th>
                    <th>Trạng Thái</th>
                    <th>Hành Động</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($bookings)): ?>
                    <tr><td colspan="8" class="text-center">Chưa có đơn đặt chỗ nào.</td></tr>
                <?php else: ?>
                    <?php foreach ($bookings as $booking): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($booking['id'] ?? ''); ?></td> 
                        
                        <td><?php echo htmlspecialchars($booking['ma_dat_tour'] ?? ''); ?></td>
                        <td><?php echo htmlspecialchars($booking['ten_tour'] ?? ''); ?></td>
                        <td><?php echo htmlspecialchars($booking['customer_name'] ?? ''); ?></td>
                        
                        <td>
                            <?php 
                            // Kiểm tra và định dạng ngày tháng an toàn
                            $ngay_dat = $booking['ngay_dat'] ?? null;
                            if ($ngay_dat) {
                                echo date('d/m/Y', strtotime($ngay_dat));
                            } else {
                                echo 'N/A';
                            }
                            ?>
                        </td>
                        
                        <td><?php echo number_format($booking['tong_tien'] ?? 0); ?> VNĐ</td>
                        
                        <td><span class="badge 
                            <?php 
                            $trang_thai = $booking['trang_thai'] ?? '';
                            if ($trang_thai == 'Đã xác nhận') echo 'bg-success';
                            else if ($trang_thai == 'Đang chờ') echo 'bg-warning text-dark';
                            else echo 'bg-danger';
                            ?>">
                            <?php echo htmlspecialchars($trang_thai); ?>
                        </span></td>
                        
                        <td>
                            <a href="index.php?action=booking_show&id=<?php echo $booking['id'] ?? ''; ?>" class="btn btn-sm btn-info" title="Chi tiết"><i class="fas fa-eye"></i></a>
                            <a href="index.php?action=booking_edit&id=<?php echo $booking['id'] ?? ''; ?>" class="btn btn-sm btn-warning" title="Sửa"><i class="fas fa-edit"></i></a>
                            
                            <form method="POST" action="index.php?action=booking_delete&id=<?php echo $booking['id'] ?? ''; ?>" style="display:inline;" onsubmit="return confirm('Bạn có chắc chắn muốn xóa đơn đặt chỗ này không?');">
                                <button type="submit" class="btn btn-sm btn-danger" title="Xóa"><i class="fas fa-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include 'views/layout/footer.php'; ?>
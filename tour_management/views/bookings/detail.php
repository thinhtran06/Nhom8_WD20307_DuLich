<?php 
include 'views/layout/header.php'; 
// Giả định: $booking đã được truyền từ BookingController::show()
?>

<div class="container-fluid" style="margin-top: 16px;">
    <h2>👁️ Chi Tiết Đặt Chỗ: <?php echo htmlspecialchars($booking['ma_dat_tour']); ?></h2>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Thông Tin Chung</h6>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <p><strong>Mã Đơn:</strong> <?php echo htmlspecialchars($booking['ma_dat_tour']); ?></p>
                    <p><strong>Tour:</strong> <?php echo htmlspecialchars($booking['ten_tour']); ?></p>
                    <p><strong>Ngày Đặt:</strong> <?php echo date('d/m/Y H:i:s', strtotime($booking['ngay_dat'])); ?></p>
                    <p><strong>Khách Hàng:</strong> <?php echo htmlspecialchars($booking['customer_name']); ?></p>
                </div>
                <div class="col-md-6">
                    <p><strong>Trạng Thái:</strong> 
                        <span class="badge 
                            <?php 
                            if ($booking['trang_thai'] == 'Đã xác nhận') echo 'bg-success';
                            else if ($booking['trang_thai'] == 'Đang chờ') echo 'bg-warning text-dark';
                            else echo 'bg-danger';
                            ?>">
                            <?php echo htmlspecialchars($booking['trang_thai']); ?>
                        </span>
                    </p>
                    <p><strong>Người Tạo Đơn (ID):</strong> <?php echo htmlspecialchars($booking['user_id'] ?? 'Hệ thống/Khách hàng'); ?></p>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Chi Tiết Thanh Toán & Số Lượng</h6>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <p><strong>Số Người Lớn:</strong> <?php echo htmlspecialchars($booking['so_nguoi_lon']); ?></p>
                    <p><strong>Số Trẻ Em:</strong> <?php echo htmlspecialchars($booking['so_tre_em']); ?></p>
                    <p><strong>Tổng Cộng:</strong> <?php echo htmlspecialchars($booking['so_nguoi_lon'] + $booking['so_tre_em']); ?> khách</p>
                </div>
                <div class="col-md-6">
                    <p><strong>Tổng Tiền:</strong> <span class="text-danger fw-bold"><?php echo number_format($booking['tong_tien']); ?> VNĐ</span></p>
                    <p><strong>Đã Thanh Toán:</strong> 
                        <?php if ($booking['da_thanh_toan'] == 1): ?>
                            <span class="badge bg-success">Đã Thanh Toán Đủ</span>
                        <?php else: ?>
                            <span class="badge bg-warning text-dark">Chưa Thanh Toán Đủ</span>
                        <?php endif; ?>
                    </p>
                </div>
            </div>
        </div>
    </div>
    
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Ghi Chú</h6>
        </div>
        <div class="card-body">
            <p><?php echo nl2br(htmlspecialchars($booking['ghi_chu'] ?? 'Không có ghi chú.')); ?></p>
        </div>
    </div>

    <div class="mt-4">
        <a href="index.php?action=booking_edit&id=<?php echo $booking['id']; ?>" class="btn btn-warning"><i class="fas fa-edit"></i> Sửa Đặt Chỗ</a>
        <a href="index.php?action=booking_index" class="btn btn-secondary">Quay Lại Danh Sách</a>
    </div>

</div>

<?php include 'views/layout/footer.php'; ?>
<?php 
include 'views/layout/header.php'; 
// Giả định: $booking (chi tiết đặt chỗ) và $tours (danh sách tour) đã được truyền từ BookingController::edit()
?>

<div class="container-fluid" style="margin-top: 16px;">
    <h2>✏️ Chỉnh Sửa Đặt Chỗ: <?php echo htmlspecialchars($booking['ma_dat_tour']); ?></h2>
    
    <?php if (isset($_GET['error'])): ?>
        <div class="alert alert-danger"><?php echo htmlspecialchars($_GET['error']); ?></div>
    <?php endif; ?>

    <form action="index.php?action=booking_update&id=<?php echo $booking['id']; ?>" method="POST">
        
        <div class="mb-3">
            <label for="tour_id" class="form-label">Chọn Tour</label>
            <select class="form-select" id="tour_id" name="tour_id" required>
                <option value="">-- Chọn Tour --</option>
                <?php foreach ($tours as $tour): ?>
                    <option value="<?php echo $tour['id']; ?>" 
                        <?php echo ($tour['id'] == $booking['tour_id']) ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($tour['ten_tour']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        
        <div class="mb-3">
            <label for="customer_id" class="form-label">ID Khách Hàng</label>
            <input type="number" class="form-control" id="customer_id" name="customer_id" 
                   value="<?php echo htmlspecialchars($booking['customer_id']); ?>" required readonly>
            <div class="form-text">Khách hàng: **<?php echo htmlspecialchars($booking['customer_name']); ?>**</div>
        </div>
        
        <div class="row">
            <div class="col-md-4 mb-3">
                <label for="so_nguoi_lon" class="form-label">Số Người Lớn</label>
                <input type="number" class="form-control" id="so_nguoi_lon" name="so_nguoi_lon" 
                       value="<?php echo htmlspecialchars($booking['so_nguoi_lon']); ?>" min="1" required>
            </div>
            <div class="col-md-4 mb-3">
                <label for="so_tre_em" class="form-label">Số Trẻ Em</label>
                <input type="number" class="form-control" id="so_tre_em" name="so_tre_em" 
                       value="<?php echo htmlspecialchars($booking['so_tre_em']); ?>" min="0" required>
            </div>
            <div class="col-md-4 mb-3">
                <label for="tong_tien" class="form-label">Tổng Tiền (VNĐ)</label>
                <input type="number" class="form-control" id="tong_tien" name="tong_tien" step="1000" 
                       value="<?php echo htmlspecialchars($booking['tong_tien']); ?>" required>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="trang_thai" class="form-label">Trạng Thái</label>
                <select class="form-select" id="trang_thai" name="trang_thai" required>
                    <?php 
                    $statuses = ['Đã xác nhận', 'Đang chờ', 'Đã hủy'];
                    foreach ($statuses as $status):
                    ?>
                        <option value="<?php echo $status; ?>" 
                            <?php echo ($status == $booking['trang_thai']) ? 'selected' : ''; ?>>
                            <?php echo $status; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-6 mb-3">
                <label for="da_thanh_toan" class="form-label">Đã Thanh Toán</label>
                <select class="form-select" id="da_thanh_toan" name="da_thanh_toan" required>
                    <option value="1" <?php echo ($booking['da_thanh_toan'] == 1) ? 'selected' : ''; ?>>Đã thanh toán đủ</option>
                    <option value="0" <?php echo ($booking['da_thanh_toan'] == 0) ? 'selected' : ''; ?>>Chưa/Thanh toán một phần</option>
                </select>
            </div>
        </div>

        <div class="mb-3">
            <label for="ghi_chu" class="form-label">Ghi Chú</label>
            <textarea class="form-control" id="ghi_chu" name="ghi_chu" rows="3"><?php echo htmlspecialchars($booking['ghi_chu']); ?></textarea>
        </div>

        <button type="submit" class="btn btn-warning">Cập Nhật Đặt Chỗ</button>
        <a href="index.php?action=booking_show&id=<?php echo $booking['id']; ?>" class="btn btn-secondary">Hủy</a>
    </form>
</div>

<?php include 'views/layout/footer.php'; ?>
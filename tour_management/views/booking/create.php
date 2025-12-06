<?php 
// views/booking/create.php
// $tours: danh sách tours
// $customers: danh sách khách hàng
// $error_message: thông báo lỗi
// $success_message: thông báo thành công (từ controller)

include 'views/layout/header.php';
?>

<div class="container mt-4">
    <h1>Tạo Booking Mới</h1>
    <a href="index.php?action=booking_index" class="btn btn-secondary mb-3">
        <i class="fas fa-arrow-left"></i> Quay lại danh sách
    </a>

    <?php 
    // Hiển thị thông báo thành công (Đã được controller gán vào $success_message)
    if (isset($success_message)): ?>
        <div class="alert alert-success"><?php echo htmlspecialchars($success_message); ?></div>
    <?php endif; ?>

    <?php if (isset($error_message)): ?>
        <div class="alert alert-danger"><?php echo htmlspecialchars($error_message); ?></div>
    <?php endif; ?>

    <div class="card card-body shadow">
        <form action="index.php?action=booking_create" method="POST">
            <div class="row">
                
                <div class="col-md-6 mb-3">
                    <label for="tour_id" class="form-label">Tour (*)</label>
                    <select name="tour_id" id="tour_id" class="form-control" required>
                        <option value="">-- Chọn Tour --</option>
                        <?php 
                        // Giả định $tours là PDOStatement. Sử dụng ->fetch() an toàn.
                        if ($tours && $tours->rowCount() > 0):
                            while ($tour = $tours->fetch(PDO::FETCH_ASSOC)):
                        ?>
                            <option value="<?php echo htmlspecialchars($tour['id']); ?>">
                                <?php echo htmlspecialchars($tour['ten_tour']); ?> (ID: <?php echo htmlspecialchars($tour['id']); ?>)
                            </option>
                        <?php 
                            endwhile;
                        endif;
                        ?>
                    </select>
                </div>
                
                <div class="col-md-6 mb-3">
                    <label for="customer_id" class="form-label">Khách Hàng (*)</label>
                    <select name="customer_id" id="customer_id" class="form-control" required>
                        <option value="">-- Chọn Khách Hàng --</option>
                        <?php 
                        // Giả định $customers là PDOStatement. Sử dụng ->fetch() an toàn.
                        if ($customers && $customers->rowCount() > 0):
                            while ($customer = $customers->fetch(PDO::FETCH_ASSOC)):
                        ?>
                            <option value="<?php echo htmlspecialchars($customer['id']); ?>">
                                <?php echo htmlspecialchars($customer['ho_ten']); ?> (ID: <?php echo htmlspecialchars($customer['id']); ?>)
                            </option>
                        <?php 
                            endwhile;
                        endif;
                        ?>
                    </select>
                </div>

                <div class="col-md-4 mb-3">
                    <label for="ngay_dat" class="form-label">Ngày Đặt/Khởi hành (*)</label>
                    <input type="date" name="ngay_dat" id="ngay_dat" class="form-control" value="<?php echo date('Y-m-d'); ?>" required>
                </div>
                
                <div class="col-md-4 mb-3">
                    <label for="so_nguoi_lon" class="form-label">Số Người Lớn (*)</label>
                    <input type="number" name="so_nguoi_lon" id="so_nguoi_lon" class="form-control" min="1" value="1" required>
                </div>
                
                <div class="col-md-4 mb-3">
                    <label for="so_tre_em" class="form-label">Số Trẻ Em</label>
                    <input type="number" name="so_tre_em" id="so_tre_em" class="form-control" min="0" value="0">
                </div>
                
                <div class="col-md-4 mb-3">
                    <label for="loai_khach" class="form-label">Loại Khách</label>
                    <select name="loai_khach" id="loai_khach" class="form-control">
                        <option value="Khách lẻ">Khách lẻ</option>
                        <option value="Khách đoàn">Khách đoàn</option>
                        <option value="VIP">VIP</option>
                    </select>
                </div>

                <div class="col-md-4 mb-3">
                    <label for="da_thanh_toan" class="form-label">Đã Thanh Toán (VNĐ)</label>
                    <input type="number" name="da_thanh_toan" id="da_thanh_toan" class="form-control" min="0" value="0">
                    <small class="form-text text-muted">Số tiền khách đã trả ban đầu. Tổng tiền sẽ được tính tự động.</small>
                </div>
                
                <div class="col-md-4 mb-3">
                    <label for="trang_thai" class="form-label">Trạng Thái</label>
                    <select name="trang_thai" id="trang_thai" class="form-control">
                        <option value="Chờ xác nhận" selected>Chờ xác nhận</option>
                        <option value="Đã xác nhận">Đã xác nhận</option>
                        <option value="Đã hủy">Đã hủy</option>
                    </select>
                </div>
                
                <div class="col-md-12 mb-3">
                    <label for="ghi_chu" class="form-label">Ghi Chú</label>
                    <textarea name="ghi_chu" id="ghi_chu" class="form-control" rows="3"></textarea>
                </div>
                
            </div>
            
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> Lưu Booking
            </button>
        </form>
    </div>
</div>

<?php include 'views/layout/footer.php'; ?>
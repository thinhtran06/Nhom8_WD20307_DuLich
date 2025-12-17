<?php
// views/booking/create.php
// Giả định $tours và $customers là các đối tượng PDOStatement được truyền từ Controller

require_once 'views/layout/header.php';
?>

<div class="container mt-5 p-2">
    <h1>Tạo Booking Mới</h1>
    <a href="index.php?action=booking_index" class="btn btn-secondary mb-4">
        <i class="fas fa-arrow-left"></i> Quay lại danh sách
    </a>

    <?php if (isset($success_message)): ?>
        <div class="alert alert-success"><i class="fas fa-check-circle"></i> <?php echo htmlspecialchars($success_message); ?></div>
    <?php endif; ?>

    <?php if (isset($error_message)): ?>
        <div class="alert alert-danger"><i class="fas fa-times-circle"></i> <?php echo htmlspecialchars($error_message); ?></div>
    <?php endif; ?>

    <div class="card card-body shadow">
        <form action="index.php?action=booking_create" method="POST">
            <h4 class="mb-3 text-primary"><i class="fas fa-info-circle"></i> Thông Tin Cơ Bản</h4>
            <div class="row">

                <div class="col-md-6 mb-3">
                    <label for="tour_id" class="form-label">Tour (*)</label>
                    <select name="tour_id" id="tour_id" class="form-control" required>
                        <option value="">-- Chọn Tour --</option>
                        <?php
                        // Giả định $tours là PDOStatement
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
                    <label for="customer_id" class="form-label">Khách Hàng Đại Diện (*)</label>
                    <select name="customer_id" id="customer_id" class="form-control" required>
                        <option value="">-- Chọn Khách Hàng --</option>
                        <?php
                        // Giả định $customers là PDOStatement
                        if ($customers && $customers->rowCount() > 0):
                            // Dùng fetchAll() rồi lặp lại để giữ PDOStatement cho các mục đích khác (nếu cần)
                            $customerList = $customers->fetchAll(PDO::FETCH_ASSOC);
                            foreach ($customerList as $customer):
                        ?>
                                <option value="<?php echo htmlspecialchars($customer['id']); ?>">
                                    <?php echo htmlspecialchars($customer['ho_ten']); ?> (ID: <?php echo htmlspecialchars($customer['id']); ?>)
                                </option>
                        <?php
                            endforeach;
                        endif;
                        ?>
                    </select>
                </div>

                <div class="col-md-4 mb-3">
                    <label for="ngay_dat" class="form-label">Ngày Khởi hành (*)</label>
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

                <div class="col-12 mb-4">
                    <div class="alert alert-info py-2">
                        <i class="fas fa-users"></i> **Tổng số khách:** Hệ thống sẽ tự động tạo **<?php echo isset($customerList) ? count($customerList) : 'N+1'; ?>** bản ghi khách hàng cá nhân (`tour_customers`) bằng tổng số Người Lớn và Trẻ Em, cộng với khách Đại diện.
                    </div>
                </div>

                <h4 class="mb-3 mt-3 text-primary"><i class="fas fa-wallet"></i> Tài Chính & Trạng Thái</h4>

                <div class="col-md-4 mb-3">
                    <label for="loai_khach" class="form-label">Loại Khách</label>
                    <select name="loai_khach" id="loai_khach" class="form-control">
                        <option value="Khách lẻ" selected>Khách lẻ</option>
                        <option value="Khách đoàn">Khách đoàn</option>
                        <option value="VIP">VIP</option>
                    </select>
                </div>

                <div class="col-md-4 mb-3">
                    <label for="da_thanh_toan" class="form-label">Đã Thanh Toán (VNĐ)</label>
                    <input type="number" name="da_thanh_toan" id="da_thanh_toan" class="form-control" min="0" value="0">
                    <small class="form-text text-muted">Số tiền khách đã trả ban đầu. Tổng tiền sẽ được tính tự động sau.</small>
                </div>

                <div class="col-md-4 mb-3">
                    <label for="trang_thai" class="form-label">Trạng Thái (*)</label>
                    <select name="trang_thai" id="trang_thai" class="form-control">
                        <option value="Chờ xác nhận" selected>Chờ xác nhận</option>
                        <option value="Đã xác nhận">Đã xác nhận</option>
                        <option value="Đã hủy">Đã hủy</option>
                    </select>
                </div>

                <div class="col-md-12 mb-4">
                    <label for="ghi_chu" class="form-label">Ghi Chú</label>
                    <textarea name="ghi_chu" id="ghi_chu" class="form-control" rows="3"></textarea>
                </div>
            </div>

            <button type="submit" class="btn btn-primary btn-lg">
                <i class="fas fa-save"></i> Lưu Booking
            </button>
        </form>
    </div>
</div>

<?php
require_once 'views/layout/footer.php';
?>
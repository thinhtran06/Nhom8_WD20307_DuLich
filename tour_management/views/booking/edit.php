<?php 
// views/booking/edit.php
// $booking: Mảng dữ liệu booking hiện tại
// $tours: danh sách tours
// $customers: danh sách khách hàng
// $error_message: thông báo lỗi
// $success_message: thông báo thành công (từ controller)

include 'views/layout/header.php';
?>

<div class="container mb-5" style="margin-top: 80px;">
    <h1>Chỉnh Sửa Booking Mã: <?php echo htmlspecialchars($booking['ma_dat_tour'] ?? 'N/A'); ?></h1>
    <a href="index.php?action=booking_index" class="btn btn-secondary mb-3">
        <i class="fas fa-arrow-left"></i> Quay lại danh sách
    </a>

    <?php 
    if (isset($success_message)): ?>
        <div class="alert alert-success"><?php echo htmlspecialchars($success_message); ?></div>
    <?php endif; ?>

    <?php if (isset($error_message)): ?>
        <div class="alert alert-danger"><?php echo htmlspecialchars($error_message); ?></div>
    <?php endif; ?>

    <div class="card card-body shadow">
        <form action="index.php?action=booking_edit&id=<?php echo $booking['id']; ?>" method="POST">
            <div class="row">
                
                <div class="col-md-6 mb-3">
                    <label for="tour_id" class="form-label">Tour (*)</label>
                    <select name="tour_id" id="tour_id" class="form-control" required>
                        <option value="">-- Chọn Tour --</option>
                        <?php 
                        if ($tours && $tours->rowCount() > 0):
                            $current_tour_id = $booking['tour_id'] ?? null;
                            while ($tour = $tours->fetch(PDO::FETCH_ASSOC)):
                        ?>
                            <option value="<?php echo htmlspecialchars($tour['id']); ?>"
                                <?php echo ($current_tour_id == $tour['id']) ? 'selected' : ''; ?>>
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
                        if ($customers && $customers->rowCount() > 0):
                            $current_customer_id = $booking['customer_id'] ?? null;
                            while ($customer = $customers->fetch(PDO::FETCH_ASSOC)):
                        ?>
                            <option value="<?php echo htmlspecialchars($customer['id']); ?>"
                                <?php echo ($current_customer_id == $customer['id']) ? 'selected' : ''; ?>>
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
                    <input type="date" name="ngay_dat" id="ngay_dat" class="form-control" 
                           value="<?php echo htmlspecialchars($booking['ngay_dat'] ?? ''); ?>" required>
                </div>
                
                <div class="col-md-4 mb-3">
                    <label for="so_nguoi_lon" class="form-label">Số Người Lớn (*)</label>
                    <input type="number" name="so_nguoi_lon" id="so_nguoi_lon" class="form-control" min="1" 
                           value="<?php echo htmlspecialchars($booking['so_nguoi_lon'] ?? 1); ?>" required>
                </div>
                
                <div class="col-md-4 mb-3">
                    <label for="so_tre_em" class="form-label">Số Trẻ Em</label>
                    <input type="number" name="so_tre_em" id="so_tre_em" class="form-control" min="0" 
                           value="<?php echo htmlspecialchars($booking['so_tre_em'] ?? 0); ?>">
                </div>
                
                <div class="col-md-4 mb-3">
                    <label for="tong_tien" class="form-label">Tổng Tiền (*)</label>
                    <input type="number" step="0.01" name="tong_tien" id="tong_tien" class="form-control" min="0" 
                           value="<?php echo htmlspecialchars($booking['tong_tien'] ?? 0); ?>" required>
                    <small class="form-text text-muted">Phải nhập hoặc tính toán trước khi lưu.</small>
                </div>

                <div class="col-md-4 mb-3">
                    <label for="da_thanh_toan" class="form-label">Đã Thanh Toán (VNĐ)</label>
                    <input type="number" step="0.01" name="da_thanh_toan" id="da_thanh_toan" class="form-control" min="0" 
                           value="<?php echo htmlspecialchars($booking['da_thanh_toan'] ?? 0); ?>">
                </div>
                
                <div class="col-md-4 mb-3">
                    <label class="form-label">Còn Lại (VNĐ)</label>
                    <input type="text" class="form-control" disabled 
                           value="<?php echo number_format($booking['con_lai'] ?? 0, 0, ',', '.'); ?>">
                    <small class="form-text text-muted">Tự động tính toán (Tổng tiền - Đã TT).</small>
                </div>
                
                <div class="col-md-4 mb-3">
                    <label for="loai_khach" class="form-label">Loại Khách</label>
                    <select name="loai_khach" id="loai_khach" class="form-control">
                        <?php 
                            $options = ['Khách lẻ', 'Khách đoàn', 'VIP'];
                            $current_loai_khach = $booking['loai_khach'] ?? 'Khách lẻ';
                            foreach ($options as $opt):
                        ?>
                            <option value="<?php echo $opt; ?>" 
                                <?php echo ($current_loai_khach == $opt) ? 'selected' : ''; ?>>
                                <?php echo $opt; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                
                <div class="col-md-4 mb-3">
                    <label for="trang_thai" class="form-label">Trạng Thái</label>
                    <select name="trang_thai" id="trang_thai" class="form-control">
                        <?php 
                            $statuses = ['Chờ xác nhận', 'Đã xác nhận', 'Đã hủy', 'Đã hoàn thành'];
                            $current_trang_thai = $booking['trang_thai'] ?? 'Chờ xác nhận';
                            foreach ($statuses as $status):
                        ?>
                            <option value="<?php echo $status; ?>" 
                                <?php echo ($current_trang_thai == $status) ? 'selected' : ''; ?>>
                                <?php echo $status; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                
                <div class="col-md-12 mb-3">
                    <label for="ghi_chu" class="form-label">Ghi Chú</label>
                    <textarea name="ghi_chu" id="ghi_chu" class="form-control" rows="3"><?php echo htmlspecialchars($booking['ghi_chu'] ?? ''); ?></textarea>
                </div>
                
            </div>
            
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-sync-alt"></i> Cập Nhật Booking
            </button>
        </form>
    </div>
</div>

<?php include 'views/layout/footer.php'; ?>
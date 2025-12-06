<?php 
// views/booking/attendance.php

// Dữ liệu cần có từ Controller:
// $booking: Mảng thông tin Booking (id, ma_dat_tour, so_nguoi_lon, so_tre_em, tong_so_khach, trang_thai_booking)
// $attendance_history: Mảng chứa lịch sử điểm danh (ngay_hoat_dong, ten_hoat_dong, trang_thai_nhom, chi_tiet)
// $success_message, $error_message: Các thông báo nếu có

include 'views/layout/header.php'; // Giả định
?>

<div class="container mt-4">
    <h1><i class="fas fa-clipboard-check"></i> Điểm Danh Hoạt Động - Mã Booking: <?php echo htmlspecialchars($booking['ma_dat_tour'] ?? 'N/A'); ?></h1>
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

    <div class="card card-body bg-light mb-4">
        <h5>Thông tin Booking</h5>
        <p class="mb-1">
            <strong>Tổng số khách đã đăng ký:</strong> 
            <span class="badge bg-primary fs-6"><?php echo htmlspecialchars($booking['tong_so_khach'] ?? 0); ?></span> người 
            (Lớn: <?php echo htmlspecialchars($booking['so_nguoi_lon'] ?? 0); ?>, Trẻ em: <?php echo htmlspecialchars($booking['so_tre_em'] ?? 0); ?>)
        </p>
        <p>
            <strong>Trạng thái Booking:</strong> 
            <span class="badge bg-info"><?php echo htmlspecialchars($booking['trang_thai_booking'] ?? 'N/A'); ?></span>
        </p>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="card shadow-sm border-warning mb-4">
                <div class="card-header bg-warning text-white">
                    <h5 class="mb-0">Điểm Danh Hoạt Động Mới</h5>
                </div>
                <div class="card-body">
                    <form action="index.php?action=booking_attendance&id=<?php echo $booking['id'] ?? 0; ?>" method="POST">
                        
                        <div class="mb-3">
                            <label for="ngay_hoat_dong" class="form-label">Ngày Hoạt Động</label>
                            <input type="date" name="ngay_hoat_dong" id="ngay_hoat_dong" class="form-control" value="<?php echo date('Y-m-d'); ?>" required>
                        </div>
                        
                        <div class="mb-3">
                            <label for="ten_hoat_dong" class="form-label">Tên Hoạt Động/Mốc Điểm Danh (*)</label>
                            <input type="text" name="ten_hoat_dong" id="ten_hoat_dong" class="form-control" placeholder="VD: Ngày 1: Tập trung Sân bay" required>
                        </div>
                        
                        <div class="mb-3">
                            <label for="trang_thai_nhom" class="form-label">Trạng Thái Nhóm (*)</label>
                            <select name="trang_thai_nhom" id="trang_thai_nhom" class="form-control" required>
                                <option value="Đủ">Đủ (Tất cả khách đều có mặt)</option>
                                <option value="Thiếu">Thiếu (Vắng một vài khách)</option>
                                <option value="Vắng mặt (No Show)">Vắng mặt (Không khách nào đến)</option>
                                <option value="Không áp dụng">Không áp dụng (Hoạt động không bắt buộc)</option>
                            </select>
                        </div>
                        
                        <div class="mb-3">
                            <label for="chi_tiet" class="form-label">Chi Tiết / Ghi Chú (Nếu Thiếu)</label>
                            <textarea name="chi_tiet" id="chi_tiet" class="form-control" rows="3" placeholder="Ghi rõ số lượng khách vắng mặt, tên khách (nếu nhớ), hoặc lý do"></textarea>
                        </div>
                        
                        <button type="submit" class="btn btn-warning w-100">
                            <i class="fas fa-save"></i> Lưu Điểm Danh
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card shadow-sm border-info">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0">Lịch Sử Điểm Danh</h5>
                </div>
                <div class="card-body p-0">
                    <?php if (isset($attendance_history) && is_array($attendance_history) && count($attendance_history) > 0): ?>
                        <table class="table table-striped table-sm mb-0">
                            <thead>
                                <tr>
                                    <th>Ngày</th>
                                    <th>Hoạt Động</th>
                                    <th>Trạng Thái</th>
                                    <th>Ghi Chú</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($attendance_history as $log): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars(date('d/m/Y', strtotime($log['ngay_hoat_dong'] ?? ''))); ?></td>
                                    <td><?php echo htmlspecialchars($log['ten_hoat_dong'] ?? 'N/A'); ?></td>
                                    <td><span class="badge bg-<?php 
                                        $status = $log['trang_thai_nhom'] ?? '';
                                        if ($status == 'Đủ') echo 'success';
                                        elseif ($status == 'Thiếu') echo 'warning';
                                        else echo 'danger';
                                    ?>"><?php echo htmlspecialchars($status); ?></span></td>
                                    <td><?php echo nl2br(htmlspecialchars($log['chi_tiet'] ?? '')); ?></td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    <?php else: ?>
                        <p class="p-3 text-center text-muted">Chưa có lịch sử điểm danh cho Booking này.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'views/layout/footer.php'; ?>
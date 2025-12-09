<?php 
// views/booking/index.php
// $bookings: danh sách booking từ BookingController->index()
// $message: thông báo (nếu có)
include 'views/layout/header.php';
?>

<div class="container" style="margin-top: 100px;">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Quản Lý Đặt Tour (Bookings)</h1>
        <a href="index.php?action=booking_create" class="btn btn-success">
            <i class="fas fa-plus"></i> Tạo Booking Mới
        </a>
    </div>
    
    <?php // Xóa bỏ nút Điểm danh bị đặt sai vị trí ở đây ?>

    <?php if (isset($message)): ?>
        <div class="alert alert-success"><?php echo htmlspecialchars($message); ?></div>
    <?php endif; ?>

    <?php if ($bookings->rowCount() > 0): ?>
        <div class="table-responsive">
            <table class="table table-bordered table-hover table-sm align-middle">
                <thead class="thead-dark">
                    <tr>
                        <th>ID</th>
                        <th>Mã Booking</th>
                        <th>Tên Tour</th>
                        <th>Tên Khách Hàng</th>
                        <th>Ngày Đặt</th>
                        <th>SL Khách</th>
                        <th>Tổng Tiền (VNĐ)</th>
                        <th>Đã TT (VNĐ)</th>
                        <th>Còn Lại (VNĐ)</th>
                        <th>Trạng Thái</th>
                        <th>Thao Tác</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    // Định nghĩa các trạng thái có thể có
                    $statuses = ['Chờ xác nhận', 'Đã xác nhận', 'Đã hủy', 'Đã hoàn thành'];
                    
                    while ($booking = $bookings->fetch(PDO::FETCH_ASSOC)): 
                        // Tính toán và định dạng số tiền
                        $tong_khach = (int)$booking['so_nguoi_lon'] + (int)$booking['so_tre_em'];
                        $tong_tien = number_format($booking['tong_tien'], 0, ',', '.');
                        $da_thanh_toan = number_format($booking['da_thanh_toan'], 0, ',', '.');
                        $con_lai_val = (float)$booking['con_lai'];
                        $con_lai = number_format($con_lai_val, 0, ',', '.');
                    ?>
                        <tr>
                            <td><?php echo htmlspecialchars($booking['id']); ?></td>
                            <td><?php echo htmlspecialchars($booking['ma_dat_tour']); ?></td>
                            <td><?php echo htmlspecialchars($booking['ten_tour'] ?? 'N/A'); ?></td> 
                            <td><?php echo htmlspecialchars($booking['ho_ten'] ?? 'N/A'); ?></td>
                            <td><?php echo htmlspecialchars(date('d/m/Y', strtotime($booking['ngay_dat']))); ?></td>
                            <td><?php echo htmlspecialchars($tong_khach); ?></td>
                            <td><?php echo $tong_tien; ?></td> 
                            <td><?php echo $da_thanh_toan; ?></td> 
                            <td class="<?php echo ($con_lai_val > 0) ? 'text-danger fw-bold' : 'text-success'; ?>">
                                <?php echo $con_lai; ?>
                            </td> 
                            
                            <td>
                                <form action="index.php?action=booking_update_status&id=<?php echo $booking['id']; ?>" method="POST" style="margin: 0; display: inline-block;">
                                    <select name="trang_thai" class="form-control form-control-sm" 
                                            onchange="this.form.submit()" style="max-width: 130px;">
                                        <?php foreach ($statuses as $status): ?>
                                            <option value="<?php echo $status; ?>" 
                                                <?php echo ($booking['trang_thai'] == $status) ? 'selected' : ''; ?>>
                                                <?php echo $status; ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </form>
                            </td>
                            
                            <td style="min-width: 250px;">
                                <a href="index.php?action=booking_attendance&id=<?php echo $booking['id']; ?>" class="btn btn-warning mb-1 me-1" title="Điểm danh hoạt động">
                                    <i class="fas fa-user-check"></i> Điểm Danh
                                </a>
                                
                                <a href="index.php?action=booking_edit&id=<?php echo $booking['id']; ?>" class="btn btn-info mb-1 me-1" title="Chỉnh sửa chi tiết Booking">
                                    <i class="fas fa-edit"></i> Sửa
                                </a>

                                <a href="index.php?action=booking_delete&id=<?php echo $booking['id']; ?>" 
                                    onclick="return confirm('Bạn có chắc chắn muốn xóa Booking này?');" 
                                    class="btn btn-danger mb-1" title="Xóa Booking">
                                    <i class="fas fa-trash"></i> Xóa
                                </a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <div class="alert alert-warning">Chưa có Booking nào trong hệ thống.</div>
    <?php endif; ?>
</div>
<

<?php include 'views/layout/footer.php'; ?>
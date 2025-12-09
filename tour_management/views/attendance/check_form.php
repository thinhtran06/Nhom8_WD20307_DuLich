<?php 
// views/attendance/check_form.php
// $tour: thông tin Tour
// $bookings_stmt: danh sách Booking đã xác nhận
// $current_attendance: mảng ['booking_id' => 'Có mặt'/'Vắng mặt']
$tour_id = $tour['id'];
$day = $_GET['day'];
?>

<div class="container mt-4">
    <h1 class="mb-4"><?php echo $page_title; ?></h1>

    <?php if (isset($_GET['message'])): ?>
        <div class="alert alert-success"><?php echo htmlspecialchars($_GET['message']); ?></div>
    <?php endif; ?>
    
    <div class="card mb-4">
        <div class="card-body">
            <p><strong>Tour:</strong> <?php echo htmlspecialchars($tour['ten_tour']); ?></p>
            <p><strong>Ngày Tour:</strong> <span class="badge badge-info">Ngày <?php echo htmlspecialchars($day); ?> / <?php echo htmlspecialchars($tour['so_ngay']); ?></span></p>
            <p><strong>Ngày khởi hành thực tế:</strong> <?php echo htmlspecialchars(date('d/m/Y', strtotime($tour['ngay_khoi_hanh'] ?? 'N/A'))); ?></p>
        </div>
    </div>

    <form method="POST" action="index.php?action=attendance_check&id=<?php echo $tour_id; ?>&day=<?php echo $day; ?>">
        <table class="table table-bordered table-hover">
            <thead class="thead-dark">
                <tr>
                    <th>ID Booking</th>
                    <th>Tên Khách Hàng</th>
                    <th>Tổng Số Khách</th>
                    <th>Trạng thái Điểm Danh</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $bookings = $bookings_stmt->fetchAll(PDO::FETCH_ASSOC);
                if (count($bookings) > 0): 
                    foreach ($bookings as $booking):
                        $booking_id = $booking['booking_id'];
                        $is_present = isset($current_attendance[$booking_id]) && $current_attendance[$booking_id] === 'Có mặt';
                        $is_absent = isset($current_attendance[$booking_id]) && $current_attendance[$booking_id] === 'Vắng mặt';
                ?>
                    <tr>
                        <td><?php echo htmlspecialchars($booking_id); ?></td>
                        <td><?php echo htmlspecialchars($booking['ho_ten']); ?></td>
                        <td><?php echo htmlspecialchars($booking['tong_khach']); ?></td>
                        <td>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" 
                                    name="diem_danh[<?php echo $booking_id; ?>]" 
                                    id="present_<?php echo $booking_id; ?>" 
                                    value="Có mặt" 
                                    <?php echo $is_present ? 'checked' : ''; ?>>
                                <label class="form-check-label text-success" for="present_<?php echo $booking_id; ?>">Có mặt</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" 
                                    name="diem_danh[<?php echo $booking_id; ?>]" 
                                    id="absent_<?php echo $booking_id; ?>" 
                                    value="Vắng mặt" 
                                    <?php echo $is_absent ? 'checked' : ''; ?>>
                                <label class="form-check-label text-danger" for="absent_<?php echo $booking_id; ?>">Vắng mặt</label>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; 
                else: ?>
                    <tr>
                        <td colspan="4" class="text-center text-danger">Không tìm thấy khách hàng đã xác nhận cho Tour này.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
        
        <?php if (count($bookings) > 0): ?>
            <button type="submit" class="btn btn-success btn-lg mt-3">Lưu Điểm Danh Ngày <?php echo $day; ?></button>
        <?php endif; ?>
    </form>
    
    <div class="mt-4">
        <a href="index.php?action=attendance_list_bookings&id=<?php echo $tour_id; ?>" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Quay lại
        </a>
    </div>
</div>
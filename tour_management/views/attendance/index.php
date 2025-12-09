<?php 
// views/attendance/index.php (ĐÃ SỬA LỖI)
// Biến được truyền từ Controller là $tour_runs
include 'views/layout/header.php';
?>



<div class="container mt-4">
    <h1 class="mb-4"><?php echo $page_title; ?></h1>

    <?php if (isset($_GET['message'])): ?>
        <div class="alert alert-info"><?php echo htmlspecialchars($_GET['message']); ?></div>
    <?php endif; ?>

    <?php if (count($tour_runs) > 0): ?> 
        <table class="table table-bordered table-hover">
            <thead class="thead-dark">
                <tr>
                    <th>ID Booking</th>
                    <th>Tên Tour</th>
                    <th>Ngày Khởi Hành</th>
                    <th>Số Ngày</th>
                    <th>Hành Động</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($tour_runs as $tour_run): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($tour_run['booking_id']); ?></td>
                        <td><?php echo htmlspecialchars($tour_run['ten_tour']); ?></td>
                        <td><?php echo htmlspecialchars(date('d/m/Y', strtotime($tour_run['ngay_khoi_hanh'] ?? 'N/A'))); ?></td>
                        <td><?php echo htmlspecialchars($tour_run['so_ngay']); ?></td>
                        <td>
                            <a href="index.php?action=attendance_list_bookings&id=<?php echo $tour_run['booking_id']; ?>" class="btn btn-sm btn-primary">
                                Điểm Danh Chi Tiết
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <div class="alert alert-warning">
            Không có chuyến đi (Booking) đã xác nhận nào sắp/đang hoạt động để điểm danh.
        </div>
    <?php endif; ?>
</div>
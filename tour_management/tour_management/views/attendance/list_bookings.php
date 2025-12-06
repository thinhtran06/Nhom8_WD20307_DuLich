<?php 
// views/attendance/list_bookings.php
// $tour: thông tin Tour
// $bookings: danh sách Booking đã xác nhận
?>

<div class="container mt-4">
    <h1 class="mb-4"><?php echo $page_title; ?></h1>
    
    <div class="card mb-4">
        <div class="card-body">
            <h5 class="card-title">Thông tin Tour</h5>
            <p><strong>Ngày khởi hành:</strong> <?php echo htmlspecialchars(date('d/m/Y', strtotime($tour['ngay_khoi_hanh'] ?? 'N/A'))); ?></p>
            <p><strong>Số ngày Tour:</strong> <?php echo htmlspecialchars($tour['so_ngay']); ?></p>
        </div>
    </div>
    
    <h2 class="mt-5">Chọn Ngày Tour Để Điểm Danh</h2>
    <div class="list-group mb-4">
        <?php 
        $so_ngay_tour = (int)($tour['so_ngay'] ?? 1); 
        for ($i = 1; $i <= $so_ngay_tour; $i++): 
        ?>
            <a href="index.php?action=attendance_check&id=<?php echo $tour['id']; ?>&day=<?php echo $i; ?>" class="list-group-item list-group-item-action">
                <strong>Ngày <?php echo $i; ?></strong>: Điểm danh cho ngày thứ <?php echo $i; ?> của chuyến đi.
            </a>
        <?php endfor; ?>
    </div>

    <h2 class="mt-5">Danh sách Khách Hàng đã Xác nhận</h2>
    <?php if ($bookings->rowCount() > 0): ?>
        <table class="table table-striped table-bordered">
            <thead class="thead-light">
                <tr>
                    <th>ID Booking</th>
                    <th>Tên Khách Hàng</th>
                    <th>SL Người Lớn</th>
                    <th>SL Trẻ Em</th>
                    <th>Tổng Khách</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($booking = $bookings->fetch(PDO::FETCH_ASSOC)): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($booking['booking_id']); ?></td>
                        <td><?php echo htmlspecialchars($booking['ho_ten']); ?></td>
                        <td><?php echo htmlspecialchars($booking['so_nguoi_lon']); ?></td>
                        <td><?php echo htmlspecialchars($booking['so_tre_em']); ?></td>
                        <td><?php echo htmlspecialchars($booking['tong_khach']); ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <div class="alert alert-warning">
            Chưa có khách hàng nào đã xác nhận đặt Tour này.
        </div>
    <?php endif; ?>
</div>
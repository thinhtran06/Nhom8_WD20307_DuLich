<?php include "views/layout/header.php"; ?>
<?php var_dump($booking_id); ?>
<?php
$tour_id  = $_GET['tour_id'] ?? 0;
$guide_id = $_GET['guide_id'] ?? 0;

if (!$tour_id || !$guide_id) {
    die("<b>Lỗi:</b> Thiếu tour_id hoặc guide_id");
}


if (!$booking_id) {
    die("<b>Lỗi:</b> Không tìm thấy booking cho tour này");
}
?>

<div class="container mt-4">
    <h3>➕ Thêm khách hàng vào tour</h3>

    <div class="card mt-3">
        <div class="card-body">

            <form method="POST" action="index.php?action=guide_customer_store">

                <input type="hidden" name="tour_id" value="<?= $tour_id ?>">
                <input type="hidden" name="guide_id" value="<?= $guide_id ?>">
                <input type="hidden" name="booking_id" value="<?= $booking_id ?>">

                <div class="form-group mb-3">
                    <label><strong>Họ tên khách *</strong></label>
                    <input type="text" name="ho_ten" class="form-control" required>
                </div>

                <div class="form-group mb-3">
                    <label>Email</label>
                    <input type="email" name="email" class="form-control">
                </div>

                <div class="form-group mb-3">
                    <label>Điện thoại</label>
                    <input type="text" name="dien_thoai" class="form-control">
                </div>

                <div class="form-group mb-3">
                    <label>Giới tính</label>
                    <select name="gioi_tinh" class="form-control">
                        <option value="Nam">Nam</option>
                        <option value="Nữ">Nữ</option>
                        <option value="Khác">Khác</option>
                    </select>
                </div>

                <div class="form-group mb-3">
                    <label>Quốc tịch</label>
                    <input type="text" name="quoc_tich" class="form-control" value="VN">
                </div>

                <div class="form-group mb-3">
                    <label>Ghi chú</label>
                    <textarea name="ghi_chu" class="form-control"></textarea>
                </div>

                <button type="submit" class="btn btn-success">Lưu khách hàng</button>

                <a href="index.php?action=guide_customers&tour_id=<?= $tour_id ?>&guide_id=<?= $guide_id ?>" 
                   class="btn btn-secondary">
                   Quay lại
                </a>

            </form>
        </div>
    </div>
</div>

<?php include "views/layout/footer.php"; ?>

<?php 
// views/bookings/create.php

include 'views/layout/header.php'; 
?>

<div class="container-fluid" style="margin-top: 16px;">
    <h2>➕ Thêm Đặt Chỗ Mới</h2>
    
    <?php 
    if (isset($_GET['error'])): ?>
        <div class="alert alert-danger"><?php echo htmlspecialchars($_GET['error']); ?></div>
    <?php endif; ?>

    <form action="index.php?action=booking_store" method="POST">
        
        <div class="mb-3">
            <label class="form-label">Chọn Tour</label>
            <select class="form-select" name="tour_id" required>
                <option value="">-- Chọn Tour --</option>
                <?php 
                if (isset($tours) && is_array($tours)):
                    foreach ($tours as $tour):
                        $id = $tour['id'] ?? '';
                        $ten = htmlspecialchars($tour['ten_tour'] ?? 'Không tên');
                        $ma = htmlspecialchars($tour['ma_tour'] ?? 'N/A');
                    ?>
                    <option value="<?php echo $id; ?>">
                        <?php echo $ten . " (" . $ma . ")"; ?>
                    </option>
                <?php endforeach; endif; ?>
            </select>
        </div>
        
        <div class="mb-3 border p-3 rounded bg-light">
            <h4>👤 Thông tin Khách Hàng</h4>
            <div class="mb-3">
                <label class="form-label">Tên Khách Hàng (Bắt buộc)</label>
                <input type="text" class="form-control" name="customer_name" required placeholder="Nhập tên khách hàng">
            </div>
            <div class="mb-3">
                <label class="form-label">Số Điện Thoại</label>
                <input type="text" class="form-control" name="customer_phone" placeholder="Nhập số điện thoại">
            </div>
        </div>
        
        <div class="row">
            <div class="col-md-4 mb-3">
                <label class="form-label">Số Người Lớn</label>
                <input type="number" class="form-control" name="so_nguoi_lon" value="1" min="1" required>
            </div>
            <div class="col-md-4 mb-3">
                <label class="form-label">Số Trẻ Em</label>
                <input type="number" class="form-control" name="so_tre_em" value="0" min="0">
            </div>
            <div class="col-md-4 mb-3">
                <label class="form-label">Tổng Tiền (VNĐ)</label>
                <input type="number" class="form-control" name="tong_tien" required>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label">Trạng Thái</label>
                <select class="form-select" name="trang_thai">
                    <option value="Đang chờ">Đang chờ</option>
                    <option value="Đã xác nhận">Đã xác nhận</option>
                    <option value="Đã hủy">Đã hủy</option>
                </select>
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label">Thanh Toán</label>
                <select class="form-select" name="da_thanh_toan">
                    <option value="0">Chưa thanh toán</option>
                    <option value="1">Đã thanh toán</option>
                </select>
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label">Ghi Chú</label>
            <textarea class="form-control" name="ghi_chu" rows="3"></textarea>
        </div>

        <button type="submit" class="btn btn-success">Lưu Đặt Chỗ</button>
        <a href="index.php?action=booking_index" class="btn btn-secondary">Quay Lại</a>
    </form>
</div>

<?php 
include 'views/layout/footer.php'; 
?>
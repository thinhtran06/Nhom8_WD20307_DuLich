<?php include "views/layout/header.php"; ?>

<div class="container mt-4">

    <div class="card shadow p-4">

        <h3 class="mb-4">
            <span style="font-size: 28px; color:#5a5aff;">➕</span> 
            Thêm khách vào tour
        </h3>

        <form action="index.php?action=guide_customer_store" method="POST">

            <input type="hidden" name="tour_id" value="<?= $tour_id ?>">
            <input type="hidden" name="guide_id" value="<?= $guide_id ?>">

            <div class="mb-3">
                <label class="form-label">Họ tên</label>
                <input type="text" name="ho_ten" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control">
            </div>

            <div class="mb-3">
                <label class="form-label">Điện thoại</label>
                <input type="text" name="dien_thoai" class="form-control">
            </div>

            <div class="mb-3">
                <label class="form-label">Giới tính</label>
                <select name="gioi_tinh" class="form-control">
                    <option value="">-- Chọn --</option>
                    <option value="Nam">Nam</option>
                    <option value="Nữ">Nữ</option>
                    <option value="Khác">Khác</option>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Quốc tịch</label>
                <input type="text" name="quoc_tich" class="form-control">
            </div>

            <div class="mb-3">
                <label class="form-label">Ghi chú</label>
                <textarea name="ghi_chu" class="form-control" rows="3"></textarea>
            </div>

            <div class="mt-3">
                <button class="btn btn-primary">💾 Lưu khách</button>
                <a href="index.php?action=guide_customers&tour_id=<?= $tour_id ?>&guide_id=<?= $guide_id ?>" 
                   class="btn btn-secondary ms-2">Hủy</a>
            </div>

        </form>

    </div>
</div>

<?php include "views/layout/footer.php"; ?>

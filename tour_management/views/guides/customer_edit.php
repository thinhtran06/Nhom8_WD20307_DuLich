<?php include "views/layout/header.php"; ?>

<div class="main-content container mt-4">

    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">✏️ Sửa thông tin khách</h4>
        </div>

        <div class="card-body">

            <form method="POST" action="index.php?action=guide_customer_update">

                <!-- Hidden Fields -->
                <input type="hidden" name="customer_id" value="<?= $customer['id'] ?>">
<input type="hidden" name="tour_id" value="<?= $tour_id ?>">
<input type="hidden" name="guide_id" value="<?= $guide_id ?>">

<div class="mb-3">
    <label class="form-label">Họ tên</label>
    <input type="text" name="ho_ten" class="form-control"
           value="<?= htmlspecialchars($customer['ho_ten'] ?? '') ?>" required>
</div>

<div class="mb-3">
    <label class="form-label">Email</label>
    <input type="text" name="email" class="form-control"
           value="<?= htmlspecialchars($customer['email'] ?? '') ?>">
</div>

<div class="mb-3">
    <label class="form-label">Điện thoại</label>
    <input type="text" name="dien_thoai" class="form-control"
           value="<?= htmlspecialchars($customer['dien_thoai'] ?? '') ?>">
</div>

<div class="mb-3">
    <label class="form-label">Giới tính</label>
    <input type="text" name="gioi_tinh" class="form-control"
           value="<?= htmlspecialchars($customer['gioi_tinh'] ?? '') ?>">
</div>

<div class="mb-3">
    <label class="form-label">Quốc tịch</label>
    <input type="text" name="quoc_tich" class="form-control"
           value="<?= htmlspecialchars($customer['quoc_tich'] ?? '') ?>">
</div>

<div class="mb-3">
    <label class="form-label">Ghi chú</label>
    <textarea name="ghi_chu" class="form-control" rows="3">
        <?= htmlspecialchars($customer['ghi_chu'] ?? '') ?>
    </textarea>
</div>


                <button class="btn btn-primary">💾 Lưu thay đổi</button>
                <a href="index.php?action=guide_customers&tour_id=<?= $tour_id ?>&guide_id=<?= $guide_id ?>"
                   class="btn btn-secondary ms-2">
                    ⬅️ Quay lại
                </a>

            </form>

        </div>
    </div>

</div>

<?php include "views/layout/footer.php"; ?>

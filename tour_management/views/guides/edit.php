<?php include "views/layout/header.php"; ?>

<?php
// Hàm bảo vệ giá trị
function safe($value) {
    return htmlspecialchars($value ?? '', ENT_QUOTES, 'UTF-8');
}

// Nếu không có dữ liệu → dừng
if (empty($guide)) {
    echo "<div class='alert alert-danger mt-4'>Không tìm thấy hướng dẫn viên.</div>";
    echo "<a href='index.php?action=guide_index' class='btn btn-secondary'>Quay lại</a>";
    include "views/layout/footer.php";
    return;
}
?>
<div style="margin-left:260px; margin-top:80px; padding:20px;">
<h3 class="mt-3">Sửa thông tin Hướng Dẫn Viên</h3>

<!-- FORM UPDATE HDV -->
<form method="POST" action="index.php?action=guide_update">

    <!-- QUAN TRỌNG: Gửi ID về Controller -->
    <input type="hidden" name="id" value="<?= safe($guide->id) ?>">

    <div class="row">
        <div class="col-md-6 mb-3">
            <label>Họ tên:</label>
            <input type="text" name="ho_ten" class="form-control"
                   value="<?= safe($guide->ho_ten) ?>" required>
        </div>

        <div class="col-md-3 mb-3">
            <label>Ngày sinh:</label>
            <input type="date" name="ngay_sinh" class="form-control"
                   value="<?= safe($guide->ngay_sinh) ?>">
        </div>

        <div class="col-md-3 mb-3">
            <label>Giới tính:</label>
            <select name="gioi_tinh" class="form-control">
                <option value="Nam"   <?= ($guide->gioi_tinh == 'Nam')?'selected':'' ?>>Nam</option>
                <option value="Nữ"    <?= ($guide->gioi_tinh == 'Nữ')?'selected':'' ?>>Nữ</option>
                <option value="Khác"  <?= ($guide->gioi_tinh == 'Khác')?'selected':'' ?>>Khác</option>
            </select>
        </div>
    </div>


    <div class="row">
        <div class="col-md-4 mb-3">
            <label>Điện thoại:</label>
            <input type="text" name="dien_thoai" class="form-control"
                   value="<?= safe($guide->dien_thoai) ?>">
        </div>

        <div class="col-md-4 mb-3">
            <label>Email:</label>
            <input type="email" name="email" class="form-control"
                   value="<?= safe($guide->email) ?>">
        </div>

        <div class="col-md-4 mb-3">
            <label>Trạng thái:</label>
            <select name="trang_thai" class="form-control">
                <option value="Đang hoạt động" <?= ($guide->trang_thai=='Đang hoạt động')?'selected':'' ?>>Đang hoạt động</option>
                <option value="Tạm nghỉ"      <?= ($guide->trang_thai=='Tạm nghỉ')?'selected':'' ?>>Tạm nghỉ</option>
                <option value="Ngưng"         <?= ($guide->trang_thai=='Ngưng')?'selected':'' ?>>Ngưng</option>
            </select>
        </div>
    </div>


    <div class="mb-3">
        <label>Địa chỉ:</label>
        <input type="text" name="dia_chi" class="form-control"
               value="<?= safe($guide->dia_chi) ?>">
    </div>

    <div class="row">
        <div class="col-md-4 mb-3">
            <label>Ngoại ngữ:</label>
            <input type="text" name="ngon_ngu" class="form-control"
                   value="<?= safe($guide->ngon_ngu) ?>">
        </div>

        <div class="col-md-4 mb-3">
            <label>Loại HDV:</label>
            <select name="loai_hdv" class="form-control">
                <option value="Nội địa" <?= ($guide->loai_hdv=='Nội địa')?'selected':'' ?>>Nội địa</option>
                <option value="Quốc tế" <?= ($guide->loai_hdv=='Quốc tế')?'selected':'' ?>>Quốc tế</option>
            </select>
        </div>

        <div class="col-md-4 mb-3">
            <label>Chuyên tuyến:</label>
            <input type="text" name="chuyen_tuyen" class="form-control"
                   value="<?= safe($guide->chuyen_tuyen) ?>">
        </div>
    </div>


    <div class="mb-3">
        <label>Ghi chú:</label>
        <textarea name="ghi_chu" class="form-control" rows="3"><?= safe($guide->ghi_chu) ?></textarea>
    </div>

    <button type="submit" class="btn btn-success">Lưu thay đổi</button>
    <a href="index.php?action=guide_index" class="btn btn-secondary">Hủy</a>

</form>
<</div>
<?php include "views/layout/footer.php"; ?>

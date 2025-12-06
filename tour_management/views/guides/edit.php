<?php include "views/layout/header.php"; ?>

<h3>Sửa thông tin Hướng Dẫn Viên</h3>

<form method="POST" action="index.php?action=guide_update&id=<?= $guide->id ?>" class="mt-3">

    <div class="row">
        <div class="col-md-6 mb-3">
            <label>Họ tên <span class="text-danger">*</span></label>
            <input type="text" name="ho_ten" class="form-control" 
                   value="<?= htmlspecialchars($guide->ho_ten ?? '') ?>" required>
        </div>

        <div class="col-md-3 mb-3">
            <label>Ngày sinh</label>
            <input type="date" name="ngay_sinh" class="form-control" 
                   value="<?= htmlspecialchars($guide->ngay_sinh ?? '') ?>">
        </div>

        <div class="col-md-3 mb-3">
            <label>Giới tính</label>
            <select name="gioi_tinh" class="form-select">
                <option value="Nam" <?= ($guide->gioi_tinh ?? '')=='Nam'?'selected':''; ?>>Nam</option>
                <option value="Nữ" <?= ($guide->gioi_tinh ?? '')=='Nữ'?'selected':''; ?>>Nữ</option>
                <option value="Khác" <?= ($guide->gioi_tinh ?? '')=='Khác'?'selected':''; ?>>Khác</option>
            </select>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4 mb-3">
            <label>Điện thoại</label>
            <input type="text" name="dien_thoai" class="form-control"
                   value="<?= htmlspecialchars($guide->dien_thoai ?? '') ?>">
        </div>
        <div class="col-md-4 mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control"
                   value="<?= htmlspecialchars($guide->email ?? '') ?>">
        </div>
        <div class="col-md-4 mb-3">
            <label>Địa chỉ</label>
            <input type="text" name="dia_chi" class="form-control"
                   value="<?= htmlspecialchars($guide->dia_chi ?? '') ?>">
        </div>
    </div>

    <div class="row">
        <div class="col-md-4 mb-3">
            <label>Trình độ</label>
            <input type="text" name="trinh_do" class="form-control"
                   value="<?= htmlspecialchars($guide->trinh_do ?? '') ?>">
        </div>
        <div class="col-md-4 mb-3">
            <label>Chứng chỉ HDV</label>
            <input type="text" name="chung_chi" class="form-control"
                   value="<?= htmlspecialchars($guide->chung_chi ?? '') ?>">
        </div>
        <div class="col-md-4 mb-3">
            <label>Ngoại ngữ</label>
            <input type="text" name="ngon_ngu" class="form-control"
                   value="<?= htmlspecialchars($guide->ngon_ngu ?? '') ?>">
        </div>
    </div>

    <div class="row">
        <div class="col-md-4 mb-3">
            <label>Loại HDV</label>
            <select name="loai_hdv" class="form-select">
                <option value="Nội địa" <?= ($guide->loai_hdv ?? '')=='Nội địa'?'selected':''; ?>>Nội địa</option>
                <option value="Quốc tế" <?= ($guide->loai_hdv ?? '')=='Quốc tế'?'selected':''; ?>>Quốc tế</option>
            </select>
        </div>
        <div class="col-md-4 mb-3">
            <label>Chuyên tuyến</label>
            <input type="text" name="chuyen_tuyen" class="form-control"
                   value="<?= htmlspecialchars($guide->chuyen_tuyen ?? '') ?>">
        </div>
        <div class="col-md-4 mb-3">
            <label>Sức khỏe</label>
            <select name="suc_khoe" class="form-select">
                <option value="Tốt" <?= ($guide->suc_khoe ?? '')=='Tốt'?'selected':''; ?>>Tốt</option>
                <option value="Bình thường" <?= ($guide->suc_khoe ?? '')=='Bình thường'?'selected':''; ?>>Bình thường</option>
                <option value="Yếu" <?= ($guide->suc_khoe ?? '')=='Yếu'?'selected':''; ?>>Yếu</option>
            </select>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4 mb-3">
            <label>Trạng thái</label>
            <select name="trang_thai" class="form-select">
                <option value="Đang hoạt động" <?= ($guide->trang_thai ?? '')=='Đang hoạt động'?'selected':''; ?>>Đang hoạt động</option>
                <option value="Tạm nghỉ" <?= ($guide->trang_thai ?? '')=='Tạm nghỉ'?'selected':''; ?>>Tạm nghỉ</option>
                <option value="Không hoạt động" <?= ($guide->trang_thai ?? '')=='Không hoạt động'?'selected':''; ?>>Không hoạt động</option>
            </select>
        </div>
        <div class="col-md-8 mb-3">
            <label>Ghi chú</label>
            <textarea name="ghi_chu" class="form-control" rows="2">
<?= htmlspecialchars($guide->ghi_chu ?? '') ?>
            </textarea>
        </div>
    </div>

    <div class="mt-3">
        <a href="index.php?action=guide_index" class="btn btn-secondary">Quay lại</a>
        <button type="submit" class="btn btn-primary">Cập nhật</button>
    </div>
</form>

<?php include "views/layout/footer.php"; ?>

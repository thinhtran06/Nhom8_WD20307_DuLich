<?php include "views/layout/header.php"; ?>

<div style="margin-left:260px; margin-top:80px; padding:20px;">
<h3 class="mt-3">Thêm Hướng Dẫn Viên</h3>

<!-- FORM CREATE HDV -->
<form method="POST" action="index.php?action=guide_store">

    <div class="row">
        <div class="col-md-6 mb-3">
            <label>Họ tên:</label>
            <input type="text" name="ho_ten" class="form-control" required>
        </div>

        <div class="col-md-3 mb-3">
            <label>Ngày sinh:</label>
            <input type="date" name="ngay_sinh" class="form-control">
        </div>

        <div class="col-md-3 mb-3">
            <label>Giới tính:</label>
            <select name="gioi_tinh" class="form-control">
                <option value="Nam">Nam</option>
                <option value="Nữ">Nữ</option>
                <option value="Khác">Khác</option>
            </select>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4 mb-3">
            <label>Điện thoại:</label>
            <input type="text" name="dien_thoai" class="form-control">
        </div>

        <div class="col-md-4 mb-3">
            <label>Email:</label>
            <input type="email" name="email" class="form-control">
        </div>

        <div class="col-md-4 mb-3">
            <label>Trạng thái:</label>
            <select name="trang_thai" class="form-control">
                <option value="Đang hoạt động">Đang hoạt động</option>
                <option value="Tạm nghỉ">Tạm nghỉ</option>
                <option value="Ngưng">Ngưng</option>
            </select>
        </div>
    </div>

    <div class="mb-3">
        <label>Địa chỉ:</label>
        <input type="text" name="dia_chi" class="form-control">
    </div>

    <div class="row">
        <div class="col-md-4 mb-3">
            <label>Ngoại ngữ:</label>
            <input type="text" name="ngon_ngu" class="form-control">
        </div>

        <div class="col-md-4 mb-3">
            <label>Loại HDV:</label>
            <select name="loai_hdv" class="form-control">
                <option value="Nội địa">Nội địa</option>
                <option value="Quốc tế">Quốc tế</option>
            </select>
        </div>

        <div class="col-md-4 mb-3">
            <label>Chuyên tuyến:</label>
            <input type="text" name="chuyen_tuyen" class="form-control">
        </div>
    </div>

    <div class="mb-3">
        <label>Ghi chú:</label>
        <textarea name="ghi_chu" class="form-control" rows="3"></textarea>
    </div>

    <button type="submit" class="btn btn-primary">Lưu</button>
    <a href="index.php?action=guide_index" class="btn btn-secondary">Quay lại</a>

</form>
</div>

<?php include "views/layout/footer.php"; ?>
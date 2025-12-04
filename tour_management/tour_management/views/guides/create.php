<?php include "views/layout/header.php"; ?>

<h3 class="mb-4">➕ Thêm Hướng Dẫn Viên</h3>

<div class="card shadow-sm p-4">
    <form method="POST" action="index.php?action=guide_store">

        <!-- Row 1 -->
        <div class="form-row">
            <div class="form-group col-md-6">
                <label><strong>Họ tên <span class="text-danger">*</span></strong></label>
                <input type="text" name="ho_ten" class="form-control" placeholder="Nhập họ và tên" required>
            </div>

            <div class="form-group col-md-3">
                <label><strong>Ngày sinh</strong></label>
                <input type="date" name="ngay_sinh" class="form-control">
            </div>

            <div class="form-group col-md-3">
                <label><strong>Giới tính</strong></label>
                <select name="gioi_tinh" class="form-control">
                    <option>Nam</option>
                    <option>Nữ</option>
                    <option>Khác</option>
                </select>
            </div>
        </div>

        <!-- Row 2 -->
        <div class="form-row">
            <div class="form-group col-md-3">
                <label><strong>Điện thoại</strong></label>
                <input type="text" name="dien_thoai" class="form-control" placeholder="SĐT liên hệ">
            </div>

            <div class="form-group col-md-4">
                <label><strong>Email</strong></label>
                <input type="email" name="email" class="form-control" placeholder="Email">
            </div>

            <div class="form-group col-md-5">
                <label><strong>Địa chỉ</strong></label>
                <input type="text" name="dia_chi" class="form-control" placeholder="Nơi cư trú">
            </div>
        </div>

        <!-- Row 3 -->
        <div class="form-row">
            <div class="form-group col-md-4">
                <label><strong>Trình độ</strong></label>
                <input type="text" name="trinh_do" class="form-control" placeholder="ĐH / CĐ Du lịch...">
            </div>

            <div class="form-group col-md-4">
                <label><strong>Chứng chỉ HDV</strong></label>
                <input type="text" name="chung_chi" class="form-control" placeholder="HDV nội địa / quốc tế">
            </div>

            <div class="form-group col-md-4">
                <label><strong>Ngoại ngữ</strong></label>
                <input type="text" name="ngon_ngu" class="form-control" placeholder="Tiếng Anh, Nhật, Hàn...">
            </div>
        </div>

        <!-- Row 4 -->
        <div class="form-row">
            <div class="form-group col-md-4">
                <label><strong>Loại HDV</strong></label>
                <select name="loai_hdv" class="form-control">
                    <option value="Nội địa">Nội địa</option>
                    <option value="Quốc tế">Quốc tế</option>
                </select>
            </div>

            <div class="form-group col-md-4">
                <label><strong>Chuyên tuyến</strong></label>
                <input type="text" name="chuyen_tuyen" class="form-control" placeholder="Miền Bắc / Miền Trung / Miền Nam...">
            </div>

            <div class="form-group col-md-4">
                <label><strong>Sức khỏe</strong></label>
                <select name="suc_khoe" class="form-control">
                    <option>Tốt</option>
                    <option>Bình thường</option>
                    <option>Yếu</option>
                </select>
            </div>
        </div>

        <!-- Row 5 -->
        <div class="form-row">
            <div class="form-group col-md-4">
                <label><strong>Trạng thái</strong></label>
                <select name="trang_thai" class="form-control">
                    <option>Đang hoạt động</option>
                    <option>Tạm nghỉ</option>
                    <option>Không hoạt động</option>
                </select>
            </div>

            <div class="form-group col-md-8">
                <label><strong>Ghi chú</strong></label>
                <textarea name="ghi_chu" class="form-control" rows="2" placeholder="Ghi chú thêm (nếu có)"></textarea>
            </div>
        </div>

        <div class="mt-3">
            <a href="index.php?action=guide_index" class="btn btn-secondary px-4">Quay lại</a>
            <button type="submit" class="btn btn-primary px-4">Lưu</button>
        </div>

    </form>
</div>

<?php include "views/layout/footer.php"; ?>

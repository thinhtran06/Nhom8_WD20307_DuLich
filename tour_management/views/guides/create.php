<?php include "views/layout/header.php"; ?>

<div style="margin-left:260px; margin-top:80px; padding:20px;">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0"><i class="fas fa-user-plus"></i> Thêm Hướng Dẫn Viên Mới</h4>
        </div>
        <div class="card-body">
            <form method="POST" action="index.php?action=guide_store">
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Họ tên <span class="text-danger">*</span></label>
                        <input type="text" name="ho_ten" class="form-control" placeholder="Nhập đầy đủ họ tên" required>
                    </div>

                    <div class="col-md-3 mb-3">
                        <label class="form-label fw-bold">Ngày sinh</label>
                        <input type="date" name="ngay_sinh" class="form-control">
                    </div>

                    <div class="col-md-3 mb-3">
                        <label class="form-label fw-bold">Giới tính</label>
                        <select name="gioi_tinh" class="form-select">
                            <option value="Nam">Nam</option>
                            <option value="Nữ">Nữ</option>
                            <option value="Khác">Khác</option>
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label fw-bold">Số điện thoại <span class="text-danger">*</span></label>
                        <input type="text" name="dien_thoai" class="form-control" placeholder="Số điện thoại liên lạc" required>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label fw-bold">Email</label>
                        <input type="email" name="email" class="form-control" placeholder="example@mail.com">
                    </div>

                    <div class="col-md-4 mb-3">
    <label class="form-label fw-bold">Kinh nghiệm (năm)</label>
    <input type="number" name="kinh_nghiem" class="form-control" placeholder="Ví dụ: 3">
</div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label fw-bold">Trạng thái làm việc</label>
                        <select name="trang_thai" class="form-select">
                            <option value="Đang hoạt động">Đang hoạt động</option>
                            <option value="Tạm nghỉ">Tạm nghỉ</option>
                            <option value="Ngừng việc">Ngừng việc</option>
                        </select>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Địa chỉ</label>
                    <input type="text" name="dia_chi" class="form-control" placeholder="Địa chỉ thường trú">
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Ngoại ngữ (Nếu có)</label>
                    <input type="text" name="ngon_ngu" class="form-control" placeholder="Ví dụ: Tiếng Anh, Tiếng Trung...">
                </div>

                <div class="mt-4 border-top pt-3">
                    <button type="submit" class="btn btn-primary px-4">
                        <i class="fas fa-save"></i> Lưu thông tin
                    </button>
                    <a href="index.php?action=guide_index" class="btn btn-outline-secondary px-4">
                        <i class="fas fa-arrow-left"></i> Quay lại
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include "views/layout/footer.php"; ?>
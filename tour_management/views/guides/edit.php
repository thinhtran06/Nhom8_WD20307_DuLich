<?php include "views/layout/header.php"; ?>

<?php
// Hàm hỗ trợ để tránh lỗi XSS và xử lý dữ liệu null
function safe($v) {
    return htmlspecialchars($v ?? '', ENT_QUOTES, 'UTF-8');
}
?>

<div style="margin-left:260px; margin-top:80px; padding:20px;">
    <div class="card shadow-sm border-0">
        <div class="card-header bg-warning text-dark d-flex align-items-center">
            <h4 class="mb-0"><i class="fas fa-user-edit"></i> Chỉnh sửa Hướng Dẫn Viên: <?= safe($guide['ho_ten']) ?></h4>
        </div>
        <div class="card-body p-4">
            <form method="POST" action="index.php?action=guide_update">
                
                <input type="hidden" name="id" value="<?= $guide['id'] ?>">

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Họ tên <span class="text-danger">*</span></label>
                        <input type="text" name="ho_ten" class="form-control" value="<?= safe($guide['ho_ten']) ?>" required>
                    </div>

                    <div class="col-md-3 mb-3">
                        <label class="form-label fw-bold">Ngày sinh</label>
                        <input type="date" name="ngay_sinh" class="form-control" value="<?= safe($guide['ngay_sinh']) ?>">
                    </div>

                    <div class="col-md-3 mb-3">
                        <label class="form-label fw-bold">Giới tính</label>
                        <select name="gioi_tinh" class="form-select">
                            <option value="Nam" <?= $guide['gioi_tinh'] == 'Nam' ? 'selected' : '' ?>>Nam</option>
                            <option value="Nữ" <?= $guide['gioi_tinh'] == 'Nữ' ? 'selected' : '' ?>>Nữ</option>
                            <option value="Khác" <?= $guide['gioi_tinh'] == 'Khác' ? 'selected' : '' ?>>Khác</option>
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label fw-bold">Số điện thoại <span class="text-danger">*</span></label>
                        <input type="text" name="dien_thoai" class="form-control" value="<?= safe($guide['dien_thoai']) ?>" required>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label fw-bold">Email</label>
                        <input type="email" name="email" class="form-control" value="<?= safe($guide['email']) ?>">
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label fw-bold">Trạng thái làm việc</label>
                        <select name="trang_thai" class="form-select">
                            <option value="Đang hoạt động" <?= $guide['trang_thai'] == 'Đang hoạt động' ? 'selected' : '' ?>>Đang hoạt động</option>
                            <option value="Tạm nghỉ" <?= $guide['trang_thai'] == 'Tạm nghỉ' ? 'selected' : '' ?>>Tạm nghỉ</option>
                            <option value="Ngừng việc" <?= $guide['trang_thai'] == 'Ngừng việc' ? 'selected' : '' ?>>Ngừng việc</option>
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-8 mb-3">
                        <label class="form-label fw-bold">Địa chỉ</label>
                        <input type="text" name="dia_chi" class="form-control" value="<?= safe($guide['dia_chi']) ?>">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label fw-bold">Kinh nghiệm (năm)</label>
                        <input type="number" name="kinh_nghiem" class="form-control" value="<?= safe($guide['kinh_nghiem']) ?>">
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Ngoại ngữ</label>
                    <input type="text" name="ngon_ngu" class="form-control" value="<?= safe($guide['ngon_ngu']) ?>" placeholder="Ví dụ: Tiếng Anh, Tiếng Nhật...">
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Ghi chú chuyên môn</label>
                    <textarea name="ghi_chu" class="form-control" rows="3"><?= safe($guide['ghi_chu']) ?></textarea>
                </div>

                <div class="mt-4 border-top pt-3 d-flex gap-2">
                    <button type="submit" class="btn btn-warning px-4 fw-bold">
                        <i class="fas fa-save"></i> Cập nhật thay đổi
                    </button>
                    <a href="index.php?action=guide_index" class="btn btn-outline-secondary px-4">
                        <i class="fas fa-times"></i> Hủy bỏ
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include "views/layout/footer.php"; ?>
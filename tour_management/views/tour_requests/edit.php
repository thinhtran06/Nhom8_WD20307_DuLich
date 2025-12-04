<?php require_once 'views/layout/header.php'; ?>

<div class="container-fluid">
    <div class="row">
        <!-- MAIN CONTENT -->
        <main class="col-md-9 ml-0 col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Sửa Yêu Cầu Tour #<?= (int)($tourRequest['id'] ?? 0) ?></h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <a href="index.php?action=tour_request_index" class="btn btn-sm btn-outline-secondary">
                        Quay Lại Danh Sách
                    </a>
                </div>
            </div>

            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Thông Tin Chi Tiết Yêu Cầu Tour</h5>
                </div>
                <div class="card-body">
                    <form action="index.php?action=tour_request_update" method="POST">
                        <input type="hidden" name="id" value="<?= (int)($tourRequest['id'] ?? 0) ?>">

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Tên khách hàng <span class="text-danger">*</span></label>
                                <input type="text" name="ten_khach_hang" class="form-control" 
                                       value="<?= htmlspecialchars($tourRequest['ten_khach_hang'] ?? '') ?>" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Điện thoại <span class="text-danger">*</span></label>
                                <input type="text" name="dien_thoai" class="form-control"
                                       value="<?= htmlspecialchars($tourRequest['dien_thoai'] ?? '') ?>" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Email</label>
                                <input type="email" name="email" class="form-control"
                                       value="<?= htmlspecialchars($tourRequest['email'] ?? '') ?>">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Số lượng khách</label>
                                <input type="number" name="so_luong_khach" class="form-control" min="1"
                                       value="<?= htmlspecialchars($tourRequest['so_luong_khach'] ?? '1') ?>">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Điểm đến mong muốn</label>
                                <input type="text" name="diem_den_mong_muon" class="form-control"
                                       value="<?= htmlspecialchars($tourRequest['diem_den_mong_muon'] ?? '') ?>">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Ngày khởi hành mong muốn</label>
                                <input type="date" name="ngay_khoi_hanh_mong_luon" class="form-control"
                                       value="<?= $tourRequest['ngay_khoi_hanh_mong_luon'] ? date('Y-m-d', strtotime($tourRequest['ngay_khoi_hanh_mong_luon'])) : '' ?>">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Ngân sách (VNĐ)</label>
                                <input type="text" name="ngan_sach" id="ngan_sach" class="form-control text-end"
                                       value="<?= $tourRequest['ngan_sach'] ? number_format($tourRequest['ngan_sach']) : '' ?>"
                                       placeholder="50,000,000">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Trạng thái</label>
                                <select name="trang_thai" class="form-select">
                                    <?php $status = $tourRequest['trang_thai'] ?? 'Mới'; ?>
                                    <option value="Mới" <?= $status == 'Mới' ? 'selected' : '' ?>>Mới</option>
                                    <option value="Đang xử lý" <?= $status == 'Đang xử lý' ? 'selected' : '' ?>>Đang xử lý</option>
                                    <option value="Đã báo giá" <?= $status == 'Đã báo giá' ? 'selected' : '' ?>>Đã báo giá</option>
                                    <option value="Đã hoàn thành" <?= $status == 'Đã hoàn thành' ? 'selected' : '' ?>>Đã hoàn thành</option>
                                    <option value="Đã hủy" <?= $status == 'Đã hủy' ? 'selected' : '' ?>>Đã hủy</option>
                                </select>
                            </div>

                            <div class="col-12">
                                <label class="form-label">Ghi chú / Yêu cầu chi tiết</label>
                                <textarea name="yeu_cau_chi_tiet" class="form-control" rows="5"><?= htmlspecialchars($tourRequest['yeu_cau_chi_tiet'] ?? '') ?></textarea>
                            </div>
                        </div>

                        <div class="mt-4">
                            <button type="submit" class="btn btn-success btn-lg px-5">
                                Lưu Thay Đổi
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </main>
    </div>
</div>

<!-- Tự động định dạng tiền tệ -->
<script>
    const nganSachInput = document.getElementById('ngan_sach');
    nganSachInput.addEventListener('input', function(e) {
        let value = e.target.value.replace(/[^0-9]/g, '');
        if (value === '') {
            e.target.value = '';
        } else {
            e.target.value = parseInt(value).toLocaleString('vi-VN');
        }
    });
</script>

<?php require_once 'views/layout/footer.php'; ?>
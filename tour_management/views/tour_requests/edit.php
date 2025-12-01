<?php require_once 'views/layout/header.php'; ?>
<div class="container-fluid">
    <div class="row">

        <main class="col-md-9 ml-0 col-lg-10 px-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">✏️ Sửa Thông Tin Yêu Cầu Tour #<?= htmlspecialchars($tourRequest['id'] ?? 'Mới') ?></h1>
                <div>
                    <a href="index.php?action=tour_request_index" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Quay Lại Danh Sách
                    </a>
                </div>
            </div>

            <div class="card shadow-lg mb-4">
                <div class="card-header bg-info text-white"> 
                    <h5 class="mb-0">
                        <i class="fas fa-user-circle me-2"></i> Thông tin khách hàng
                    </h5>
                </div>
                <div class="card-body">
                    
                    <form action="index.php?action=tour_request_update" method="POST">
                        <input type="hidden" name="id" value="<?= htmlspecialchars($tourRequest['id'] ?? '') ?>">

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="ten_khach_hang" class="form-label">Tên khách hàng (*):</label>
                                <input type="text" name="ten_khach_hang" id="ten_khach_hang" class="form-control" 
                                       value="<?= htmlspecialchars($tourRequest['ten_khach_hang'] ?? '') ?>" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="dien_thoai" class="form-label">Điện thoại (*):</label>
                                <input type="text" name="dien_thoai" id="dien_thoai" class="form-control"
                                       value="<?= htmlspecialchars($tourRequest['dien_thoai'] ?? '') ?>" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label">Email:</label>
                                <input type="email" name="email" id="email" class="form-control"
                                       value="<?= htmlspecialchars($tourRequest['email'] ?? '') ?>">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="so_luong_khach" class="form-label">Số lượng khách:</label>
                                <input type="number" name="so_luong_khach" id="so_luong_khach" class="form-control"
                                       value="<?= htmlspecialchars($tourRequest['so_luong_khach'] ?? 1) ?>" min="1">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="diem_den_mong_muon" class="form-label">Điểm đến mong muốn:</label>
                                <input type="text" name="diem_den_mong_muon" id="diem_den_mong_muon" class="form-control"
                                       value="<?= htmlspecialchars($tourRequest['diem_den_mong_muon'] ?? '') ?>">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="ngay_khoi_hanh_mong_luon" class="form-label">Ngày khởi hành mong muốn:</label>
                                <input type="date" name="ngay_khoi_hanh_mong_luon" id="ngay_khoi_hanh_mong_luon" class="form-control"
                                       value="<?= !empty($tourRequest['ngay_khoi_hanh_mong_luon']) ? htmlspecialchars(date('Y-m-d', strtotime($tourRequest['ngay_khoi_hanh_mong_luon']))) : '' ?>">
                            </div>
                        </div>

                        <hr class="my-4"> 

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="ngan_sach" class="form-label">Ngân sách (VNĐ):</label>
                                <input type="number" name="ngan_sach" id="ngan_sach" class="form-control"
                                       value="<?= htmlspecialchars($tourRequest['ngan_sach'] ?? '') ?>" min="0">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="trang_thai" class="form-label">Trạng thái:</label>
                                <select name="trang_thai" id="trang_thai" class="form-select">
                                    <?php $current_status = $tourRequest['trang_thai'] ?? ''; ?>
                                    <option value="Mới" <?= $current_status == 'Mới' ? 'selected' : '' ?>>Mới</option>
                                    <option value="Đang xử lý" <?= $current_status == 'Đang xử lý' ? 'selected' : '' ?>>Đang xử lý</option>
                                    <option value="Đã báo giá" <?= $current_status == 'Đã báo giá' ? 'selected' : '' ?>>Đã báo giá</option>
                                    <option value="Đã hoàn thành" <?= $current_status == 'Đã hoàn thành' ? 'selected' : '' ?>>Đã hoàn thành</option>
                                    <option value="Đã hủy" <?= $current_status == 'Đã hủy' ? 'selected' : '' ?>>Đã hủy</option>
                                </select>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="yeu_cau_chi_tiet" class="form-label">Ghi chú / Chi tiết yêu cầu:</label>
                            <textarea name="yeu_cau_chi_tiet" id="yeu_cau_chi_tiet" class="form-control" rows="4"><?= htmlspecialchars($tourRequest['yeu_cau_chi_tiet'] ?? '') ?></textarea>
                        </div>

                        <div class="d-flex justify-content-start mt-4">
                            <button type="submit" class="btn btn-success me-2"> 
                                <i class="fas fa-check-circle"></i> Lưu Thay Đổi
                            </button>
                        </div>
                    </form>

                </div>
            </div>
            
        </main>
    </div>
</div>

<?php require_once 'views/layout/footer.php'; ?>
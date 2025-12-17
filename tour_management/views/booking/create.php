<?php
require_once 'views/layout/header.php';
?>

<div class="container mt-4 mb-5">

    <h1>Tạo Booking Mới</h1>
    <a href="index.php?action=booking_index" class="btn btn-secondary mb-4">
        <i class="fas fa-arrow-left"></i> Quay lại danh sách
    </a>

    <?php if (!empty($success_message)): ?>
        <div class="alert alert-success">
            <i class="fas fa-check-circle"></i> <?= htmlspecialchars($success_message) ?>
        </div>
    <?php endif; ?>

    <?php if (!empty($error_message)): ?>
        <div class="alert alert-danger">
            <i class="fas fa-times-circle"></i> <?= htmlspecialchars($error_message) ?>
        </div>
    <?php endif; ?>

    <div class="card card-body shadow">
        <form action="index.php?action=booking_create" method="POST" id="bookingForm">

            <!-- ================== THÔNG TIN CƠ BẢN ================== -->
            <h4 class="mb-3 text-primary"><i class="fas fa-info-circle"></i> Thông Tin Cơ Bản</h4>
            <div class="row">

                <!-- TOUR -->
                <div class="col-md-6 mb-3">
                    <label for="tour_id" class="form-label">Tour (*)</label>
                    <select name="tour_id" id="tour_id" class="form-control" required>
                        <option value="">-- Chọn Tour --</option>

                        <?php if (!empty($tours)): ?>
                            <?php foreach ($tours as $tour): ?>
                                <option value="<?= $tour['id'] ?>">
                                    <?= htmlspecialchars($tour['ten_tour']) ?> (ID: <?= $tour['id'] ?>)
                                </option>
                            <?php endforeach; ?>
                        <?php endif; ?>

                    </select>
                </div>

                <!-- HƯỚNG DẪN VIÊN -->
                <div class="col-md-6 mb-3">
                    <label for="guide_id" class="form-label">Hướng Dẫn Viên</label>
                    <select name="guide_id" id="guide_id" class="form-control">
                        <option value="">-- Chưa phân công --</option>

                        <?php if (!empty($guides)): ?>
                            <?php foreach ($guides as $guide): ?>
                                <option value="<?= $guide['id'] ?>">
                                    <?= htmlspecialchars($guide['ho_ten']) ?> (ID: <?= $guide['id'] ?>)
                                </option>
                            <?php endforeach; ?>
                        <?php endif; ?>

                    </select>
                </div>

                <!-- NGÀY KHỞI HÀNH -->
                <div class="col-md-6 mb-3">
                    <label for="ngay_khoi_hanh" class="form-label">Ngày Khởi hành (*)</label>
                    <input type="date" name="ngay_khoi_hanh" id="ngay_khoi_hanh"
                           class="form-control" value="<?= date('Y-m-d') ?>" required>
                </div>

                <!-- SỐ NGƯỜI LỚN -->
                <div class="col-md-4 mb-3">
                    <label for="so_nguoi_lon" class="form-label">Số Người Lớn (*)</label>
                    <input type="number" name="so_nguoi_lon" id="so_nguoi_lon"
                           class="form-control" min="1" value="1" required>
                </div>

                <!-- SỐ TRẺ EM -->
                <div class="col-md-4 mb-3">
                    <label for="so_tre_em" class="form-label">Số Trẻ Em</label>
                    <input type="number" name="so_tre_em" id="so_tre_em"
                           class="form-control" min="0" value="0">
                </div>

                <!-- LOẠI KHÁCH -->
                <div class="col-md-4 mb-3">
                    <label for="loai_khach" class="form-label">Loại Khách</label>
                    <select name="loai_khach" id="loai_khach" class="form-control">
                        <option value="Khách lẻ" selected>Khách lẻ</option>
                        <option value="Khách đoàn">Khách đoàn</option>
                        <option value="VIP">VIP</option>
                    </select>
                </div>

            </div>

            <hr>

            <!-- ================== KHÁCH HÀNG ĐẠI DIỆN ================== -->
            <h4 class="mb-3 text-primary"><i class="fas fa-user-tie"></i> Khách Hàng Đại Diện</h4>
            <div class="row">

                <!-- CHỌN KHÁCH CŨ -->
                <div class="col-md-12 mb-3">
                    <label for="customer_id" class="form-label">1. Chọn Khách Hàng Đã Tồn Tại</label>
                    <select name="customer_id" id="customer_id" class="form-control">
                        <option value="">-- Chọn Khách Hàng (Để trống nếu tạo mới) --</option>

                        <?php if (!empty($customers)): ?>
                            <?php foreach ($customers as $c): ?>
                                <option value="<?= $c['id'] ?>">
                                    <?= htmlspecialchars($c['ho_ten']) ?> (SĐT: <?= $c['dien_thoai'] ?>)
                                </option>
                            <?php endforeach; ?>
                        <?php endif; ?>

                    </select>
                    <small class="form-text text-muted">Nếu chọn, bỏ qua phần 2.</small>
                </div>

                <!-- TẠO KHÁCH MỚI -->
                <div class="col-md-12 mb-3">
                    <h5 class="text-success mt-3"><i class="fas fa-plus-square"></i> 2. Hoặc Nhập Thông Tin Khách Hàng Mới</h5>

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="ho_ten_khach" class="form-label">Họ Tên Khách</label>
                            <input type="text" name="ho_ten_khach" id="ho_ten_khach" class="form-control">
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="cccd_khach" class="form-label">CMND/CCCD</label>
                            <input type="text" name="cccd_khach" id="cccd_khach" class="form-control">
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="dien_thoai_khach" class="form-label">Điện Thoại</label>
                            <input type="tel" name="dien_thoai_khach" id="dien_thoai_khach" class="form-control">
                        </div>
                    </div>

                    <small class="form-text text-muted">Nếu nhập thông tin mới, phải để trống mục 1.</small>
                </div>

            </div>

            <hr>

            <!-- ================== TÀI CHÍNH ================== -->
            <h4 class="mb-3 mt-3 text-primary"><i class="fas fa-wallet"></i> Tài Chính & Trạng Thái</h4>
            <div class="row">

                <div class="col-md-4 mb-3">
                    <label for="da_thanh_toan" class="form-label">Đã Thanh Toán (VNĐ)</label>
                    <input type="number" name="da_thanh_toan" id="da_thanh_toan"
                           class="form-control" min="0" value="0">
                </div>

                <div class="col-md-4 mb-3">
                    <label for="trang_thai" class="form-label">Trạng Thái (*)</label>
                    <select name="trang_thai" id="trang_thai" class="form-control">
                        <option value="Chờ xác nhận" selected>Chờ xác nhận</option>
                        <option value="Đã xác nhận">Đã xác nhận</option>
                        <option value="Đã hủy">Đã hủy</option>
                    </select>
                </div>

                <div class="col-md-12 mb-4">
                    <label for="ghi_chu" class="form-label">Ghi Chú</label>
                    <textarea name="ghi_chu" id="ghi_chu" class="form-control" rows="3"></textarea>
                </div>

            </div>

            <div class="alert alert-info py-2">
                <i class="fas fa-users"></i>
                Tổng số khách sẽ dựa trên **Số Người Lớn + Số Trẻ Em**.
            </div>

            <button type="submit" class="btn btn-primary btn-lg">
                <i class="fas fa-save"></i> Lưu Booking
            </button>

        </form>
    </div>
</div>

<?php
require_once 'views/layout/footer.php';
?>
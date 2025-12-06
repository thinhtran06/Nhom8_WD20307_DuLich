<?php require_once "views/layout/header.php"; ?>

<div class="container py-4">

    <div class="card shadow-sm border-0">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">Tạo Booking Mới</h4>
        </div>

        <div class="card-body">

            <form action="index.php?action=booking_store" method="POST">

                <!-- CHỌN TOUR -->
                <div class="mb-3">
                    <label class="form-label fw-semibold">Chọn Tour</label>
                    <select name="tour_id" class="form-select" required>
                        <option value="">-- Chọn Tour --</option>
                        <?php foreach ($tours as $tour): ?>
                            <option value="<?= $tour['id'] ?>">
                                <?= $tour['ten_tour'] ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- TÊN KHÁCH -->
                <div class="mb-3">
                    <label class="form-label fw-semibold">Tên Khách Hàng</label>
                    <input type="text" name="customer_name" class="form-control"
                           placeholder="Nhập tên khách hàng" required>
                </div>

                <!-- LOẠI KHÁCH -->
                <div class="mb-3">
                    <label class="form-label fw-semibold">Loại Khách</label>
                    <select name="loai_khach" class="form-select" required>
                        <option value="">-- Chọn loại khách --</option>
                        <option value="Khách lẻ">Khách lẻ</option>
                        <option value="Khách đoàn">Khách đoàn</option>
                        <option value="Nội địa">Nội địa</option>
                        <option value="Quốc tế">Quốc tế</option>
                        <option value="VIP">Khách VIP</option>
                    </select>
                </div>

                <!-- SỐ LƯỢNG NGƯỜI -->
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold">Số người lớn</label>
                        <input type="number" name="so_nguoi_lon" class="form-control" min="1" value="1" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold">Số trẻ em</label>
                        <input type="number" name="so_tre_em" class="form-control" min="0" value="0">
                    </div>
                </div>

                <!-- THANH TOÁN -->
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label fw-semibold">Tổng tiền</label>
                        <input type="number" name="tong_tien" class="form-control" min="0" required>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label fw-semibold">Đã thanh toán</label>
                        <input type="number" name="da_thanh_toan" class="form-control" min="0" value="0" required>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label fw-semibold">Còn lại</label>
                        <input type="number" name="con_lai" class="form-control" min="0" value="0" required>
                    </div>
                </div>

                <!-- GHI CHÚ -->
                <div class="mb-3">
                    <label class="form-label fw-semibold">Ghi Chú</label>
                    <textarea name="ghi_chu" class="form-control" rows="3"
                              placeholder="Nhập ghi chú nếu có..."></textarea>
                </div>

                <!-- BUTTON -->
                <div class="text-end">
                    <a href="index.php?action=booking_index" class="btn btn-secondary">Hủy</a>
                    <button class="btn btn-primary">Tạo Booking</button>
                </div>

            </form>
        </div>
    </div>

</div>

<?php require_once "views/layout/footer.php"; ?>

<?php include "views/layout/header.php"; ?>

<div class="main-content container mt-4">

    <div class="card shadow-sm">

        <!-- HEADER -->
        <div class="card-header bg-white py-3">
            <h4 class="mb-0">
                📘 Chi tiết tour – 
                <span class="text-primary">
                    <?= htmlspecialchars($tour->ten_tour ?? '') ?>
                </span>
            </h4>
        </div>

        <div class="card-body">

            <?php if ($tour): ?>

                <!-- THÔNG TIN TOUR -->
                <table class="table table-bordered">
                    <tr>
                        <th width="180">Tên tour</th>
                        <td><?= htmlspecialchars($tour->ten_tour ?? '') ?></td>
                    </tr>

                    <tr>
                        <th>Mô tả</th>
                        <td><?= nl2br(htmlspecialchars($tour->mo_ta ?? '')) ?></td>
                    </tr>

                    <tr>
                        <th>Điểm khởi hành</th>
                        <td><?= htmlspecialchars($tour->diem_khoi_hanh ?? '') ?></td>
                    </tr>

                    <tr>
                        <th>Điểm đến</th>
                        <td><?= htmlspecialchars($tour->diem_den ?? '') ?></td>
                    </tr>

                    <tr>
                        <th>Ngày khởi hành</th>
                        <td><?= htmlspecialchars($tour->ngay_khoi_hanh ?? '') ?></td>
                    </tr>

                    <tr>
                        <th>Số ngày</th>
                        <td><?= htmlspecialchars($tour->so_ngay ?? 'Không rõ') ?> ngày</td>
                    </tr>

                    <tr>
                        <th>Giá tour</th>
                        <td><?= number_format($tour->gia_tour ?? 0) ?> VNĐ</td>
                    </tr>
                </table>

            <?php else: ?>

                <div class="alert alert-danger">
                    Không tìm thấy thông tin tour.
                </div>

            <?php endif; ?>


            <!-- DANH SÁCH KHÁCH -->
            <hr>
            <h5 class="mt-3 mb-3">👥 Danh sách khách trong tour</h5>

            <table class="table table-bordered table-striped align-middle text-center">
                <thead class="table-light">
                    <tr>
                        <th>Họ tên</th>
                        <th>Email</th>
                        <th>Điện thoại</th>
                        <th>Giới tính</th>
                        <th>Quốc tịch</th>
                        <th>Ghi chú</th>
                    </tr>
                </thead>

                <tbody>
                <?php if (!empty($customers)): ?>

                    <?php foreach ($customers as $c): ?>
                        <?php if (is_object($c)) $c = (array)$c; ?>

                        <tr>
                            <td><?= htmlspecialchars($c['ho_ten'] ?? '') ?></td>
                            <td><?= htmlspecialchars($c['email'] ?? '') ?></td>
                            <td><?= htmlspecialchars($c['dien_thoai'] ?? '') ?></td>
                            <td><?= htmlspecialchars($c['gioi_tinh'] ?? '') ?></td>
                            <td><?= htmlspecialchars($c['quoc_tich'] ?? '') ?></td>
                            <td><?= htmlspecialchars($c['ghi_chu'] ?? '') ?></td>
                        </tr>
                    <?php endforeach; ?>

                <?php else: ?>

                    <tr>
                        <td colspan="6" class="text-center text-muted">Không có khách nào.</td>
                    </tr>

                <?php endif; ?>
                </tbody>
            </table>
            <hr>

<h3 class="mt-4 mb-3 text-primary">🗺️ Lịch trình tour</h3>

<?php if (!empty($tour->lich_trinh)): ?>

    <ul class="list-group">
        <?php foreach (explode("\n", $tour->lich_trinh) as $ngay): ?>
            <li class="list-group-item">
                <?= htmlspecialchars(trim($ngay)) ?>
            </li>
        <?php endforeach; ?>
    </ul>

<?php else: ?>

    <div class="alert alert-warning">
        Chưa có lịch trình cho tour này.
    </div>

<?php endif; ?>

            <!-- QUAY LẠI -->
            <a href="index.php?action=guide_schedule&id=<?= htmlspecialchars($_GET['guide_id'] ?? '') ?>" 
               class="btn btn-secondary mt-2">
                Quay lại
            </a>

        </div>

    </div>

</div>

<?php include "views/layout/footer.php"; ?>

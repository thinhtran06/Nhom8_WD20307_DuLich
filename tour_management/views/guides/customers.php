<?php include "views/layout/header.php"; ?>

<?php
$tour_id  = $_GET['tour_id'] ?? 0;
$guide_id = $_GET['guide_id'] ?? 0;
?>

<div class="container" style="margin-left:260px; margin-top:80px;">

    <!-- TITLE + BUTTON -->
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <h3 class="fw-bold text-primary mb-3">👥 Danh sách khách trong đoàn</h3>

            <a class="btn btn-success"
               href="index.php?action=guide_customer_add&tour_id=<?= $tour_id ?>&guide_id=<?= $guide_id ?>">
               ➕ Thêm khách hàng
            </a>
        </div>
    </div>

    <!-- TABLE WRAPPER -->
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white fw-bold">
            📄 Thông tin khách hàng
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover mb-0">

                    <thead class="table-light">
                        <tr>
                            <th>Họ tên</th>
                            <th>Email</th>
                            <th>Điện thoại</th>
                            <th>Giới tính</th>
                            <th>Quốc tịch</th>
                            <th>Ghi chú</th>
                            <th style="width: 120px;">Hành động</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php if (!empty($customers)): ?>
                            <?php foreach ($customers as $c): ?>
                                <tr>
                                    <td><?= htmlspecialchars($c['ho_ten'] ?? '') ?></td>
                                    <td><?= htmlspecialchars($c['email'] ?? '') ?></td>
                                    <td><?= htmlspecialchars($c['dien_thoai'] ?? '') ?></td>
                                    <td><?= htmlspecialchars($c['gioi_tinh'] ?? '') ?></td>
                                    <td><?= htmlspecialchars($c['quoc_tich'] ?? '') ?></td>
                                    <td><?= nl2br(htmlspecialchars($c['ghi_chu'] ?? '')) ?></td>

                                    <td class="text-center">
                                        <a href="index.php?action=guide_customer_delete
                                            &tour_id=<?= $tour_id ?>
                                            &guide_id=<?= $guide_id ?>
                                            &customer_id=<?= $c['id'] ?>"
                                           class="btn btn-danger btn-sm"
                                           onclick="return confirm('Bạn chắc chắn muốn xóa khách này?');">
                                           🗑️ Xóa
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>

                        <?php else: ?>
                            <tr>
                                <td colspan="7" class="text-center text-muted py-4">
                                    Không có khách nào.
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>

                </table>
            </div>
        </div>
    </div>

    <a href="javascript:history.back();" class="btn btn-secondary mt-3">⬅ Quay lại</a>

</div>

<?php include "views/layout/footer.php"; ?>
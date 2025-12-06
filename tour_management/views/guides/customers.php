<?php include "views/layout/header.php"; ?>

<div class="main-content container mt-4">   <!-- 👈 THÊM main-content -->

    <div class="card shadow-sm">
        <div class="card-header bg-white py-3">
            <h4 class="mb-0">
                👥 Danh sách khách trong tour 
                <span class="text-primary">
                    <?= htmlspecialchars($tour->ten_tour ?? ("#".$tour_id)) ?>
                </span>
            </h4>
        </div>

        <div class="card-body">

            <p class="mb-3">
                <strong>Tour ID:</strong> <?= (int)$tour_id ?> |
                <strong>HDV ID:</strong> <?= (int)$guide_id ?>
            </p>

            <?php if (empty($customers)): ?>
                <div class="alert alert-warning">Không có khách nào.</div>
                <a href="index.php?action=guide_schedule&id=<?= $guide_id ?>" class="btn btn-secondary">Quay lại</a>
            <?php else: ?>

                <table class="table table-bordered align-middle text-center">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Họ tên</th>
                            <th>Email</th>
                            <th>Điện thoại</th>
                            <th>Giới tính</th>
                            <th>Quốc tịch</th>
                            <th>Ghi chú</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($customers as $i => $c): ?>
                            <tr>
                                <td><?= $i + 1 ?></td>
                                <td><?= htmlspecialchars($c->ho_ten ?? '') ?></td>
                                <td><?= htmlspecialchars($c->email ?? '') ?></td>
                                <td><?= htmlspecialchars($c->dien_thoai ?? '') ?></td>
                                <td><?= htmlspecialchars($c->gioi_tinh ?? '') ?></td>
                                <td><?= htmlspecialchars($c->quoc_tich ?? '') ?></td>
                                <td><?= htmlspecialchars($c->ghi_chu ?? '') ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>

                <a href="index.php?action=guide_schedule&id=<?= $guide_id ?>" class="btn btn-secondary">Quay lại</a>

            <?php endif; ?>

        </div>
    </div>

</div>

<?php include "views/layout/footer.php"; ?>

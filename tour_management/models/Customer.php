<?php include "views/layout/header.php"; ?>

<style>
    .page-title {
        font-size: 26px;
        font-weight: 700;
        color: #2c3e50;
        margin-bottom: 6px;
    }

    .info-box {
        background: #f8f9fa;
        padding: 12px 20px;
        border-left: 4px solid #007bff;
        border-radius: 6px;
        margin-bottom: 20px;
        font-size: 15px;
    }

    .card-wrapper {
        background: white;
        padding: 20px;
        border-radius: 12px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    }

    table thead th {
        background: #eef2f7 !important;
        font-weight: 600;
    }
</style>

<div class="main-content">

    <!-- TITLE -->
    <h1 class="page-title">
        👥 Danh sách khách – 
        <?= htmlspecialchars($tour->ten_tour ?? 'Tour không xác định') ?>
    </h1>

    <!-- INFO BOX -->
    <div class="info-box">
        <strong>Tour ID:</strong> <?= (int)$tour_id ?> &nbsp; | &nbsp;
        <strong>Hướng dẫn viên ID:</strong> <?= (int)$guide_id ?>
    </div>

    <hr>

    <!-- EMPTY STATE -->
    <?php if (empty($customers)): ?>
        <div class="alert alert-warning">
            Không có khách nào trong tour này.
        </div>
        <a href="index.php?action=guide_schedule&id=<?= (int)$guide_id ?>" class="btn btn-secondary mt-3">
            ⬅ Quay lại
        </a>
        <?php include "views/layout/footer.php"; return; ?>
    <?php endif; ?>

    <!-- TABLE WRAPPER -->
    <div class="card-wrapper">

        <table class="table table-bordered align-middle">
            <thead>
                <tr>
                    <th style="width: 60px;">#</th>
                    <th>Họ tên</th>
                    <th>Điện thoại</th>
                    <th>Email</th>
                    <th>Giới tính</th>
                    <th>Quốc tịch</th>
                    <th>Ghi chú</th>
                </tr>
            </thead>

            <tbody>
            <?php foreach ($customers as $i => $c): ?>
                <tr>
                    <td><strong><?= $i + 1 ?></strong></td>

                    <td><?= htmlspecialchars($c->ho_ten ?? '') ?></td>
                    <td><?= htmlspecialchars($c->dien_thoai ?? '') ?></td>
                    <td><?= htmlspecialchars($c->email ?? '') ?></td>

                    <td>
                        <?php if (($c->gioi_tinh ?? '') === 'Nam'): ?>
                            <span class="badge bg-primary">Nam</span>
                        <?php elseif (($c->gioi_tinh ?? '') === 'Nữ'): ?>
                            <span class="badge bg-danger">Nữ</span>
                        <?php else: ?>
                            <span class="badge bg-secondary">Khác</span>
                        <?php endif; ?>
                    </td>

                    <td><?= htmlspecialchars($c->quoc_tich ?? '') ?></td>

                    <td><?= htmlspecialchars($c->ghi_chu ?? '') ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>

        </table>

    </div>

    <a href="index.php?action=guide_schedule&id=<?= (int)$guide_id ?>" class="btn btn-secondary mt-3">
        ⬅ Quay lại
    </a>

</div>

<?php include "views/layout/footer.php"; ?>

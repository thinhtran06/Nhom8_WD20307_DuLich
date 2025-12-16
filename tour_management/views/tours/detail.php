<?php require_once 'views/layout/header.php'; ?>

<div class="container">
    <h2>Chi Tiết Tour</h2>
    
    <div class="card">
        <div class="card-body">

            <h3><?= htmlspecialchars($tour->ten_tour) ?></h3>
            <hr>

            <p><strong>Mô tả:</strong> <?= htmlspecialchars($tour->mo_ta) ?></p>

            <div class="row">
                <div class="col-md-6">
                    <p><strong>Điểm khởi hành:</strong> <?= htmlspecialchars($tour->diem_khoi_hanh) ?></p>
                    <p><strong>Điểm đến:</strong> <?= htmlspecialchars($tour->diem_den) ?></p>
                </div>

                <div class="col-md-6">
                    <p><strong>Số ngày:</strong> <?= htmlspecialchars($tour->so_ngay) ?> ngày</p>
                    <p><strong>Giá:</strong> <?= number_format($tour->gia_tour) ?> VNĐ</p>
                    <p><strong>Số chỗ:</strong> <?= htmlspecialchars($tour->so_cho) ?> người</p>
                    <p><strong>Trạng thái:</strong> 
                        <span class="badge badge-info"><?= htmlspecialchars($tour->trang_thai) ?></span>
                    </p>
                </div>
            </div>

            <h4 class="mt-4 mb-3">📋 Lịch Trình Chi Tiết (<?= $tour->so_ngay ?> Ngày)</h4>

            <?php if (!empty($tour->lich_trinh)): ?>
                <ul class="list-group">
                    <?php foreach (explode("\n", $tour->lich_trinh) as $ngay): ?>
                        <li class="list-group-item">
                            <?= htmlspecialchars(trim($ngay)) ?>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php else: ?>
                <p class="alert alert-warning">
                    Chưa có lịch trình chi tiết nào được thiết lập cho tour này.
                </p>
            <?php endif; ?>

            <hr class="mt-4">

            <a href="index.php?action=tour_index" class="btn btn-secondary">Quay lại</a>
            <a href="index.php?action=tour_edit&id=<?= $tour->id ?>" class="btn btn-warning">Chỉnh sửa</a>

        </div>
    </div>
</div>
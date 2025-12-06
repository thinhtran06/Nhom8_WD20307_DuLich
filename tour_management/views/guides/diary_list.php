<?php include "views/layout/header.php"; ?>

<style>
    .page-title {
        font-size: 26px;
        font-weight: 700;
        margin-bottom: 10px;
        color: #2c3e50;
    }

    .info-box {
        background: #f8f9fa;
        padding: 12px 20px;
        border-left: 4px solid #007bff;
        margin-bottom: 20px;
        border-radius: 6px;
        font-size: 15px;
    }

    .card-style {
        background: white;
        padding: 20px;
        border-radius: 12px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    }

    table img {
        border: 1px solid #ddd;
        border-radius: 8px;
        padding: 2px;
        background: #fff;
    }
</style>

<div class="main-content">

    <!-- TITLE -->
    <h1 class="page-title">
        📘 Nhật ký tour: 
        <?= htmlspecialchars($tour->ten_tour ?? $tour['ten_tour'] ?? 'Không xác định') ?>
    </h1>

    <!-- GUIDE INFO -->
    <div class="info-box">
        <strong>👨‍🏫 Hướng dẫn viên:</strong>
        <?= htmlspecialchars($guide->ho_ten ?? $guide['ho_ten'] ?? 'Không xác định') ?>
    </div>

    <!-- BUTTON -->
    <a href="index.php?action=guide_diary_add&tour_id=<?= ($tour->id ?? $tour['id']) ?>&guide_id=<?= ($guide->id ?? $guide['id']) ?>"
       class="btn btn-primary mb-3">
        + Thêm nhật ký
    </a>

    <!-- TABLE WRAPPER -->
    <div class="card-style">

        <table class="table table-bordered align-middle">
            <thead class="table-light">
                <tr>
                    <th width="120">Ngày</th>
                    <th width="220">Sự kiện</th>
                    <th width="220">Sự cố</th>
                    <th width="220">Phản hồi khách</th>
                    <th width="160">Hình ảnh</th>
                    <th width="80">Thao tác</th>
                </tr>
            </thead>

            <tbody>
            <?php if (!empty($diaries)): ?>
                <?php foreach ($diaries as $d): ?>

                <tr>
                    <td><?= htmlspecialchars($d->ngay ?? $d['ngay'] ?? '') ?></td>

                    <td><?= nl2br(htmlspecialchars($d->su_kien ?? $d['su_kien'] ?? '')) ?></td>

                    <td><?= nl2br(htmlspecialchars($d->su_co ?? $d['su_co'] ?? '')) ?></td>

                    <td><?= nl2br(htmlspecialchars($d->phan_hoi ?? $d['phan_hoi'] ?? '')) ?></td>

                    <td>
                        <?php
                            $imgList = $d->hinh_anh ?? $d['hinh_anh'] ?? '';
                        ?>

                        <?php if (!empty($imgList)): ?>
                            <?php foreach (explode(",", $imgList) as $img): ?>
                                <img src="uploads/diary/<?= trim($img) ?>" width="60" class="mb-1">
                            <?php endforeach; ?>
                        <?php else: ?>
                            <span class="text-muted">Không có</span>
                        <?php endif; ?>
                    </td>

                    <td>
                        <a class="btn btn-sm btn-warning"
                           href="index.php?action=guide_diary_edit&id=<?= ($d->id ?? $d['id']) ?>">
                            Sửa
                        </a>
                    </td>
                </tr>

                <?php endforeach; ?>

            <?php else: ?>
                <tr>
                    <td colspan="6" class="text-center text-muted py-3">
                        Chưa có nhật ký nào cho tour này.
                    </td>
                </tr>
            <?php endif; ?>
            </tbody>

        </table>

    </div>

    <a href="index.php?action=guide_schedule&id=<?= ($guide->id ?? $guide['id']) ?>" class="btn btn-secondary mt-3">
        ⬅ Quay lại
    </a>

</div>

<?php include "views/layout/footer.php"; ?>

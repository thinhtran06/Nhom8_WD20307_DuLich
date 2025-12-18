<?php
// ==================
// Guard variables
// ==================
$diaries  = $diaries  ?? [];
$tour_id  = $tour_id  ?? ($_GET['tour_id']  ?? 0);
$guide_id = $guide_id ?? ($_GET['guide_id'] ?? 0);
?>

<?php include "views/layout/header.php"; ?>

<div class="container">

    <div class="diary-wrapper">

        <h3 class="diary-title">📘 Nhật ký tour</h3>

        <?php if (empty($diaries)): ?>
            <div class="alert alert-info diary-empty">
                Chưa có nhật ký nào cho tour này.
            </div>
        <?php else: ?>

            <div class="table-responsive">
                <table class="table table-bordered table-striped diary-table">
                    <thead>
                        <tr>
                            <th width="120">Ngày</th>
                            <th width="180">Tiêu đề</th>
                            <th>Nội dung</th>
                            <th>Sự cố</th>
                            <th>Phản hồi khách</th>
                            <th>Cách xử lý</th>
                            <th width="140">Thao tác</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php foreach ($diaries as $e): ?>
                            <tr>
                                <td class="text-center">
                                    <?= htmlspecialchars($e['ngay'] ?? '') ?>
                                </td>

                                <td>
                                    <strong>
                                        <?= htmlspecialchars($e['tieu_de'] ?? '') ?>
                                    </strong>
                                </td>

                                <td>
                                    <?= nl2br(htmlspecialchars($e['noi_dung'] ?? '')) ?>
                                </td>

                                <td>
                                    <?= nl2br(htmlspecialchars($e['su_co'] ?? '—')) ?>
                                </td>

                                <td>
                                    <?= nl2br(htmlspecialchars($e['phan_hoi_khach'] ?? '—')) ?>
                                </td>

                                <td>
                                    <?= nl2br(htmlspecialchars($e['cach_xu_ly'] ?? '—')) ?>
                                </td>

                                <td class="text-center diary-actions">
                                    <a class="btn btn-warning btn-sm mb-1"
                                       href="index.php?action=guide_diary_edit&id=<?= (int)$e['id'] ?>">
                                        Sửa
                                    </a>

                                    <a class="btn btn-danger btn-sm"
                                       onclick="return confirm('Xóa nhật ký này?')"
                                       href="index.php?action=guide_diary_delete&id=<?= (int)$e['id'] ?>&tour_id=<?= (int)$tour_id ?>&guide_id=<?= (int)$guide_id ?>">
                                        Xóa
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

        <?php endif; ?>

        <div class="mt-3">
            <a href="index.php?action=guide_diary_add&tour_id=<?= $tour_id ?>&guide_id=<?= $guide_id ?>"
   class="btn btn-primary">
    + Thêm nhật ký
</a>


            <a href="index.php?action=guide_schedule&id=<?= (int)$guide_id ?>"
               class="btn btn-secondary ms-2">
                ⬅ Quay lại
            </a>
        </div>

    </div>
</div>

<?php include "views/layout/footer.php"; ?>
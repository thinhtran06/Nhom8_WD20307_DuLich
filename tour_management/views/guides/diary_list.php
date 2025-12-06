<?php include "views/layout/header.php"; ?>

<h2>📘 Nhật ký tour</h2>

<p><strong>Tour:</strong> <?= htmlspecialchars($tour->ten_tour ?? '') ?></p>
<p><strong>Hướng dẫn viên:</strong> <?= htmlspecialchars($guide->ho_ten ?? '') ?></p>

<a href="index.php?action=guide_diary_add&tour_id=<?= $tour_id ?>&guide_id=<?= $guide_id ?>"
   class="btn btn-primary mb-3">+ Thêm nhật ký</a>


<table class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>Ngày</th>
            <th>Tiêu đề</th>
            <th>Nội dung</th>
            <th>Sự cố</th>
            <th>Phản hồi khách</th>
            <th>Cách xử lý</th>
            <th>Thao tác</th>
        </tr>
    </thead>

    <tbody>
        <?php if (empty($diaries)): ?>
            <tr>
                <td colspan="7" class="text-center text-muted">
                    Chưa có nhật ký nào cho tour này.
                </td>
            </tr>
        <?php else: ?>
            <?php foreach ($diaries as $e): ?>
                <tr>
                    <td><?= $e['ngay'] ?></td>
                    <td><?= htmlspecialchars($e['tieu_de']) ?></td>
                    <td><?= nl2br(htmlspecialchars($e['noi_dung'])) ?></td>
                    <td><?= nl2br(htmlspecialchars($e['su_co'])) ?></td>
                    <td><?= nl2br(htmlspecialchars($e['phan_hoi_khach'])) ?></td>
                    <td><?= nl2br(htmlspecialchars($e['cach_xu_ly'])) ?></td>

                    <td>
                        <a class="btn btn-warning btn-sm"
                           href="index.php?action=guide_diary_edit&id=<?= $e['id'] ?>">
                           Sửa
                        </a>
                        <a class="btn btn-danger btn-sm"
                    href="index.php?action=guide_diary_delete&id=<?= $e['id'] ?>&tour_id=<?= $tour_id ?>&guide_id=<?= $guide_id ?>"
                    onclick="return confirm('Bạn có chắc chắn muốn xóa nhật ký này?');">
                            Xóa
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
    </tbody>
</table>

<a href="javascript:history.back()" class="btn btn-secondary">Quay lại</a>

<?php include "views/layout/footer.php"; ?>

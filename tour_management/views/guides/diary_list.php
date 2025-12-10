<?php include "views/layout/header.php"; ?>

<div class="container mt-4">

<h3>📘 Nhật ký tour</h3>

<?php if (empty($entries)): ?>
    <div class="alert alert-info mt-3">Chưa có nhật ký nào.</div>
<?php else: ?>

<table class="table table-bordered table-striped mt-3">
    <thead class="table-light">
        <tr>
            <th>Ngày ghi</th>
            <th>Nội dung</th>
            <th>Ghi chú</th>
            <th>Thao tác</th>
        </tr>
    </thead>

    <tbody>
        <?php foreach ($entries as $e): ?>
            <tr>
                <td><?= htmlspecialchars($e['created_at'] ?? '') ?></td>
                <td><?= nl2br(htmlspecialchars($e['noi_dung'] ?? '')) ?></td>
                <td><?= nl2br(htmlspecialchars($e['ghi_chu'] ?? '')) ?></td>

                <td>
                    <a class="btn btn-warning btn-sm"
                       href="index.php?action=guide_diary_edit&id=<?= $e['id'] ?>">
                        Sửa
                    </a>

                    <a class="btn btn-danger btn-sm"
                       onclick="return confirm('Xóa nhật ký này?')"
                       href="index.php?action=guide_diary_delete&id=<?= $e['id'] ?>">
                        Xóa
                    </a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php endif; ?>

<a href="javascript:history.back();" class="btn btn-secondary mt-3">⬅ Quay lại</a>

</div>

<?php include "views/layout/footer.php"; ?>

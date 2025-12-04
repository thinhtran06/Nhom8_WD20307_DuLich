<?php include "views/layout/header.php"; ?>

<?php
$tour_id  = $_GET['tour_id'] ?? 0;
$guide_id = $_GET['guide_id'] ?? 0;
?>

<h3 class="mt-3">Danh sách khách trong đoàn</h3>

<a class="btn btn-success mb-3"
   href="index.php?action=guide_customer_add&tour_id=<?= $tour_id ?>&guide_id=<?= $guide_id ?>">
   + Thêm khách hàng
</a>

<div class="table-responsive mt-3">
<table class="table table-bordered table-striped table-hover">

    <thead class="table-light">
        <tr>
            <th>Họ tên</th>
            <th>Email</th>
            <th>Điện thoại</th>
            <th>Giới tính</th>
            <th>Quốc tịch</th>
            <th>Ghi chú</th>
            <th>Hành động</th>
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


            <td>
                <a href="index.php?action=guide_customer_delete&tour_id=<?= $tour_id ?>&guide_id=<?= $guide_id ?>&customer_id=<?= $c['customer_id'] ?>"
                   class="btn btn-danger btn-sm"
                   onclick="return confirm('Bạn chắc chắn muốn xóa khách này?');">
                   Xóa
                </a>
            </td>
        </tr>
    <?php endforeach; ?>

<?php else: ?>
    <tr>
        <td colspan="7" class="text-center">Không có khách nào.</td>
    </tr>
<?php endif; ?>
</tbody>



</table>
</div>

<a href="javascript:history.back();" class="btn btn-secondary mt-2">Quay lại</a>

<?php include "views/layout/footer.php"; ?>

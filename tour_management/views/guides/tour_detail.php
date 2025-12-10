<?php include "views/layout/header.php"; ?>

<?php 
// Đảm bảo $tour là object hợp lệ
if (empty($tour) || !is_object($tour)) {
    echo "<div class='alert alert-danger mt-4'>Không tìm thấy thông tin tour.</div>";
    echo "<button onclick='history.back()' class='btn btn-secondary mt-3'>Quay lại</button>";
    include "views/layout/footer.php";
    return;
}
?>

<h3 class="mt-3">Chi tiết tour</h3>

<table class="table table-bordered table-striped">
    <tr>
        <th style="width: 180px">Tên tour</th>
        <td><?= htmlspecialchars($tour->ten_tour ?? 'Không rõ') ?></td>
    </tr>

    <tr>
        <th>Mô tả</th>
        <td><?= nl2br(htmlspecialchars($tour->mo_ta ?? '')) ?></td>
    </tr>

    <tr>
        <th>Lịch trình</th>
        <td><?= nl2br(htmlspecialchars($tour->lich_trinh ?? 'Chưa có lịch trình')) ?></td>
    </tr>

    <tr>
        <th>Điểm khởi hành</th>
        <td><?= htmlspecialchars($tour->diem_khoi_hanh ?? 'Không rõ') ?></td>
    </tr>

    <tr>
        <th>Điểm đến</th>
        <td><?= htmlspecialchars($tour->diem_den ?? 'Không rõ') ?></td>
    </tr>

    <tr>
        <th>Ngày khởi hành</th>
        <td><?= htmlspecialchars($tour->ngay_khoi_hanh ?? 'Không rõ') ?></td>
    </tr>

    <tr>
        <th>Số ngày</th>
        <td>
            <?php
                echo (!empty($tour->so_ngay) && $tour->so_ngay > 0)
                    ? $tour->so_ngay . " ngày"
                    : "Không rõ";
            ?>
        </td>
    </tr>

    <tr>
        <th>Giá tour</th>
        <td><?= number_format((int)($tour->gia_tour ?? 0)) ?> VNĐ</td>
    </tr>
</table>

<hr>

<h4 class="mt-4">Danh sách khách trong tour</h4>

<div class="table-responsive">
<table class="table table-bordered table-striped">
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
            <tr>
                <td><?= htmlspecialchars($c['ho_ten'] ?? '') ?></td>
                <td><?= htmlspecialchars($c['email'] ?? '') ?></td>
                <td><?= htmlspecialchars($c['dien_thoai'] ?? '') ?></td>
                <td><?= htmlspecialchars($c['gioi_tinh'] ?? '') ?></td>
                <td><?= htmlspecialchars($c['quoc_tich'] ?? '') ?></td>
                <td><?= nl2br(htmlspecialchars($c['ghi_chu'] ?? '')) ?></td>
            </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr><td colspan="6" class="text-center text-muted">Không có khách nào.</td></tr>
        <?php endif; ?>
    </tbody>
</table>
</div>

<a href="javascript:history.back();" class="btn btn-secondary mt-3">Quay lại</a>

<?php include "views/layout/footer.php"; ?>

<?php require_once 'views/layout/header.php'; ?>

<div class="container">
    <h2>📄 Chi tiết yêu cầu tour</h2>

    <table class="table table-bordered">
        <tr><th>ID</th><td><?= $data['id'] ?></td></tr>
        <tr><th>Tên khách hàng</th><td><?= htmlspecialchars($data['ten_khach_hang']) ?></td></tr>
        <tr><th>Điện thoại</th><td><?= htmlspecialchars($data['dien_thoai']) ?></td></tr>
        <tr><th>Email</th><td><?= htmlspecialchars($data['email']) ?></td></tr>
        <tr><th>Số lượng khách</th><td><?= htmlspecialchars($data['so_luong_khach']) ?></td></tr>
        <tr><th>Điểm đến mong muốn</th><td><?= htmlspecialchars($data['diem_den_mong_muon']) ?></td></tr>
        <tr><th>Ngày khởi hành mong muốn</th><td><?= htmlspecialchars($data['ngay_khoi_hanh_mong_luon']) ?></td></tr>
        <tr><th>Ghi chú</th><td><?= htmlspecialchars($request['ghi_chu'] ?? '', ENT_QUOTES, 'UTF-8') ?>
</td></tr>
    </table>
    <a href="index.php?action=tour_request_index" class="btn btn-secondary">⬅ Quay lại</a>
</div>

<?php require_once 'views/layout/footer.php'; ?>

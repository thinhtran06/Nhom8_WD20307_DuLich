<?php require_once 'views/layout/header.php'; ?>

<div class="container">
    <h2>📄 Chi tiết yêu cầu tour</h2>

    <table class="table table-bordered">
        <tr>
            <th>Tên khách hàng</th>
            <td><?= htmlspecialchars((string)($this->request->ten_khach_hang ?? ''), ENT_QUOTES, 'UTF-8') ?></td>
        </tr>
        <tr>
            <th>Điện thoại</th>
            <td><?= htmlspecialchars((string)($this->request->dien_thoai ?? ''), ENT_QUOTES, 'UTF-8') ?></td>
        </tr>
        <tr>
            <th>Email</th>
            <td><?= htmlspecialchars((string)($this->request->email ?? ''), ENT_QUOTES, 'UTF-8') ?></td>
        </tr>
        <tr>
            <th>Số lượng khách</th>
            <td><?= htmlspecialchars((string)($this->request->so_luong_khach ?? ''), ENT_QUOTES, 'UTF-8') ?></td>
        </tr>
        <tr>
            <th>Điểm đến mong muốn</th>
            <td><?= htmlspecialchars((string)($this->request->diem_den_mong_muon ?? ''), ENT_QUOTES, 'UTF-8') ?></td>
        </tr>
        <tr>
            <th>Ngày khởi hành mong muốn</th>
            <td><?= htmlspecialchars((string)($this->request->ngay_khoi_hanh_mong_luon ?? ''), ENT_QUOTES, 'UTF-8') ?></td>
        </tr>
        <tr>
            <th>Ghi chú</th>
            <td><?= htmlspecialchars((string)($this->request->yeu_cau_chi_tiet ?? ''), ENT_QUOTES, 'UTF-8') ?></td>
        </tr>
    </table>

    <a href="index.php?action=tour_request_index" class="btn btn-secondary">⬅ Quay lại</a>
</div>

<?php require_once 'views/layout/footer.php'; ?>

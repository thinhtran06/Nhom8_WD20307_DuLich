<!-- views/guide_work/tours.php -->
<h2>Lịch tour của: <?= htmlspecialchars($guide['ho_ten']) ?></h2>

<p>
    <a href="index.php?action=guide_work_select">← Chọn HDV khác</a>
</p>

<?php if (empty($tours)): ?>
    <p>HDV hiện chưa được phân công tour nào.</p>
<?php else: ?>
    <table border="1" cellpadding="8" cellspacing="0">
        <thead>
            <tr>
                <th>Tên tour</th>
                <th>Ngày bắt đầu</th>
                <th>Ngày kết thúc</th>
                <th>Điểm khởi hành</th>
                <th>Xem chi tiết</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($tours as $tour): ?>
            <tr>
                <td><?= htmlspecialchars($tour['ten_tour']) ?></td>
                <td><?= htmlspecialchars($tour['ngay_bat_dau']) ?></td>
                <td><?= htmlspecialchars($tour['ngay_ket_thuc']) ?></td>
                <td><?= htmlspecialchars($tour['dia_diem_khoi_hanh'] ?? '') ?></td>
                <td>
                    <a href="index.php?action=guide_work_detail&tour_id=<?= $tour['id'] ?>&guide_id=<?= $guide['id'] ?>">
                        Lịch trình & nhiệm vụ
                    </a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>

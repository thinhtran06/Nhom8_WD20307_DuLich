<!-- views/guide_work/tour_detail.php -->
<h2>Lịch trình tour: <?= htmlspecialchars($tour['ten_tour']) ?></h2>
<p>Hướng dẫn viên: <strong><?= htmlspecialchars($guide['ho_ten']) ?></strong></p>

<p>
    <a href="index.php?action=guide_work_tours&guide_id=<?= $guide['id'] ?>">← Quay lại danh sách tour</a>
</p>

<?php if (empty($schedule)): ?>
    <p>Tour này chưa có lịch trình chi tiết.</p>
<?php else: ?>
    <table border="1" cellpadding="8" cellspacing="0">
        <thead>
            <tr>
                <th>Ngày</th>
                <th>Ngày đi</th>
                <th>Địa điểm</th>
                <th>Hoạt động</th>
                <th>Nhiệm vụ của HDV</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($schedule as $d): ?>
            <tr>
                <td>Ngày <?= (int)$d['day_number'] ?></td>
                <td><?= htmlspecialchars($d['ngay']) ?></td>
                <td><?= htmlspecialchars($d['dia_diem']) ?></td>
                <td><?= nl2br(htmlspecialchars($d['hoat_dong'])) ?></td>
                <td><?= nl2br(htmlspecialchars($d['nhiem_vu_hdv'])) ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>

<?php include "views/layout/header.php"; ?>

<?php
// Hàm tránh lỗi null
function safe($v) {
    return htmlspecialchars($v ?? '', ENT_QUOTES, 'UTF-8');
}
?>

<h3 class="mb-3">
    📍 Điểm danh khách – 
    <?= safe($tour->ten_tour ?? ('Tour ID ' . $tour_id)) ?>
</h3>

<p>
    <strong>Tour ID:</strong> <?= (int)$tour_id ?> |
    <strong>Hướng dẫn viên ID:</strong> <?= (int)$guide_id ?>
</p>

<hr>

<?php if (empty($customers)): ?>
    <div class="alert alert-warning">
        Không có khách nào trong tour này.
    </div>
    <button type="button" onclick="history.back();" class="btn btn-secondary mt-3">Quay lại</button>
    <?php include "views/layout/footer.php"; return; ?>
<?php endif; ?>

<!-- FORM ĐIỂM DANH -->
<form method="POST" action="index.php?action=guide_save_checkin" class="mb-4">

    <input type="hidden" name="tour_id" value="<?= (int)$tour_id ?>">
    <input type="hidden" name="guide_id" value="<?= (int)$guide_id ?>">

    <div class="mb-3">
        <label class="form-label fw-bold">Điểm tập trung / chặng:</label>
        <input type="text" name="diem_tap_trung" class="form-control"
               value="<?= safe($diem_tap_trung ?: 'Điểm tập trung 1') ?>" required>
        <div class="form-text">
            Ví dụ: Bến xe miền Tây, Sân bay Tân Sơn Nhất, Trạm dừng chân 1...
        </div>
    </div>

    <div class="table-responsive">
    <table class="table table-bordered align-middle">
        <thead class="table-light">
            <tr>
                <th>#</th>
                <th>Khách hàng</th>
                <th>Điện thoại</th>
                <th>Ghi chú</th>
                <th>Trạng thái</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($customers as $i => $c): ?>
                <?php
                    $cid    = $c['customer_id'] ?? $c['id'] ?? null;
                    if (!$cid) continue;

                    $status = $statusMap[$cid] ?? 'Chua_den';
                ?>
                <tr>
                    <td><?= $i + 1 ?></td>
                    <td><?= safe($c['ho_ten'] ?? '') ?></td>
                    <td><?= safe($c['dien_thoai'] ?? '') ?></td>
                    <td><?= safe($c['ghi_chu'] ?? '') ?></td>
                    <td style="min-width: 160px;">
                        <select name="trang_thai[<?= (int)$cid ?>]" class="form-select form-select-sm">
                            <option value="Da_den"   <?= $status === 'Da_den'   ? 'selected' : '' ?>>Đã đến</option>
                            <option value="Chua_den" <?= $status === 'Chua_den' ? 'selected' : '' ?>>Chưa đến</option>
                            <option value="Vang"     <?= $status === 'Vang'     ? 'selected' : '' ?>>Vắng</option>
                        </select>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    </div>

    <button class="btn btn-primary">Lưu điểm danh</button>
    <button type="button" onclick="history.back();" class="btn btn-secondary ms-2">Quay lại</button>
</form>

<hr>

<h4>Lịch sử điểm danh</h4>

<?php if (empty($history)): ?>
    <p class="text-muted">Chưa có lịch sử check-in cho tour này.</p>
<?php else: ?>
    <div class="table-responsive">
    <table class="table table-sm table-striped">
        <thead>
            <tr>
                <th>Thời gian</th>
                <th>Khách</th>
                <th>Điểm tập trung / chặng</th>
                <th>Trạng thái</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($history as $h): ?>
                <tr>
                    <td><?= safe($h['thoi_gian'] ?? '') ?></td>
                    <td><?= safe($h['ho_ten'] ?? '') ?></td>
                    <td><?= safe($h['diem_tap_trung'] ?? '') ?></td>
                    <td>
                        <?php if (($h['trang_thai'] ?? '') === 'Da_den'): ?>
                            <span class="badge bg-success">Đã đến</span>
                        <?php elseif (($h['trang_thai'] ?? '') === 'Vang'): ?>
                            <span class="badge bg-danger">Vắng</span>
                        <?php else: ?>
                            <span class="badge bg-secondary">Chưa đến</span>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    </div>
<?php endif; ?>

<?php include "views/layout/footer.php"; ?>

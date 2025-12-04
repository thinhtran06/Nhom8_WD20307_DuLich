<?php include "views/layout/header.php"; ?>

<h3>Phân công Hướng Dẫn Viên cho tour: 
    <span class="text-primary"><?= htmlspecialchars($tour->ten_tour) ?></span>
</h3>

<p><strong>Thời gian:</strong> 
    <?= htmlspecialchars($tour->ngay_bat_dau) ?> 
    đến 
    <?= htmlspecialchars($tour->ngay_ket_thuc) ?>
</p>

<hr>

<h5>Hướng dẫn viên đã được phân công</h5>

<table class="table table-bordered table-striped align-middle">
    <thead class="table-light">
        <tr>
            <th>Họ tên</th>
            <th>Điện thoại</th>
            <th>Ngày bắt đầu</th>
            <th>Ngày kết thúc</th>
            <th>Ghi chú</th>
            <th style="width: 80px;">Xoá</th>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($assigned)): ?>
            <?php foreach($assigned as $a): ?>
                <tr>
                    <td><?= htmlspecialchars($a->ho_ten) ?></td>
                    <td><?= htmlspecialchars($a->dien_thoai ?? '') ?></td>
                    <td><?= htmlspecialchars($a->ngay_bat_dau) ?></td>
                    <td><?= htmlspecialchars($a->ngay_ket_thuc) ?></td>
                    <td><?= htmlspecialchars($a->ghi_chu) ?></td>
                    <td class="text-center">
                        <a href="index.php?action=guide_remove&schedule_id=<?= $a->id ?>&tour_id=<?= $tour->id ?>"
                           class="btn btn-sm btn-danger"
                           onclick="return confirm('Xoá HDV này khỏi tour?');">
                           Xoá
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="6" class="text-center text-muted">
                    Chưa phân công HDV nào cho tour này.
                </td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>

<hr>

<h5>Thêm HDV vào tour</h5>

<form method="POST" action="index.php?action=guide_assign" class="mt-2">
    <input type="hidden" name="tour_id" value="<?= $tour->id ?>">

    <div class="row">
        <div class="col-md-5 mb-3">
            <label>Chọn Hướng dẫn viên</label>
            <select name="guide_id" class="form-select" required>
                <option value="">-- Chọn HDV --</option>
                <?php foreach($guides as $g): ?>
                    <option value="<?= $g->id ?>">
                        <?= htmlspecialchars($g->ho_ten) ?> 
                        (<?= htmlspecialchars($g->loai_hdv) ?> - <?= htmlspecialchars($g->chuyen_tuyen) ?>)
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="col-md-3 mb-3">
            <label>Ngày bắt đầu</label>
            <input type="date" name="ngay_bat_dau" class="form-control" 
                   value="<?= htmlspecialchars($tour->ngay_bat_dau) ?>" required>
        </div>

        <div class="col-md-3 mb-3">
            <label>Ngày kết thúc</label>
            <input type="date" name="ngay_ket_thuc" class="form-control"
                   value="<?= htmlspecialchars($tour->ngay_ket_thuc) ?>" required>
        </div>

        <div class="col-md-12 mb-3">
            <label>Ghi chú</label>
            <textarea name="ghi_chu" class="form-control" rows="2"></textarea>
        </div>
    </div>

    <button type="submit" class="btn btn-success">Thêm HDV</button>
    <a href="index.php?action=tour_index" class="btn btn-secondary ms-2">Quay lại danh sách tour</a>
</form>
<?php if (!empty($_SESSION['guide_assign_error'])): ?>
    <div class="alert alert-danger"><?= $_SESSION['guide_assign_error']; ?></div>
<?php endif; ?>

<?php if (!empty($_SESSION['guide_assign_success'])): ?>
    <div class="alert alert-success"><?= $_SESSION['guide_assign_success']; ?></div>
<?php endif; ?>

<?php
unset($_SESSION['guide_assign_error'], $_SESSION['guide_assign_success']);
?>

<?php include "views/layout/footer.php"; ?>

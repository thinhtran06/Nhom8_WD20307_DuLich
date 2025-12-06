<?php include "views/layout/header.php"; ?>

<h3 class="mb-4">✏️ Sửa Ngày Nghỉ / Ngày Bận</h3>

<?php if (!empty($_SESSION['timeoff_error'])): ?>
    <div class="alert alert-danger">
        <?= htmlspecialchars($_SESSION['timeoff_error']) ?>
    </div>
    <?php unset($_SESSION['timeoff_error']); ?>
<?php endif; ?>

<div class="card">
    <div class="card-body">
        <form method="POST" action="index.php?action=guide_timeoff_update&id=<?= $timeoff->id ?>">

            <div class="form-row">
                <div class="form-group col-md-4">
                    <label><strong>Hướng dẫn viên</strong></label>
                    <select name="guide_id" class="form-control" required>
                        <?php foreach($guides as $g): ?>
                            <option value="<?= $g->id ?>"
                                <?= ($g->id == $timeoff->guide_id) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($g->ho_ten) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group col-md-3">
                    <label><strong>Từ ngày</strong></label>
                    <input type="date" name="ngay_bat_dau" class="form-control"
                           value="<?= htmlspecialchars($timeoff->ngay_bat_dau) ?>" required>
                </div>

                <div class="form-group col-md-3">
                    <label><strong>Đến ngày</strong></label>
                    <input type="date" name="ngay_ket_thuc" class="form-control"
                           value="<?= htmlspecialchars($timeoff->ngay_ket_thuc) ?>" required>
                </div>

                <div class="form-group col-md-12">
                    <label><strong>Lý do</strong></label>
                    <input type="text" name="ly_do" class="form-control"
                           value="<?= htmlspecialchars($timeoff->ly_do) ?>">
                </div>
            </div>

            <a href="index.php?action=guide_timeoff" class="btn btn-secondary">Quay lại</a>
            <button type="submit" class="btn btn-primary">Cập nhật</button>

        </form>
    </div>
</div>

<?php include "views/layout/footer.php"; ?>

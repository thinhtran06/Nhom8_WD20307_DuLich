<?php include "views/layout/header.php"; ?>

<h3 class="mb-4">📅 Quản lý Ngày Nghỉ / Ngày Bận của Hướng Dẫn Viên</h3>

<?php if (!empty($error)): ?>
    <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
<?php endif; ?>

<?php if (!empty($success)): ?>
    <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
<?php endif; ?>

<div class="card mb-4">
    <div class="card-body">
        <h5 class="card-title">➕ Thêm Ngày Nghỉ / Ngày Bận</h5>

        <form action="index.php?action=guide_timeoff_add" method="POST" class="mt-3">
            <div class="form-row">
                <div class="form-group col-md-4">
                    <label><strong>Hướng dẫn viên</strong></label>
                    <select name="guide_id" class="form-control" required>
                        <option value="">-- Chọn HDV --</option>
                        <?php foreach ($guides as $g): ?>
                            <option value="<?= $g->id ?>" 
                                <?= (isset($selectedGuideId) && $selectedGuideId == $g['id']) ? 'selected' : '' ?>> 
                                <?= htmlspecialchars($g->ho_ten) ?> (<?= htmlspecialchars($g->chuyen_tuyen) ?>)
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group col-md-3">
                    <label><strong>Từ ngày</strong></label>
                    <input type="date" name="ngay_bat_dau" class="form-control" required>
                </div>

                <div class="form-group col-md-3">
                    <label><strong>Đến ngày</strong></label>
                    <input type="date" name="ngay_ket_thuc" class="form-control" required>
                </div>

                <div class="form-group col-md-12">
                    <label><strong>Lý do</strong></label>
                    <input type="text" name="ly_do" class="form-control"
                           placeholder="Ví dụ: Nghỉ phép, việc gia đình, bận tour khác...">
                </div>
            </div>

            <button type="submit" class="btn btn-primary">Lưu</button>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="card-title mb-0">📋 Danh sách Ngày nghỉ / Ngày bận</h5>

            <form method="GET" action="index.php" class="form-inline">
                <input type="hidden" name="action" value="guide_timeoff">
                <label class="mr-2">Lọc theo HDV:</label>
                <select name="guide_id" class="form-control form-control-sm mr-2" onchange="this.form.submit()">
                    <option value="">-- Tất cả --</option>
                    <?php foreach ($guides as $g): ?>
                        <option value="<?= $g->id ?>" 
                            <?= (isset($selectedGuideId) && $selectedGuideId == $g['id']) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($g->ho_ten) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <noscript><button class="btn btn-sm btn-secondary">Lọc</button></noscript>
            </form>
        </div>

        <table class="table table-bordered table-striped mb-0">
            <thead class="thead-light">
                <tr>
                    <th>Hướng dẫn viên</th>
                    <th>Từ ngày</th>
                    <th>Đến ngày</th>
                    <th>Lý do</th>
                    <th style="width: 130px;">Thao tác</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($timeoff)): ?>
                    <?php foreach ($timeoff as $t): ?>
                        <tr>
                            <td><?= htmlspecialchars($t->ho_ten) ?></td>
                            <td><?= htmlspecialchars($t->ngay_bat_dau) ?></td>
                            <td><?= htmlspecialchars($t->ngay_ket_thuc) ?></td>
                            <td><?= htmlspecialchars($t->ly_do) ?></td>
                            <td>
                                <a href="index.php?action=guide_timeoff_edit&id=<?= $t->id ?>" 
                                   class="btn btn-sm btn-warning">Sửa</a>
                                <a href="index.php?action=guide_timeoff_delete&id=<?= $t->id ?>"
                                   class="btn btn-sm btn-danger"
                                   onclick="return confirm('Xoá khoảng nghỉ/bận này?');">
                                   Xoá
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" class="text-center text-muted">Chưa có dữ liệu ngày nghỉ / ngày bận.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include "views/layout/footer.php"; ?>

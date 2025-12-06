<?php include "views/layout/header.php"; ?>

<div class="main-content container mt-4">

    <h3 class="mb-4">🌟 Phân Công Hướng Dẫn Viên Cho Tour</h3>

    <div class="card shadow-sm p-4">

        <p><strong>Tên tour:</strong> <?= htmlspecialchars($tour->ten_tour) ?></p>
        <p><strong>Ngày khởi hành:</strong> <?= htmlspecialchars($tour->ngay_khoi_hanh) ?></p>

        <form action="index.php?action=guide_work_assign_save" method="POST">

            <input type="hidden" name="tour_id" value="<?= $tour->id ?>">

            <label><strong>Chọn Hướng Dẫn Viên:</strong></label>
            <select name="guide_id" class="form-control w-50 mb-3" required>
                <?php foreach ($guides as $g): ?>
                    <option value="<?= $g->id ?>">
                        <?= $g->ho_ten ?> — <?= $g->chuyen_tuyen ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <button class="btn btn-primary">💾 Lưu phân công</button>
            <a href="index.php?action=tour_index" class="btn btn-secondary">Quay lại</a>
        </form>

    </div>

</div>

<?php include "views/layout/footer.php"; ?>

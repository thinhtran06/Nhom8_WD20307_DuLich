<!-- views/guide_work/select_guide.php -->
<h2>Hướng dẫn viên – Xem lịch làm việc & tour được phân công</h2>

<form method="get" action="index.php">
    <input type="hidden" name="action" value="guide_work_tours">
    
    <label for="guide_id">Chọn Hướng dẫn viên:</label>
    <select name="guide_id" id="guide_id" required>
        <option value="">-- Chọn HDV --</option>
        <?php foreach ($guides as $g): ?>
            <option value="<?= $g['id'] ?>">
                <?= htmlspecialchars($g['ho_ten']) ?>
            </option>
        <?php endforeach; ?>
    </select>

    <button type="submit">Xem tour</button>
</form>

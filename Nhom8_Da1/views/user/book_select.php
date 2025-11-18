<div class="section">
    <h2>Chọn Tour để đặt</h2>
    <div class="tour-grid">
        <?php foreach($tours as $tour): ?>
            <div class="tour-card">
                <img src="https://via.placeholder.com/300x150" alt="<?= htmlspecialchars($tour['name']) ?>">
                <h3><?= htmlspecialchars($tour['name']) ?></h3>
                <p>Giá: <?= number_format($tour['price'],0,',','.') ?> VNĐ</p>
                <p><?= substr($tour['description'],0,100) ?>...</p>
                <a href="index.php?page=user&action=book&id=<?= $tour['id'] ?>" class="btn-primary">Đặt tour này</a>
            </div>
        <?php endforeach; ?>
    </div>
</div>

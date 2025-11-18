<div class="section">
    <h2 class="tour-title">Khám phá các Tour hấp dẫn</h2>

    <div class="tour-grid">
        <?php foreach($tours as $tour): ?>
            <div class="tour-card">
                <div class="tour-image">
                    <img src="https://via.placeholder.com/400x220" alt="<?= htmlspecialchars($tour['name']) ?>">
                </div>

                <div class="tour-content">
                    <h3 class="tour-name"><?= htmlspecialchars($tour['name']) ?></h3>
                    <p class="tour-desc"><?= substr($tour['description'], 0, 100) ?>...</p>

                    <div class="tour-info">
                        <span class="tour-price"><?= number_format($tour['price'],0,',','.') ?> VNĐ</span>
                        <a href="index.php?page=user&action=detail&id=<?= $tour['id'] ?>" class="tour-btn">
                            Xem chi tiết →
                        </a>
                    </div>
                </div>

            </div>
        <?php endforeach; ?>
    </div>
</div>
<style>
    .section {
    padding: 20px 0;
}

.tour-title {
    text-align: center;
    font-size: 28px;
    margin-bottom: 25px;
    font-weight: bold;
    color: #333;
}

.tour-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
    gap: 25px;
}

.tour-card {
    background: #fff;
    border-radius: 14px;
    overflow: hidden;
    box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    transition: 0.3s ease;
}

.tour-card:hover {
    transform: translateY(-6px);
    box-shadow: 0 8px 18px rgba(0,0,0,0.15);
}

.tour-image img {
    width: 100%;
    height: 180px;
    object-fit: cover;
    border-bottom: 1px solid #eee;
}

.tour-content {
    padding: 15px;
}

.tour-name {
    font-size: 20px;
    font-weight: bold;
    margin-bottom: 8px;
    color: #222;
}

.tour-desc {
    font-size: 14px;
    color: #555;
    margin-bottom: 12px;
}

.tour-info {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.tour-price {
    font-size: 18px;
    font-weight: bold;
    color: #e63946;
}

.tour-btn {
    background: #0071c2;
    padding: 8px 15px;
    border-radius: 6px;
    color: #fff;
    text-decoration: none;
    transition: 0.2s;
}

.tour-btn:hover {
    background: #005a99;
}

</style>
<style>
    .tour-detail-container {
        max-width: 1100px;
        margin: 0 auto;
        padding: 20px 0;
    }

    .tour-banner img {
        width: 100%;
        height: 350px;
        object-fit: cover;
        border-radius: 12px;
        margin-bottom: 25px;
    }

    .tour-header {
        margin-bottom: 20px;
    }

    .tour-header h2 {
        font-size: 32px;
        margin-bottom: 10px;
        color: #222;
        font-weight: bold;
    }

    .tour-meta {
        display: flex;
        gap: 20px;
        font-size: 15px;
        color: #555;
        margin-bottom: 25px;
    }

    .tour-section {
        background: #fff;
        padding: 20px;
        border-radius: 12px;
        margin-bottom: 25px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.08);
    }

    .tour-section h3 {
        font-size: 22px;
        margin-bottom: 12px;
        color: #0071c2;
    }

    .tour-section p {
        font-size: 15px;
        line-height: 1.6;
        color: #444;
        white-space: pre-line;
    }

    .tour-price-box {
        background: #f1f8ff;
        border-left: 5px solid #0071c2;
        padding: 15px 20px;
        border-radius: 8px;
        margin-bottom: 25px;
        font-size: 18px;
        font-weight: bold;
        color: #d62828;
    }

    .tour-buttons {
        display: flex;
        gap: 15px;
        margin-top: 20px;
    }

    .btn-primary {
        background: #0071c2;
        color: #fff;
        padding: 12px 25px;
        border-radius: 8px;
        font-size: 16px;
        text-decoration: none;
        font-weight: bold;
        transition: 0.2s;
    }
    .btn-primary:hover {
        background: #005a9c;
    }

    .btn-secondary {
        background: #ddd;
        color: #333;
        padding: 12px 25px;
        border-radius: 8px;
        font-size: 16px;
        text-decoration: none;
        transition: 0.2s;
    }
    .btn-secondary:hover {
        background: #cfcfcf;
    }
</style>


<div class="tour-detail-container">

    <?php if($tour): ?>

        <!-- Banner -->
        <div class="tour-banner">
            <img src="https://via.placeholder.com/1100x350" alt="<?= htmlspecialchars($tour['name']) ?>">
        </div>

        <!-- Title -->
        <div class="tour-header">
            <h2><?= htmlspecialchars($tour['name']) ?></h2>
        </div>

        <!-- Meta -->
        <div class="tour-meta">
            <span><strong>Loại tour:</strong> <?= htmlspecialchars($tour['type']) ?></span>
            <span><strong>Nhà cung cấp:</strong> <?= htmlspecialchars($tour['supplier']) ?></span>
        </div>

        <!-- Price -->
        <div class="tour-price-box">
            Giá: <?= number_format($tour['price'], 0, ',', '.') ?> VNĐ / người
        </div>

        <!-- Description -->
        <div class="tour-section">
            <h3>Mô tả chi tiết</h3>
            <p><?= htmlspecialchars($tour['description']) ?></p>
        </div>

        <!-- Policy -->
        <div class="tour-section">
            <h3>Chính sách & Quy định</h3>
            <p><?= htmlspecialchars($tour['policy']) ?></p>
        </div>

        <!-- Buttons -->
        <div class="tour-buttons">
            <a href="index.php?page=user_tours&action=book&id=<?= $tour['id'] ?>" class="btn-primary">Đặt tour ngay</a>
            <a href="index.php?page=user&action=index" class="btn-secondary">← Quay lại danh sách</a>
        </div>

    <?php else: ?>
        <p>Tour không tồn tại.</p>
    <?php endif; ?>

</div>

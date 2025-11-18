<?php 
require_once __DIR__ . '/../app/Models/Tour.php';
$tours = Tour::all(); 
?>

<style>
    .hero {
        text-align:center;
        padding:60px 20px;
        background:#e9f3ff;
        border-radius:10px;
        margin-bottom:40px;
    }
    .hero h1 {
        font-size:40px;
        font-weight:bold;
        margin-bottom:15px;
        color:#003580;
    }
    .hero p {
        font-size:18px;
        margin-bottom:25px;
        color:#444;
    }

    .section {
        max-width:1200px;
        margin:0 auto 40px auto;
    }

    .section h2 {
        font-size:28px;
        margin-bottom:20px;
        font-weight:bold;
        color:#003580;
        border-left:5px solid #0071c2;
        padding-left:15px;
    }

    .tour-grid {
        display:flex;
        flex-wrap:wrap;
        gap:20px;
    }

    .tour-card {
        background:#fff;
        border-radius:10px;
        padding:15px;
        border:1px solid #ddd;
        width:calc(33% - 20px);
        box-shadow:0 4px 12px rgba(0,0,0,0.08);
        transition:0.2s;
    }
    .tour-card:hover {
        transform:translateY(-5px);
        box-shadow:0 6px 18px rgba(0,0,0,0.12);
    }

    .tour-card img {
        width:100%;
        height:160px;
        object-fit:cover;
        border-radius:8px;
        margin-bottom:10px;
    }

    .tour-card h3 {
        font-size:20px;
        margin-bottom:10px;
        color:#222;
    }

    .tour-card p {
        font-size:14px;
        color:#555;
        margin-bottom:10px;
    }

    .btn-primary {
        display:inline-block;
        text-decoration:none;
        background:#0071c2;
        color:#fff;
        padding:10px 18px;
        border-radius:6px;
        font-weight:bold;
        transition:0.2s;
    }
    .btn-primary:hover {
        background:#005a9c;
    }

</style>

<!-- Hero -->
<div class="hero">
    <h1>Chào mừng bạn đến với Web Du Lịch</h1>
    <p>Khám phá hàng trăm tour hấp dẫn – giá tốt – đặt nhanh chóng.</p>
    <a href="index.php?page=user&action=index" class="btn-primary">Xem tất cả tour</a>
</div>

<!-- Featured Tours -->
<div class="section">
    <h2>Tour nổi bật</h2>
    <div class="tour-grid">
        <?php 
        $count = 0;
        foreach($tours as $tour): 
            if ($count >= 6) break; // Chỉ hiển thị 6 tour nổi bật
            $count++;
        ?>
            <div class="tour-card">
                <img src="https://via.placeholder.com/350x160" alt="<?= htmlspecialchars($tour['name']) ?>">
                <h3><?= htmlspecialchars($tour['name']) ?></h3>
                <p>Giá: <strong><?= number_format($tour['price'],0,',','.') ?> VNĐ</strong></p>
                <p><?= substr($tour['description'], 0, 80) ?>...</p>
                <a href="index.php?page=user&action=detail&id=<?= $tour['id'] ?>" class="btn-primary">Xem chi tiết</a>
            </div>
        <?php endforeach; ?>
    </div>
</div>

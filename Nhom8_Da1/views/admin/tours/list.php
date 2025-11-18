<main class="site-content">
    <div class="hero">
        <h2>Khám phá những tour hấp dẫn</h2>
        <p>Đặt tour nhanh chóng và tiện lợi.</p>
    </div>

    <div class="container">
        <h3>Danh sách tour</h3>
        <div class="tour-grid">
            <?php 
            // Giả lập dữ liệu tour, sau này lấy từ DB
            $tours = [
                ['name'=>'Tour Hà Nội - Hạ Long', 'desc'=>'3 ngày 2 đêm, tham quan Vịnh Hạ Long', 'img'=>'https://via.placeholder.com/300x150'],
                ['name'=>'Tour Đà Nẵng - Hội An', 'desc'=>'4 ngày 3 đêm, khám phá phố cổ Hội An', 'img'=>'https://via.placeholder.com/300x150'],
                ['name'=>'Tour Sài Gòn - Cần Thơ', 'desc'=>'3 ngày 2 đêm, trải nghiệm chợ nổi Cần Thơ', 'img'=>'https://via.placeholder.com/300x150']
            ];
            foreach($tours as $tour): ?>
            <div class="tour-card">
                <img src="<?= $tour['img'] ?>" alt="<?= $tour['name'] ?>">
                <h4><?= $tour['name'] ?></h4>
                <p><?= $tour['desc'] ?></p>
                <a href="#" class="btn-primary">Đặt tour</a>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</main>

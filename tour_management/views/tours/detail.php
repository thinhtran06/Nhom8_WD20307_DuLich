<?php require_once 'views/layout/header.php'; ?>

<div class="main-content">

    <h1 class="page-title">
        <span class="emoji">🗺️</span> Chi Tiết Tour
    </h1>

    <div class="card p-4">

        <div class="container">

            <h2>Chi Tiết Tour</h2>
            
            <div class="card">
                <div class="card-body">
                    <h3><?php echo $this->tour->ten_tour; ?></h3>
                    <hr>
                    
                    <p><strong>Mô tả:</strong> <?php echo $this->tour->mo_ta; ?></p>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Điểm khởi hành:</strong> <?php echo $this->tour->diem_khoi_hanh; ?></p>
                            <p><strong>Điểm đến:</strong> <?php echo $this->tour->diem_den; ?></p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Số ngày:</strong> <?php echo $this->tour->so_ngay; ?> ngày</p>

                            <!-- GIÁ: đã sửa number_format -->
                            <p><strong>Giá:</strong> 
                                <?= $this->tour->gia_tour !== null ? number_format($this->tour->gia_tour) : "Chưa cập nhật"; ?> VNĐ
                            </p>

                            <p><strong>Số chỗ:</strong> <?php echo $this->tour->so_cho; ?> người</p>
                            <p><strong>Trạng thái:</strong> 
                                <span class="badge badge-info"><?php echo $this->tour->trang_thai; ?></span>
                            </p>
                        </div>
                    </div>

                    <h4 class="mt-4 mb-3">
                        📋 Lịch Trình Chi Tiết (<?php echo $this->tour->so_ngay; ?> Ngày)
                    </h4>

                    <?php if (!empty($this->tour->lich_trinh)): ?>
                        <div class="card p-3 bg-light">
                            <pre style="white-space: pre-wrap; word-wrap: break-word; font-family: inherit; margin: 0;">
                                <?php echo htmlspecialchars($this->tour->lich_trinh); ?>
                            </pre>
                        </div>
                    <?php else: ?>
                        <p class="alert alert-warning">
                            Chưa có lịch trình chi tiết nào được thiết lập cho tour này.
                        </p>
                    <?php endif; ?>

                    <hr class="mt-4">

                    <a href="index.php" class="btn btn-secondary">Quay lại</a>
                    <a href="index.php?action=tour_edit&id=<?php echo $this->tour->id; ?>" 
                       class="btn btn-warning">Chỉnh sửa</a>

                </div>
            </div>

        </div>

    </div>

</div>

<?php require_once 'views/layout/footer.php'; ?>

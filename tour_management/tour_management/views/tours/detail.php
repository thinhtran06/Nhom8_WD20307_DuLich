<?php require_once 'views/layout/header.php'; ?>

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
                    <p><strong>Ngày khởi hành:</strong> <?php echo date('d/m/Y', strtotime($this->tour->ngay_khoi_hanh)); ?></p>
                </div>
                <div class="col-md-6">
                    <p><strong>Số ngày:</strong> <?php echo $this->tour->so_ngay; ?> ngày</p>
                    <p><strong>Giá:</strong> <?php echo number_format($this->tour->gia_tour); ?> VNĐ</p>
                    <p><strong>Số chỗ:</strong> <?php echo $this->tour->so_cho; ?> người</p>
                    <p><strong>Trạng thái:</strong> <span class="badge badge-info"><?php echo $this->tour->trang_thai; ?></span></p>
                </div>
            </div>

            <hr>
            <a href="index.php" class="btn btn-secondary">Quay lại</a>
            <a href="index.php?action=tour_edit&id=<?php echo $this->tour->id; ?>" class="btn btn-warning">Chỉnh sửa</a>
        </div>
    </div>
</div>
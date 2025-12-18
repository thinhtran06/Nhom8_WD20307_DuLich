<?php require_once 'views/layout/header.php'; ?>

<div class="container">
    
    <h2>📝 Tạo Yêu Cầu Tour Tùy Chỉnh Mới (Nội bộ)</h2>
    <p class="lead">Sử dụng form này để ghi lại một yêu cầu tour tùy chỉnh nhận được qua điện thoại hoặc trực tiếp, hoặc để tạo một dự thảo yêu cầu.</p>
    
    <?php if(isset($_GET['message'])): ?>
        <div class="alert alert-danger"><?php echo htmlspecialchars($_GET['message']); ?></div>
    <?php endif; ?>

    <form action="index.php?action=tour_request_store" method="POST">
        
        <div class="card mb-4">
            <div class="card-header">Thông tin Khách hàng</div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 form-group">
                        <label>Tên Khách hàng / Liên hệ:</label>
                        <input type="text" name="ten_khach_hang" class="form-control" required>
                    </div>
                    <div class="col-md-6 form-group">
                        <label>Điện thoại:</label>
                        <input type="text" name="dien_thoai" class="form-control" required>
                    </div>
                </div>
                <div class="form-group">
                    <label>Email:</label>
                    <input type="email" name="email" class="form-control">
                </div>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header">Thông tin Yêu cầu Tour</div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4 form-group">
                        <label>Số lượng khách (Dự kiến):</label>
                        <input type="number" name="so_luong_khach" class="form-control" value="1" required>
                    </div>
                    <div class="col-md-4 form-group">
                        <label>Điểm đến mong muốn:</label>
                        <input type="text" name="diem_den_mong_muon" class="form-control" required>
                    </div>
                    <div class="col-md-4 form-group">
                        <label>Ngày khởi hành mong muốn:</label>
                        <input type="date" name="ngay_khoi_hanh_mong_luon" class="form-control">
                    </div>
                </div>
                
                <div class="form-group">
                    <label>Ngân sách dự kiến (VNĐ):</label>
                    <input type="number" name="ngan_sach" class="form-control" placeholder="Tùy chọn">
                </div>
                
                <div class="form-group">
                    <label>Yêu cầu Chi tiết / Ghi chú:</label>
                    <textarea name="yeu_cau_chi_tiet" class="form-control" rows="5" placeholder="Các yêu cầu đặc biệt về khách sạn, phương tiện, hoạt động,..."></textarea>
                </div>

                <input type="hidden" name="trang_thai" value="Mới">
            </div>
        </div>
        
        <button type="submit" class="btn btn-primary btn-lg">Lưu Yêu Cầu</button>
        <a href="index.php?action=tour_request_index" class="btn btn-secondary">Hủy</a>
    </form>
</div>
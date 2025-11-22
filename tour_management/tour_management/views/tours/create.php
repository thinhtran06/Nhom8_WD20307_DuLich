<?php require_once 'views/layout/header.php'; ?>

<div class="container">
    <h2>Thêm Tour Mới</h2>
    
    <form action="index.php?action=tour_store" method="POST">
        <div class="form-group">
            <label>Tên Tour:</label>
            <input type="text" name="ten_tour" class="form-control" required>
        </div>

        <div class="form-group">
            <label>Mô tả:</label>
            <textarea name="mo_ta" class="form-control" rows="4"></textarea>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>Điểm khởi hành:</label>
                    <input type="text" name="diem_khoi_hanh" class="form-control" required>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Điểm đến:</label>
                    <input type="text" name="diem_den" class="form-control" required>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>Ngày khởi hành:</label>
                    <input type="date" name="ngay_khoi_hanh" class="form-control" required>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Số ngày:</label>
                    <input type="number" name="so_ngay" class="form-control" required>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>Giá tour (VNĐ):</label>
                    <input type="number" name="gia_tour" class="form-control" required>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Số chỗ:</label>
                    <input type="number" name="so_cho" class="form-control" required>
                </div>
            </div>
        </div>

        <div class="form-group">
            <label>Trạng thái:</label>
            <select name="trang_thai" class="form-control">
                <option value="Còn chỗ">Còn chỗ</option>
                <option value="Hết chỗ">Hết chỗ</option>
                <option value="Sắp khởi hành">Sắp khởi hành</option>
            </select>
        </div>

        <button type="submit" class="btn btn-success">Lưu</button>
        <a href="index.php" class="btn btn-secondary">Hủy</a>
    </form>
</div>
<?php require_once 'views/layout/header.php'; ?>

<div class="container">
    <h1>Quản Lý Tour Du Lịch</h1>
    
    <?php if(isset($_GET['message'])): ?>
        <div class="alert alert-success"><?php echo $_GET['message']; ?></div>
    <?php endif; ?>

    <a href="index.php?action=tour_create" class="btn btn-primary mb-3">Thêm Tour Mới</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Tên Tour</th>
                <th>Mô Tả</th>
                <th>Khởi hành</th>
                <th>Điểm đến</th>
                <!-- <th>Ngày đi</th> -->
                <th>Số ngày</th>
                <th>Giá</th>
                <th>Số chỗ</th>
                <th>Trạng thái</th>
                <th>Thao tác</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($tours as $tour): ?>
            <tr>
                <td><?php echo $tour['id']; ?></td>
                <td><?php echo $tour['ten_tour']; ?></td>
                <td><?php echo $tour['mo_ta']; ?></td>
                <td><?php echo $tour['diem_khoi_hanh']; ?></td>
                <td><?php echo $tour['diem_den']; ?></td>
              
                <td><?php echo $tour['so_ngay']; ?> ngày</td>
                <td><?php echo number_format($tour['gia_tour']); ?> VNĐ</td>
                <td><?php echo $tour['so_cho']; ?></td>
                <td><span class="badge badge-info"><?php echo $tour['trang_thai']; ?></span></td>
                <td>
                    <a href="index.php?action=tour_show&id=<?php echo $tour['id']; ?>" class="btn btn-sm btn-info">Xem</a>
                    <a href="index.php?action=tour_edit&id=<?php echo $tour['id']; ?>" class="btn btn-sm btn-warning">Sửa</a>
                    <a href="index.php?action=tour_delete&id=<?php echo $tour['id']; ?>" 
                       onclick="return confirm('Bạn có chắc muốn xóa?')" 
                       class="btn btn-sm btn-danger">Xóa</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
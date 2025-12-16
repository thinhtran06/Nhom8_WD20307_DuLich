<?php require_once 'views/layout/header.php'; ?>

<?php 
// Xác định tiêu đề động
$displayTitle = $page_title ?? 'Quản Lý Tất Cả Tour Du Lịch'; 
?>

<div class="container">
    
    <h1><?php echo $displayTitle; ?></h1>
    
    <?php if(isset($_GET['message'])): ?>
        <div class="alert alert-success"><?php echo htmlspecialchars($_GET['message']); ?></div>
    <?php endif; ?>

    <a href="index.php?action=tour_create" class="btn btn-primary mb-3">Thêm Tour Mới</a>

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Tên Tour</th>
                <th>Mô Tả</th>
                <th>Khởi hành</th>
                <th>Điểm đến</th>
                <th>Loại Tour</th> 
                <th>Số ngày</th>
                <th>Giá</th>
                <th>Số chỗ</th>
                <th>Trạng thái</th>
                <th>Thao tác</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            // Đảm bảo $tours là mảng, tránh lỗi nếu không có dữ liệu
            if (isset($tours) && is_array($tours)): 
            ?>
                <?php foreach($tours as $tour): ?>
                <tr>
                    <td><?php echo htmlspecialchars($tour['id']); ?></td>
                    <td><?php echo htmlspecialchars($tour['ten_tour']); ?></td>
                    <td><?php echo htmlspecialchars(substr($tour['mo_ta'], 0, 50)) . '...'; ?></td>
                    <td><?php echo htmlspecialchars($tour['diem_khoi_hanh']); ?></td>
                    <td><?php echo htmlspecialchars($tour['diem_den']); ?></td>
                    
                    <td>
                        <?php 
                            $loaiTour = htmlspecialchars($tour['loai_tour'] ?? 'N/A');
                            
                            // Xác định lớp CSS (màu nền Bootstrap)
                            if ($loaiTour == 'Ngoài nước') {
                                // Màu đỏ (hoặc màu nổi bật khác) cho tour quốc tế
                                $badgeClass = 'badge-danger'; 
                            } else {
                                // Màu xanh dương/xám mặc định cho tour trong nước
                                $badgeClass = 'badge-info'; 
                            }
                        ?>
                        
                        <span class="badge <?php echo $badgeClass; ?>"><?php echo $loaiTour; ?></span>
                    </td>
                    <td><?php echo htmlspecialchars($tour['so_ngay']); ?> ngày</td>
                    <td><?php echo number_format($tour['gia_tour']); ?> VNĐ</td>
                    <td><?php echo htmlspecialchars($tour['so_cho']); ?></td>
                    <td><span class="badge badge-info"><?php echo htmlspecialchars($tour['trang_thai']); ?></span></td>
                    <td>
                        <a href="index.php?action=tour_show&id=<?php echo $tour['id']; ?>" class="btn btn-sm btn-info">Xem</a>
                        <a href="index.php?action=tour_edit&id=<?php echo $tour['id']; ?>" class="btn btn-sm btn-warning">Sửa</a>
                        <a href="index.php?action=tour_delete&id=<?php echo $tour['id']; ?>" 
                           onclick="return confirm('Bạn có chắc muốn xóa Tour ID <?php echo $tour['id']; ?>?')" 
                           class="btn btn-sm btn-danger">Xóa</a>
                           <a href="index.php?action=guide_work_assign&tour_id=<?php echo $tour['id']; ?>" 
   class="btn btn-sm btn-success">
   Phân công HDV
</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="11" class="text-center">Không tìm thấy tour nào.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
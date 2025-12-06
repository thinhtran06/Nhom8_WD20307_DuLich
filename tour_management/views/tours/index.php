<?php require_once 'views/layout/header.php'; ?>

<div class="main-content">

    <!-- TITLE -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="page-title">
            <span class="emoji">🌍</span>
            <?php echo $page_title ?? 'Quản Lý Tất Cả Tour Du Lịch'; ?>
        </h1>

        <a href="index.php?action=tour_create" class="btn btn-primary btn-lg">
            + Tạo Tour Mới
        </a>
    </div>

    <!-- Thông báo -->
    <?php if(isset($_GET['message'])): ?>
        <div class="alert alert-success shadow-sm">
            <?= htmlspecialchars($_GET['message']); ?>
        </div>
    <?php endif; ?>

    <!-- TABLE -->
    <div class="table-wrapper">

        <table class="table align-middle">
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
                    <th width="220">Thao tác</th>
                </tr>
            </thead>

            <tbody>

                <?php if (!empty($tours) && is_array($tours)): ?>
                    <?php foreach($tours as $tour): ?>

                        <tr>
                            <td><?= htmlspecialchars($tour['id']); ?></td>

                            <td><?= htmlspecialchars($tour['ten_tour']); ?></td>

                            <td><?= htmlspecialchars(substr($tour['mo_ta'], 0, 40)) . '...'; ?></td>

                            <td><?= htmlspecialchars($tour['diem_khoi_hanh']); ?></td>
                            <td><?= htmlspecialchars($tour['diem_den']); ?></td>

                            <!-- Loại tour -->
                            <td>
                                <?php
                                    $loaiTour = htmlspecialchars($tour['loai_tour'] ?? 'N/A');
                                    $badgeClass = ($loaiTour === 'Ngoài nước')
                                                ? 'badge-danger'
                                                : 'badge-info';
                                ?>
                                <span class="badge <?= $badgeClass ?>" style="padding:7px 14px;">
                                    <?= $loaiTour ?>
                                </span>
                            </td>

                            <td><?= htmlspecialchars($tour['so_ngay']); ?> ngày</td>

                            <td><?= number_format($tour['gia_tour']); ?> VNĐ</td>

                            <td><?= htmlspecialchars($tour['so_cho']); ?></td>

                            <!-- TRẠNG THÁI -->
                            <td>
                                <span class="badge badge-success" style="padding:7px 14px;">
                                    <?= htmlspecialchars($tour['trang_thai']); ?>
                                </span>
                            </td>

                            <!-- ACTION BUTTONS -->
                            <td>

                                <div class="d-flex flex-wrap gap-1">

                                    <a href="index.php?action=tour_show&id=<?= $tour['id']; ?>"
                                       class="btn btn-sm btn-info">
                                        Xem
                                    </a>

                                    <a href="index.php?action=tour_edit&id=<?= $tour['id']; ?>"
                                       class="btn btn-sm btn-warning">
                                        Sửa
                                    </a>

                                    <a href="index.php?action=tour_delete&id=<?= $tour['id']; ?>"
                                       onclick="return confirm('Bạn chắc chắn muốn xóa Tour ID <?= $tour['id']; ?>?');"
                                       class="btn btn-sm btn-danger">
                                        Xóa
                                    </a>
                                 <a href="index.php?action=guide_work_assign&tour_id=<?= $tour['id'] ?>" 
   class="btn btn-sm btn-success">
    Phân công HDV
</a>



                                </div>

                            </td>

                        </tr>

                    <?php endforeach; ?>
                <?php else: ?>

                    <tr>
                        <td colspan="11" class="text-center text-muted py-4">
                            Không tìm thấy tour nào.
                        </td>
                    </tr>

                <?php endif; ?>

            </tbody>
        </table>

    </div>

</div>

<?php require_once 'views/layout/footer.php'; ?>

<?php require_once 'views/layout/header.php'; ?>

<div class="container-fluid">
    <div class="row">
        <?php require_once 'views/layout/sidebar.php'; ?>

        <main class="col-md-9 ml-sm-0 col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h3">Quản Lý Booking Tour</h1>
                <a href="index.php?action=booking_create" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Tạo Booking Mới
                </a>
            </div>

            <?php if (isset($_GET['message'])): ?>
                <div class="alert alert-success alert-dismissible fade show">
                    <?php echo htmlspecialchars($_GET['message']); ?>
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                </div>
            <?php endif; ?>

            <?php if (isset($_GET['error'])): ?>
                <div class="alert alert-danger alert-dismissible fade show">
                    <?php echo htmlspecialchars($_GET['error']); ?>
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                </div>
            <?php endif; ?>

            <div class="table-responsive">
                <table class="table table-striped table-bordered table-hover">
                    <thead class="thead-dark">
                        <tr>
                            <th>Mã Đặt Tour</th>
                            <th>Tên Tour</th>
                            <th>Khách Hàng</th>
                            <th>Số Khách</th>
                            <th>Tổng Tiền</th>
                            <th>Trạng Thái</th>
                            <th>Ngày Đặt</th>
                            <th>Hành Động</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($bookings) && count($bookings) > 0): ?>
                            <?php foreach ($bookings as $b): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($b['ma_dat_tour']); ?></td>
                                    <td><?php echo htmlspecialchars($b['ten_tour'] ?? ''); ?></td>
                                    <td><?php echo htmlspecialchars($b['customer_name'] ?? ''); ?></td>
                                    <td><?php echo (int)$b['so_nguoi_lon'] + (int)$b['so_tre_em']; ?></td>
                                    <td><?php echo number_format($b['tong_tien']); ?> đ</td>
                                    <td>
                                        <form method="post" action="index.php?action=booking_update_status&id=<?php echo $b['id']; ?>">
                                            <select name="status" class="form-control form-control-sm" onchange="this.form.submit()">
                                                <option value="Chờ xác nhận" <?php if ($b['trang_thai'] == 'Chờ xác nhận') echo 'selected'; ?>>Chờ xác nhận</option>
                                                <option value="Đã cọc" <?php if ($b['trang_thai'] == 'Đã cọc') echo 'selected'; ?>>Đã cọc</option>
                                                <option value="Hoàn tất" <?php if ($b['trang_thai'] == 'Hoàn tất') echo 'selected'; ?>>Hoàn tất</option>
                                                <option value="Hủy" <?php if ($b['trang_thai'] == 'Hủy') echo 'selected'; ?>>Hủy</option>
                                            </select>
                                        </form>
                                    </td>
                                    <td><?php echo htmlspecialchars($b['ngay_dat']); ?></td>
                                    <td>
                                        <a href="index.php?action=booking_delete&id=<?php echo $b['id']; ?>"
                                           class="btn btn-sm btn-danger"
                                           onclick="return confirm('Bạn có chắc muốn xóa booking này?');">
                                            Xóa
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="8" class="text-center">Chưa có booking nào.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </main>
    </div>
</div>

<?php require_once 'views/layout/footer.php'; ?>

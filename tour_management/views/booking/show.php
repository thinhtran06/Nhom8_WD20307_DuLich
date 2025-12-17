<?php 
require_once 'views/layout/header.php'; 
?>

<div class="container mb-5" style="margin-top: 120px;">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>
            <i class="fas fa-eye text-secondary"></i> Chi Tiết Đặt Chỗ: 
            <span class="text-primary"><?php echo htmlspecialchars($booking['ma_dat_tour']); ?></span>
        </h2>
        <div>
            <a href="index.php?action=booking_index" class="btn btn-outline-secondary me-2">
                <i class="fas fa-list"></i> Danh sách
            </a>
            <a href="index.php?action=booking_edit&id=<?php echo $booking['id']; ?>" class="btn btn-warning">
                <i class="fas fa-edit"></i> Sửa thông tin
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-7">
            <div class="card shadow-sm mb-4 border-0">
                <div class="card-header py-3 bg-white border-bottom">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-info-circle me-2"></i>Thông Tin Chung
                    </h6>
                </div>
                <div class="card-body">
                    <table class="table table-borderless align-middle">
                        <tr>
                            <th width="35%" class="text-muted">Tour:</th>
                            <td><strong class="text-dark"><?php echo htmlspecialchars($booking['ten_tour']); ?></strong></td>
                        </tr>
                        <tr>
                            <th class="text-muted">Khách hàng đại diện:</th>
                            <td>
                                <span class="badge bg-light text-primary border border-primary px-3 py-2">
                                    <i class="fas fa-user me-1"></i><?php echo htmlspecialchars($booking['customer_name']); ?>
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <th class="text-muted">Ngày khởi hành:</th>
                            <td><i class="far fa-calendar-alt me-1"></i> <?php echo date('d/m/Y', strtotime($booking['ngay_dat'])); ?></td>
                        </tr>
                        <tr>
                            <th class="text-muted">Trạng thái đơn:</th>
                            <td>
                                <span class="badge rounded-pill <?php 
                                    if ($booking['trang_thai'] == 'Đã xác nhận') echo 'bg-success';
                                    else if ($booking['trang_thai'] == 'Chờ xác nhận') echo 'bg-warning text-dark';
                                    else echo 'bg-danger';
                                ?>">
                                    <?php echo htmlspecialchars($booking['trang_thai']); ?>
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <th class="text-muted">Nhân viên xử lý:</th>
                            <td><small class="text-muted"><?php echo htmlspecialchars($booking['user_name'] ?? 'Hệ thống'); ?></small></td>
                        </tr>
                    </table>
                </div>
            </div>

            <div class="card shadow-sm mb-4 border-0">
                <div class="card-header py-3 bg-white border-bottom">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-sticky-note me-2"></i>Ghi Chú Đơn Hàng
                    </h6>
                </div>
                <div class="card-body">
                    <p class="text-muted mb-0">
                        <?php echo nl2br(htmlspecialchars($booking['ghi_chu'] ?: 'Không có ghi chú nào cho đơn hàng này.')); ?>
                    </p>
                </div>
            </div>
        </div>

        <div class="col-md-5">
            <div class="card shadow-sm border-0 overflow-hidden">
                <div class="card-header py-3 bg-success text-white">
                    <h6 class="m-0 font-weight-bold"><i class="fas fa-wallet me-2"></i>Tài Chính & Số Lượng</h6>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span class="text-muted">Số lượng khách:</span>
                        <span class="fw-bold">
                            <?php echo $booking['so_nguoi_lon']; ?> Lớn, <?php echo $booking['so_tre_em']; ?> Trẻ em
                        </span>
                    </div>
                    <hr class="text-muted opacity-25">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span class="text-muted">Tổng tiền dịch vụ:</span>
                        <h5 class="text-dark mb-0 fw-bold"><?php echo number_format($booking['tong_tien']); ?> <small>đ</small></h5>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span class="text-muted">Số tiền đã thu:</span>
                        <span class="text-success fw-bold">+ <?php echo number_format($booking['da_thanh_toan']); ?> đ</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-4 p-3 bg-light rounded">
                        <span class="fw-bold">Còn lại cần thu:</span>
                        <h4 class="text-danger mb-0 fw-bold"><?php echo number_format($booking['con_lai']); ?> đ</h4>
                    </div>

                    <div class="text-center mt-2">
                        <?php if ($booking['con_lai'] <= 0): ?>
                            <div class="alert alert-success border-0 mb-0 shadow-sm">
                                <i class="fas fa-check-circle me-1"></i> Đã thu đủ tiền
                            </div>
                        <?php else: ?>
                            <div class="alert alert-danger border-0 mb-0 shadow-sm">
                                <i class="fas fa-info-circle me-1"></i> Còn công nợ khách hàng
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once 'views/layout/footer.php'; ?>
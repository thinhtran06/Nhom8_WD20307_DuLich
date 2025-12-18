<?php include "views/layout/header.php"; ?>

<div style="margin-left:260px; margin-top:80px; padding:20px;">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold"><i class="fas fa-calendar-alt text-primary"></i> Lịch làm việc: <span class="text-danger"><?= htmlspecialchars($guide['ho_ten'] ?? 'N/A') ?></span></h3>
        <a href="index.php?action=guide_index" class="btn btn-secondary shadow-sm">
            <i class="fas fa-arrow-left"></i> Quay lại
        </a>
    </div>

    <div class="card shadow-sm border-0" style="border-radius: 15px;">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th class="ps-4">Mã đơn</th>
                            <th>Tên Tour</th>
                            <th class="text-center">Ngày Khởi hành</th>
                            <th>Khách hàng</th>
                            <th class="text-center">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($schedules)): foreach ($schedules as $s): ?>
                        <tr>
                            <td class="ps-4 fw-bold text-primary">#<?= htmlspecialchars($s['ma_dat_tour'] ?? $s['id']) ?></td>
                            <td class="fw-bold"><?= htmlspecialchars($s['ten_tour']) ?></td>
                            <td class="text-center">
                                <?php 
                                    $ngay = $s['ngay_dat'] ?? null;
                                    echo $ngay ? date('d/m/Y', strtotime($ngay)) : '<span class="text-muted">Chưa có ngày</span>';
                                ?>
                            </td>
                            <td><?= htmlspecialchars($s['ten_khach'] ?? 'N/A') ?></td>
                            <td class="text-center">
                                <a href="index.php?action=guide_tour_detail&tour_id=<?= $s['tour_id'] ?>" 
                                   class="btn btn-sm btn-info text-white me-1">
                                    <i class="fas fa-info-circle"></i> Chi tiết
                                </a>

                                <a href="index.php?action=guide_diary&booking_id=<?= $s['id'] ?>" 
                                   class="btn btn-sm btn-success">
                                    <i class="fas fa-edit"></i> Nhật ký
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; else: ?>
                        <tr>
                            <td colspan="5" class="text-center py-5 text-muted">Chưa có lịch làm việc được phân công.</td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php include "views/layout/footer.php"; ?>
<?php include "views/layout/header.php"; ?>

<div style="margin-left:260px; margin-top:80px; padding:20px; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold text-dark mb-0">
                <i class="fas fa-map-marked-alt text-primary me-2"></i>Chi tiết: <?= htmlspecialchars($tour['ten_tour']) ?>
            </h3>
            <p class="text-muted mb-0 small">Xem thông tin lộ trình và điểm đến được phân công</p>
        </div>
        <a href="javascript:history.back()" class="btn btn-outline-secondary shadow-sm rounded-pill px-4">
            <i class="fas fa-arrow-left me-2"></i>Quay lại
        </a>
    </div>

    <div class="row">
        <div class="col-lg-4">
            <div class="card shadow-sm border-0 mb-4" style="border-radius: 15px; background: linear-gradient(to bottom, #ffffff, #f8f9fa);">
                <div class="card-body p-4">
                    <h5 class="fw-bold text-primary mb-4 border-bottom pb-2">Tổng quan lộ trình</h5>
                    
                    <div class="mb-4">
                        <div class="d-flex align-items-center mb-2">
                            <i class="fas fa-clock text-warning me-2"></i>
                            <span class="text-muted small">Thời gian dự kiến</span>
                        </div>
                        <h5 class="fw-bold ps-4"><?= htmlspecialchars($tour['so_ngay'] ?? 'N/A') ?> Ngày</h5>
                    </div>

                    <div class="mb-4">
                        <div class="d-flex align-items-center mb-2">
                            <i class="fas fa-plane-departure text-success me-2"></i>
                            <span class="text-muted small">Điểm khởi hành</span>
                        </div>
                        <h5 class="fw-bold ps-4"><?= htmlspecialchars($tour['diem_khoi_hanh'] ?? 'N/A') ?></h5>
                    </div>

                    <div class="mb-4">
                        <div class="d-flex align-items-center mb-2">
                            <i class="fas fa-map-marker-alt text-danger me-2"></i>
                            <span class="text-muted small">Điểm đến chính</span>
                        </div>
                        <h5 class="fw-bold ps-4"><?= htmlspecialchars($tour['diem_den'] ?? 'N/A') ?></h5>
                    </div>

                    <hr>
                    
                    <div class="mt-3">
                        <label class="fw-bold text-muted small text-uppercase">Ghi chú từ quản lý:</label>
                        <p class="text-secondary small mt-2 italic" style="line-height: 1.6;">
                            <?= !empty($tour['mo_ta']) ? nl2br(htmlspecialchars($tour['mo_ta'])) : 'Không có ghi chú thêm.' ?>
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-8">
            <div class="card shadow-sm border-0" style="border-radius: 15px;">
                <div class="card-header bg-white py-3 border-0 mt-2">
                    <h5 class="mb-0 fw-bold text-dark d-flex align-items-center">
                        <span class="bg-success text-white rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 30px; height: 30px;">
                            <i class="fas fa-route" style="font-size: 0.9rem;"></i>
                        </span>
                        Nội dung lịch trình di chuyển
                    </h5>
                </div>
                <div class="card-body p-4 pt-0">
                    <?php if(!empty($tour['lich_trinh'])): ?>
                        <div class="p-4 rounded-4" style="background-color: #fcfcfc; border: 1px solid #eee; min-height: 400px;">
                            <div style="line-height: 2; font-size: 1.1rem; color: #2c3e50; white-space: pre-line;">
                                <?= htmlspecialchars($tour['lich_trinh']) ?>
                            </div>
                        </div>
                    <?php else: ?>
                        <div class="text-center py-5 border rounded-4 bg-light">
                            <i class="fas fa-edit fa-3x text-light mb-3"></i>
                            <p class="text-muted">Lịch trình chi tiết đang được cập nhật...</p>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="card-footer bg-white border-0 py-3 text-end">
                    <small class="text-muted italic">Cập nhật lần cuối: <?= date('d/m/Y') ?></small>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include "views/layout/footer.php"; ?>
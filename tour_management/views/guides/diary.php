<?php include "views/layout/header.php"; ?>

<div style="margin-left:260px; margin-top:80px; padding:30px; background-color: #f0f2f5; min-height: 100vh; font-family: 'Inter', sans-serif;">
    
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold text-dark mb-1">
                <i class="fas fa-feather-alt text-success me-2"></i>Nhật ký hành trình
            </h2>
            <p class="text-muted mb-0">Mã đoàn: <span class="badge bg-white text-dark border shadow-sm">#<?= htmlspecialchars($booking_id) ?></span></p>
        </div>
        <div class="d-flex gap-2">
            <a href="index.php?action=guide_schedule" class="btn btn-white border shadow-sm rounded-pill px-4 fw-bold">
                <i class="fas fa-chevron-left me-1"></i> Quay lại
            </a>
            <a href="index.php?action=guide_diary_add&booking_id=<?= $booking_id ?>" class="btn btn-primary btn-lg shadow px-4 rounded-pill fw-bold">
                <i class="fas fa-plus-circle me-1"></i> Viết bài mới
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-10 col-lg-12">
            <?php if (!empty($diaries)): foreach ($diaries as $d): ?>
                <div class="card border-0 shadow-sm mb-4 diary-card">
                    <div class="card-body p-4">
                        <div class="row align-items-center">
                            <div class="col-md-2 border-end text-center">
                                <h3 class="fw-bold mb-0 text-primary"><?= date('d', strtotime($d['created_at'])) ?></h3>
                                <div class="text-uppercase small fw-bold text-muted"><?= date('M / Y', strtotime($d['created_at'])) ?></div>
                                <div class="badge bg-light text-dark mt-2"><i class="far fa-clock me-1"></i><?= date('H:i', strtotime($d['created_at'])) ?></div>
                            </div>

                            <div class="col-md-7 ps-4">
                                <h4 class="fw-bold text-dark mb-2"><?= htmlspecialchars($d['tieu_de']) ?></h4>
                                <div class="text-secondary mb-3" style="line-height: 1.6; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
                                    <?= nl2br(htmlspecialchars(strip_tags($d['noi_dung']))) ?>
                                </div>
                                <div class="d-flex align-items-center">
                                    <div class="avatar-circle me-2">
                                        <?= strtoupper(substr($d['user_name'] ?? 'H', 0, 1)) ?>
                                    </div>
                                    <span class="small text-muted fw-bold"><?= htmlspecialchars($d['user_name'] ?? 'Hướng dẫn viên') ?></span>
                                </div>
                            </div>

                            <div class="col-md-3 text-end">
                                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                    <a href="index.php?action=guide_diary_edit&id=<?= $d['id'] ?>" 
                                       class="btn btn-warning text-white fw-bold px-4 py-2 rounded-pill shadow-sm">
                                        <i class="fas fa-edit me-1"></i> Sửa
                                    </a>
                                    <a href="index.php?action=guide_diary_delete&id=<?= $d['id'] ?>&booking_id=<?= $booking_id ?>" 
                                       class="btn btn-outline-danger fw-bold px-4 py-2 rounded-pill shadow-sm" 
                                       onclick="return confirm('Bạn có chắc muốn xóa bài nhật ký này?')">
                                        <i class="fas fa-trash-alt me-1"></i> Xóa
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; else: ?>
                <div class="card border-0 shadow-sm text-center py-5" style="border-radius: 20px;">
                    <div class="card-body">
                        <img src="https://cdn-icons-png.flaticon.com/512/4076/4076402.png" style="width: 120px; opacity: 0.5;" alt="Empty" class="mb-4">
                        <h4 class="fw-bold text-muted">Chưa có bài viết nào!</h4>
                        <p class="text-secondary mb-4">Hãy bắt đầu ghi lại những khoảnh khắc và báo cáo cho chuyến đi này.</p>
                        <a href="index.php?action=guide_diary_add&booking_id=<?= $booking_id ?>" class="btn btn-primary btn-lg rounded-pill px-5 shadow">
                            Viết bài nhật ký đầu tiên
                        </a>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<style>
    /* Google Fonts */
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap');

    /* Hiệu ứng Card */
    .diary-card {
        border-radius: 20px;
        transition: all 0.3s ease;
        border: 1px solid transparent !important;
    }
    .diary-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0,0,0,0.1) !important;
        border-color: #0d6efd !important;
    }

    /* Avatar hướng dẫn viên */
    .avatar-circle {
        width: 30px;
        height: 30px;
        background-color: #e9ecef;
        color: #495057;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 12px;
        font-weight: bold;
    }

    /* Tùy chỉnh nút bấm */
    .btn-primary {
        background: linear-gradient(135deg, #0d6efd, #0b5ed7);
        border: none;
    }
    .btn-white {
        background-color: #fff;
        color: #333;
    }
    .rounded-pill {
        border-radius: 50px !important;
    }
    
    /* Responsive cho mobile */
    @media (max-width: 768px) {
        .border-end {
            border-end: none !important;
            border-bottom: 1px solid #dee2e6;
            padding-bottom: 15px;
            margin-bottom: 15px;
        }
    }
</style>

<?php include "views/layout/footer.php"; ?>
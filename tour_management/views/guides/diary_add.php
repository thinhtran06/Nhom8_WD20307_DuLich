<?php include "views/layout/header.php"; ?>

<div style="margin-left:260px; margin-top:80px; padding:20px;">
    <div class="card shadow-sm border-0" style="border-radius: 15px;">
        <div class="card-header bg-white py-3">
            <h5 class="fw-bold mb-0 text-success"><i class="fas fa-pen-nib me-2"></i>Viết Nhật ký đoàn: #<?= htmlspecialchars($_GET['booking_id']) ?></h5>
        </div>
        <div class="card-body">
            <form action="index.php?action=guide_diary_store" method="POST">
                <input type="hidden" name="booking_id" value="<?= htmlspecialchars($_GET['booking_id']) ?>">
                
                <div class="mb-3">
                    <label class="form-label fw-bold">Tiêu đề (Ví dụ: Ngày 1 - Đón khách tại sân bay)</label>
                    <input type="text" name="tieu_de" class="form-control" placeholder="Nhập tiêu đề nhật ký..." required>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Nội dung chi tiết</label>
                    <textarea name="noi_dung" class="form-control" rows="8" placeholder="Ghi chú các sự việc xảy ra, tình trạng đoàn khách..." required></textarea>
                </div>

                <div class="text-end">
                    <a href="javascript:history.back()" class="btn btn-light border">Hủy bỏ</a>
                    <button type="submit" class="btn btn-success px-4">
                        <i class="fas fa-save"></i> Lưu nhật ký
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include "views/layout/footer.php"; ?>
<?php include "views/layout/header.php"; ?>

<?php
// Lấy tour_id, guide_id từ URL
$tour_id  = (int)($_GET['tour_id'] ?? 0);
$guide_id = (int)($_GET['guide_id'] ?? 0);
?>

<h3>📝 Thêm nhật ký tour</h3>

<form action="index.php?action=guide_diary_store" method="POST">

    <input type="hidden" name="tour_id" value="<?= $tour_id ?>">
    <input type="hidden" name="guide_id" value="<?= $guide_id ?>">

    <div class="mb-3">
        <label class="form-label">Ngày</label>
        <input type="date" name="ngay" class="form-control" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Tiêu đề</label>
        <input type="text" name="tieu_de" class="form-control" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Nội dung</label>
        <textarea name="noi_dung" class="form-control" rows="4" required></textarea>
    </div>

    <div class="mb-3">
        <label class="form-label">Sự cố (nếu có)</label>
        <textarea name="su_co" class="form-control" rows="3"></textarea>
    </div>

    <div class="mb-3">
        <label class="form-label">Phản hồi khách</label>
        <textarea name="phan_hoi_khach" class="form-control" rows="3"></textarea>
    </div>

    <div class="mb-3">
        <label class="form-label">Cách xử lý</label>
        <textarea name="cach_xu_ly" class="form-control" rows="3"></textarea>
    </div>

    <div class="mb-3">
        <label class="form-label">Hình ảnh (tên file / đường dẫn - nếu dùng)</label>
        <input type="text" name="hinh_anh" class="form-control">
    </div>

    <button class="btn btn-success">Lưu nhật ký</button>
    <a href="index.php?action=guide_diary&tour_id=<?= $tour_id ?>&guide_id=<?= $guide_id ?>"
       class="btn btn-secondary ms-2">
        Quay lại
    </a>
</form>

<?php include "views/layout/footer.php"; ?>
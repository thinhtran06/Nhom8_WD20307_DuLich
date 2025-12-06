<?php include "views/layout/header.php"; ?>

<?php  
// Nếu $entry không tồn tại nghĩa là ADD MODE
$is_edit = isset($entry) && !empty($entry);
?>

<h3 class="mt-3">
    <?= $is_edit ? "Chỉnh sửa nhật ký tour" : "Thêm nhật ký tour" ?>
</h3>

<form method="POST" action="index.php?action=guide_diary_store" enctype="multipart/form-data">

    <input type="hidden" name="id" value="<?= $is_edit ? $entry['id'] : '' ?>">
    <input type="hidden" name="tour_id" value="<?= $tour_id ?>">
    <input type="hidden" name="guide_id" value="<?= $guide_id ?>">

    <div class="mb-3">
        <label class="form-label">Ngày</label>
        <input type="date" name="ngay" class="form-control"
               value="<?= $is_edit ? $entry['ngay'] : '' ?>" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Tiêu đề</label>
        <input type="text" name="tieu_de" class="form-control"
               value="<?= $is_edit ? htmlspecialchars($entry['tieu_de']) : '' ?>" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Nội dung</label>
        <textarea name="noi_dung" class="form-control" rows="5"><?= 
            $is_edit ? htmlspecialchars($entry['noi_dung']) : '' 
        ?></textarea>
    </div>

    <div class="mb-3">
        <label class="form-label">Sự cố</label>
        <textarea name="su_co" class="form-control" rows="3"><?= 
            $is_edit ? htmlspecialchars($entry['su_co']) : '' 
        ?></textarea>
    </div>

    <div class="mb-3">
        <label class="form-label">Phản hồi khách</label>
        <textarea name="phan_hoi_khach" class="form-control" rows="3"><?= 
            $is_edit ? htmlspecialchars($entry['phan_hoi_khach']) : '' 
        ?></textarea>
    </div>

    <div class="mb-3">
        <label class="form-label">Cách xử lý</label>
        <textarea name="cach_xu_ly" class="form-control" rows="3"><?= 
            $is_edit ? htmlspecialchars($entry['cach_xu_ly']) : '' 
        ?></textarea>
    </div>

    <div class="mb-3">
        <label class="form-label">Hình ảnh</label>
        <input type="file" name="hinh_anh[]" class="form-control" multiple>

        <?php if ($is_edit && !empty($entry['hinh_anh'])): ?>
            <div class="mt-2">
                <strong>Ảnh cũ:</strong><br>
                <?php foreach (explode(",", $entry['hinh_anh']) as $img): ?>
                    <img src="uploads/diary/<?= $img ?>" height="80" class="me-2 mb-2">
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>

    <button class="btn btn-primary"><?= $is_edit ? "Cập nhật" : "Thêm mới" ?></button>
    <a href="index.php?action=guide_diary&tour_id=<?= $tour_id ?>&guide_id=<?= $guide_id ?>" 
       class="btn btn-secondary">Quay lại</a>

</form>

<?php include "views/layout/footer.php"; ?>

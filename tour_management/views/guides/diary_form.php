<?php include "views/layout/header.php"; ?>

<h3>
    <?= isset($diary) ? "Sửa Nhật ký" : "Thêm Nhật ký" ?>
</h3>

<form method="POST" enctype="multipart/form-data"
      action="index.php?action=guide_diary_save">

    <input type="hidden" name="id" value="<?= $diary['id'] ?? '' ?>">
    <input type="hidden" name="tour_id" value="<?= $tour_id ?>">
    <input type="hidden" name="guide_id" value="<?= $guide_id ?>">

    <div class="mb-3">
        <label class="form-label">Ngày</label>
        <input type="date" name="ngay" class="form-control"
               value="<?= $diary['ngay'] ?? '' ?>" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Sự kiện trong ngày</label>
        <textarea name="su_kien" class="form-control" rows="3" required><?= $diary['su_kien'] ?? '' ?></textarea>
    </div>

    <div class="mb-3">
        <label class="form-label">Sự cố (nếu có)</label>
        <textarea name="su_co" class="form-control" rows="3"><?= $diary['su_co'] ?? '' ?></textarea>
    </div>

    <div class="mb-3">
        <label class="form-label">Cách xử lý</label>
        <textarea name="xu_ly" class="form-control" rows="3"><?= $diary['xu_ly'] ?? '' ?></textarea>
    </div>

    <div class="mb-3">
        <label class="form-label">Phản hồi của khách</label>
        <textarea name="phan_hoi" class="form-control" rows="3"><?= $diary['phan_hoi'] ?? '' ?></textarea>
    </div>

    <div class="mb-3">
        <label class="form-label">Hình ảnh trong ngày</label>
        <input type="file" name="hinh_anh[]" class="form-control" accept="image/*" multiple>
        
        <?php if (!empty($diary['hinh_anh'])): ?>
            <div class="mt-2">
                <p>Hình ảnh hiện có:</p>
                <?php foreach (explode(',', $diary['hinh_anh']) as $img): ?>
                    <img src="uploads/diary/<?= $img ?>" width="70" class="me-1 mb-1 rounded">
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>

    <button type="submit" class="btn btn-success">Lưu</button>
    <a href="index.php?action=guide_diary&tour_id=<?= $tour_id ?>&guide_id=<?= $guide_id ?>"
       class="btn btn-secondary">
        Hủy
    </a>
</form>

<?php include "views/layout/footer.php"; ?>

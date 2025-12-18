<?php include "views/layout/header.php"; ?>

<?php  
// Nếu $entry không tồn tại nghĩa là ADD MODE
$is_edit = isset($entry) && !empty($entry);
?>

<div style="margin-left:260px; margin-top:80px; padding:20px;">

    <h3 class="mb-4">
        <?= $is_edit ? "✏️ Chỉnh sửa nhật ký tour" : "➕ Thêm nhật ký tour" ?>
    </h3>

    <div class="card shadow-sm">
        <div class="card-body">

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
                    placeholder="Nhập tiêu đề nhật ký..."
                           value="<?= $is_edit ? htmlspecialchars($entry['tieu_de']) : '' ?>" required>
                </div>

                <div class="mb-3">
    <label class="form-label">Nội dung</label>
    <textarea name="noi_dung" class="form-control" rows="5"
              placeholder="Mô tả chi tiết hoạt động trong ngày..."><?= 
        $is_edit ? htmlspecialchars($entry['noi_dung'] ?? '') : '' 
    ?></textarea>
</div>


                <div class="mb-3">
    <label class="form-label">Sự cố</label>
    <textarea name="su_co" class="form-control" rows="3"
              placeholder="Ghi lại sự cố (nếu có)..."><?= 
        $is_edit ? htmlspecialchars($entry['su_co'] ?? '') : '' 
    ?></textarea>
</div>


                <div class="mb-3">
    <label class="form-label">Phản hồi khách</label>
    <textarea name="phan_hoi_khach" class="form-control" rows="3"
              placeholder="Ý kiến, phản hồi của khách hàng..."><?= 
        $is_edit ? htmlspecialchars($entry['phan_hoi_khach'] ?? '') : '' 
    ?></textarea>
</div>

<div class="mb-3">
    <label class="form-label">Cách xử lý</label>
    <textarea name="cach_xu_ly" class="form-control" rows="3"
              placeholder="Bạn đã xử lý sự cố như thế nào..."><?= 
        $is_edit ? htmlspecialchars($entry['cach_xu_ly'] ?? '') : '' 
    ?></textarea>
</div>


                <div class="mt-4">
                    <button class="btn btn-primary">
                        <?= $is_edit ? "Cập nhật" : "Thêm mới" ?>
                    </button>
                    <a href="index.php?action=guide_diary&tour_id=<?= $tour_id ?>&guide_id=<?= $guide_id ?>" 
                       class="btn btn-secondary">
                        Quay lại
                    </a>
                </div>

            </form>

        </div>
    </div>

</div>

<?php include "views/layout/footer.php"; ?>
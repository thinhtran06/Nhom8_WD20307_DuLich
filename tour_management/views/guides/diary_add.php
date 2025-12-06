<h3>Thêm nhật ký tour</h3>

<form method="POST" action="index.php?action=guide_diary_store">
    <input type="hidden" name="tour_id" value="<?= $_GET['tour_id'] ?>">
    <input type="hidden" name="guide_id" value="<?= $_GET['guide_id'] ?>">

    <label>Ngày</label>
    <input type="date" name="ngay" class="form-control" required>

    <label>Tiêu đề</label>
    <input type="text" name="tieu_de" class="form-control" required>

    <label>Nội dung</label>
    <textarea name="noi_dung" class="form-control" rows="4"></textarea>

    <label>Sự cố (nếu có)</label>
    <textarea name="su_co" class="form-control"></textarea>

    <label>Cách xử lý</label>
    <textarea name="cach_xu_ly" class="form-control"></textarea>

    <label>Phản hồi khách</label>
    <textarea name="phan_hoi_khach" class="form-control"></textarea>

    <label>Hình ảnh (đường dẫn)</label>
    <input type="text" name="hinh_anh" class="form-control">

    <button class="btn btn-primary mt-3">Lưu nhật ký</button>
</form>

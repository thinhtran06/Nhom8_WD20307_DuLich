<?php require_once 'views/layout/header.php'; ?>

<div class="container-fluid">
    <div class="row">
        <?php require_once 'views/layout/sidebar.php'; ?>

        <main class="col-md-9 ml-sm-auto col-lg-10 px-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Chỉnh Sửa Nhà Cung Cấp</h1>
            </div>

            <form action="index.php?action=supplier_update&id=<?php echo $this->supplier->id; ?>" method="POST">
                <div class="card mb-3">
                    <div class="card-header bg-primary text-white">
                        <strong>Thông Tin Cơ Bản</strong>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label>Tên Nhà Cung Cấp <span class="text-danger">*</span></label>
                                    <input type="text" name="ten_ncc" value="<?php echo htmlspecialchars($this->supplier->ten_ncc); ?>" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Loại Dịch Vụ <span class="text-danger">*</span></label>
                                    <select name="loai_dich_vu" class="form-control" required>
                                        <option value="Khách sạn" <?php echo ($this->supplier->loai_dich_vu === 'Khách sạn') ? 'selected' : ''; ?>>Khách sạn</option>
                                        <option value="Nhà hàng" <?php echo ($this->supplier->loai_dich_vu === 'Nhà hàng') ? 'selected' : ''; ?>>Nhà hàng</option>
                                        <option value="Vận chuyển" <?php echo ($this->supplier->loai_dich_vu === 'Vận chuyển') ? 'selected' : ''; ?>>Vận chuyển</option>
                                        <option value="Hướng dẫn viên" <?php echo ($this->supplier->loai_dich_vu === 'Hướng dẫn viên') ? 'selected' : ''; ?>>Hướng dẫn viên</option>
                                        <option value="Vé tham quan" <?php echo ($this->supplier->loai_dich_vu === 'Vé tham quan') ? 'selected' : ''; ?>>Vé tham quan</option>
                                        <option value="Khác" <?php echo ($this->supplier->loai_dich_vu === 'Khác') ? 'selected' : ''; ?>>Khác</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label>Địa Chỉ</label>
                                    <input type="text" name="dia_chi" value="<?php echo htmlspecialchars($this->supplier->dia_chi); ?>" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Thành Phố</label>
                                    <input type="text" name="thanh_pho" value="<?php echo htmlspecialchars($this->supplier->thanh_pho); ?>" class="form-control">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Điện Thoại</label>
                                    <input type="text" name="dien_thoai" value="<?php echo htmlspecialchars($this->supplier->dien_thoai); ?>" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Email</label>
                                    <input type="email" name="email" value="<?php echo htmlspecialchars($this->supplier->email); ?>" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Website</label>
                                    <input type="text" name="website" value="<?php echo htmlspecialchars($this->supplier->website); ?>" class="form-control">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card mb-3">
                    <div class="card-header bg-success text-white">
                        <strong>Thông Tin Liên Hệ</strong>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Người Liên Hệ</label>
                                    <input type="text" name="nguoi_lien_he" value="<?php echo htmlspecialchars($this->supplier->nguoi_lien_he); ?>" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Chức Vụ</label>
                                    <input type="text" name="chuc_vu_lien_he" value="<?php echo htmlspecialchars($this->supplier->chuc_vu_lien_he); ?>" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Điện Thoại Liên Hệ</label>
                                    <input type="text" name="dien_thoai_lien_he" value="<?php echo htmlspecialchars($this->supplier->dien_thoai_lien_he); ?>" class="form-control">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card mb-3">
                    <div class="card-header bg-info text-white">
                        <strong>Thông Tin Khác</strong>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Thông Tin Thanh Toán</label>
                                    <textarea name="thong_tin_thanh_toan" class="form-control" rows="3"><?php echo htmlspecialchars($this->supplier->thong_tin_thanh_toan); ?></textarea>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Ghi Chú</label>
                                    <textarea name="ghi_chu" class="form-control" rows="3"><?php echo htmlspecialchars($this->supplier->ghi_chu); ?></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Trạng Thái</label>
                            <select name="trang_thai" class="form-control">
                                <option value="Đang hợp tác" <?php echo ($this->supplier->trang_thai === 'Đang hợp tác') ? 'selected' : ''; ?>>Đang hợp tác</option>
                                <option value="Ngừng hợp tác" <?php echo ($this->supplier->trang_thai === 'Ngừng hợp tác') ? 'selected' : ''; ?>>Ngừng hợp tác</option>
                            </select>
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn btn-success btn-lg">
                    <i class="fas fa-save"></i> Cập Nhật
                </button>
                <a href="index.php?action=supplier_index" class="btn btn-secondary btn-lg">
                    <i class="fas fa-arrow-left"></i> Quay Lại
                </a>
            </form>
            <br>
        </main>
    </div>
</div>

<?php require_once 'views/layout/footer.php'; ?>
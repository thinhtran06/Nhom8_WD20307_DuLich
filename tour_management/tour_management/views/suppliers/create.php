<?php require_once 'views/layout/header.php'; ?>

<div class="container-fluid">
    <div class="row">
        <?php require_once 'views/layout/sidebar.php'; ?>

        <main class="col-md-9 ml-sm-auto col-lg-10 px-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Thêm Nhà Cung Cấp Mới</h1>
            </div>

            <?php if(isset($_GET['error'])): ?>
                <div class="alert alert-danger"><?php echo htmlspecialchars($_GET['error']); ?></div>
            <?php endif; ?>

            <form action="index.php?action=supplier_store" method="POST">
                <div class="card mb-3">
                    <div class="card-header bg-primary text-white">
                        <strong>Thông Tin Cơ Bản</strong>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label>Tên Nhà Cung Cấp <span class="text-danger">*</span></label>
                                    <input type="text" name="ten_ncc" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Loại Dịch Vụ <span class="text-danger">*</span></label>
                                    <select name="loai_dich_vu" class="form-control" required>
                                        <option value="">-- Chọn loại --</option>
                                        <option value="Khách sạn">Khách sạn</option>
                                        <option value="Nhà hàng">Nhà hàng</option>
                                        <option value="Vận chuyển">Vận chuyển</option>
                                        <option value="Hướng dẫn viên">Hướng dẫn viên</option>
                                        <option value="Vé tham quan">Vé tham quan</option>
                                        <option value="Khác">Khác</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label>Địa Chỉ</label>
                                    <input type="text" name="dia_chi" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Thành Phố</label>
                                    <input type="text" name="thanh_pho" class="form-control">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Điện Thoại</label>
                                    <input type="text" name="dien_thoai" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Email</label>
                                    <input type="email" name="email" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Website</label>
                                    <input type="text" name="website" class="form-control">
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
                                    <input type="text" name="nguoi_lien_he" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Chức Vụ</label>
                                    <input type="text" name="chuc_vu_lien_he" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Điện Thoại Liên Hệ</label>
                                    <input type="text" name="dien_thoai_lien_he" class="form-control">
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
                                    <textarea name="thong_tin_thanh_toan" class="form-control" rows="3" 
                                              placeholder="Ví dụ: STK: 123456789, Ngân hàng: Vietcombank"></textarea>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Ghi Chú</label>
                                    <textarea name="ghi_chu" class="form-control" rows="3"></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Trạng Thái</label>
                            <select name="trang_thai" class="form-control">
                                <option value="Đang hợp tác">Đang hợp tác</option>
                                <option value="Ngừng hợp tác">Ngừng hợp tác</option>
                            </select>
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn btn-success btn-lg">
                    <i class="fas fa-save"></i> Lưu Nhà Cung Cấp
                </button>
                <a href="index.php?action=supplier_index" class="btn btn-secondary btn-lg">
                    <i class="fas fa-times"></i> Hủy
                </a>
            </form>
            <br>
        </main>
    </div>
</div>

<?php require_once 'views/layout/footer.php'; ?>

<?php require_once 'views/layout/header.php'; ?>

<div class="container-fluid">
    <div class="row">
        <?php require_once 'views/layout/sidebar.php'; ?>

        <main class="col-md-9 ml-0 col-lg-10 px-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Chi Tiết Nhà Cung Cấp</h1>
                <div>
                    <a href="index.php?action=supplier_edit&id=<?php echo $this->supplier->id ?? ''; ?>" class="btn btn-warning">
                        <i class="fas fa-edit"></i> Chỉnh Sửa
                    </a>
                    <a href="index.php?action=supplier_index" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Quay Lại
                    </a>
                </div>
            </div>

            <div class="card mb-3">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">
                        <strong><?php echo htmlspecialchars($this->supplier->ten_ncc ?? ''); ?></strong>
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <th width="40%">Loại Dịch Vụ:</th>
                                    <td>
                                        <span class="badge badge-info badge-lg">
                                            <?php echo htmlspecialchars($this->supplier->loai_dich_vu ?? ''); ?>
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Địa Chỉ:</th>
                                    <td><?php echo htmlspecialchars($this->supplier->dia_chi ?? ''); ?></td>
                                </tr>
                                <tr>
                                    <th>Thành Phố:</th>
                                    <td><?php echo htmlspecialchars($this->supplier->thanh_pho ?? ''); ?></td>
                                </tr>
                                <tr>
                                    <th>Điện Thoại:</th>
                                    <td><a href="tel:<?php echo $this->supplier->dien_thoai ?? ''; ?>"><?php echo htmlspecialchars($this->supplier->dien_thoai ?? ''); ?></a></td>
                                </tr>
                                <tr>
                                    <th>Email:</th>
                                    <td><a href="mailto:<?php echo $this->supplier->email ?? ''; ?>"><?php echo htmlspecialchars($this->supplier->email ?? ''); ?></a></td>
                                </tr>
                                <tr>
                                    <th>Website:</th>
                                    <td>
                                        <?php if(!empty($this->supplier->website)): ?>
                                            <a href="<?php echo htmlspecialchars($this->supplier->website ?? ''); ?>" target="_blank">
                                                <?php echo htmlspecialchars($this->supplier->website ?? ''); ?>
                                            </a>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <th width="40%">Người Liên Hệ:</th>
                                    <td><?php echo htmlspecialchars($this->supplier->nguoi_lien_he ?? ''); ?></td>
                                </tr>
                                <tr>
                                    <th>Chức Vụ:</th>
                                    <td><?php echo htmlspecialchars($this->supplier->chuc_vu_lien_he ?? ''); ?></td>
                                </tr>
                                <tr>
                                    <th>ĐT Liên Hệ:</th>
                                    <td><a href="tel:<?php echo $this->supplier->dien_thoai_lien_he ?? ''; ?>"><?php echo htmlspecialchars($this->supplier->dien_thoai_lien_he ?? ''); ?></a></td>
                                </tr>
                                <tr>
                                    <th>Trạng Thái:</th>
                                    <td>
                                        <?php if(($this->supplier->trang_thai ?? '') === 'Đang hợp tác'): ?>
                                            <span class="badge badge-success badge-lg">Đang hợp tác</span>
                                        <?php else: ?>
                                            <span class="badge badge-secondary badge-lg">Ngừng hợp tác</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <?php if(!empty($this->supplier->thong_tin_thanh_toan)): ?>
                    <hr>
                    <h6><strong>Thông Tin Thanh Toán:</strong></h6>
                    <p><?php echo nl2br(htmlspecialchars($this->supplier->thong_tin_thanh_toan ?? '')); ?></p>
                    <?php endif; ?>

                    <?php if(!empty($this->supplier->ghi_chu)): ?>
                    <hr>
                    <h6><strong>Ghi Chú:</strong></h6>
                    <p><?php echo nl2br(htmlspecialchars($this->supplier->ghi_chu ?? '')); ?></p>
                    <?php endif; ?>
                </div>
            </div>
        </main>
    </div>
</div>

<?php require_once 'views/layout/footer.php'; ?>

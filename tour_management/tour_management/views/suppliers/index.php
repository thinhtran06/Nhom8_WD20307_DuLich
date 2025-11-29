<?php require_once 'views/layout/header.php'; ?>

<div class="container-fluid">
    <div class="row">
     

        <main class="col-md-9 ml-0  col-lg-10 px-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">🏢 Quản Lý Nhà Cung Cấp</h1>
                <a href="index.php?action=supplier_create" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Thêm Nhà Cung Cấp
                </a>
            </div>

            <?php if(isset($_GET['message'])): ?>
                <div class="alert alert-success alert-dismissible fade show">
                    <?php echo htmlspecialchars($_GET['message']); ?>
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                </div>
            <?php endif; ?>

            <?php if(isset($_GET['error'])): ?>
                <div class="alert alert-danger alert-dismissible fade show">
                    <?php echo htmlspecialchars($_GET['error']); ?>
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                </div>
            <?php endif; ?>

            <div class="table-responsive">
                <table class="table table-striped table-bordered table-hover">
                    <thead class="thead-dark">
                        <tr>
                            <th width="5%">ID</th>
                            <th width="20%">Tên Nhà Cung Cấp</th>
                            <th width="12%">Loại Dịch Vụ</th>
                            <th width="12%">Thành Phố</th>
                            <th width="12%">Điện Thoại</th>
                            <th width="12%">Người Liên Hệ</th>
                            <th width="10%">Trạng Thái</th>
                            <th width="17%">Thao Tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(count($suppliers) > 0): ?>
                            <?php foreach($suppliers as $supplier): ?>
                            <tr>
                                <td><?php echo $supplier['id']; ?></td>
                                <td><strong><?php echo htmlspecialchars($supplier['ten_ncc']); ?></strong></td>
                                <td>
                                    <span class="badge badge-info">
                                        <?php echo htmlspecialchars($supplier['loai_dich_vu']); ?>
                                    </span>
                                </td>
                                <td><?php echo htmlspecialchars($supplier['thanh_pho']); ?></td>
                                <td><?php echo htmlspecialchars($supplier['dien_thoai']); ?></td>
                                <td><?php echo htmlspecialchars($supplier['nguoi_lien_he']); ?></td>
                                <td>
                                    <?php if($supplier['trang_thai'] === 'Đang hợp tác'): ?>
                                        <span class="badge badge-success">Đang hợp tác</span>
                                    <?php else: ?>
                                        <span class="badge badge-secondary">Ngừng hợp tác</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <a href="index.php?action=supplier_show&id=<?php echo $supplier['id']; ?>" 
                                       class="btn btn-sm btn-info" title="Xem chi tiết">
                                        Xem
                                    </a>
                                    <a href="index.php?action=supplier_edit&id=<?php echo $supplier['id']; ?>" 
                                       class="btn btn-sm btn-warning" title="Chỉnh sửa">
                                        Sửa
                                    </a>
                                    <a href="index.php?action=supplier_delete&id=<?php echo $supplier['id']; ?>" 
                                       onclick="return confirm('Bạn có chắc muốn xóa nhà cung cấp này?')" 
                                       class="btn btn-sm btn-danger" title="Xóa">
                                        Xóa
                                    </a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="8" class="text-center">Chưa có nhà cung cấp nào</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </main>
    </div>
</div>

<?php require_once 'views/layout/footer.php'; ?>

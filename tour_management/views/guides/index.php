<?php include "views/layout/header.php"; ?>

<div class="main-content">

    <!-- Title + Add Button -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="page-title">
            <span class="emoji">🧭</span> Quản Lý Hướng Dẫn Viên
        </h1>

        <a href="index.php?action=guide_create" class="btn btn-primary btn-lg">
            + Thêm Hướng Dẫn Viên
        </a>
    </div>

    <!-- Table Wrapper -->
    <div class="table-wrapper">

        <table class="table align-middle">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Họ tên</th>
                    <th>Giới tính</th>
                    <th>Điện thoại</th>
                    <th>Email</th>
                    <th>Loại HDV</th>
                    <th>Chuyên tuyến</th>
                    <th>Trạng thái</th>
                    <th width="240">Thao tác</th>
                </tr>
            </thead>

            <tbody>
                <?php if (!empty($guides)): ?>
                    <?php foreach ($guides as $index => $g): ?>
                        <tr>
                            <td><?= $index + 1 ?></td>
                            <td><?= htmlspecialchars($g->ho_ten) ?></td>
                            <td><?= htmlspecialchars($g->gioi_tinh) ?></td>
                            <td><?= htmlspecialchars($g->dien_thoai) ?></td>
                            <td><?= htmlspecialchars($g->email) ?></td>
                            <td><?= htmlspecialchars($g->loai_hdv) ?></td>
                            <td><?= htmlspecialchars($g->chuyen_tuyen) ?></td>

                            <td>
                                <?php 
                                    $status = $g->trang_thai;
                                    $badgeClass = match ($status) {
                                        'Đang hoạt động' => 'badge-success',
                                        'Tạm nghỉ'        => 'badge-warning text-dark',
                                        default          => 'badge-secondary'
                                    };
                                ?>
                                <span class="badge <?= $badgeClass ?>" style="padding:7px 14px;">
                                    <?= htmlspecialchars($status) ?>
                                </span>
                            </td>

                            <td>
                                <div class="d-flex flex-wrap gap-1">

                                    <a href="index.php?action=guide_schedule&id=<?= $g->id ?>" 
                                       class="btn btn-sm btn-info">
                                        Lịch làm việc
                                    </a>

                                    <a href="index.php?action=guide_edit&id=<?= $g->id ?>" 
                                       class="btn btn-sm btn-warning">
                                        Sửa
                                    </a>

                                    <a href="index.php?action=guide_delete&id=<?= $g->id ?>"
                                       class="btn btn-sm btn-danger"
                                       onclick="return confirm('Bạn chắc chắn muốn xoá HDV này?');">
                                        Xoá
                                    </a>

                                </div>
                            </td>

                        </tr>
                    <?php endforeach; ?>

                <?php else: ?>
                    <tr>
                        <td colspan="9" class="text-center text-muted py-4">
                            Chưa có hướng dẫn viên nào.
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>

        </table>
    </div>
</div>

<?php include "views/layout/footer.php"; ?>

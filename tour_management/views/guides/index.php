<?php include "views/layout/header.php"; ?>

<?php
// Hàm chống lỗi htmlspecialchars(null)
function safe($v) {
    return htmlspecialchars($v ?? '', ENT_QUOTES, 'UTF-8');
}
?>

<div style="margin-left:260px; margin-top:80px; padding:20px;">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>Quản lý Hướng Dẫn Viên</h3>
        <a href="index.php?action=guide_create" class="btn btn-primary">
            + Thêm Hướng Dẫn Viên
        </a>
    </div>

    <!-- Ô tìm kiếm -->
    <div class="mb-3">
        <input type="text" id="searchInput" class="form-control" placeholder="🔍 Tìm kiếm hướng dẫn viên...">
    </div>

    <table id="guideTable" class="table table-bordered table-striped align-middle">
        <thead class="table-light">
            <tr>
                <th>#</th>
                <th>Họ tên</th>
                <th>Giới tính</th>
                <th>Điện thoại</th>
                <th>Email</th>
                <th>Loại HDV</th>
                <th>Chuyên tuyến</th>
                <th>Trạng thái</th>
                <th style="width: 220px;">Thao tác</th>
            </tr>
        </thead>

        <tbody>
            <?php foreach ($guides as $index => $g): ?>
            <tr>
                <td><?= $index + 1 ?></td>

                <!-- ✅ Sửa toàn bộ $g->field thành $g['field'] -->
                <td><?= safe($g['ho_ten']) ?></td>
                <td><?= safe($g['gioi_tinh']) ?></td>
                <td><?= safe($g['dien_thoai']) ?></td>
                <td><?= safe($g['email']) ?></td>
                <td><?= safe($g['loai_hdv']) ?></td>
                <td><?= safe($g['chuyen_tuyen']) ?></td>

                <td>
                    <?php if ($g['trang_thai'] === 'Đang hoạt động'): ?>
                        <span class="badge bg-success"><?= safe($g['trang_thai']) ?></span>
                    <?php elseif ($g['trang_thai'] === 'Tạm nghỉ'): ?>
                        <span class="badge bg-warning text-dark"><?= safe($g['trang_thai']) ?></span>
                    <?php else: ?>
                        <span class="badge bg-secondary"><?= safe($g['trang_thai']) ?></span>
                    <?php endif; ?>
                </td>

                <td>
                    <a href="index.php?action=guide_schedule&guide_id=<?= $g['id'] ?>" 
   class="btn btn-sm btn-info">
    Lịch làm việc
</a>
                    <a href="index.php?action=guide_edit&id=<?= $g['id'] ?>" class="btn btn-sm btn-warning">Sửa</a>
                    <a href="index.php?action=guide_delete&id=<?= $g['id'] ?>" class="btn btn-sm btn-danger"
                        onclick="return confirm('Bạn chắc chắn muốn xoá?');">
                        Xoá
                    </a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <script>
    document.getElementById("searchInput").addEventListener("keyup", function() {
        let filter = this.value.toLowerCase();
        let rows = document.querySelectorAll("#guideTable tbody tr");

        rows.forEach(row => {
            let text = row.textContent.toLowerCase();
            row.style.display = text.includes(filter) ? "" : "none";
        });
    });
    </script>

    <?php include "views/layout/footer.php"; ?>
</div>
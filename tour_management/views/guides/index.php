<?php include "views/layout/header.php"; ?>

<?php
function safe($v) {
    return htmlspecialchars($v ?? '', ENT_QUOTES, 'UTF-8');
}
?>

<div style="margin-left:260px; margin-top:80px; padding:20px;">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold text-primary"><i class="fas fa-users-cog"></i> Quản lý Hướng Dẫn Viên</h3>
        <a href="index.php?action=guide_create" class="btn btn-primary shadow-sm">
            <i class="fas fa-plus-circle"></i> Thêm Hướng Dẫn Viên
        </a>
    </div>

    <div class="card shadow-sm mb-4 border-0">
        <div class="card-body">
            <div class="input-group">
                <span class="input-group-text bg-white border-end-0"><i class="fas fa-search text-muted"></i></span>
                <input type="text" id="searchInput" class="form-control border-start-0" placeholder="Tìm tên, số điện thoại hoặc email...">
            </div>
        </div>
    </div>

    <div class="table-responsive shadow-sm" style="border-radius: 12px; overflow: hidden;">
        <table id="guideTable" class="table table-hover align-middle mb-0 bg-white">
            <thead class="table-dark">
                <tr>
                    <th class="text-center" style="width: 50px;">#</th>
                    <th>Thông tin cơ bản</th>
                    <th>Liên hệ</th>
                    <th class="text-center">Trạng thái</th>
                    <th class="text-center" style="width: 250px;">Thao tác</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($guides)): foreach ($guides as $index => $g): ?>
                <tr>
                    <td class="text-center text-muted"><?= $index + 1 ?></td>
                    <td>
                        <div class="fw-bold text-dark"><?= safe($g['ho_ten']) ?></div>
                        <small class="text-muted"><i class="fas fa-venus-mars"></i> <?= safe($g['gioi_tinh']) ?></small>
                    </td>
                    <td>
                        <div><i class="fas fa-phone-alt fa-xs text-primary"></i> <?= safe($g['dien_thoai']) ?></div>
                        <div class="small text-muted"><i class="fas fa-envelope fa-xs"></i> <?= safe($g['email']) ?></div>
                    </td>
                    <td class="text-center">
                        <?php 
                            $status = $g['trang_thai'] ?? 'Đang hoạt động';
                            $badgeClass = ($status === 'Đang hoạt động') ? 'bg-success' : (($status === 'Tạm nghỉ') ? 'bg-warning text-dark' : 'bg-danger');
                        ?>
                        <span class="badge rounded-pill <?= $badgeClass ?>" style="padding: 8px 15px; font-weight: 500;">
                            <?= safe($status) ?>
                        </span>
                    </td>
                    <td class="text-center">
                        <div class="d-flex justify-content-center gap-2">
                            <a href="index.php?action=guide_schedule&guide_id=<?= $g['id'] ?>" class="btn btn-info btn-sm text-white shadow-sm" title="Xem lịch dẫn tour">
                                <i class="fas fa-calendar-alt"></i> Lịch
                            </a>

                            <a href="index.php?action=guide_edit&id=<?= $g['id'] ?>" class="btn btn-warning btn-sm shadow-sm" title="Chỉnh sửa">
                                <i class="fas fa-edit"></i> Sửa
                            </a>

                            <a href="index.php?action=guide_delete&id=<?= $g['id'] ?>" class="btn btn-danger btn-sm shadow-sm" 
                               onclick="return confirm('Xóa HDV này sẽ gỡ tên họ khỏi các Booking. Chắc chắn chứ?');" title="Xóa">
                                <i class="fas fa-trash"></i> Xóa
                            </a>
                        </div>
                    </td>
                </tr>
                <?php endforeach; else: ?>
                    <tr><td colspan="5" class="text-center py-5 text-muted italic">Chưa có dữ liệu hướng dẫn viên.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<script>
document.getElementById("searchInput").addEventListener("keyup", function() {
    let filter = this.value.toLowerCase();
    let rows = document.querySelectorAll("#guideTable tbody tr");
    rows.forEach(row => {
        let text = row.innerText.toLowerCase();
        row.style.display = text.includes(filter) ? "" : "none";
    });
});
</script>

<?php include "views/layout/footer.php"; ?>
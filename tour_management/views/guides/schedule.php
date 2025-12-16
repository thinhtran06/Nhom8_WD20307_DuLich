<?php include "views/layout/header.php"; ?>

<?php 
if (!$guide) {
    echo "<div class='alert alert-danger mt-4'>Không tìm thấy hướng dẫn viên.</div>";
    echo "<a href='index.php?action=guide_index' class='btn btn-primary'>Quay lại</a>";
    include "views/layout/footer.php";
    exit;
}

$guide_id = (int)$guide->id;
?>
<div style="margin-left:260px; margin-top:30px; padding:20px;">
<h3 class="mt-3">
    Lịch làm việc của Hướng Dẫn Viên: 
    <span class="text-primary fw-bold"><?= htmlspecialchars($guide->ho_ten ?? '') ?></span>
</h3>

<p class="text-muted">
    <strong>Loại HDV:</strong> 
    <span class="badge bg-info text-dark"><?= htmlspecialchars($guide->loai_hdv ?? '') ?></span>

    <strong class="ms-3">Chuyên tuyến:</strong> 
    <span class="badge bg-primary"><?= htmlspecialchars($guide->chuyen_tuyen ?? '') ?></span>

    <strong class="ms-3">Ngoại ngữ:</strong> 
    <span class="badge bg-secondary"><?= htmlspecialchars($guide->ngon_ngu ?? '') ?></span>
</p>

<hr>

<div class="table-responsive">
<table class="table table-bordered table-striped table-hover align-middle">
    <thead class="table-light">
        <tr>
            <th>Tour</th>
            <th>Ngày khởi hành</th>
            <th>Ngày kết thúc</th>
            <th>Nơi khởi hành</th>
            <th>Điểm đến</th>
            <th class="text-center" width="180">Thao tác</th>
        </tr>
    </thead>

    <tbody>
        <?php if (!empty($schedule)): ?>
            <?php foreach ($schedule as $s): ?>

                <?php
                    if (!isset($s->tour_id)) continue;

                    $start = $s->ngay_khoi_hanh;
                    $so_ngay = max((int)$s->so_ngay - 1, 0);
                    $end = date('Y-m-d', strtotime("$start +{$so_ngay} days"));

                    $tour_id = (int)$s->tour_id;
                ?>

                <tr>
                    <td><?= htmlspecialchars($s->ten_tour ?? '') ?></td>
                    <td><?= htmlspecialchars($start ?? '') ?></td>
                    <td><?= htmlspecialchars($end ?? '') ?></td>
                    <td><?= htmlspecialchars($s->diem_khoi_hanh ?? '') ?></td>
                    <td><?= htmlspecialchars($s->diem_den ?? '') ?></td>

                    <td class="text-center">

                        <!-- Dropdown thao tác -->
                        <div class="btn-group">
    <button type="button" class="btn btn-sm btn-primary dropdown-toggle" data-toggle="dropdown">
        Thao tác
    </button>

    <ul class="dropdown-menu dropdown-menu-end">

        <li>
            <a class="dropdown-item"
                href="index.php?action=guide_tour_detail&tour_id=<?= $tour_id ?>&guide_id=<?= $guide_id ?>">
                Chi tiết tour
            </a>
        </li>

        <li>
            <a class="dropdown-item"
                href="index.php?action=guide_special_request&tour_id=<?= $tour_id ?>&guide_id=<?= $guide_id ?>">
                Yêu cầu đặc biệt
            </a>
        </li>

        <li>
            <a class="dropdown-item"
                href="index.php?action=guide_diary&tour_id=<?= $tour_id ?>&guide_id=<?= $guide_id ?>">
                Nhật ký tour
            </a>
        </li>

        <li>
            <a class="dropdown-item"
                href="index.php?action=guide_checkin&tour_id=<?= $tour_id ?>&guide_id=<?= $guide_id ?>">
                Điểm danh
            </a>
        </li>

        <li>
            <a class="dropdown-item"
                href="index.php?action=guide_customers&tour_id=<?= $tour_id ?>&guide_id=<?= $guide_id ?>">
                Danh sách khách
            </a>
        </li>

    </ul>
</div>

                    </td>
                </tr>

            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="6" class="text-center text-muted">
                    HDV chưa được phân công tour nào.
                </td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>
</div>

<a href="index.php?action=guide_index" class="btn btn-secondary mt-3">Quay lại</a>
</div>
<?php include "views/layout/footer.php"; ?>

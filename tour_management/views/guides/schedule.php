<?php include "views/layout/header.php"; ?>

<div class="main-content">

    <!-- Tiêu đề trang -->
    <h1 class="page-title">
        <span class="emoji">🧑‍✈️</span>
        Lịch làm việc của Hướng Dẫn Viên
    </h1>

    <!-- Thông tin HDV -->
    <?php if (!$guide): ?>
        <div class="alert alert-danger mt-4">Không tìm thấy hướng dẫn viên.</div>
        <a href="index.php?action=guide_index" class="btn btn-primary">Quay lại</a>
        </div>
        <?php include "views/layout/footer.php"; exit; ?>
    <?php endif; ?>

    <div class="card p-4 mb-4">
        <h4 class="mb-2">
            <strong><?= htmlspecialchars($guide->ho_ten ?? '') ?></strong>
        </h4>

        <div class="text-muted">
            <strong>Loại HDV:</strong> <?= htmlspecialchars($guide->loai_hdv ?? '') ?> |
            <strong>Chuyên tuyến:</strong> <?= htmlspecialchars($guide->chuyen_tuyen ?? '') ?> |
            <strong>Ngoại ngữ:</strong> <?= htmlspecialchars($guide->ngon_ngu ?? '') ?>
        </div>
    </div>

    <!-- Bảng lịch -->
    <div class="table-wrapper">
        <table class="table align-middle">
            <thead>
                <tr>
                    <th>Tour</th>
                    <th>Ngày khởi hành</th>
                    <th>Ngày kết thúc</th>
                    <th>Nơi khởi hành</th>
                    <th>Điểm đến</th>
                    <th width="250">Thao tác</th>
                </tr>
            </thead>

            <tbody>
                <?php if (!empty($schedule)): ?>
                    <?php foreach ($schedule as $s): ?>

                        <?php
                            $start = $s->ngay_khoi_hanh;
                            $so_ngay = (int)$s->so_ngay;
                            $end = date('Y-m-d', strtotime("$start +". max($so_ngay - 1, 0) ." days"));
                        ?>

                        <tr>
                            <td><?= htmlspecialchars($s->ten_tour ?? '') ?></td>
                            <td><?= htmlspecialchars($start) ?></td>
                            <td><?= htmlspecialchars($end) ?></td>
                            <td><?= htmlspecialchars($s->diem_khoi_hanh ?? '') ?></td>
                            <td><?= htmlspecialchars($s->diem_den ?? '') ?></td>

                            <td>
    <div class="dropdown">
        <button class="btn btn-sm btn-primary dropdown-toggle" type="button"
                data-bs-toggle="dropdown" aria-expanded="false">
            Tác vụ
        </button>
        <ul class="dropdown-menu">

            <li>
                <a class="dropdown-item"
                   href="index.php?action=guide_tour_detail&tour_id=<?= $s->tour_id ?>&guide_id=<?= $guide_id ?>">
                   📄 Chi tiết tour
                </a>
            </li>

            <li>
                <a class="dropdown-item"
                   href="index.php?action=guide_diary&tour_id=<?= $s->tour_id ?>&guide_id=<?= $guide_id ?>">
                   📘 Nhật ký tour
                </a>
            </li>

            <li>
                <a class="dropdown-item"
                   href="index.php?action=guide_special_request&tour_id=<?= $s->tour_id ?>&guide_id=<?= $guide_id ?>">
                   💡 Yêu cầu đặc biệt
                </a>
            </li>

            <li>
                <a class="dropdown-item"
                   href="index.php?action=guide_checkin&tour_id=<?= $s->tour_id ?>&guide_id=<?= $guide_id ?>">
                   ✔️ Điểm danh
                </a>
            </li>

            <li>
                <a class="dropdown-item"
                   href="index.php?action=guide_customers&tour_id=<?= $s->tour_id ?>&guide_id=<?= $guide_id ?>">
                   🧑‍🤝‍🧑 Danh sách khách
                </a>
            </li>

        </ul>
    </div>
</td>

                        </tr>

                    <?php endforeach; ?>

                <?php else: ?>
                    <tr>
                        <td colspan="6" class="text-center text-muted py-4">
                            HDV chưa được phân công tour nào.
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <a href="index.php?action=guide_index" class="btn btn-secondary mt-3">← Quay lại</a>

</div>

<?php include "views/layout/footer.php"; ?>

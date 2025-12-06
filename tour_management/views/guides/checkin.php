<?php include "views/layout/header.php"; ?>

<div class="main-content container mt-4">

    <div class="card shadow-sm">

        <!-- HEADER -->
        <div class="card-header bg-white py-3">
            <h4 class="mb-0">
                📍 Điểm danh khách – 
                <span class="text-primary">
                    <?= htmlspecialchars($tour->ten_tour ?? ('Tour ID '.$tour_id)) ?>
                </span>
            </h4>

            <small class="text-muted">
                Tour ID: <?= (int)$tour_id ?> | HDV ID: <?= (int)$guide_id ?>
            </small>
        </div>

        <div class="card-body">

            <!-- Nếu không có khách -->
            <?php if (empty($customers)): ?>
                <div class="alert alert-warning">
                    Không có khách nào trong tour này.
                </div>

                <a href="index.php?action=guide_schedule&id=<?= $guide_id ?>" 
                   class="btn btn-secondary mt-3">
                    Quay lại
                </a>

            <?php else: ?>

                <!-- FORM LƯU CHECKIN -->
                <form method="POST" action="index.php?action=guide_save_checkin" class="mb-4">

                    <input type="hidden" name="tour_id" value="<?= (int)$tour_id ?>">
                    <input type="hidden" name="guide_id" value="<?= (int)$guide_id ?>">

                    <div class="mb-3">
                        <label class="form-label fw-bold">Điểm tập trung / chặng:</label>
                        <input type="text" 
                               name="diem_tap_trung" 
                               class="form-control"
                               value="<?= htmlspecialchars($diem_tap_trung ?? 'Điểm tập trung 1') ?>" 
                               required>
                    </div>

                    <!-- BẢNG DANH SÁCH KHÁCH -->
                    <table class="table table-bordered align-middle text-center">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Khách hàng</th>
                                <th>Điện thoại</th>
                                <th>Ghi chú</th>
                                <th>Trạng thái</th>
                            </tr>
                        </thead>

                        <tbody>

                        <?php foreach ($customers as $i => $c): ?>
                            <?php
                                if (is_object($c)) $c = (array)$c; // Ép object → array để tránh lỗi

                                $cid    = $c['customer_id'] ?? 0;
                                $status = $statusMap[$cid] ?? 'Chua_den';
                            ?>
                            <tr>
                                <td><?= $i + 1 ?></td>
                                <td><?= htmlspecialchars($c['ho_ten'] ?? '') ?></td>
                                <td><?= htmlspecialchars($c['dien_thoai'] ?? '') ?></td>
                                <td><?= htmlspecialchars($c['ghi_chu'] ?? '') ?></td>

                                <td>
                                    <select name="trang_thai[<?= $cid ?>]" class="form-select form-select-sm">
                                        <option value="Da_den"   <?= $status === 'Da_den' ? 'selected' : '' ?>>Đã đến</option>
                                        <option value="Chua_den" <?= $status === 'Chua_den' ? 'selected' : '' ?>>Chưa đến</option>
                                        <option value="Vang"     <?= $status === 'Vang' ? 'selected' : '' ?>>Vắng</option>
                                    </select>
                                </td>
                            </tr>
                        <?php endforeach; ?>

                        </tbody>
                    </table>

                    <button class="btn btn-primary">Lưu điểm danh</button>
                    <a href="index.php?action=guide_schedule&id=<?= $guide_id ?>" 
                       class="btn btn-secondary ms-2">
                        Quay lại
                    </a>

                </form>

                <hr>

                <!-- LỊCH SỬ CHECKIN -->
                <h5 class="mb-3">📘 Lịch sử điểm danh</h5>

                <?php 
                // Đảm bảo $history là mảng
                $history = is_array($history) ? $history : [];
                ?>

                <?php if (empty($history)): ?>

                    <p class="text-muted">Chưa có lịch sử check-in.</p>

                <?php else: ?>

                    <table class="table table-sm table-striped">
                        <thead>
                            <tr>
                                <th>Thời gian</th>
                                <th>Khách</th>
                                <th>Điểm tập trung</th>
                                <th>Trạng thái</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php foreach ($history as $h): ?>

                                <?php
                                    if (is_object($h)) $h = (array)$h; // Ép object → array để tránh lỗi

                                    $time  = htmlspecialchars($h['thoi_gian'] ?? '');
                                    $name  = htmlspecialchars($h['ho_ten'] ?? '');
                                    $point = htmlspecialchars($h['diem_tap_trung'] ?? '');
                                    $state = $h['trang_thai'] ?? 'Chua_den';
                                ?>

                                <tr>
                                    <td><?= $time ?></td>
                                    <td><?= $name ?></td>
                                    <td><?= $point ?></td>

                                    <td>
                                        <?php if ($state === 'Da_den'): ?>
                                            <span class="badge bg-success">Đã đến</span>
                                        <?php elseif ($state === 'Vang'): ?>
                                            <span class="badge bg-danger">Vắng</span>
                                        <?php else: ?>
                                            <span class="badge bg-secondary">Chưa đến</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>

                            <?php endforeach; ?>
                        </tbody>

                    </table>

                <?php endif; ?>

            <?php endif; ?>

        </div>
    </div>

</div>

<?php include "views/layout/footer.php"; ?>

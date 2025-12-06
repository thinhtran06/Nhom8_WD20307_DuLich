<?php include "views/layout/header.php"; ?>

<div class="main-content container mt-4">

    <div class="card shadow-sm">

        <!-- HEADER -->
        <div class="card-header bg-white py-3">
            <h4 class="mb-0">
                🧾 Yêu cầu đặc biệt của khách – 
                <span class="text-primary">Tour ID <?= (int)$tour_id ?></span>
            </h4>
            <small class="text-muted">HDV ID: <?= (int)$guide_id ?></small>
        </div>


        <div class="card-body">

            <?php if (empty($customers)): ?>
                <div class="alert alert-warning">Không có khách nào trong tour này.</div>
                <a href="index.php?action=guide_schedule&id=<?= $guide_id ?>" class="btn btn-secondary mt-3">Quay lại</a>

            <?php else: ?>

                <form method="POST" action="index.php?action=guide_special_request_save">

                    <input type="hidden" name="tour_id" value="<?= (int)$tour_id ?>">
                    <input type="hidden" name="guide_id" value="<?= (int)$guide_id ?>">

                    <table class="table table-bordered align-middle text-center">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Họ tên</th>
                                <th>Yêu cầu đặc biệt</th>
                                <th>Ghi chú</th>
                            </tr>
                        </thead>

                        <tbody>

                        <?php $i = 1; foreach ($customers as $cus): ?>

                            <?php
                                // CHUYỂN OBJECT → ARRAY ĐỂ TRÁNH LỖI
                                if (is_object($cus)) $cus = (array)$cus;

                                // XÁC ĐỊNH ID KHÁCH
                                $customer_id = $cus['id'] 
                                            ?? $cus['customer_id'] 
                                            ?? $cus['khach_id'] 
                                            ?? null;

                                // TRÁNH LỖI OBJECT
                                if (isset($requests[$customer_id]) && is_object($requests[$customer_id])) {
                                    $requests[$customer_id] = (array)$requests[$customer_id];
                                }

                                // LẤY DỮ LIỆU YÊU CẦU
                                $req  = $requests[$customer_id]['yeu_cau'] ?? "";
                                $note = $requests[$customer_id]['ghi_chu'] ?? "";
                            ?>

                            <tr>
                                <td><?= $i++ ?></td>

                                <td><?= htmlspecialchars($cus['ho_ten'] ?? '') ?></td>

                                <td>
                                    <input type="text"
                                           name="yeu_cau[<?= $customer_id ?>]"
                                           value="<?= htmlspecialchars($req) ?>"
                                           class="form-control"
                                           placeholder="Ví dụ: Ăn chay, dị ứng hải sản…">
                                </td>

                                <td>
                                    <input type="text"
                                           name="ghi_chu[<?= $customer_id ?>]"
                                           value="<?= htmlspecialchars($note) ?>"
                                           class="form-control"
                                           placeholder="Ghi chú thêm…">
                                </td>
                            </tr>

                        <?php endforeach; ?>

                        </tbody>
                    </table>

                    <button class="btn btn-primary">💾 Lưu yêu cầu</button>
                    <a href="index.php?action=guide_schedule&id=<?= $guide_id ?>" class="btn btn-secondary ms-2">
                        Quay lại
                    </a>

                </form>

            <?php endif; ?>

        </div>

    </div>

</div>

<?php include "views/layout/footer.php"; ?>

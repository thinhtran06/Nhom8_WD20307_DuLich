<?php include "views/layout/header.php"; ?>

<h3>🧾 Yêu cầu đặc biệt của khách – Tour ID <?= $tour_id ?></h3>
    <?php if (isset($_GET['saved'])): ?>
                <div class="alert alert-success">
                        ✅ Đã lưu yêu cầu thành công!
                </div>
    <?php endif; ?>
<p><strong>HDV ID:</strong> <?= $guide_id ?></p>

<form method="POST" action="index.php?action=guide_save_special_request">

    <input type="hidden" name="tour_id" value="<?= $tour_id ?>">
    <input type="hidden" name="guide_id" value="<?= $guide_id ?>">

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>Họ tên</th>
                <th>Yêu cầu đặc biệt</th>
                <th>Ghi chú</th>
            </tr>
        </thead>

        <tbody>
            <?php $i=1; foreach($customers as $cus): ?>

                <?php
                    // khách trả về dạng ARRAY
                    $customer_id = $cus['customer_id'];

                    $req  = $requests[$customer_id]->yeu_cau ?? "";
                    $note = $requests[$customer_id]->ghi_chu ?? "";
                ?>

                <tr>
                    <td><?= $i++ ?></td>

                    <td><?= htmlspecialchars($cus['ho_ten']) ?></td>

                    <td>
                        <input type="text" 
                               name="yeu_cau[<?= $customer_id ?>]"
                               value="<?= htmlspecialchars($req) ?>"
                               class="form-control"
                               placeholder="Ăn chay, dị ứng hải sản...">
                    </td>

                    <td>
                        <input type="text" 
                               name="ghi_chu[<?= $customer_id ?>]"
                               value="<?= htmlspecialchars($note) ?>"
                               class="form-control"
                               placeholder="Ghi chú thêm...">
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <button class="btn btn-primary">💾 Lưu yêu cầu</button>
    <a href="index.php?action=guide_schedule&id=<?= $guide_id ?>" class="btn btn-secondary">Quay lại</a>
</form>

<?php include "views/layout/footer.php"; ?>

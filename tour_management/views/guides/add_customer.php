<?php include "views/layout/header.php"; ?>

<div style="margin-left:260px; margin-top:80px; padding:20px;">

    <h3 class="mb-4">➕ Thêm khách mới vào tour</h3>

    <div class="card shadow-sm">
        <div class="card-body">

            <form method="POST" action="index.php?action=guide_add_customer_store">

                <input type="hidden" name="tour_id" value="<?= $tour_id ?>">
                <input type="hidden" name="guide_id" value="<?= $guide_id ?>">
                <input type="hidden" name="booking_id" value="<?= $booking_id ?>">

                <label>Họ tên</label>
                <input type="text" name="ho_ten" class="form-control" required>

                <label>Email</label>
                <input type="email" name="email" class="form-control">

                <label>Điện thoại</label>
                <input type="text" name="dien_thoai" class="form-control">

                <button class="btn btn-primary mt-3">Thêm khách</button>
                <a href="javascript:history.back()" class="btn btn-secondary mt-3">Quay lại</a>

            </form>

        </div>
    </div>

</div>

<?php include "views/layout/footer.php"; ?>
<?php 
require_once __DIR__ . '/../../app/Models/Tour.php';
?>

<style>
    .booking-container {
        max-width: 700px;
        margin: 0 auto;
        background: #fff;
        padding: 25px;
        border-radius: 12px;
        border: 1px solid #ddd;
        box-shadow: 0 5px 18px rgba(0,0,0,0.08);
    }
    h2 {
        text-align: center;
        color: #003580;
        margin-bottom: 20px;
    }
    label { font-weight: bold; margin-top: 12px; display:block; }
    input, select, textarea {
        width: 100%;
        padding: 12px;
        border: 1px solid #ccc;
        border-radius: 6px;
        margin-top: 5px;
    }
    textarea { height: 100px; }
    .btn-primary {
        background:#0071c2;
        color:#fff;
        padding:12px;
        text-align:center;
        border-radius:6px;
        display:block;
        margin-top:20px;
        text-decoration:none;
        font-weight:bold;
    }
    .btn-primary:hover { background:#005a9c; }
</style>

<div class="booking-container">
    <h2>Đặt Tour</h2>

    <?php if ($tour): ?>
        <h3><?= htmlspecialchars($tour['name']) ?></h3>
        <p>Giá: <strong><?= number_format($tour['price'],0,',','.') ?> VNĐ</strong></p>
        <hr>

        <form action="index.php?page=user&action=storeBooking" method="POST">
            <input type="hidden" name="tour_id" value="<?= $tour['id'] ?>">

            <label>Loại khách</label>
            <select name="booking_type" required>
                <option value="1">Khách lẻ (1–2 người)</option>
                <option value="2">Khách đoàn (nhiều người)</option>
            </select>

            <label>Tên người đặt</label>
            <input type="text" name="customer_name" required placeholder="VD: Nguyễn Văn A">

            <label>Số lượng người</label>
            <input type="number" name="quantity" min="1" required>

            <label>Ngày khởi hành</label>
            <input type="date" name="start_date" required>

            <label>Số điện thoại</label>
            <input type="text" name="phone" required placeholder="0912345678">

            <label>Email</label>
            <input type="email" name="email" placeholder="example@gmail.com">

            <label>Yêu cầu đặc biệt</label>
            <textarea name="notes" placeholder="Ví dụ: ăn chay, phòng 3 người…"></textarea>

            <button type="submit" class="btn-primary">Xác nhận đặt tour</button>
        </form>

    <?php else: ?>
        <p>Không tìm thấy tour.</p>
    <?php endif; ?>
</div>

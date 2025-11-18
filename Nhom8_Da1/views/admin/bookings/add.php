<?php include __DIR__ . '/../../layouts/header.php'; ?>

<main class="site-content">
    <div class="container">
        <h2 style="text-align:center; margin-bottom:30px;">Đặt Tour</h2>
        <form action="index.php?page=admin_bookings&action=add" method="post" class="booking-form">
            <label for="customer_name">Họ và tên:</label>
            <input type="text" id="customer_name" name="customer_name" required>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>

            <label for="phone">Số điện thoại:</label>
            <input type="text" id="phone" name="phone" required>

            <label for="tour">Chọn tour:</label>
            <select id="tour" name="tour" required>
                <option value="">-- Chọn tour --</option>
                <option value="Tour Hà Nội - Hạ Long">Tour Hà Nội - Hạ Long</option>
                <option value="Tour Đà Nẵng - Hội An">Tour Đà Nẵng - Hội An</option>
                <option value="Tour Sài Gòn - Cần Thơ">Tour Sài Gòn - Cần Thơ</option>
            </select>

            <label for="date">Ngày khởi hành:</label>
            <input type="date" id="date" name="date" required>

            <label for="guests">Số lượng khách:</label>
            <input type="number" id="guests" name="guests" min="1" value="1" required>

            <label for="note">Ghi chú (nếu có):</label>
            <textarea id="note" name="note" rows="3"></textarea>

            <button type="submit" class="btn-primary">Đặt tour</button>
        </form>
    </div>
</main>

<?php include __DIR__ . '/../../layouts/footer.php'; ?>

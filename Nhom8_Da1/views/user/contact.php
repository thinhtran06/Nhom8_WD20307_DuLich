<div class="section contact-section">
    <h2>Liên hệ với chúng tôi</h2>
    <p>Vui lòng điền thông tin dưới đây, chúng tôi sẽ phản hồi sớm nhất.</p>

    <form action="index.php?page=user&action=sendContact" method="POST" class="contact-form">
        <div class="form-group">
            <label for="name">Tên của bạn:</label>
            <input type="text" id="name" name="name" required placeholder="Nhập tên của bạn">
        </div>

        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required placeholder="Nhập email của bạn">
        </div>

        <div class="form-group">
            <label for="phone">Điện thoại:</label>
            <input type="text" id="phone" name="phone" placeholder="Nhập số điện thoại">
        </div>

        <div class="form-group">
            <label for="message">Nội dung:</label>
            <textarea id="message" name="message" rows="5" required placeholder="Nhập nội dung liên hệ"></textarea>
        </div>

        <button type="submit" class="btn-primary">Gửi liên hệ</button>
    </form>
</div>

<style>
.contact-section {
    max-width: 700px;
    margin: 0 auto 50px;
    padding: 20px;
    background: #f9f9f9;
    border-radius: 10px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
}

.contact-section h2 {
    text-align: center;
    margin-bottom: 10px;
    font-size: 28px;
    color: #0071c2;
}

.contact-section p {
    text-align: center;
    margin-bottom: 30px;
    color: #555;
}

.contact-form .form-group {
    margin-bottom: 20px;
}

.contact-form label {
    display: block;
    margin-bottom: 5px;
    font-weight: 500;
}

.contact-form input,
.contact-form textarea {
    width: 100%;
    padding: 12px 15px;
    border: 1px solid #ccc;
    border-radius: 6px;
    font-size: 15px;
    transition: all 0.3s;
}

.contact-form input:focus,
.contact-form textarea:focus {
    outline: none;
    border-color: #0071c2;
    box-shadow: 0 0 5px
}
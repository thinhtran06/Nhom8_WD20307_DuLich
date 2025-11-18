
<div class="section" style="max-width:400px; margin:50px auto; padding:30px; border:1px solid #ddd; border-radius:10px; box-shadow:0 2px 8px rgba(0,0,0,0.1); background-color:#fff;">
    <h2 style="text-align:center; margin-bottom:20px;">Đăng ký tài khoản</h2>

    <form action="index.php?page=register&action=saveRegister" method="POST">
        <div style="margin-bottom:15px;">
            <label for="name">Họ và tên</label>
            <input type="text" id="name" name="name" required style="width:100%; padding:10px; border:1px solid #ccc; border-radius:5px;">
        </div>

        <div style="margin-bottom:15px;">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" required style="width:100%; padding:10px; border:1px solid #ccc; border-radius:5px;">
        </div>

        <div style="margin-bottom:15px;">
            <label for="password">Mật khẩu</label>
            <input type="password" id="password" name="password" required style="width:100%; padding:10px; border:1px solid #ccc; border-radius:5px;">
        </div>

        <div style="margin-bottom:15px;">
            <label for="confirm_password">Xác nhận mật khẩu</label>
            <input type="password" id="confirm_password" name="confirm_password" required style="width:100%; padding:10px; border:1px solid #ccc; border-radius:5px;">
        </div>

        <button type="submit" class="btn-primary" style="width:100%; padding:10px; border:none; border-radius:5px; background-color:#28a745; color:#fff; font-weight:bold;">Đăng ký</button>
    </form>

    <p style="text-align:center; margin-top:15px;">
        Bạn đã có tài khoản? 
        <a href="index.php?page=login&action=index" style="color:#007bff;">Đăng nhập</a>
    </p>
</div>



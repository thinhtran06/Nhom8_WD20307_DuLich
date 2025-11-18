<?php include __DIR__ . '/../layouts/header.php'; ?>

<div class="section" style="max-width:400px; margin:50px auto; padding:30px; border:1px solid #ddd; border-radius:10px; box-shadow:0 2px 8px rgba(0,0,0,0.1); background-color:#fff;">
    <h2 style="text-align:center; margin-bottom:20px;">Đăng nhập</h2>
    
    <form action="index.php?page=login&action=checkLogin" method="POST">
        <div style="margin-bottom:15px;">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" required style="width:100%; padding:10px; border:1px solid #ccc; border-radius:5px;">
        </div>

        <div style="margin-bottom:15px;">
            <label for="password">Mật khẩu</label>
            <input type="password" id="password" name="password" required style="width:100%; padding:10px; border:1px solid #ccc; border-radius:5px;">
        </div>

        <button type="submit" class="btn-primary" style="width:100%; padding:10px; border:none; border-radius:5px; background-color:#007bff; color:#fff; font-weight:bold;">Đăng nhập</button>
    </form>

    <p style="text-align:center; margin-top:15px;">
        Chưa có tài khoản? 
        <a href="index.php?page=register&action=index" style="color:#007bff;">Đăng ký</a>
    </p>
</div>

<?php include __DIR__ . '/../layouts/footer.php'; ?>

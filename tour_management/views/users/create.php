<?php 
// views/users/create.php - Đã khắc phục lỗi trùng lặp layout
require_once 'views/layout/header.php'; 
?>
<div class="container">
    <h2>➕ Tạo Tài Khoản Mới</h2>
    
    <?php if (isset($_GET['error'])): ?>
        <div class="alert alert-danger" role="alert">
            ❌ Lỗi: <?php echo htmlspecialchars($_GET['error']); ?>
        </div>
    <?php endif; ?>
    
    <form action="index.php?action=user_store" method="POST">
        
        <div class="mb-3">
            <label for="username" class="form-label">Tên Đăng Nhập</label>
            <input type="text" class="form-control" id="username" name="username" required>
        </div>
        
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>
        
        <div class="mb-3">
            <label for="password" class="form-label">Mật Khẩu</label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>
        
       <div class="mb-3">
    <label for="role" class="form-label">Quyền Hạn</label>
    <select class="form-control" id="role" name="role" required>
        <option value="Admin">Admin</option>
        <option value="Staff">Staff</option> 
        </select>
</div>
        
        <button type="submit" class="btn btn-primary">Lưu Người Dùng</button>
        <a href="index.php?action=user_index" class="btn btn-secondary">Hủy</a>
        
    </form>
</div>
<?php require_once 'views/layout/footer.php'; ?>
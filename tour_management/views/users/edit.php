<?php require_once 'views/layout/header.php'; ?>
<div class="container">
    <h2>✏️ Sửa Tài Khoản: <?php echo $user['username']; ?></h2>
    
    <?php // $user được truyền từ UserController::edit($id) ?>
    <form action="index.php?action=user_update&id=<?php echo $user['id']; ?>" method="POST">
        <div class="mb-3">
            <label for="username" class="form-label">Tên Đăng Nhập</label>
            <input type="text" class="form-control" id="username" name="username" value="<?php echo htmlspecialchars($user['username']); ?>" required>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Mật Khẩu (Để trống nếu không đổi)</label>
            <input type="password" class="form-control" id="password" name="password">
        </div>
       <div class="mb-3">
    <label for="role" class="form-label">Quyền Hạn</label>
    <select class="form-control" id="role" name="role" required>
        <option value="Admin" <?php echo ($user['role'] == 'Admin') ? 'selected' : ''; ?>>Admin</option>
        <option value="Staff" <?php echo ($user['role'] == 'Staff') ? 'selected' : ''; ?>>Staff</option>
        </select>
</div>
        <button type="submit" class="btn btn-primary">Cập Nhật</button>
        <a href="index.php?action=user_index" class="btn btn-secondary">Hủy</a>
    </form>
</div>
<?php require_once 'views/layout/footer.php'; ?>
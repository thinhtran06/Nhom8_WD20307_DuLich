<?php require_once 'views/layout/header.php'; ?>
<div class="container">
    <h2>ℹ️ Chi Tiết Tài Khoản</h2>
    
    <?php // $user được truyền từ UserController::show($id) ?>
    <div class="card">
        <div class="card-header">
            Thông tin Người Dùng #<?php echo $user['id']; ?>
        </div>
        <div class="card-body">
            <p><strong>Tên Đăng Nhập:</strong> <?php echo $user['username']; ?></p>
            <p><strong>Email:</strong> <?php echo $user['email']; ?></p>
            <p><strong>Quyền Hạn:</strong> <span class="badge bg-primary"><?php echo $user['role']; ?></span></p>
            </div>
        <div class="card-footer">
            <a href="index.php?action=user_edit&id=<?php echo $user['id']; ?>" class="btn btn-warning">Sửa</a>
            <a href="index.php?action=user_index" class="btn btn-secondary">Quay lại danh sách</a>
        </div>
    </div>
</div>
<?php require_once 'views/layout/footer.php'; ?>
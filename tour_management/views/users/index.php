<?php require_once 'views/layout/header.php'; ?>
<div class="container">
    <h2>👥 Quản Lý Tài Khoản</h2>
    
    <?php if(isset($_GET['message'])): ?>
        <div class="alert alert-success"><?php echo $_GET['message']; ?></div>
    <?php endif; ?>

    <a href="index.php?action=user_create" class="btn btn-primary mb-3">Thêm Tài Khoản Mới</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Tên Đăng Nhập</th>
                <th>Email</th>
                <th>Quyền</th>
                <th>Thao tác</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            // $users được truyền từ UserController::index()
            foreach($users as $user): ?>
            <tr>
                <td><?php echo $user['id']; ?></td>
                <td><?php echo $user['username']; ?></td>
                <td><?php echo $user['email']; ?></td>
                <td><?php echo $user['role']; ?></td>
                <td>
                    <a href="index.php?action=user_show&id=<?php echo $user['id']; ?>" class="btn btn-sm btn-info">Xem</a>
                    <a href="index.php?action=user_edit&id=<?php echo $user['id']; ?>" class="btn btn-sm btn-warning">Sửa</a>
                    <a href="index.php?action=user_delete&id=<?php echo $user['id']; ?>" 
                       onclick="return confirm('Bạn có chắc muốn xóa tài khoản này?')" 
                       class="btn btn-sm btn-danger">Xóa</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?php require_once 'views/layout/footer.php'; ?>
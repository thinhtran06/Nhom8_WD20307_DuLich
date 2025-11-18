<div class="container mt-5">
    <h2 class="mb-4">Danh sách Tour</h2>
    <a href="index.php?page=admin_tours&action=add" class="btn btn-primary mb-3">Thêm Tour Mới</a>

    <table class="table table-striped table-bordered">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Tên Tour</th>
                <th>Giá (VNĐ)</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            <?php if(!empty($tours)): ?>
                <?php foreach($tours as $tour): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($tour['id']); ?></td>
                        <td><?php echo htmlspecialchars($tour['name']); ?></td>
                        <td><?php echo number_format($tour['price']); ?></td>
                        <td>
                            <!-- Có thể thêm sửa/xóa sau -->
                            <a href="index.php?page=admin_tours&action=edit&id=<?php echo $tour['id']; ?>" class="btn btn-sm btn-warning">Sửa</a>
                            <a href="index.php?page=admin_tours&action=delete&id=<?php echo $tour['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Bạn có chắc muốn xóa tour này?');">Xóa</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="4" class="text-center">Chưa có tour nào.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

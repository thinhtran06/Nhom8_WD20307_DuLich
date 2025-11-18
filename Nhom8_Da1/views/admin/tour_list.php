<h2>Quản lý tour</h2>
<a href="index.php?page=admin_tours&action=add" class="btn">Thêm tour</a>

<table border="1" cellpadding="8" cellspacing="0">
    <thead>
        <tr>
            <th>ID</th>
            <th>Tên tour</th>
            <th>Loại</th>
            <th>Giá</th>
            <th>Nhà cung cấp</th>
            <th>Hành động</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($tours as $tour): ?>
        <tr>
            <td><?= $tour['id'] ?></td>
            <td><?= htmlspecialchars($tour['name']) ?></td>
            <td><?= $tour['type'] ?></td>
            <td><?= number_format($tour['price']) ?></td>
            <td><?= htmlspecialchars($tour['supplier']) ?></td>
            <td>
                <a href="index.php?page=admin_tours&action=edit&id=<?= $tour['id'] ?>">Sửa</a> |
                <a href="index.php?page=admin_tours&action=delete&id=<?= $tour['id'] ?>" onclick="return confirm('Xác nhận xóa?')">Xóa</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

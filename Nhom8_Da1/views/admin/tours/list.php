<!-- views/admin/tours/list.php -->
<h2>Danh sách tour</h2>
<a href="index.php?page=admin_tours&action=add">Thêm tour mới</a>
<table border="1">
<tr><th>ID</th><th>Tên</th><th>Loại</th><th>Giá</th></tr>
<?php foreach($tours as $t): ?>
<tr>
    <td><?= $t['id'] ?></td>
    <td><?= $t['name'] ?></td>
    <td><?= $t['type'] ?></td>
    <td><?= $t['price'] ?></td>
</tr>
<?php endforeach; ?>
</table>

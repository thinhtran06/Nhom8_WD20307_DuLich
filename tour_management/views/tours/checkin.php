<div class="card">
    <div class="card-header">
        <h3>Điểm danh Tour: <?= $tour['ten_tour'] ?></h3>
    </div>
    <div class="card-body">
        <form action="process_checkin.php" method="POST">
            <input type="hidden" name="tour_id" value="<?= $tour['id'] ?>">
            
            <div class="row mb-3">
                <div class="col-md-6">
                    <label>Điểm tập trung / Trạm dừng:</label>
                    <input type="text" name="diem_tap_trung" class="form-control" required placeholder="VD: Sân bay, Trạm nghỉ số 1...">
                </div>
                <div class="col-md-6">
                    <label>Hướng dẫn viên:</label>
                    <select name="guide_id" class="form-control">
                        <?php foreach($guides as $guide): ?>
                            <option value="<?= $guide['id'] ?>"><?= $guide['ho_ten'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Khách hàng</th>
                        <th>SĐT</th>
                        <th>Trạng thái</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($customers as $cust): ?>
                    <tr>
                        <td>
                            <?= $cust['ho_ten'] ?>
                            <input type="hidden" name="customer_ids[]" value="<?= $cust['id'] ?>">
                        </td>
                        <td><?= $cust['dien_thoai'] ?></td>
                        <td>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="status_<?= $cust['id'] ?>" value="Da_den" checked>
                                <label class="form-check-label">Đã đến</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="status_<?= $cust['id'] ?>" value="Vang">
                                <label class="form-check-label text-danger">Vắng</label>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <button type="submit" class="btn btn-primary">Lưu điểm danh</button>
        </form>
    </div>
</div>
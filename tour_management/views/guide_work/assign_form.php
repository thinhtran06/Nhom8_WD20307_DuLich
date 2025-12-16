<?php require_once 'views/layout/header.php'; ?>


<div class="container mt-4">

    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">
                <i class="fas fa-user-check"></i> 
                Phân công HDV cho tour: <?= htmlspecialchars($tour['ten_tour']) ?>
            </h4>
        </div>

        <div class="card-body">

            <form method="POST" action="index.php?action=guide_work_assign_save">

                <!-- Hidden tour_id -->
                <input type="hidden" name="tour_id" value="<?= $tour['id'] ?>">

                <!-- Chọn HDV -->
                <div class="form-group mb-3">
                    <label class="fw-bold">Chọn Hướng Dẫn Viên</label>
                    <select name="guide_id" class="form-control" required>
                        <option value="">-- Chọn HDV --</option>
                        <?php foreach ($guides as $g): ?>
                            <option value="<?= $g['id'] ?>">
                                <?= htmlspecialchars($g['ho_ten']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- Ngày làm việc -->
                <div class="form-group mb-3">
                    <label class="fw-bold">Ngày khởi hành</label>
                    <input type="date" name="work_date" class="form-control" required>
                </div>

                <!-- Buttons -->
                <div class="mt-4">
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-save"></i> Lưu phân công
                    </button>

                    <a href="index.php?action=tour_index" class="btn btn-secondary ms-2">
                        <i class="fas fa-arrow-left"></i> Quay lại
                    </a>
                </div>

            </form>

        </div>
    </div>

</div>
<?php 
// views/booking/attendance.php (ĐÃ HOÀN CHỈNH)

// 1. INCLUDE HEADER 
require_once 'views/layout/header.php'; 
// Giả định $booking, $guests, và $attendance_history đã được Controller truyền vào.

?>

<div class="container mt-4">
    <h2 class="mb-4">Điểm Danh Tour: <?php echo htmlspecialchars($booking['ma_dat_tour'] ?? 'N/A'); ?></h2>
    
    <?php if ($guests): ?>
        <form action="index.php?action=booking_attendance&id=<?php echo $booking['id']; ?>" method="POST">
            <input type="hidden" name="update_attendance" value="1">
            
            <div class="card p-3 mb-4 bg-light">
                <h5><i class="fas fa-bullhorn"></i> Hoạt Động Điểm Danh</h5>
                <input type="text" name="activity_name" class="form-control" placeholder="Ví dụ: Check-in Khách Sạn/Ăn Trưa Ngày 1" required>
            </div>
            
            <div class="table-responsive mb-5">
                <table class="table table-bordered table-hover align-middle">
                    <thead class="thead-dark">
                        <tr class="table-dark">
                            <th>#</th>
                            <th>Họ Tên Khách Hàng</th>
                            <th>Trạng Thái Gần Nhất</th>
                            <th>Điểm Danh Lần Này</th>
                            <th>Ghi Chú Lần Này</th>
                            <!-- <th>Lịch Sử</th>  -->
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $stt = 1;
                        foreach ($guests as $guest):
                            $latest_status = $guest['latest_log']['is_present'] ?? null;
                        ?>
                            <tr>
                                <td><?php echo $stt++; ?></td>
                                <td>
                                    <?php echo htmlspecialchars($guest['ho_ten']); ?>
                                    <?php if (isset($booking['customer_id']) && $guest['customer_id'] == $booking['customer_id']): ?>
                                        <span class="badge bg-primary">Đại Diện</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php 
                                        if ($latest_status === 1) {
                                            echo '<span class="badge bg-success">Đã Đến (' . htmlspecialchars($guest['latest_log']['activity_name']) . ')</span>';
                                        } elseif ($latest_status === 0) {
                                            echo '<span class="badge bg-danger">Vắng Mặt (' . htmlspecialchars($guest['latest_log']['activity_name']) . ')</span>';
                                        } else {
                                            echo '<span class="badge bg-secondary">Chưa điểm danh</span>';
                                        }
                                    ?>
                                </td>
                                <td>
                                    <div class="d-flex gap-2">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" 
                                                    name="attendance_<?php echo $guest['id']; ?>" 
                                                    id="present_<?php echo $guest['id']; ?>" 
                                                    value="Đã đến" 
                                                    <?php echo ($latest_status === 1) ? 'checked' : ''; ?> required>
                                            <label class="form-check-label text-success" for="present_<?php echo $guest['id']; ?>">Có Mặt</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" 
                                                    name="attendance_<?php echo $guest['id']; ?>" 
                                                    id="absent_<?php echo $guest['id']; ?>" 
                                                    value="Vắng mặt" 
                                                    <?php echo ($latest_status === 0) ? 'checked' : ''; ?> required>
                                            <label class="form-check-label text-danger" for="absent_<?php echo $guest['id']; ?>">Vắng Mặt</label>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <input type="text" name="notes_<?php echo $guest['id']; ?>" 
                                            class="form-control form-control-sm" 
                                            placeholder="Lý do vắng mặt, số phòng,..." 
                                            value="<?php echo htmlspecialchars($guest['latest_log']['notes'] ?? ''); ?>">
                                </td>
                                <!-- <td>
                                    <button type="button" class="btn btn-sm btn-info" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#historyModal" 
                                            data-guest-id="<?php echo $guest['id']; ?>"
                                            data-guest-name="<?php echo htmlspecialchars($guest['ho_ten']); ?>">
                                        <i class="fas fa-history"></i> Log
                                    </button>
                                </td> -->
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            
            <button type="submit" class="btn btn-success btn-lg mb-4">
                <i class="fas fa-check-double"></i> Cập Nhật Điểm Danh (Lưu Log Mới)
            </button>
        </form>

        <hr>

        <h4 class="mt-4 mb-3"><i class="fas fa-list-ul"></i> Lịch Sử Điểm Danh Chi Tiết</h4>
        <?php if (!empty($attendance_history)): ?>
            <div class="table-responsive">
                <table class="table table-striped table-sm">
                    <thead class="table-secondary">
                        <tr>
                            <th>Khách Hàng</th>
                            <th>Hoạt Động</th>
                            <th>Trạng Thái</th>
                            <th>Thời Gian</th>
                            <th>Ghi Chú</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($attendance_history as $log): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($log['ho_ten']); ?></td>
                                <td><?php echo htmlspecialchars($log['activity_name']); ?></td>
                                <td>
                                    <?php if ($log['is_present'] == 1): ?>
                                        <span class="badge bg-success">CÓ MẶT</span>
                                    <?php else: ?>
                                        <span class="badge bg-danger">VẮNG MẶT</span>
                                    <?php endif; ?>
                                </td>
                                <td><?php echo date('H:i:s d/m/Y', strtotime($log['attendance_time'])); ?></td>
                                <td><?php echo htmlspecialchars($log['notes'] ?? ''); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <div class="alert alert-info">
                Chưa có hoạt động điểm danh nào được ghi lại cho Booking này.
            </div>
        <?php endif; ?>

    <?php else: ?>
        <div class="alert alert-warning">
            <i class="fas fa-exclamation-triangle"></i> Không tìm thấy khách hàng cá nhân nào trong Booking này.
        </div>
    <?php endif; ?>
</div>

<div class="modal fade" id="historyModal" tabindex="-1" aria-labelledby="historyModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="historyModalLabel">Lịch Sử Điểm Danh Cá Nhân</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p>Khách hàng: <strong id="guestNameDisplay"></strong></p>
        <div id="historyTableContainer">
          Đang tải lịch sử...
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
      </div>
    </div>
  </div>
</div>

<script>
// JavaScript xử lý sự kiện mở Modal và tải dữ liệu lịch sử bằng AJAX (Giữ nguyên)
document.addEventListener('DOMContentLoaded', function () {
    var historyModal = document.getElementById('historyModal');
    if (!historyModal) return; 

    historyModal.addEventListener('show.bs.modal', function (event) {
        var button = event.relatedTarget;
        var guestId = button.getAttribute('data-guest-id'); 
        var guestName = button.getAttribute('data-guest-name');
        
        var modalTitle = historyModal.querySelector('#guestNameDisplay');
        var historyContainer = historyModal.querySelector('#historyTableContainer');

        modalTitle.textContent = guestName;
        historyContainer.innerHTML = '<div class="text-center p-3"><i class="fas fa-spinner fa-spin"></i> Đang tải lịch sử...</div>';

        // Gọi endpoint để lấy lịch sử điểm danh cá nhân
        fetch('index.php?action=get_attendance_history&tour_customer_id=' + guestId)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                let tableHtml = '<table class="table table-sm table-striped">';
                tableHtml += '<thead><tr><th>Hoạt Động</th><th>Trạng Thái</th><th>Thời Gian</th><th>Ghi Chú</th></tr></thead><tbody>';
                
                if (data.length > 0) {
                    data.forEach(log => {
                        const statusBadge = log.is_present == 1 
                            ? '<span class="badge bg-success">CÓ MẶT</span>' 
                            : '<span class="badge bg-danger">VẮNG MẶT</span>';
                        
                        const date = new Date(log.attendance_time);
                        const formattedTime = date.toLocaleString('vi-VN', { 
                            year: 'numeric', month: 'numeric', day: 'numeric', 
                            hour: '2-digit', minute: '2-digit' 
                        });
                            
                        tableHtml += `<tr>
                                          <td>${log.activity_name}</td>
                                          <td>${statusBadge}</td>
                                          <td>${formattedTime}</td>
                                          <td>${log.notes || ''}</td>
                                      </tr>`;
                    });
                } else {
                    tableHtml += '<tr><td colspan="4"><div class="alert alert-info mt-2">Chưa có bản ghi điểm danh nào.</div></td></tr>';
                }
                
                tableHtml += '</tbody></table>';
                historyContainer.innerHTML = tableHtml;
            })
            .catch(error => {
                historyContainer.innerHTML = '<div class="alert alert-danger mt-2">Lỗi khi tải lịch sử.</div>';
                console.error('Error fetching history:', error);
            });
    });
});
</script>

<?php 
// require_once 'views/layout/footer.php'; 
?>
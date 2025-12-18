<?php include 'views/layout/header.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<div class="container" style="margin-top: 100px; padding-bottom: 50px;">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2><i class="fas fa-chart-pie text-primary me-2"></i>Báo Cáo Hoạt Động Hệ Thống</h2>
        <button onclick="window.print()" class="btn btn-outline-secondary btn-sm">
            <i class="fas fa-print"></i> In báo cáo
        </button>
    </div>

    <div class="row g-3 mb-5">
        <div class="col-md-3">
            <div class="card border-0 shadow-sm bg-gradient-primary text-white p-3" style="background: linear-gradient(45deg, #4e73df, #224abe);">
                <div class="d-flex align-items-center">
                    <div class="flex-grow-1">
                        <small class="text-white-50">Tổng Đơn Hàng</small>
                        <h3 class="mb-0 fw-bold"><?php echo $stats['total_bookings']; ?></h3>
                    </div>
                    <i class="fas fa-clipboard-list fa-2x text-white-50"></i>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm bg-success text-white p-3" style="background: linear-gradient(45deg, #1cc88a, #13855c);">
                <div class="d-flex align-items-center">
                    <div class="flex-grow-1">
                        <small class="text-white-50">Doanh Thu Dự Kiến</small>
                        <h3 class="mb-0 fw-bold"><?php echo number_format($stats['total_revenue'], 0, ',', '.'); ?>đ</h3>
                    </div>
                    <i class="fas fa-dollar-sign fa-2x text-white-50"></i>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm bg-warning text-white p-3" style="background: linear-gradient(45deg, #f6c23e, #dda20a);">
                <div class="d-flex align-items-center">
                    <div class="flex-grow-1">
                        <small class="text-white-50">Thực Thu (Đã nhận)</small>
                        <h3 class="mb-0 fw-bold"><?php echo number_format($stats['actual_received'], 0, ',', '.'); ?>đ</h3>
                    </div>
                    <i class="fas fa-wallet fa-2x text-white-50"></i>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm bg-info text-white p-3" style="background: linear-gradient(45deg, #36b9cc, #258391);">
                <div class="d-flex align-items-center">
                    <div class="flex-grow-1">
                        <small class="text-white-50">Đơn Hoàn Thành</small>
                        <h3 class="mb-0 fw-bold"><?php echo $stats['completed_count']; ?></h3>
                    </div>
                    <i class="fas fa-check-circle fa-2x text-white-50"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-white py-3">
                    <h6 class="m-0 fw-bold text-primary">Phân tích Tài chính (VNĐ)</h6>
                </div>
                <div class="card-body">
                    <canvas id="revenueChart" style="max-height: 300px;"></canvas>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-white py-3">
                    <h6 class="m-0 fw-bold text-primary">Tỷ lệ Trạng thái</h6>
                </div>
                <div class="card-body">
                    <canvas id="statusChart" style="max-height: 300px;"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// --- BIỂU ĐỒ CỘT ---
const ctxRevenue = document.getElementById('revenueChart').getContext('2d');
new Chart(ctxRevenue, {
    type: 'bar',
    data: {
       labels: ['Tiền dự kiến thu', 'Tiền mặt thực thu'],
datasets: [{
    label: 'VNĐ',
    data: [<?php echo $stats['total_revenue']; ?>, <?php echo $stats['actual_received']; ?>],
    // Màu xanh dương cho dự kiến, màu xanh lá cho tiền mặt thực tế
    backgroundColor: ['rgba(54, 162, 235, 0.5)', 'rgba(40, 167, 69, 0.5)'], 
    borderColor: ['#36a2eb', '#28a745'],
    borderWidth: 1
}]
    },
    options: {
        responsive: true,
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    callback: function(value) {
                        return value.toLocaleString('vi-VN') + ' đ';
                    }
                }
            }
        },
        plugins: {
            legend: { display: false },
            tooltip: {
                callbacks: {
                    label: function(context) {
                        return context.raw.toLocaleString('vi-VN') + ' VNĐ';
                    }
                }
            }
        }
    }
});

// --- BIỂU ĐỒ TRÒN ---
const ctxStatus = document.getElementById('statusChart').getContext('2d');
new Chart(ctxStatus, {
    type: 'doughnut',
    data: {
        labels: ['Hoàn thành', 'Đã hủy', 'Khác'],
        datasets: [{
            data: [
                <?php echo $stats['completed_count']; ?>, 
                <?php echo $stats['canceled_count']; ?>, 
                <?php echo ($stats['total_bookings'] - $stats['completed_count'] - $stats['canceled_count']); ?>
            ],
            backgroundColor: ['#1cc88a', '#e74a3b', '#f6c23e'],
            hoverOffset: 4
        }]
    }
});
</script>

<?php include 'views/layout/footer.php'; ?>
<?php
require_once dirname(__DIR__, 2) . "/Model/init.php";
require_once dirname(__DIR__, 2) . "/Model/hoadon.php";

$hd = new HoaDon();
$tk = $hd->thongKe();
$tkThang = $hd->thongKeTheoThang();

$db = new Database();
$conn = $db->getConnection();

$sp = $conn->query("SELECT COUNT(*) as total FROM hanghoa")->fetch()['total'];
$kh = $conn->query("SELECT COUNT(*) as total FROM khachhang")->fetch()['total'];
$loai = $conn->query("SELECT COUNT(*) as total FROM loaihang")->fetch()['total'];
?>

<!-- 4 Luxury Stat Cards -->
<div class="row g-4 mb-4">
    <!-- Card 1: Tổng Doanh Thu -->
    <div class="col-xl-3 col-md-6">
        <div class="stat-card-luxury stat-card-red">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <p class="stat-label">Tổng Doanh Thu</p>
                    <h3 class="stat-value text-danger"><?php echo number_format($tk['doanh_thu'] ?? 0); ?>đ</h3>
                    <small class="text-success fw-bold"><i class="fas fa-arrow-trend-up me-1"></i> Tăng trưởng ổn định</small>
                </div>
                <div class="stat-icon-wrap" style="background: rgba(225, 29, 72, 0.1); color: var(--yame-red);">
                    <i class="fas fa-sack-dollar"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Card 2: Tổng Đơn Hàng -->
    <div class="col-xl-3 col-md-6">
        <div class="stat-card-luxury stat-card-black">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <p class="stat-label">Tổng Đơn Hàng</p>
                    <h3 class="stat-value"><?php echo $tk['tong_don'] ?? 0; ?></h3>
                    <small class="text-secondary fw-semibold">Đơn hàng phát sinh</small>
                </div>
                <div class="stat-icon-wrap" style="background: #f4f4f5; color: var(--yame-black);">
                    <i class="fas fa-cart-shopping"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Card 3: Sản Phẩm -->
    <div class="col-xl-3 col-md-6">
        <div class="stat-card-luxury stat-card-blue">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <p class="stat-label">Sản Phẩm Trong Kho</p>
                    <h3 class="stat-value" style="color: #0284c7;"><?php echo $sp; ?></h3>
                    <small class="text-secondary fw-semibold">Thuộc <?php echo $loai; ?> danh mục</small>
                </div>
                <div class="stat-icon-wrap" style="background: rgba(14, 165, 233, 0.1); color: #0284c7;">
                    <i class="fas fa-shirt"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Card 4: Khách Hàng -->
    <div class="col-xl-3 col-md-6">
        <div class="stat-card-luxury stat-card-amber">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <p class="stat-label">Khách Hàng Thành Viên</p>
                    <h3 class="stat-value" style="color: #d97706;"><?php echo $kh; ?></h3>
                    <small class="text-secondary fw-semibold">Tài khoản đã đăng ký</small>
                </div>
                <div class="stat-icon-wrap" style="background: rgba(245, 158, 11, 0.1); color: #d97706;">
                    <i class="fas fa-users"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Charts Row -->
<div class="row g-4 mb-4">
    <!-- Bar Chart Doanh Thu -->
    <div class="col-lg-8">
        <div class="table-container h-100 mb-0">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h5 class="fw-bold mb-1" style="font-size: 1.05rem;">Biểu Đồ Doanh Thu Theo Tháng</h5>
                    <small class="text-secondary">Thống kê doanh số bán ra theo từng tháng trong năm</small>
                </div>
                <span class="badge bg-light text-dark border px-3 py-2 fw-semibold">VNĐ</span>
            </div>
            <div style="position: relative; height: 280px;">
                <canvas id="revenueChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Doughnut Chart Trạng Thái -->
    <div class="col-lg-4">
        <div class="table-container h-100 mb-0">
            <div class="mb-4">
                <h5 class="fw-bold mb-1" style="font-size: 1.05rem;">Tỷ Lệ Trạng Thái Đơn Hàng</h5>
                <small class="text-secondary">Phân bổ tiến độ xử lý đơn</small>
            </div>
            <div style="position: relative; height: 240px;" class="d-flex align-items-center justify-content-center">
                <canvas id="statusChart"></canvas>
            </div>
        </div>
    </div>
</div>

<!-- Tables Row -->
<div class="row g-4">
    <!-- Đơn Hàng Gần Đây -->
    <div class="col-lg-6">
        <div class="table-container mb-0">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="fw-bold mb-0" style="font-size: 1.05rem;">
                    <i class="fas fa-clock-rotate-left text-danger me-2"></i> Đơn Hàng Gần Đây
                </h5>
                <a href="index.php?act=hoadon" class="small fw-bold text-danger text-decoration-none">Xem tất cả <i class="fas fa-arrow-right small"></i></a>
            </div>
            <div class="table-responsive">
                <table class="table align-middle table-hover mb-0">
                    <thead class="table-light small text-uppercase">
                        <tr>
                            <th>Mã đơn</th>
                            <th>Khách hàng</th>
                            <th>Tổng tiền</th>
                            <th>Trạng thái</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $recent = $conn->query("SELECT h.*, k.ten_khachhang FROM hoadon h LEFT JOIN khachhang k ON h.id_khachhang = k.id_khachhang ORDER BY h.id_hoadon DESC LIMIT 5")->fetchAll();
                        if (empty($recent)): ?>
                            <tr><td colspan="4" class="text-center py-3 text-muted">Chưa có đơn hàng nào</td></tr>
                        <?php else:
                            foreach ($recent as $r):
                        ?>
                        <tr>
                            <td><strong>#DH-<?php echo $r['id_hoadon']; ?></strong></td>
                            <td><?php echo htmlspecialchars($r['ten_khachhang'] ?? 'Khách lẻ'); ?></td>
                            <td class="fw-bold text-danger"><?php echo number_format($r['tong_tien']); ?>đ</td>
                            <td>
                                <?php 
                                $bClass = [
                                    'Chờ xác nhận' => 'bg-warning text-dark',
                                    'Đang giao' => 'bg-info text-dark',
                                    'Hoàn thành' => 'bg-success text-white',
                                    'Đã hủy' => 'bg-danger text-white'
                                ][$r['trang_thai']] ?? 'bg-secondary text-white';
                                ?>
                                <span class="badge rounded-pill px-2 py-1 small fw-bold <?php echo $bClass; ?>"><?php echo $r['trang_thai']; ?></span>
                            </td>
                        </tr>
                        <?php endforeach; endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Sản Phẩm Bán Chạy -->
    <div class="col-lg-6">
        <div class="table-container mb-0">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="fw-bold mb-0" style="font-size: 1.05rem;">
                    <i class="fas fa-fire text-danger me-2"></i> Top Sản Phẩm Bán Chạy
                </h5>
                <a href="index.php?act=hanghoa" class="small fw-bold text-danger text-decoration-none">Kho hàng <i class="fas fa-arrow-right small"></i></a>
            </div>
            <div class="table-responsive">
                <table class="table align-middle table-hover mb-0">
                    <thead class="table-light small text-uppercase">
                        <tr>
                            <th>Tên sản phẩm</th>
                            <th class="text-center">Số lượng</th>
                            <th class="text-end">Doanh số</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $bestsell = $conn->query("SELECT c.ten_hanghoa, SUM(c.so_luong) as da_ban, SUM(c.so_luong*c.don_gia) as doanh_thu FROM chitiet_hoadon c GROUP BY c.id_hanghoa ORDER BY da_ban DESC LIMIT 5")->fetchAll();
                        if (empty($bestsell)): ?>
                            <tr><td colspan="3" class="text-center py-3 text-muted">Chưa có dữ liệu bán lẻ</td></tr>
                        <?php else:
                            foreach ($bestsell as $b):
                        ?>
                        <tr>
                            <td>
                                <span class="fw-semibold text-dark text-truncate d-inline-block" style="max-width: 220px;">
                                    <?php echo htmlspecialchars($b['ten_hanghoa']); ?>
                                </span>
                            </td>
                            <td class="text-center">
                                <span class="badge bg-dark rounded-pill px-2 py-1"><?php echo $b['da_ban']; ?> cái</span>
                            </td>
                            <td class="text-end fw-bold text-danger">
                                <?php echo number_format($b['doanh_thu']); ?>đ
                            </td>
                        </tr>
                        <?php endforeach; endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function() {
    // Bar Chart
    const ctx1 = document.getElementById('revenueChart');
    if (ctx1) {
        new Chart(ctx1.getContext('2d'), {
            type: 'bar',
            data: {
                labels: [<?php echo implode(',', array_map(function($t){return "'".$t['thang']."'";}, array_reverse($tkThang))); ?>],
                datasets: [{
                    label: 'Doanh thu (VNĐ)',
                    data: [<?php echo implode(',', array_map(function($t){return $t['doanh_thu'];}, array_reverse($tkThang))); ?>],
                    backgroundColor: 'rgba(225, 29, 72, 0.85)',
                    hoverBackgroundColor: '#e11d48',
                    borderRadius: 8,
                    borderSkipped: false
                }]
            },
            options: { 
                responsive: true, 
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false }
                },
                scales: { 
                    y: { 
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return value.toLocaleString('vi-VN') + 'đ';
                            }
                        },
                        grid: { color: 'rgba(0,0,0,0.05)' }
                    },
                    x: {
                        grid: { display: false }
                    }
                } 
            }
        });
    }

    // Doughnut Chart
    const ctx2 = document.getElementById('statusChart');
    if (ctx2) {
        const choXacNhan = <?php echo (int)($tk['cho_xac_nhan'] ?? 0); ?>;
        const dangGiao = <?php echo (int)($tk['dang_giao'] ?? 0); ?>;
        const hoanThanh = <?php echo (int)($tk['hoan_thanh'] ?? 0); ?>;
        const hasData = (choXacNhan + dangGiao + hoanThanh) > 0;

        new Chart(ctx2.getContext('2d'), {
            type: 'doughnut',
            data: {
                labels: ['Chờ xác nhận', 'Đang giao', 'Hoàn thành'],
                datasets: [{
                    data: hasData ? [choXacNhan, dangGiao, hoanThanh] : [1, 1, 1],
                    backgroundColor: hasData ? ['#f59e0b', '#0ea5e9', '#10b981'] : ['#e4e4e7', '#d4d4d8', '#a1a1aa'],
                    borderWidth: 2,
                    borderColor: '#ffffff'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { position: 'bottom' }
                },
                cutout: '70%'
            }
        });
    }
});
</script>

<?php
require_once dirname(__DIR__, 2) . "/Model/init.php";
$db = new Database();
$conn = $db->getConnection();

$ds = $conn->query("SELECT * FROM khachhang ORDER BY id_khachhang DESC")->fetchAll();
?>

<div class="table-container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h5 class="fw-bold mb-1" style="font-size: 1.15rem;">Danh Sách Khách Hàng Thành Viên</h5>
            <small class="text-secondary">Thông tin liên lạc và ngày đăng ký của người dùng trên website</small>
        </div>
        <span class="badge bg-dark px-3 py-2 fs-6">Tổng <?php echo count($ds); ?> thành viên</span>
    </div>

    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light text-uppercase small" style="letter-spacing: 0.5px;">
                <tr>
                    <th class="ps-3 py-3" style="width: 80px;">Mã</th>
                    <th class="py-3">Họ và tên</th>
                    <th class="py-3">Email liên hệ</th>
                    <th class="py-3">Số điện thoại</th>
                    <th class="py-3">Địa chỉ</th>
                    <th class="pe-3 py-3 text-end">Ngày đăng ký</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($ds)): ?>
                    <tr><td colspan="6" class="text-center py-4 text-muted">Chưa có khách hàng đăng ký</td></tr>
                <?php else: ?>
                    <?php foreach ($ds as $item): ?>
                    <tr class="border-bottom">
                        <td class="ps-3 fw-bold text-secondary">#KH-<?php echo $item['id_khachhang']; ?></td>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="user-avatar me-2" style="background: #27272a; width: 32px; height: 32px; font-size: 0.8rem;">
                                    <i class="fas fa-user"></i>
                                </div>
                                <strong class="text-dark"><?php echo htmlspecialchars($item['ten_khachhang']); ?></strong>
                            </div>
                        </td>
                        <td>
                            <span class="text-secondary"><i class="fas fa-envelope small me-1 text-muted"></i><?php echo htmlspecialchars($item['email']); ?></span>
                        </td>
                        <td>
                            <span class="fw-semibold text-dark"><?php echo htmlspecialchars($item['dien_thoai'] ?: '-'); ?></span>
                        </td>
                        <td>
                            <span class="text-secondary small d-inline-block text-truncate" style="max-width: 220px;" title="<?php echo htmlspecialchars($item['dia_chi'] ?? ''); ?>">
                                <?php echo htmlspecialchars($item['dia_chi'] ?: 'Chưa cập nhật'); ?>
                            </span>
                        </td>
                        <td class="pe-3 text-end text-secondary small">
                            <?php echo date('d/m/Y H:i', strtotime($item['ngay_dang_ky'])); ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

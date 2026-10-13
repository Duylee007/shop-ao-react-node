<?php
require_once dirname(__DIR__, 2) . "/Model/init.php";
require_once dirname(__DIR__, 2) . "/Model/hoadon.php";

$hd = new HoaDon();
$message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['status_id'], $_POST['status'])) {
    $hd->capNhatTrangThai((int)$_POST['status_id'], $_POST['status']);
    $message = '<div class="alert alert-success border-0 shadow-sm rounded-3"><i class="fas fa-check-circle me-2"></i> Cập nhật trạng thái đơn hàng thành công!</div>';
}

$ds = $hd->getAll();
?>

<div class="table-container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h5 class="fw-bold mb-1" style="font-size: 1.15rem;">Quản Lý Đơn Hàng & Vận Chuyển</h5>
            <small class="text-secondary">Theo dõi tiến độ giao hàng, doanh thu và chi tiết đơn mua của khách</small>
        </div>
        <span class="badge bg-dark px-3 py-2 fs-6">Tổng <?php echo count($ds); ?> đơn</span>
    </div>

    <?php echo $message; ?>

    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light text-uppercase small" style="letter-spacing: 0.5px;">
                <tr>
                    <th class="ps-3 py-3">Mã đơn</th>
                    <th class="py-3">Khách hàng</th>
                    <th class="py-3">Ngày đặt</th>
                    <th class="py-3">Tổng thanh toán</th>
                    <th class="py-3">Địa chỉ nhận hàng</th>
                    <th class="py-3">Cập nhật trạng thái</th>
                    <th class="pe-3 py-3 text-end">Chi tiết</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($ds)): ?>
                    <tr><td colspan="7" class="text-center py-4 text-muted">Chưa có đơn hàng nào trong hệ thống</td></tr>
                <?php else: ?>
                    <?php foreach ($ds as $item): ?>
                    <tr class="border-bottom">
                        <td class="ps-3 fw-bold text-dark">#DH-<?php echo $item['id_hoadon']; ?></td>
                        <td>
                            <div class="fw-bold text-dark"><?php echo htmlspecialchars($item['ten_khachhang'] ?? 'Khách lẻ'); ?></div>
                            <small class="text-secondary"><i class="fas fa-phone small me-1"></i><?php echo $item['sdt_giao'] ?? '-'; ?></small>
                        </td>
                        <td>
                            <small class="text-secondary"><?php echo date('d/m/Y H:i', strtotime($item['ngay_dat_hang'])); ?></small>
                        </td>
                        <td>
                            <span class="fw-bold text-danger"><?php echo number_format($item['tong_tien']); ?>đ</span>
                        </td>
                        <td>
                            <span class="small text-secondary d-inline-block text-truncate" style="max-width: 200px;" title="<?php echo htmlspecialchars($item['dia_chi_giao']); ?>">
                                <?php echo htmlspecialchars($item['dia_chi_giao']); ?>
                            </span>
                        </td>
                        <td>
                            <form method="POST" class="d-flex m-0">
                                <input type="hidden" name="status_id" value="<?php echo $item['id_hoadon']; ?>">
                                <select name="status" class="form-select form-select-sm fw-bold border" onchange="this.form.submit()" style="width: 145px; font-size: 0.82rem;">
                                    <option value="Chờ xác nhận" <?php echo $item['trang_thai']=='Chờ xác nhận'?'selected':''; ?>>Chờ xác nhận</option>
                                    <option value="Đang giao" <?php echo $item['trang_thai']=='Đang giao'?'selected':''; ?>>Đang giao</option>
                                    <option value="Hoàn thành" <?php echo $item['trang_thai']=='Hoàn thành'?'selected':''; ?>>Hoàn thành</option>
                                    <option value="Đã hủy" <?php echo $item['trang_thai']=='Đã hủy'?'selected':''; ?>>Đã hủy</option>
                                </select>
                            </form>
                        </td>
                        <td class="pe-3 text-end">
                            <button class="btn btn-sm btn-outline-dark" data-bs-toggle="modal" data-bs-target="#modal<?php echo $item['id_hoadon']; ?>" title="Xem chi tiết">
                                <i class="fas fa-eye me-1"></i> Xem
                            </button>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Modals rendered OUTSIDE the table to ensure valid HTML and flawless UI -->
<?php foreach ($ds as $item): ?>
<div class="modal fade" id="modal<?php echo $item['id_hoadon']; ?>" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content rounded-4 border-0 shadow-lg">
            <div class="modal-header bg-dark text-white p-3 px-4">
                <h5 class="modal-title fw-bold" style="font-size: 1.05rem;">
                    <i class="fas fa-receipt text-danger me-2"></i> Chi Tiết Đơn Hàng #DH-<?php echo $item['id_hoadon']; ?>
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <div class="row g-3 mb-4 p-3 bg-light rounded-3">
                    <div class="col-md-6">
                        <p class="mb-1 small"><strong>Người nhận:</strong> <?php echo htmlspecialchars($item['ten_khachhang'] ?? 'Khách lẻ'); ?></p>
                        <p class="mb-1 small"><strong>Điện thoại:</strong> <?php echo $item['sdt_giao'] ?? '-'; ?></p>
                        <p class="mb-0 small"><strong>Thời gian:</strong> <?php echo date('d/m/Y H:i:s', strtotime($item['ngay_dat_hang'])); ?></p>
                    </div>
                    <div class="col-md-6">
                        <p class="mb-1 small"><strong>Địa chỉ giao:</strong> <?php echo htmlspecialchars($item['dia_chi_giao']); ?></p>
                        <p class="mb-1 small"><strong>Ghi chú:</strong> <?php echo htmlspecialchars($item['ghi_chu'] ?: 'Không có'); ?></p>
                        <p class="mb-0 small"><strong>Trạng thái:</strong> <span class="badge bg-secondary"><?php echo $item['trang_thai']; ?></span></p>
                    </div>
                </div>

                <h6 class="fw-bold text-uppercase small mb-3">Danh sách áo đã đặt:</h6>
                <?php $chitiet = $hd->getChiTiet($item['id_hoadon']); ?>
                <div class="table-responsive">
                    <table class="table align-middle">
                        <thead class="table-light small text-uppercase">
                            <tr>
                                <th>Tên sản phẩm</th>
                                <th class="text-center">Size</th>
                                <th class="text-center">Số lượng</th>
                                <th class="text-end">Đơn giá</th>
                                <th class="text-end">Thành tiền</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($chitiet as $ct): ?>
                            <tr>
                                <td class="fw-bold"><?php echo htmlspecialchars($ct['ten_hanghoa']); ?></td>
                                <td class="text-center"><span class="badge bg-dark rounded-pill px-2"><?php echo $ct['size']; ?></span></td>
                                <td class="text-center"><?php echo $ct['so_luong']; ?></td>
                                <td class="text-end"><?php echo number_format($ct['don_gia']); ?>đ</td>
                                <td class="text-end fw-bold text-danger"><?php echo number_format($ct['so_luong'] * $ct['don_gia']); ?>đ</td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <div class="d-flex justify-content-between align-items-center pt-3 border-top mt-3">
                    <span class="fw-bold text-uppercase">Tổng thanh toán đơn:</span>
                    <span class="fw-bold text-danger fs-4"><?php echo number_format($item['tong_tien']); ?>đ</span>
                </div>
            </div>
            <div class="modal-footer p-3">
                <button type="button" class="btn btn-secondary btn-sm px-4" data-bs-dismiss="modal">Đóng</button>
            </div>
        </div>
    </div>
</div>
<?php endforeach; ?>

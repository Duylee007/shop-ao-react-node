<?php require_once dirname(__DIR__) . "/View/headder.php"; ?>

<section class="py-5 bg-light min-vh-100">
    <div class="container">
        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb" style="font-size: 0.85rem;">
                <li class="breadcrumb-item"><a href="index.php" class="text-secondary text-decoration-none">Trang chủ</a></li>
                <li class="breadcrumb-item active fw-bold text-dark" aria-current="page">Lịch sử đơn hàng</li>
            </ol>
        </nav>

        <h2 class="fw-bold text-uppercase mb-4" style="letter-spacing: 1px;">LỊCH SỬ ĐƠN MUA</h2>

        <?php if (empty($donhang)): ?>
        <div class="text-center py-5 bg-white rounded-4 border p-5">
            <i class="fas fa-box-open fa-4x text-muted mb-3"></i>
            <h4 class="fw-bold">Bạn chưa có đơn hàng nào</h4>
            <p class="text-secondary small mb-4">Các đơn hàng bạn đã mua sẽ được lưu và hiển thị chi tiết tại đây.</p>
            <a href="index.php?act=sanpham" class="btn-yame-red">
                <i class="fas fa-shopping-bag me-2"></i> MUA SẮM NGAY
            </a>
        </div>
        <?php else: ?>
        <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table align-middle mb-0">
                        <thead class="bg-light">
                            <tr style="font-size: 0.82rem; letter-spacing: 0.5px; text-transform: uppercase;">
                                <th class="ps-4 py-3">Mã đơn hàng</th>
                                <th class="py-3">Thời gian đặt</th>
                                <th class="py-3">Tổng thanh toán</th>
                                <th class="py-3">Trạng thái</th>
                                <th class="pe-4 py-3 text-end">Chi tiết</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($donhang as $dh): ?>
                            <tr class="border-bottom">
                                <td class="ps-4 py-3">
                                    <span class="fw-bold text-dark">#DH-<?php echo $dh['id_hoadon']; ?></span>
                                </td>
                                <td>
                                    <small class="text-secondary"><?php echo date('d/m/Y H:i', strtotime($dh['ngay_dat_hang'])); ?></small>
                                </td>
                                <td class="fw-bold text-danger">
                                    <?php echo number_format($dh['tong_tien']); ?>đ
                                </td>
                                <td>
                                    <?php 
                                    $badgeClass = [
                                        'Chờ xác nhận' => 'bg-warning text-dark',
                                        'Đang giao' => 'bg-info text-dark',
                                        'Hoàn thành' => 'bg-success text-white',
                                        'Đã hủy' => 'bg-danger text-white'
                                    ][$dh['trang_thai']] ?? 'bg-secondary text-white';
                                    ?>
                                    <span class="badge rounded-pill px-3 py-1 fw-bold <?php echo $badgeClass; ?>">
                                        <?php echo $dh['trang_thai']; ?>
                                    </span>
                                </td>
                                <td class="pe-4 text-end">
                                    <a href="index.php?act=chitietdon&id=<?php echo $dh['id_hoadon']; ?>" class="btn-yame-outline" style="font-size: 0.78rem; padding: 0.45rem 1.2rem;">
                                        <i class="fas fa-eye me-1"></i> Xem Đơn
                                    </a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <?php endif; ?>
    </div>
</section>

<?php require_once dirname(__DIR__) . "/View/footer.php"; ?>
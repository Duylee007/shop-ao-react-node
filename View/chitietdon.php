<?php require_once dirname(__DIR__) . "/View/headder.php"; ?>

<section class="py-5 bg-light min-vh-100">
    <div class="container">
        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb" style="font-size: 0.85rem;">
                <li class="breadcrumb-item"><a href="index.php" class="text-secondary text-decoration-none">Trang chủ</a></li>
                <li class="breadcrumb-item"><a href="index.php?act=lichsu" class="text-secondary text-decoration-none">Lịch sử đơn hàng</a></li>
                <li class="breadcrumb-item active fw-bold text-dark" aria-current="page">Chi tiết đơn #DH-<?php echo $don['id_hoadon']; ?></li>
            </ol>
        </nav>

        <h2 class="fw-bold text-uppercase mb-4" style="letter-spacing: 1px;">CHI TIẾT ĐƠN HÀNG #DH-<?php echo $don['id_hoadon']; ?></h2>

        <div class="row g-4">
            <div class="col-lg-8">
                <div class="cart-table-card mb-4">
                    <div class="p-3 bg-white border-bottom">
                        <h5 class="fw-bold mb-0 text-uppercase" style="font-size: 0.95rem; letter-spacing: 0.5px;">Danh Sách Sản Phẩm</h5>
                    </div>
                    <div class="table-responsive">
                        <table class="table align-middle mb-0">
                            <thead class="bg-light">
                                <tr style="font-size: 0.82rem; letter-spacing: 0.5px; text-transform: uppercase;">
                                    <th class="ps-4 py-3">Sản phẩm</th>
                                    <th class="py-3">Kích cỡ</th>
                                    <th class="py-3 text-center">SL</th>
                                    <th class="py-3">Đơn giá</th>
                                    <th class="pe-4 py-3 text-end">Thành tiền</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($chitiet as $ct): ?>
                                <tr class="border-bottom">
                                    <td class="ps-4 py-3">
                                        <h6 class="fw-bold mb-0 text-dark small"><?php echo htmlspecialchars($ct['ten_hanghoa']); ?></h6>
                                    </td>
                                    <td>
                                        <span class="badge bg-dark rounded-pill px-3 py-1 fw-bold">
                                            Size <?php echo $ct['size']; ?>
                                        </span>
                                    </td>
                                    <td class="text-center fw-bold"><?php echo $ct['so_luong']; ?></td>
                                    <td><?php echo number_format($ct['don_gia']); ?>đ</td>
                                    <td class="pe-4 text-end fw-bold text-danger"><?php echo number_format($ct['so_luong'] * $ct['don_gia']); ?>đ</td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="cart-summary-card mb-4">
                    <h5 class="fw-bold text-uppercase mb-3" style="font-size: 0.95rem; letter-spacing: 0.5px;">Thông Tin Đơn Hàng</h5>
                    
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span class="small text-secondary">Trạng thái đơn:</span>
                        <?php 
                        $badgeClass = [
                            'Chờ xác nhận' => 'bg-warning text-dark',
                            'Đang giao' => 'bg-info text-dark',
                            'Hoàn thành' => 'bg-success text-white',
                            'Đã hủy' => 'bg-danger text-white'
                        ][$don['trang_thai']] ?? 'bg-secondary text-white';
                        ?>
                        <span class="badge rounded-pill px-3 py-1 fw-bold <?php echo $badgeClass; ?>">
                            <?php echo $don['trang_thai']; ?>
                        </span>
                    </div>
                    
                    <p class="mb-2 small text-secondary"><strong>Thời gian:</strong> <?php echo date('d/m/Y H:i', strtotime($don['ngay_dat_hang'])); ?></p>
                    <p class="mb-2 small text-secondary"><strong>Người nhận:</strong> <?php echo htmlspecialchars($don['ten_khachhang']); ?></p>
                    <p class="mb-2 small text-secondary"><strong>Số điện thoại:</strong> <?php echo $don['sdt_giao']; ?></p>
                    <p class="mb-2 small text-secondary"><strong>Địa chỉ nhận:</strong> <?php echo htmlspecialchars($don['dia_chi_giao']); ?></p>
                    <?php if ($don['ghi_chu']): ?>
                    <p class="mb-2 small text-secondary"><strong>Ghi chú:</strong> <?php echo htmlspecialchars($don['ghi_chu']); ?></p>
                    <?php endif; ?>

                    <hr class="my-3">

                    <div class="d-flex justify-content-between align-items-baseline mb-4">
                        <span class="fw-bold text-uppercase">Tổng thanh toán:</span>
                        <span class="fw-bold text-danger fs-4"><?php echo number_format($don['tong_tien']); ?>đ</span>
                    </div>

                    <a href="index.php?act=lichsu" class="btn-yame-outline w-100">
                        <i class="fas fa-arrow-left me-2"></i> Quay lại danh sách
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<?php require_once dirname(__DIR__) . "/View/footer.php"; ?>
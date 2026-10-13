<?php require_once dirname(__DIR__) . "/View/headder.php"; ?>

<section class="py-5 bg-light min-vh-100">
    <div class="container">
        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb" style="font-size: 0.85rem;">
                <li class="breadcrumb-item"><a href="index.php" class="text-secondary text-decoration-none">Trang chủ</a></li>
                <li class="breadcrumb-item"><a href="index.php?act=giohang" class="text-secondary text-decoration-none">Giỏ hàng</a></li>
                <li class="breadcrumb-item active fw-bold text-dark" aria-current="page">Thanh toán đơn hàng</li>
            </ol>
        </nav>

        <h2 class="fw-bold text-uppercase mb-4" style="letter-spacing: 1px;">THANH TOÁN & ĐẶT HÀNG</h2>

        <?php if (!empty($success)): ?>
        <div class="bg-white rounded-4 border p-5 text-center shadow-sm max-w-600 mx-auto">
            <div class="mb-3 text-success">
                <i class="fas fa-check-circle fa-4x"></i>
            </div>
            <h3 class="fw-bold text-dark mb-2"><?php echo $success; ?></h3>
            <p class="text-secondary mb-4">Cảm ơn bạn đã tin chọn <strong>YaMe Duy Studio</strong>. Nhân viên chăm sóc khách hàng sẽ liên hệ xác nhận và giao hàng sớm nhất!</p>
            <div class="d-flex justify-content-center gap-3">
                <a href="index.php?act=lichsu" class="btn-yame-dark">
                    <i class="fas fa-receipt me-2"></i> Xem Đơn Mua
                </a>
                <a href="index.php" class="btn-yame-outline">
                    Tiếp Tục Mua Hàng
                </a>
            </div>
        </div>
        <?php else: ?>
        <div class="row g-4">
            <div class="col-lg-7">
                <div class="card border-0 shadow-sm rounded-3 p-4 bg-white mb-4">
                    <h5 class="fw-bold text-uppercase mb-3" style="font-size: 1rem; letter-spacing: 0.5px;">
                        <i class="fas fa-map-marker-alt text-danger me-2"></i> Thông Tin Giao Hàng
                    </h5>

                    <?php if (!empty($error)): ?>
                    <div class="alert alert-danger rounded-3"><?php echo $error; ?></div>
                    <?php endif; ?>

                    <form action="index.php?act=dathang" method="POST">
                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label class="form-label small fw-bold text-uppercase">Họ và tên người nhận</label>
                                <input type="text" class="form-control bg-light" value="<?php echo htmlspecialchars($_SESSION['user']['ten_khachhang']); ?>" readonly>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-bold text-uppercase">Email</label>
                                <input type="email" class="form-control bg-light" value="<?php echo htmlspecialchars($_SESSION['user']['email']); ?>" readonly>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-bold text-uppercase">Số điện thoại nhận hàng <span class="text-danger">*</span></label>
                            <input type="tel" name="sdt" class="form-control" placeholder="Nhập số điện thoại chính xác" value="<?php echo htmlspecialchars($_SESSION['user']['dien_thoai'] ?? ''); ?>" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-bold text-uppercase">Địa chỉ nhận hàng chi tiết <span class="text-danger">*</span></label>
                            <textarea name="dia_chi" class="form-control" rows="3" placeholder="Số nhà, tên đường, phường/xã, quận/huyện, tỉnh/thành phố" required><?php echo htmlspecialchars($_SESSION['user']['dia_chi'] ?? ''); ?></textarea>
                        </div>
                        <div class="mb-4">
                            <label class="form-label small fw-bold text-uppercase">Ghi chú cho shipper (Tùy chọn)</label>
                            <textarea name="ghi_chu" class="form-control" rows="2" placeholder="Ví dụ: Giao giờ hành chính, gọi trước khi đến..."></textarea>
                        </div>

                        <h6 class="fw-bold text-uppercase small mb-3">Phương thức thanh toán</h6>
                        <div class="p-3 border rounded-3 bg-light mb-4">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="payment_method" id="cod" checked>
                                <label class="form-check-label fw-bold text-dark" for="cod">
                                    <i class="fas fa-money-bill-wave text-success me-2"></i> Thanh toán khi nhận hàng (COD)
                                </label>
                                <div class="small text-secondary mt-1">Khách hàng được kiểm tra hàng trước khi thanh toán cho shipper.</div>
                            </div>
                        </div>

                        <button type="submit" class="btn-yame-red w-100 py-3 fs-6">
                            <i class="fas fa-check-circle me-2"></i> XÁC NHẬN ĐẶT HÀNG
                        </button>
                    </form>
                </div>
            </div>

            <div class="col-lg-5">
                <div class="cart-summary-card">
                    <h5 class="fw-bold text-uppercase mb-3" style="font-size: 1rem; letter-spacing: 0.5px;">Đơn Hàng Của Bạn</h5>
                    
                    <div class="mb-3 max-vh-50 overflow-auto">
                        <?php foreach ($giohang as $item): ?>
                        <div class="d-flex justify-content-between align-items-center py-2 border-bottom">
                            <div>
                                <h6 class="fw-bold mb-0 text-dark small"><?php echo htmlspecialchars($item['ten']); ?></h6>
                                <small class="text-secondary">Size: <strong><?php echo $item['size']; ?></strong> | SL: <?php echo $item['so_luong']; ?></small>
                            </div>
                            <span class="fw-bold text-dark small"><?php echo number_format($item['gia'] * $item['so_luong']); ?>đ</span>
                        </div>
                        <?php endforeach; ?>
                    </div>

                    <div class="d-flex justify-content-between mb-2 small text-secondary">
                        <span>Tạm tính tiền hàng:</span>
                        <span class="fw-bold text-dark"><?php echo number_format($tongTien); ?>đ</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2 small text-secondary">
                        <span>Phí vận chuyển:</span>
                        <span><?php echo $tongTien >= 399000 ? '<strong class="text-success">MIỄN PHÍ</strong>' : '30.000đ'; ?></span>
                    </div>
                    <hr class="my-3">
                    <div class="d-flex justify-content-between align-items-baseline mb-3">
                        <span class="fw-bold text-uppercase">Tổng thanh toán:</span>
                        <span class="fw-bold text-danger fs-3">
                            <?php echo number_format($tongTien >= 399000 ? $tongTien : $tongTien + 30000); ?>đ
                        </span>
                    </div>

                    <div class="p-3 bg-light rounded-3 text-secondary small">
                        <i class="fas fa-info-circle text-danger me-1"></i> Cam kết 100% đổi hàng trong 15 ngày nếu sản phẩm có bất kỳ lỗi nào từ nhà sản xuất.
                    </div>
                </div>
            </div>
        </div>
        <?php endif; ?>
    </div>
</section>

<?php require_once dirname(__DIR__) . "/View/footer.php"; ?>
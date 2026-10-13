<?php require_once dirname(__DIR__) . "/View/headder.php"; ?>

<section class="py-5 bg-light min-vh-100">
    <div class="container">
        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb" style="font-size: 0.85rem;">
                <li class="breadcrumb-item"><a href="index.php" class="text-secondary text-decoration-none">Trang chủ</a></li>
                <li class="breadcrumb-item active fw-bold text-dark" aria-current="page">Giỏ hàng của bạn</li>
            </ol>
        </nav>

        <h2 class="fw-bold text-uppercase mb-4" style="letter-spacing: 1px;">
            GIỎ HÀNG <span class="fs-6 text-secondary fw-normal">(<?php echo count($giohang ?? []); ?> sản phẩm)</span>
        </h2>

        <?php if (empty($giohang)): ?>
        <div class="text-center py-5 bg-white rounded-3 border">
            <i class="fas fa-shopping-bag fa-4x text-muted mb-4"></i>
            <h4 class="fw-bold">Giỏ hàng của bạn đang trống</h4>
            <p class="text-secondary small mb-4">Hãy lướt xem các mẫu áo thun mới nhất của YaMe và chọn sản phẩm yêu thích.</p>
            <a href="index.php?act=sanpham" class="btn-yame-red">
                <i class="fas fa-shopping-bag me-2"></i> MUA SẮM NGAY
            </a>
        </div>
        <?php else: ?>
        <div class="row g-4">
            <!-- Cart Items -->
            <div class="col-lg-8">
                <div class="cart-table-card">
                    <form action="index.php?act=capnhat" method="POST">
                        <div class="table-responsive">
                            <table class="table align-middle mb-0">
                                <thead class="bg-light">
                                    <tr style="font-size: 0.82rem; letter-spacing: 0.5px; text-transform: uppercase;">
                                        <th class="ps-4 py-3">Sản phẩm</th>
                                        <th class="py-3">Kích cỡ</th>
                                        <th class="py-3">Đơn giá</th>
                                        <th class="py-3 text-center">Số lượng</th>
                                        <th class="py-3">Thành tiền</th>
                                        <th class="pe-4 py-3"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($giohang as $key => $item): ?>
                                    <tr class="border-bottom">
                                        <td class="ps-4 py-3">
                                            <div class="d-flex align-items-center">
                                                <img src="<?php echo $item['hinh'] ? $item['hinh'] : 'Content/imageaothun/ao-nam-basic-trang.jpg'; ?>" 
                                                     class="cart-item-img me-3">
                                                <div>
                                                    <h6 class="fw-bold mb-1" style="font-size: 0.92rem;">
                                                        <?php echo htmlspecialchars($item['ten']); ?>
                                                    </h6>
                                                    <small class="text-secondary">Mã: SP-<?php echo $key; ?></small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge bg-dark rounded-pill px-3 py-1 fw-bold">
                                                Size <?php echo $item['size']; ?>
                                            </span>
                                        </td>
                                        <td>
                                            <span class="fw-semibold"><?php echo number_format($item['gia']); ?>đ</span>
                                        </td>
                                        <td style="width: 140px;" class="text-center">
                                            <div class="quantity-stepper">
                                                <button type="button" class="quantity-btn minus"><i class="fas fa-minus small"></i></button>
                                                <input type="number" name="so_luong[<?php echo $key; ?>]" class="quantity-input" 
                                                       value="<?php echo $item['so_luong']; ?>" min="1">
                                                <button type="button" class="quantity-btn plus"><i class="fas fa-plus small"></i></button>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="fw-bold text-danger">
                                                <?php echo number_format($item['gia'] * $item['so_luong']); ?>đ
                                            </span>
                                        </td>
                                        <td class="pe-4 text-end">
                                            <a href="index.php?act=xoa&key=<?php echo $key; ?>" class="text-secondary hover-danger" title="Xóa khỏi giỏ" onclick="return confirm('Bạn có chắc muốn xóa sản phẩm này?')">
                                                <i class="far fa-trash-alt fs-5"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="p-3 bg-white d-flex justify-content-between align-items-center">
                            <a href="index.php?act=sanpham" class="btn-yame-outline" style="font-size: 0.8rem; padding: 0.6rem 1.4rem;">
                                <i class="fas fa-arrow-left me-2"></i> Tiếp tục mua hàng
                            </a>
                            <button type="submit" class="btn-yame-dark" style="font-size: 0.8rem; padding: 0.6rem 1.4rem;">
                                <i class="fas fa-sync me-2"></i> Cập nhật giỏ hàng
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Order Summary Sticky -->
            <div class="col-lg-4">
                <div class="cart-summary-card">
                    <h5 class="fw-bold text-uppercase mb-3" style="letter-spacing: 0.5px;">Tóm Tắt Đơn Hàng</h5>
                    
                    <!-- Free shipping indicator -->
                    <?php 
                        $freeshipThreshold = 399000;
                        $isFreeship = ($tongTien >= $freeshipThreshold);
                        $remaining = $freeshipThreshold - $tongTien;
                    ?>
                    <div class="p-3 rounded-3 mb-3 <?php echo $isFreeship ? 'bg-success-subtle border border-success-subtle text-success' : 'bg-warning-subtle border border-warning-subtle text-dark'; ?>" style="font-size: 0.84rem;">
                        <?php if ($isFreeship): ?>
                            <i class="fas fa-check-circle me-1"></i> <strong>Tuyệt vời!</strong> Đơn hàng của bạn được <strong>Miễn phí vận chuyển</strong> toàn quốc!
                        <?php else: ?>
                            <i class="fas fa-truck text-warning me-1"></i> Mua thêm <strong><?php echo number_format($remaining); ?>đ</strong> nữa để được <strong>FREESHIP</strong>!
                        <?php endif; ?>
                    </div>

                    <div class="d-flex justify-content-between mb-2 small text-secondary">
                        <span>Tạm tính tiền hàng:</span>
                        <span class="fw-bold text-dark"><?php echo number_format($tongTien); ?>đ</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2 small text-secondary">
                        <span>Phí vận chuyển:</span>
                        <span><?php echo $isFreeship ? '<strong class="text-success">MIỄN PHÍ</strong>' : '30.000đ'; ?></span>
                    </div>

                    <hr class="my-3">

                    <div class="d-flex justify-content-between align-items-baseline mb-4">
                        <span class="fw-bold text-uppercase">Tổng thanh toán:</span>
                        <span class="fw-bold text-danger fs-3">
                            <?php echo number_format($isFreeship ? $tongTien : $tongTien + 30000); ?>đ
                        </span>
                    </div>

                    <a href="index.php?act=dathang" class="btn-yame-red w-100 py-3 mb-3">
                        TIẾN HÀNH ĐẶT HÀNG <i class="fas fa-arrow-right ms-2"></i>
                    </a>

                    <div class="text-center text-secondary small">
                        <p class="mb-1"><i class="fas fa-shield-alt text-dark me-1"></i> Bảo mật thanh toán SSL 100%</p>
                        <p class="mb-0"><i class="fas fa-undo text-dark me-1"></i> Đổi trả hàng tận nhà trong 15 ngày</p>
                    </div>
                </div>
            </div>
        </div>
        <?php endif; ?>
    </div>
</section>

<?php require_once dirname(__DIR__) . "/View/footer.php"; ?>
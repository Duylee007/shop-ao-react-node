<?php require_once dirname(__DIR__) . "/View/headder.php"; ?>

<section class="py-5 bg-white">
    <div class="container">
        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb" style="font-size: 0.85rem;">
                <li class="breadcrumb-item"><a href="index.php" class="text-secondary text-decoration-none">Trang chủ</a></li>
                <li class="breadcrumb-item"><a href="index.php?act=sanpham" class="text-secondary text-decoration-none">Sản phẩm</a></li>
                <li class="breadcrumb-item active fw-bold text-dark" aria-current="page"><?php echo htmlspecialchars($sp['ten_hanghoa']); ?></li>
            </ol>
        </nav>

        <div class="row g-5">
            <!-- Product Gallery Column -->
            <div class="col-lg-6">
                <div class="product-gallery-main position-relative">
                    <img src="<?php echo $sp['hinh_anh'] ? $sp['hinh_anh'] : 'Content/imageaothun/ao-nam-basic-trang.jpg'; ?>" 
                         alt="<?php echo htmlspecialchars($sp['ten_hanghoa']); ?>" class="img-fluid" id="mainProductImg">
                    
                    <?php if ($sp['gia_khuyen_mai'] > 0): ?>
                        <span class="badge-discount-yame fs-6 p-2 px-3">
                            GIẢM <?php echo round((1 - $sp['gia_khuyen_mai']/$sp['gia'])*100); ?>%
                        </span>
                    <?php endif; ?>
                </div>

                <!-- Product thumbnails / extra info -->
                <div class="row g-2 mt-2">
                    <div class="col-3">
                        <img src="<?php echo $sp['hinh_anh'] ? $sp['hinh_anh'] : 'Content/imageaothun/ao-nam-basic-trang.jpg'; ?>" class="img-fluid rounded border border-dark p-1" style="height: 80px; object-fit: cover; width: 100%; cursor: pointer;">
                    </div>
                </div>
            </div>

            <!-- Product Info Column -->
            <div class="col-lg-6">
                <div class="detail-brand-badge">
                    <i class="fas fa-certificate text-danger me-1"></i> YaMe Signature • <?php echo $sp['ten_loai'] ?? 'Áo Thun Cao Cấp'; ?>
                </div>

                <h1 class="detail-product-title"><?php echo htmlspecialchars($sp['ten_hanghoa']); ?></h1>

                <div class="d-flex align-items-center gap-3 mb-3">
                    <div class="text-warning small">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                    </div>
                    <span class="text-secondary small fw-semibold">4.9 / 5.0 (256 đánh giá từ khách hàng)</span>
                </div>

                <!-- Price Box -->
                <div class="detail-price-box">
                    <?php if ($sp['gia_khuyen_mai'] > 0): ?>
                        <span class="detail-price-sale"><?php echo number_format($sp['gia_khuyen_mai']); ?>đ</span>
                        <span class="detail-price-original"><?php echo number_format($sp['gia']); ?>đ</span>
                        <span class="badge bg-danger rounded-pill px-2 py-1 small">Tiết kiệm <?php echo number_format($sp['gia'] - $sp['gia_khuyen_mai']); ?>đ</span>
                    <?php else: ?>
                        <span class="detail-price-sale" style="color: var(--yame-black);"><?php echo number_format($sp['gia']); ?>đ</span>
                    <?php endif; ?>
                </div>

                <!-- Status & Color -->
                <div class="mb-3 d-flex align-items-center gap-2">
                    <span class="text-secondary small fw-bold text-uppercase">Tình trạng:</span>
                    <?php if ($sp['so_luong'] > 0): ?>
                        <span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill px-3 py-1 fw-bold">
                            <i class="fas fa-check-circle me-1"></i> Còn hàng (<?php echo $sp['so_luong']; ?> sản phẩm)
                        </span>
                    <?php else: ?>
                        <span class="badge bg-danger-subtle text-danger border border-danger-subtle rounded-pill px-3 py-1 fw-bold">
                            <i class="fas fa-times-circle me-1"></i> Tạm hết hàng
                        </span>
                    <?php endif; ?>
                </div>

                <!-- Form Add to Cart -->
                <form action="index.php?act=them" method="POST" class="mb-4">
                    <input type="hidden" name="id" value="<?php echo $sp['id_hanghoa']; ?>">

                    <!-- Size Selector -->
                    <div class="mb-4">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <label class="text-uppercase small fw-bold text-dark mb-0">Chọn Kích Cỡ (Size):</label>
                            <a href="#" class="small text-secondary text-decoration-underline" onclick="event.preventDefault(); alert('Hướng dẫn chọn size: \nSize S: < 55kg (1m50 - 1m60)\nSize M: 55-65kg (1m60 - 1m70)\nSize L: 65-75kg (1m70 - 1m78)\nSize XL: 75-85kg (1m75 - 1m85)\nSize XXL: > 85kg');">
                                <i class="fas fa-ruler-horizontal me-1"></i> Hướng dẫn chọn size
                            </a>
                        </div>
                        <div class="size-selector-group">
                            <input type="radio" class="size-pill-radio" name="size" id="sizeS" value="S">
                            <label class="size-pill-label" for="sizeS">S</label>

                            <input type="radio" class="size-pill-radio" name="size" id="sizeM" value="M" checked>
                            <label class="size-pill-label" for="sizeM">M</label>

                            <input type="radio" class="size-pill-radio" name="size" id="sizeL" value="L">
                            <label class="size-pill-label" for="sizeL">L</label>

                            <input type="radio" class="size-pill-radio" name="size" id="sizeXL" value="XL">
                            <label class="size-pill-label" for="sizeXL">XL</label>

                            <input type="radio" class="size-pill-radio" name="size" id="sizeXXL" value="XXL">
                            <label class="size-pill-label" for="sizeXXL">XXL</label>
                        </div>
                    </div>

                    <!-- Quantity Stepper -->
                    <div class="mb-4">
                        <label class="text-uppercase small fw-bold text-dark d-block mb-2">Số lượng:</label>
                        <div class="quantity-stepper">
                            <button type="button" class="quantity-btn minus"><i class="fas fa-minus small"></i></button>
                            <input type="number" name="so_luong" class="quantity-input" value="1" min="1" max="<?php echo max(1, (int)$sp['so_luong']); ?>">
                            <button type="button" class="quantity-btn plus"><i class="fas fa-plus small"></i></button>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="d-flex flex-wrap gap-3">
                        <button type="submit" class="btn-yame-dark flex-grow-1 py-3" <?php echo $sp['so_luong'] <= 0 ? 'disabled' : ''; ?>>
                            <i class="fas fa-shopping-bag me-2"></i> THÊM VÀO GIỎ HÀNG
                        </button>
                        <a href="index.php?act=giohang" class="btn-yame-red py-3 px-4">
                            XEM GIỎ HÀNG
                        </a>
                    </div>
                </form>

                <!-- Trust Guarantees Box -->
                <div class="detail-trust-box">
                    <div class="trust-item">
                        <i class="fas fa-award text-danger"></i>
                        <span>Chất liệu 100% Cotton Compact siêu mềm mịn, thoáng mát, bền màu</span>
                    </div>
                    <div class="trust-item">
                        <i class="fas fa-truck-fast text-danger"></i>
                        <span>Miễn phí vận chuyển toàn quốc cho mọi đơn hàng từ 399.000đ</span>
                    </div>
                    <div class="trust-item">
                        <i class="fas fa-sync-alt text-danger"></i>
                        <span>Chính sách đổi hàng trong vòng 15 ngày tận nhà nhanh chóng</span>
                    </div>
                    <div class="trust-item">
                        <i class="fas fa-shield-alt text-danger"></i>
                        <span>Bảo hành form dáng, cổ áo và đường may suốt 365 ngày</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Detailed Description -->
        <div class="mt-5 pt-4 border-top">
            <h4 class="fw-bold text-uppercase mb-3" style="letter-spacing: 1px;">Mô Tả & Thông Tin Chi Tiết</h4>
            <div class="bg-light p-4 rounded-3 text-secondary" style="line-height: 1.8;">
                <p class="mb-2"><strong>Tên sản phẩm:</strong> <?php echo htmlspecialchars($sp['ten_hanghoa']); ?></p>
                <p class="mb-2"><strong>Dòng sản phẩm:</strong> YaMe Everyday Wear - Phù hợp đi làm, đi chơi, du lịch, thể thao.</p>
                <p class="mb-2"><strong>Chất liệu:</strong> Vải thun Cotton Compact cao cấp dệt 4 chiều, thấm hút mồ hôi tối đa, không co rút khi giặt máy.</p>
                <p class="mb-0"><strong>Mô tả chi tiết:</strong><br><?php echo nl2br(htmlspecialchars($sp['mo_ta'])); ?></p>
            </div>
        </div>

        <!-- Related Products Section -->
        <?php if (!empty($spLienQuan)): ?>
        <div class="mt-5 pt-4">
            <div class="yame-section-header text-start mb-4">
                <span class="yame-section-subtitle">GỢI Ý PHỐI ĐỒ</span>
                <h3 class="yame-section-title" style="font-size: 1.6rem;">CÓ THỂ BẠN CŨNG THÍCH</h3>
                <div class="yame-title-line ms-0"></div>
            </div>

            <div class="row g-4">
                <?php 
                $count = 0;
                foreach ($spLienQuan as $lq): 
                    if ($lq['id_hanghoa'] == $sp['id_hanghoa']) continue;
                    if ($count >= 4) break;
                    $count++;
                ?>
                <div class="col-lg-3 col-6">
                    <div class="yame-product-card">
                        <div class="product-image-wrapper">
                            <img src="<?php echo $lq['hinh_anh'] ? $lq['hinh_anh'] : 'Content/imageaothun/ao-nam-basic-trang.jpg'; ?>" 
                                 alt="<?php echo htmlspecialchars($lq['ten_hanghoa']); ?>">
                            
                            <div class="product-quick-actions">
                                <a href="index.php?act=chitiet&id=<?php echo $lq['id_hanghoa']; ?>" class="btn-quick-view">
                                    <i class="fas fa-eye"></i> Xem Ngay
                                </a>
                            </div>
                        </div>
                        <div class="yame-card-body">
                            <span class="product-category-tag"><?php echo $lq['ten_loai'] ?? 'YaMe'; ?></span>
                            <h6 class="product-title">
                                <a href="index.php?act=chitiet&id=<?php echo $lq['id_hanghoa']; ?>">
                                    <?php echo htmlspecialchars($lq['ten_hanghoa']); ?>
                                </a>
                            </h6>
                            <div class="product-price-box">
                                <span class="price-current normal">
                                    <?php echo number_format($lq['gia_khuyen_mai'] > 0 ? $lq['gia_khuyen_mai'] : $lq['gia']); ?>đ
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
        <?php endif; ?>
    </div>
</section>

<?php require_once dirname(__DIR__) . "/View/footer.php"; ?>
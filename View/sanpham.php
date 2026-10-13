<?php require_once dirname(__DIR__) . "/View/headder.php"; ?>

<section class="py-5">
    <div class="container">
        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb" style="font-size: 0.85rem;">
                <li class="breadcrumb-item"><a href="index.php" class="text-secondary text-decoration-none">Trang chủ</a></li>
                <li class="breadcrumb-item active fw-bold text-dark" aria-current="page">
                    <?php 
                        if (!empty($id_loai)) {
                            if ($id_loai == 1) echo 'Áo Nam';
                            else if ($id_loai == 2) echo 'Áo Nữ';
                            else if ($id_loai == 3) echo 'Áo Unisex';
                            else echo 'Danh Mục ' . $id_loai;
                        } else if (!empty($keyword)) {
                            echo 'Tìm kiếm: "' . htmlspecialchars($keyword) . '"';
                        } else {
                            echo 'Tất Cả Sản Phẩm';
                        }
                    ?>
                </li>
            </ol>
        </nav>

        <div class="row g-4">
            <!-- Sidebar Filters -->
            <div class="col-lg-3">
                <div class="filter-card mb-4">
                    <h5 class="fw-bold mb-3 text-uppercase" style="font-size: 0.95rem; letter-spacing: 1px;">
                        <i class="fas fa-filter me-2 text-danger"></i> Bộ Lọc Sản Phẩm
                    </h5>
                    
                    <hr class="my-3 text-muted">

                    <h6 class="fw-bold text-uppercase small mb-2" style="letter-spacing: 0.5px;">Danh Mục</h6>
                    <div class="mb-3">
                        <a href="index.php?act=sanpham" class="filter-category-link <?php echo empty($id_loai) ? 'active' : ''; ?>">
                            <span>Tất Cả Sản Phẩm</span>
                            <i class="fas fa-chevron-right small opacity-50"></i>
                        </a>
                        <a href="index.php?act=sanpham&loai=1" class="filter-category-link <?php echo (isset($id_loai) && $id_loai == 1) ? 'active' : ''; ?>">
                            <span>Áo Thun Nam</span>
                            <i class="fas fa-chevron-right small opacity-50"></i>
                        </a>
                        <a href="index.php?act=sanpham&loai=2" class="filter-category-link <?php echo (isset($id_loai) && $id_loai == 2) ? 'active' : ''; ?>">
                            <span>Áo Thun Nữ</span>
                            <i class="fas fa-chevron-right small opacity-50"></i>
                        </a>
                        <a href="index.php?act=sanpham&loai=3" class="filter-category-link <?php echo (isset($id_loai) && $id_loai == 3) ? 'active' : ''; ?>">
                            <span>Áo Unisex Form Rộng</span>
                            <i class="fas fa-chevron-right small opacity-50"></i>
                        </a>
                    </div>

                    <hr class="my-3 text-muted">

                    <!-- Price Filter -->
                    <h6 class="fw-bold text-uppercase small mb-2" style="letter-spacing: 0.5px;">Khoảng Giá (VNĐ)</h6>
                    <form action="index.php" method="GET">
                        <input type="hidden" name="act" value="sanpham">
                        <?php if (!empty($id_loai)): ?>
                            <input type="hidden" name="loai" value="<?php echo $id_loai; ?>">
                        <?php endif; ?>
                        
                        <div class="row g-2 mb-3">
                            <div class="col-6">
                                <input type="number" class="form-control form-control-sm" placeholder="Từ..." name="gia_tu" value="<?php echo isset($_GET['gia_tu']) ? htmlspecialchars($_GET['gia_tu']) : ''; ?>">
                            </div>
                            <div class="col-6">
                                <input type="number" class="form-control form-control-sm" placeholder="Đến..." name="gia_den" value="<?php echo isset($_GET['gia_den']) ? htmlspecialchars($_GET['gia_den']) : ''; ?>">
                            </div>
                        </div>
                        <button type="submit" class="btn-yame-dark w-100 py-2" style="font-size: 0.78rem;">
                            Áp Dụng Lọc
                        </button>
                    </form>
                </div>

                <!-- Trust Guarantee Banner in Sidebar -->
                <div class="p-3 bg-white rounded-3 border text-center d-none d-lg-block">
                    <i class="fas fa-shield-halved fa-2x text-danger mb-2"></i>
                    <h6 class="fw-bold mb-1">Cam Kết Chính Hãng</h6>
                    <p class="text-secondary small mb-0">100% hình ảnh tự chụp thực tế, bảo hành form dáng 365 ngày.</p>
                </div>
            </div>

            <!-- Product Grid Area -->
            <div class="col-lg-9">
                <!-- Sorting & Product Count Bar -->
                <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 p-3 bg-white rounded-3 border">
                    <div class="text-secondary small">
                        Hiển thị <strong><?php echo count($sanpham); ?></strong> sản phẩm
                    </div>
                    <div class="d-flex align-items-center gap-2">
                        <label class="small text-secondary fw-semibold text-nowrap">Sắp xếp:</label>
                        <select class="form-select form-select-sm border-0 bg-light fw-bold" style="width: 180px; font-size: 0.84rem;" onchange="window.location.href=this.value">
                            <option value="?act=sanpham<?php echo !empty($id_loai) ? '&loai='.$id_loai : ''; ?>">Mặc định</option>
                            <option value="?act=sanpham&sort=new<?php echo !empty($id_loai) ? '&loai='.$id_loai : ''; ?>" <?php echo (isset($_GET['sort']) && $_GET['sort']=='new') ? 'selected' : ''; ?>>Mới nhất</option>
                            <option value="?act=sanpham&sort=price_asc<?php echo !empty($id_loai) ? '&loai='.$id_loai : ''; ?>" <?php echo (isset($_GET['sort']) && $_GET['sort']=='price_asc') ? 'selected' : ''; ?>>Giá tăng dần</option>
                            <option value="?act=sanpham&sort=price_desc<?php echo !empty($id_loai) ? '&loai='.$id_loai : ''; ?>" <?php echo (isset($_GET['sort']) && $_GET['sort']=='price_desc') ? 'selected' : ''; ?>>Giá giảm dần</option>
                        </select>
                    </div>
                </div>

                <!-- Products -->
                <?php if (empty($sanpham)): ?>
                    <div class="text-center py-5 bg-white rounded-3 border">
                        <i class="fas fa-tshirt fa-3x text-muted mb-3"></i>
                        <h5 class="fw-bold">Không tìm thấy sản phẩm nào</h5>
                        <p class="text-secondary small">Vui lòng thử tìm với từ khóa hoặc bộ lọc khác.</p>
                        <a href="index.php?act=sanpham" class="btn-yame-dark btn-sm">Xem tất cả sản phẩm</a>
                    </div>
                <?php else: ?>
                    <div class="row g-4">
                        <?php foreach ($sanpham as $sp): ?>
                        <div class="col-lg-4 col-md-6 col-6">
                            <div class="yame-product-card">
                                <!-- Image -->
                                <div class="product-image-wrapper">
                                    <img src="<?php echo $sp['hinh_anh'] ? $sp['hinh_anh'] : 'Content/imageaothun/ao-nam-basic-trang.jpg'; ?>" 
                                         alt="<?php echo htmlspecialchars($sp['ten_hanghoa']); ?>" loading="lazy">
                                    
                                    <?php if ($sp['gia_khuyen_mai'] > 0): ?>
                                        <span class="badge-discount-yame">
                                            -<?php echo round((1 - $sp['gia_khuyen_mai']/$sp['gia'])*100); ?>%
                                        </span>
                                    <?php endif; ?>

                                    <!-- Slide-Up Actions -->
                                    <div class="product-quick-actions">
                                        <a href="index.php?act=chitiet&id=<?php echo $sp['id_hanghoa']; ?>" class="btn-quick-view">
                                            <i class="fas fa-eye"></i> Xem Nhanh
                                        </a>
                                        <form action="index.php?act=them" method="POST" class="m-0 add-to-cart-ajax">
                                            <input type="hidden" name="id" value="<?php echo $sp['id_hanghoa']; ?>">
                                            <input type="hidden" name="so_luong" value="1">
                                            <input type="hidden" name="size" value="M">
                                            <button type="submit" class="btn-quick-cart" title="Thêm vào giỏ hàng">
                                                <i class="fas fa-cart-plus"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>

                                <!-- Body -->
                                <div class="yame-card-body">
                                    <span class="product-category-tag"><?php echo $sp['ten_loai'] ?? 'YaMe Collection'; ?></span>
                                    <h6 class="product-title">
                                        <a href="index.php?act=chitiet&id=<?php echo $sp['id_hanghoa']; ?>">
                                            <?php echo htmlspecialchars($sp['ten_hanghoa']); ?>
                                        </a>
                                    </h6>

                                    <!-- Swatches -->
                                    <div class="product-swatches">
                                        <span class="swatch-dot swatch-black active"></span>
                                        <span class="swatch-dot swatch-white"></span>
                                        <span class="swatch-dot swatch-gray"></span>
                                    </div>

                                    <!-- Pricing -->
                                    <div class="product-price-box">
                                        <?php if ($sp['gia_khuyen_mai'] > 0): ?>
                                            <span class="price-current"><?php echo number_format($sp['gia_khuyen_mai']); ?>đ</span>
                                            <span class="price-old"><?php echo number_format($sp['gia']); ?>đ</span>
                                        <?php else: ?>
                                            <span class="price-current normal"><?php echo number_format($sp['gia']); ?>đ</span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>

                    <!-- Pagination -->
                    <?php if (empty($keyword) && empty($id_loai) && isset($phantrang)): ?>
                        <div class="d-flex justify-content-center mt-5">
                            <?php echo $phantrang->render("index.php?act=sanpham"); ?>
                        </div>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>

<?php require_once dirname(__DIR__) . "/View/footer.php"; ?>
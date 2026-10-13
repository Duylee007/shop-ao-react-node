<?php
// session_start(); // Đã được gọi ở index.php
$soLuongGioHang = 0;
if (isset($_SESSION['giohang'])) {
    foreach ($_SESSION['giohang'] as $item) {
        $soLuongGioHang += $item['so_luong'];
    }
}
$currentAct = isset($_GET['act']) ? $_GET['act'] : 'home';
$currentLoai = isset($_GET['loai']) ? (int)$_GET['loai'] : 0;
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DUY FASHION – Trang Phục Nam Nữ Bền, Mềm, Không Lỗi Mốt</title>
    <link rel="icon" type="image/jpeg" href="Content/favicon.jpg">
    <link rel="shortcut icon" type="image/jpeg" href="Content/favicon.jpg">
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <!-- Bootstrap & FontAwesome -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Custom YaMe Style -->
    <link rel="stylesheet" href="Content/CSS/style.css">
</head>
<body>
    <!-- Top Bar YaMe Style -->
    <div class="yame-topbar">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-7 d-none d-lg-block">
                    <span class="topbar-promo-tag"><i class="fas fa-fire me-1"></i> ƯU ĐÃI</span>
                    <span>Miễn phí giao hàng đơn từ <strong>399K</strong> &nbsp;|&nbsp; Đổi trả tận nhà <strong>15 ngày</strong> &nbsp;|&nbsp; Hotline: <strong>1900 1234</strong></span>
                </div>
                <div class="col-lg-5 col-12 text-lg-end text-center">
                    <?php if (isset($_SESSION['user'])): ?>
                        <span>
                            <i class="far fa-user-circle me-1"></i> Xin chào, <strong><?php echo htmlspecialchars($_SESSION['user']['ten_khachhang']); ?></strong> 
                            &nbsp;|&nbsp; <a href="index.php?act=lichsu"><i class="fas fa-receipt me-1"></i> Đơn mua</a> 
                            &nbsp;|&nbsp; <a href="index.php?act=dangnhap&logout=1"><i class="fas fa-sign-out-alt me-1"></i> Đăng xuất</a>
                        </span>
                    <?php else: ?>
                        <span>
                            <a href="index.php?act=dangnhap"><i class="fas fa-sign-in-alt me-1"></i> Đăng nhập</a> 
                            &nbsp;|&nbsp; 
                            <a href="index.php?act=dangky"><i class="fas fa-user-plus me-1"></i> Đăng ký thành viên (Nhận 50K)</a>
                        </span>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Navigation YaMe Style -->
    <nav class="navbar navbar-expand-lg yame-navbar sticky-top">
        <div class="container">
            <!-- Brand Logo -->
            <a class="navbar-brand yame-brand me-4" href="index.php">
                DUY<span class="yame-brand-dot"></span>
                <span class="yame-brand-sub">STUDIO</span>
            </a>

            <!-- Mobile toggler -->
            <button class="navbar-toggler border-0 p-1" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <i class="fas fa-bars fs-4 text-dark"></i>
            </button>

            <!-- Navigation Links -->
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mx-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link yame-nav-link <?php echo ($currentAct == 'home' || $currentAct == 'trangchu') ? 'active' : ''; ?>" href="index.php">TRANG CHỦ</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link yame-nav-link <?php echo ($currentAct == 'sanpham' && empty($currentLoai)) ? 'active' : ''; ?>" href="index.php?act=sanpham">SẢN PHẨM</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link yame-nav-link <?php echo ($currentAct == 'sanpham' && $currentLoai == 1) ? 'active' : ''; ?>" href="index.php?act=sanpham&loai=1">ÁO NAM</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link yame-nav-link <?php echo ($currentAct == 'sanpham' && $currentLoai == 2) ? 'active' : ''; ?>" href="index.php?act=sanpham&loai=2">ÁO NỮ</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link yame-nav-link <?php echo ($currentAct == 'sanpham' && $currentLoai == 3) ? 'active' : ''; ?>" href="index.php?act=sanpham&loai=3">ÁO UNISEX</a>
                    </li>
                    <li class="nav-item position-relative">
                        <a class="nav-link yame-nav-link" href="index.php?act=sanpham">
                            BỘ SƯU TẬP
                            <span class="nav-tag-sale">HOT</span>
                        </a>
                    </li>
                </ul>

                <!-- Action Tools (Search & Cart) -->
                <div class="d-flex align-items-center gap-3">
                    <form class="yame-search-box" action="index.php" method="GET">
                        <input type="hidden" name="act" value="sanpham">
                        <i class="fas fa-search yame-search-icon"></i>
                        <input class="yame-search-input" type="search" name="search" placeholder="Tìm sản phẩm..." aria-label="Search" value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
                    </form>

                    <?php if (isset($_SESSION['user'])): ?>
                        <a href="index.php?act=lichsu" class="yame-icon-btn d-none d-md-inline-flex" title="Lịch sử đơn hàng">
                            <i class="fas fa-user"></i>
                        </a>
                    <?php else: ?>
                        <a href="index.php?act=dangnhap" class="yame-icon-btn d-none d-md-inline-flex" title="Đăng nhập tài khoản">
                            <i class="far fa-user"></i>
                        </a>
                    <?php endif; ?>

                    <a href="index.php?act=giohang" class="yame-cart-btn" title="Giỏ hàng">
                        <i class="fas fa-shopping-bag fs-5"></i>
                        <span class="yame-cart-badge" id="cart-count">
                            <?php echo $soLuongGioHang; ?>
                        </span>
                    </a>
                </div>
            </div>
        </div>
    </nav>

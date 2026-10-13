<?php 
if (!isset($_SESSION['admin'])) { 
    header("Location: View/dangnhap.php"); 
    exit; 
} 
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DUY STUDIO Admin – Quan Tri He Thong</title>
    <link rel="icon" type="image/jpeg" href="../Content/favicon.jpg">
    <link rel="shortcut icon" type="image/jpeg" href="../Content/favicon.jpg">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        :root {
            --sidebar-w: 268px;
            --red: #e11d48;
            --red-hover: #be123c;
            --red-glow: rgba(225, 29, 72, 0.25);
            --black: #0a0a0a;
            --dark: #111117;
            --card-bg: #ffffff;
            --border: rgba(0,0,0,0.06);
            --text-muted: #71717a;
            --font: 'Plus Jakarta Sans', sans-serif;
            --shadow-sm: 0 2px 12px rgba(0,0,0,0.06);
            --shadow-md: 0 8px 30px rgba(0,0,0,0.10);
            --radius: 16px;
            --radius-sm: 10px;
        }
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: var(--font);
            background: #f0f0f5;
            background-image: radial-gradient(ellipse at 80% 0%, rgba(225,29,72,0.04) 0%, transparent 60%);
            color: #18181b;
            overflow-x: hidden;
        }
        /* SIDEBAR */
        .sidebar {
            width: var(--sidebar-w);
            height: 100vh;
            position: fixed;
            left: 0; top: 0;
            background: var(--black);
            background-image: radial-gradient(ellipse at 0% 0%, rgba(225,29,72,0.12) 0%, transparent 50%),
                              radial-gradient(ellipse at 100% 100%, rgba(225,29,72,0.06) 0%, transparent 50%);
            overflow-y: auto; overflow-x: hidden;
            z-index: 1050;
            transition: transform 0.35s cubic-bezier(0.4, 0, 0.2, 1);
            scrollbar-width: thin;
            scrollbar-color: #27272a transparent;
        }
        .sidebar::-webkit-scrollbar { width: 4px; }
        .sidebar::-webkit-scrollbar-thumb { background: #27272a; border-radius: 4px; }
        .sidebar-brand {
            padding: 28px 22px 20px;
            display: flex; align-items: center; justify-content: space-between;
            border-bottom: 1px solid rgba(255,255,255,0.06);
            position: relative;
        }
        .sidebar-brand::after {
            content: '';
            position: absolute; bottom: -1px; left: 22px; right: 22px; height: 1px;
            background: linear-gradient(90deg, var(--red), transparent);
            opacity: 0.5;
        }
        .brand-logo { display: flex; align-items: center; gap: 12px; text-decoration: none; }
        .brand-icon {
            width: 40px; height: 40px;
            background: var(--red); border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            font-size: 0.85rem; color: white; font-weight: 900;
            box-shadow: 0 4px 15px var(--red-glow);
            flex-shrink: 0; letter-spacing: -1px;
        }
        .brand-name { font-size: 1rem; font-weight: 900; color: #fff; letter-spacing: 2px; text-transform: uppercase; }
        .brand-sub { font-size: 0.62rem; font-weight: 600; color: #52525b; letter-spacing: 1px; text-transform: uppercase; margin-top: 2px; }
        .admin-badge {
            background: rgba(225,29,72,0.15); border: 1px solid rgba(225,29,72,0.3); color: var(--red);
            font-size: 0.6rem; font-weight: 800; letter-spacing: 1px; padding: 3px 8px; border-radius: 20px; text-transform: uppercase;
        }
        .sidebar-user {
            padding: 14px 22px; display: flex; align-items: center; gap: 12px;
            border-bottom: 1px solid rgba(255,255,255,0.04); margin-bottom: 6px;
        }
        .sidebar-avatar {
            width: 36px; height: 36px; border-radius: 50%;
            background: linear-gradient(135deg, #27272a, #3f3f46);
            border: 2px solid rgba(225,29,72,0.4);
            display: flex; align-items: center; justify-content: center;
            font-size: 0.8rem; color: #e4e4e7; flex-shrink: 0;
        }
        .sidebar-user .user-name { font-size: 0.82rem; font-weight: 700; color: #e4e4e7; display: block; }
        .sidebar-user .user-role { font-size: 0.68rem; color: var(--red); font-weight: 600; letter-spacing: 0.5px; }
        .sidebar-nav { padding: 8px 0 20px; }
        .nav-section-label {
            font-size: 0.62rem; font-weight: 800; letter-spacing: 2px;
            text-transform: uppercase; color: #3f3f46; padding: 14px 24px 6px;
        }
        .sidebar-nav a {
            display: flex; align-items: center; padding: 10px 18px 10px 22px;
            color: #71717a; text-decoration: none; font-size: 0.855rem; font-weight: 600;
            transition: all 0.2s; position: relative; margin: 1px 10px; border-radius: 10px;
        }
        .sidebar-nav a .nav-icon {
            width: 32px; height: 32px; border-radius: 8px;
            display: flex; align-items: center; justify-content: center;
            font-size: 0.85rem; margin-right: 12px;
            background: rgba(255,255,255,0.04); flex-shrink: 0; transition: all 0.2s;
        }
        .sidebar-nav a:hover { color: #e4e4e7; background: rgba(255,255,255,0.05); }
        .sidebar-nav a:hover .nav-icon { background: rgba(225,29,72,0.15); color: var(--red); }
        .sidebar-nav a.active { background: linear-gradient(135deg, rgba(225,29,72,0.18), rgba(225,29,72,0.06)); color: #fff; }
        .sidebar-nav a.active .nav-icon { background: var(--red); color: #fff; box-shadow: 0 4px 12px var(--red-glow); }
        .sidebar-nav a.active::before {
            content: ''; position: absolute; left: 0; top: 6px; bottom: 6px;
            width: 3px; background: var(--red); border-radius: 0 3px 3px 0;
        }
        .nav-badge { margin-left: auto; background: rgba(225,29,72,0.2); color: var(--red); font-size: 0.6rem; font-weight: 800; padding: 2px 7px; border-radius: 20px; }
        .sidebar-divider { border: none; border-top: 1px solid rgba(255,255,255,0.05); margin: 8px 22px; }

        /* MAIN */
        .main-wrapper { margin-left: var(--sidebar-w); min-height: 100vh; display: flex; flex-direction: column; }
        
        /* TOPBAR */
        .admin-topbar {
            height: 70px; background: rgba(255,255,255,0.92); backdrop-filter: blur(20px);
            border-bottom: 1px solid var(--border); padding: 0 32px;
            display: flex; align-items: center; justify-content: space-between;
            position: sticky; top: 0; z-index: 100;
            box-shadow: var(--shadow-sm);
        }
        .topbar-left { display: flex; align-items: center; gap: 16px; }
        .topbar-right { display: flex; align-items: center; gap: 10px; }
        .mobile-toggle {
            display: none; background: #f4f4f5; border: 1px solid #e4e4e7;
            border-radius: 8px; width: 38px; height: 38px;
            align-items: center; justify-content: center;
            cursor: pointer; color: #18181b; font-size: 1rem;
        }
        .page-breadcrumb { display: flex; flex-direction: column; }
        .page-breadcrumb .page-label { font-size: 0.7rem; font-weight: 600; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.8px; }
        .page-breadcrumb .page-title { font-size: 1.1rem; font-weight: 800; color: var(--dark); letter-spacing: -0.3px; }
        .topbar-date {
            background: #f4f4f5; border-radius: 8px; padding: 6px 14px;
            font-size: 0.8rem; font-weight: 600; color: var(--text-muted);
            display: flex; align-items: center; gap: 6px;
        }
        .topbar-user {
            display: flex; align-items: center; gap: 10px;
            background: var(--black); border-radius: 10px; padding: 6px 14px 6px 6px; cursor: default;
        }
        .topbar-avatar {
            width: 32px; height: 32px; border-radius: 8px;
            background: var(--red); display: flex; align-items: center; justify-content: center;
            font-size: 0.8rem; color: white;
        }
        .topbar-username { font-size: 0.82rem; font-weight: 700; color: #fff; white-space: nowrap; }
        .topbar-btn {
            width: 38px; height: 38px; background: #f4f4f5; border: 1px solid #e4e4e7;
            border-radius: 8px; display: flex; align-items: center; justify-content: center;
            color: #52525b; font-size: 0.9rem; text-decoration: none; transition: all 0.2s;
        }
        .topbar-btn:hover { background: var(--red); border-color: var(--red); color: white; }

        /* CONTENT */
        .main-content { padding: 28px 32px 40px; flex: 1; }

        /* CARDS */
        .table-container {
            background: var(--card-bg); border-radius: var(--radius); padding: 24px;
            box-shadow: var(--shadow-sm); border: 1px solid var(--border); margin-bottom: 24px;
        }

        /* STAT CARDS */
        .stat-card-luxury {
            background: var(--card-bg); border-radius: var(--radius); padding: 22px;
            border: 1px solid var(--border); box-shadow: var(--shadow-sm);
            position: relative; overflow: hidden; transition: transform 0.25s, box-shadow 0.25s;
        }
        .stat-card-luxury:hover { transform: translateY(-4px); box-shadow: var(--shadow-md); }
        .stat-card-luxury::after { content: ''; position: absolute; top: 0; left: 0; right: 0; height: 3px; }
        .stat-card-red::after { background: linear-gradient(90deg, var(--red), #fb7185); }
        .stat-card-black::after { background: linear-gradient(90deg, #18181b, #52525b); }
        .stat-card-blue::after { background: linear-gradient(90deg, #0ea5e9, #38bdf8); }
        .stat-card-amber::after { background: linear-gradient(90deg, #f59e0b, #fcd34d); }
        .stat-icon-wrap {
            width: 46px; height: 46px; border-radius: 12px;
            display: flex; align-items: center; justify-content: center; font-size: 1.2rem;
        }
        .stat-value { font-size: 1.8rem; font-weight: 900; line-height: 1.1; margin: 8px 0 4px; letter-spacing: -1px; }
        .stat-label { font-size: 0.75rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.8px; color: var(--text-muted); }

        /* TABLES */
        .table { font-size: 0.875rem; }
        .table thead th {
            font-size: 0.7rem; font-weight: 800; text-transform: uppercase; letter-spacing: 0.8px;
            color: var(--text-muted); background: #fafafa; border-bottom: 1px solid #f0f0f0; padding: 12px 14px;
        }
        .table tbody td { padding: 13px 14px; border-bottom: 1px solid #f9f9f9; vertical-align: middle; }
        .table tbody tr:last-child td { border-bottom: none; }
        .table-hover tbody tr:hover td { background: #fafafa; }

        /* BUTTONS */
        .btn-yame-admin {
            background: var(--red); color: white; border: none;
            font-weight: 700; font-size: 0.84rem; padding: 9px 20px;
            border-radius: var(--radius-sm); transition: all 0.2s;
            text-decoration: none; display: inline-flex; align-items: center;
            gap: 7px; cursor: pointer;
        }
        .btn-yame-admin:hover {
            background: var(--red-hover); color: white;
            transform: translateY(-1px); box-shadow: 0 6px 20px var(--red-glow);
        }

        /* FORMS */
        .form-control, .form-select {
            border-radius: var(--radius-sm); border-color: #e4e4e7;
            font-size: 0.875rem; font-family: var(--font); padding: 10px 14px;
            transition: border-color 0.2s, box-shadow 0.2s;
        }
        .form-control:focus, .form-select:focus {
            border-color: var(--red); box-shadow: 0 0 0 3px rgba(225,29,72,0.12);
        }
        .form-label {
            font-size: 0.75rem; font-weight: 700; text-transform: uppercase;
            letter-spacing: 0.5px; color: #52525b; margin-bottom: 6px;
        }

        /* ALERTS */
        .alert { border-radius: var(--radius-sm); border: none; padding: 12px 18px; font-size: 0.875rem; font-weight: 600; }

        /* RESPONSIVE */
        @media (max-width: 1024px) {
            .sidebar { transform: translateX(-268px); }
            .sidebar.open { transform: translateX(0); }
            .main-wrapper { margin-left: 0; }
            .mobile-toggle { display: flex; }
            .main-content { padding: 20px; }
            .admin-topbar { padding: 0 20px; }
        }
        .sidebar-overlay { display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.5); z-index: 1049; }
        .sidebar-overlay.show { display: block; }
    </style>
</head>
<body>
    <div class="sidebar-overlay" id="sidebarOverlay" onclick="closeSidebar()"></div>

    <!-- SIDEBAR -->
    <aside class="sidebar" id="adminSidebar">
        <div class="sidebar-brand">
            <a href="index.php" class="brand-logo">
                <div class="brand-icon">DS</div>
                <div>
                    <div class="brand-name">DUY<span style="color:var(--red)">.</span>STUDIO</div>
                    <div class="brand-sub">Fashion & Apparel</div>
                </div>
            </a>
            <span class="admin-badge">Admin</span>
        </div>

        <div class="sidebar-user">
            <div class="sidebar-avatar"><i class="fas fa-user-shield"></i></div>
            <div>
                <span class="user-name"><?php echo htmlspecialchars($_SESSION['admin']['ten_hien_thi'] ?? $_SESSION['admin']['username']); ?></span>
                <span class="user-role">&#x25CF; Quản trị viên</span>
            </div>
        </div>

        <nav class="sidebar-nav">
            <div class="nav-section-label">Tổng quan</div>
            <a href="index.php?act=thongke" class="<?php echo $act == 'thongke' ? 'active' : ''; ?>">
                <div class="nav-icon"><i class="fas fa-chart-pie"></i></div>
                Báo Cáo & Thống Kê
            </a>

            <div class="nav-section-label" style="margin-top:6px;">Cửa hàng</div>
            <a href="index.php?act=hanghoa" class="<?php echo in_array($act, ['hanghoa','edithanghoa']) ? 'active' : ''; ?>">
                <div class="nav-icon"><i class="fas fa-shirt"></i></div>
                Sản Phẩm
            </a>
            <a href="index.php?act=loaisanpham" class="<?php echo in_array($act, ['loaisanpham','addloaisanpham','editloaisanpham']) ? 'active' : ''; ?>">
                <div class="nav-icon"><i class="fas fa-tags"></i></div>
                Loại Sản Phẩm
            </a>
            <a href="index.php?act=hoadon" class="<?php echo $act == 'hoadon' ? 'active' : ''; ?>">
                <div class="nav-icon"><i class="fas fa-receipt"></i></div>
                Đơn Hàng
            </a>
            <a href="index.php?act=khachhang" class="<?php echo $act == 'khachhang' ? 'active' : ''; ?>">
                <div class="nav-icon"><i class="fas fa-users"></i></div>
                Khách Hàng
            </a>

            <hr class="sidebar-divider">
            <div class="nav-section-label">Hệ thống</div>
            <a href="../index.php" target="_blank">
                <div class="nav-icon"><i class="fas fa-store"></i></div>
                Xem Website
                <span class="nav-badge">↗</span>
            </a>
            <a href="login.php?act=logout" onclick="return confirm('Ban co chac muon dang xuat?')" style="color:#ef4444;">
                <div class="nav-icon" style="background:rgba(239,68,68,0.1);color:#ef4444;"><i class="fas fa-right-from-bracket"></i></div>
                Đăng Xuất
            </a>
        </nav>
    </aside>

    <!-- MAIN WRAPPER -->
    <div class="main-wrapper">
        <header class="admin-topbar">
            <div class="topbar-left">
                <button class="mobile-toggle" onclick="toggleSidebar()"><i class="fas fa-bars"></i></button>
                <div class="page-breadcrumb">
                    <span class="page-label"><?php 
                        $sections = ['thongke'=>'Tổng quan','hanghoa'=>'Kho hàng','edithanghoa'=>'Kho hàng','loaisanpham'=>'Danh mục','addloaisanpham'=>'Danh mục','editloaisanpham'=>'Danh mục','hoadon'=>'Đơn hàng','khachhang'=>'Khách hàng'];
                        echo $sections[$act] ?? 'Dashboard';
                    ?></span>
                    <div class="page-title"><?php 
                        $titles = [
                            'thongke'=>'<i class="fas fa-chart-line me-2" style="color:var(--red)"></i>Báo Cáo Thống Kê',
                            'hanghoa'=>'<i class="fas fa-shirt me-2" style="color:var(--red)"></i>Quản Lý Sản Phẩm',
                            'edithanghoa'=>'<i class="fas fa-pen-to-square me-2" style="color:var(--red)"></i>Chỉnh Sửa Sản Phẩm',
                            'loaisanpham'=>'<i class="fas fa-tags me-2" style="color:var(--red)"></i>Loại Sản Phẩm',
                            'addloaisanpham'=>'<i class="fas fa-plus-circle me-2" style="color:var(--red)"></i>Thêm Loại Mới',
                            'editloaisanpham'=>'<i class="fas fa-edit me-2" style="color:var(--red)"></i>Sửa Loại Sản Phẩm',
                            'hoadon'=>'<i class="fas fa-receipt me-2" style="color:var(--red)"></i>Đơn Hàng & Vận Chuyển',
                            'khachhang'=>'<i class="fas fa-users me-2" style="color:var(--red)"></i>Danh Sách Khách Hàng',
                        ];
                        echo $titles[$act] ?? '<i class="fas fa-gauge me-2" style="color:var(--red)"></i>Dashboard';
                    ?></div>
                </div>
            </div>
            <div class="topbar-right">
                <div class="topbar-date d-none d-md-flex">
                    <i class="far fa-calendar-alt" style="color:var(--red)"></i>
                    <?php echo date('d/m/Y'); ?>
                </div>
                <a href="../index.php" target="_blank" class="topbar-btn d-none d-md-flex" title="Xem website">
                    <i class="fas fa-external-link-alt"></i>
                </a>
                <div class="topbar-user">
                    <div class="topbar-avatar"><i class="fas fa-user-shield"></i></div>
                    <span class="topbar-username"><?php echo htmlspecialchars($_SESSION['admin']['ten_hien_thi'] ?? $_SESSION['admin']['username']); ?></span>
                </div>
            </div>
        </header>

        <main class="main-content">

<script>
function toggleSidebar() {
    document.getElementById('adminSidebar').classList.toggle('open');
    document.getElementById('sidebarOverlay').classList.toggle('show');
}
function closeSidebar() {
    document.getElementById('adminSidebar').classList.remove('open');
    document.getElementById('sidebarOverlay').classList.remove('show');
}
</script>

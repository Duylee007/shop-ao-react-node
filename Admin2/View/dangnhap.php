<?php
session_start();
if (isset($_SESSION['admin'])) { 
    header("Location: ../index.php"); 
    exit; 
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng Nhập Quản Trị – DUY STUDIO Admin</title>
    <link rel="icon" type="image/jpeg" href="../../Content/favicon.jpg">
    <link rel="shortcut icon" type="image/jpeg" href="../../Content/favicon.jpg">
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --yame-black: #111111;
            --yame-dark: #18181b;
            --yame-red: #e11d48;
            --font-main: 'Plus Jakarta Sans', sans-serif;
        }
        * { box-sizing: border-box; }
        body {
            font-family: var(--font-main);
            background: radial-gradient(circle at 50% 20%, #27272a 0%, #111111 75%, #09090b 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #ffffff;
            margin: 0;
            padding: 20px;
        }
        .admin-login-card {
            background: rgba(24, 24, 27, 0.95);
            border: 1px solid rgba(255, 255, 255, 0.12);
            border-radius: 20px;
            box-shadow: 0 30px 70px rgba(0, 0, 0, 0.6);
            backdrop-filter: blur(20px);
            overflow: hidden;
            width: 100%;
            max-width: 440px;
        }
        .brand-title {
            font-size: 1.8rem;
            font-weight: 900;
            letter-spacing: 2px;
            text-transform: uppercase;
        }
        .brand-dot {
            color: var(--yame-red);
        }
        .form-control-yame {
            background-color: #27272a;
            border: 1px solid #3f3f46;
            color: #ffffff;
            border-radius: 10px;
            padding: 12px 16px 12px 42px;
            font-size: 0.92rem;
            transition: all 0.3s;
        }
        .form-control-yame:focus {
            background-color: #1f1f23;
            border-color: var(--yame-red);
            color: #ffffff;
            box-shadow: 0 0 0 4px rgba(225, 29, 72, 0.2);
            outline: none;
        }
        .input-icon {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: #a1a1aa;
            font-size: 1rem;
            pointer-events: none;
        }
        .btn-admin-submit {
            background: var(--yame-red);
            border: none;
            color: white;
            font-weight: 800;
            letter-spacing: 1px;
            text-transform: uppercase;
            padding: 14px;
            border-radius: 10px;
            width: 100%;
            font-size: 0.9rem;
            transition: all 0.3s;
            cursor: pointer;
        }
        .btn-admin-submit:hover {
            background: #be123c;
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(225, 29, 72, 0.4);
        }
        .login-badge {
            background: rgba(225, 29, 72, 0.15);
            color: var(--yame-red);
            border: 1px solid rgba(225, 29, 72, 0.3);
            font-size: 0.72rem;
            font-weight: 800;
            letter-spacing: 1.5px;
            padding: 4px 12px;
            border-radius: 9999px;
            display: inline-block;
            margin-bottom: 12px;
        }
        .credential-box {
            background: rgba(255, 255, 255, 0.05);
            border: 1px dashed rgba(255, 255, 255, 0.15);
            border-radius: 10px;
            padding: 10px 14px;
            font-size: 0.8rem;
            color: #a1a1aa;
        }
    </style>
</head>
<body>
    <div class="admin-login-card">
        <div class="p-4 p-sm-5">
            <div class="text-center mb-4">
                <span class="login-badge text-uppercase"><i class="fas fa-lock me-1"></i> Quản Trị Hệ Thống</span>
                <div class="brand-title">
                    DUY<span class="brand-dot">.</span>STUDIO
                </div>
                <small class="text-secondary">YaMe Control Panel Management</small>
            </div>

            <?php if (isset($_GET['loi'])): ?>
            <div class="alert alert-danger py-2 px-3 small border-0 mb-4" style="background: rgba(225, 29, 72, 0.2); color: #fda4af; border-radius: 8px;">
                <i class="fas fa-exclamation-triangle me-2"></i> Tên đăng nhập hoặc mật khẩu không chính xác!
            </div>
            <?php endif; ?>

            <form action="../login.php" method="POST">
                <div class="mb-3">
                    <label class="form-label small fw-bold text-secondary text-uppercase" style="letter-spacing: 0.5px;">Tài khoản quản trị</label>
                    <div class="position-relative">
                        <i class="fas fa-user-shield input-icon"></i>
                        <input type="text" name="username" class="form-control form-control-yame" placeholder="admin1" value="admin1" required autofocus>
                    </div>
                </div>
                <div class="mb-4">
                    <label class="form-label small fw-bold text-secondary text-uppercase" style="letter-spacing: 0.5px;">Mật khẩu</label>
                    <div class="position-relative">
                        <i class="fas fa-key input-icon"></i>
                        <input type="password" name="password" class="form-control form-control-yame" placeholder="admin123" value="admin123" required>
                    </div>
                </div>
                <button type="submit" class="btn-admin-submit mb-3">
                    <i class="fas fa-arrow-right-to-bracket me-2"></i> Đăng Nhập
                </button>
            </form>

            <div class="credential-box mb-3 text-center">
                <i class="fas fa-info-circle me-1 text-warning"></i> Tài khoản mẫu: <strong>admin1</strong> &nbsp;|&nbsp; Mật khẩu: <strong>admin123</strong>
            </div>

            <div class="text-center">
                <a href="../../index.php" class="text-secondary small text-decoration-none hover-white">
                    <i class="fas fa-arrow-left me-1"></i> Quay lại website bán hàng
                </a>
            </div>
        </div>
    </div>
</body>
</html>

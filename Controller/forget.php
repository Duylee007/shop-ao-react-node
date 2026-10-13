<?php
require_once dirname(__DIR__) . "/Model/khachhang.php";
class ForgetController {
    private $kh;
    public function __construct() { $this->kh = new KhachHang(); }
    public function index() {
        $error = ''; $success = '';
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $email = trim($_POST['email'] ?? '');
            if (empty($email)) $error = "Vui lòng nhập email!";
            elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) $error = "Email không hợp lệ!";
            else {
                $user = $this->kh->getByEmail($email);
                if (!$user) $error = "Email không tồn tại!";
                else {
                    $token = bin2hex(random_bytes(32));
                    $_SESSION['reset_token'] = $token; $_SESSION['reset_email'] = $email; $_SESSION['reset_expiry'] = time() + 3600;
                    $success = "Link đặt lại: <a href='index.php?act=resetpw&token=" . urlencode($token) . "'>Nhấn vào đây</a>";
                }
            }
        }
        require_once dirname(__DIR__) . "/View/forgetpassword.php";
    }
    public function reset() {
        $error = ''; $success = '';
        $token = $_GET['token'] ?? ($_POST['token'] ?? '');
        if (empty($token) || !isset($_SESSION['reset_token']) || $token !== $_SESSION['reset_token']) $error = "Token không hợp lệ!";
        elseif (time() > ($_SESSION['reset_expiry'] ?? 0)) { $error = "Link đã hết hạn!"; unset($_SESSION['reset_token'], $_SESSION['reset_email'], $_SESSION['reset_expiry']); }
        elseif ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $password = $_POST['password'] ?? ''; $confirm = $_POST['confirm_password'] ?? '';
            if ($password !== $confirm) $error = "Mật khẩu không khớp!";
            elseif (strlen($password) < 6) $error = "Mật khẩu phải có ít nhất 6 ký tự!";
            else {
                if ($this->kh->updatePassword($_SESSION['reset_email'] ?? '', $password)) { $success = "Đã cập nhật!"; unset($_SESSION['reset_token'], $_SESSION['reset_email'], $_SESSION['reset_expiry']); }
                else $error = "Có lỗi xảy ra!";
            }
        }
        require_once dirname(__DIR__) . "/View/resetpw.php";
    }
}
$ctrl = new ForgetController();
if (isset($_GET['act']) && $_GET['act'] == 'resetpw') $ctrl->reset();
else $ctrl->index();
?>
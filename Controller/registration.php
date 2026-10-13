<?php
require_once dirname(__DIR__) . "/Model/khachhang.php";
class RegistrationController {
    private $kh;
    public function __construct() { $this->kh = new KhachHang(); }
    public function index() {
        $error = ''; $success = '';
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $ten = trim($_POST['ten'] ?? ''); $email = trim($_POST['email'] ?? ''); $password = $_POST['password'] ?? ''; $confirm = $_POST['confirm_password'] ?? ''; $dienthoai = trim($_POST['dienthoai'] ?? ''); $diachi = trim($_POST['diachi'] ?? '');
            if (empty($ten) || empty($email) || empty($password)) $error = "Vui lòng điền đầy đủ!";
            elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) $error = "Email không hợp lệ!";
            elseif ($password !== $confirm) $error = "Mật khẩu xác nhận không khớp!";
            elseif (strlen($password) < 6) $error = "Mật khẩu phải có ít nhất 6 ký tự!";
            elseif ($this->kh->getByEmail($email)) $error = "Email đã được sử dụng!";
            else {
                if ($this->kh->dangKy($ten, $email, $password, $dienthoai, $diachi)) $success = "Đăng ký thành công!";
                else $error = "Có lỗi xảy ra!";
            }
        }
        require_once dirname(__DIR__) . "/View/registration.php";
    }
}
$ctrl = new RegistrationController(); $ctrl->index();
?>
<?php
require_once dirname(__DIR__) . "/Model/khachhang.php";
class LoginController {
    private $kh;
    public function __construct() { $this->kh = new KhachHang(); }
    public function index() {
        $error = '';
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $email = trim($_POST['email'] ?? ''); $password = $_POST['password'] ?? '';
            if (empty($email) || empty($password)) $error = "Vui lòng nhập đầy đủ!";
            else {
                $user = $this->kh->dangNhap($email, $password);
                if ($user) { $_SESSION['user'] = $user; header("Location: index.php"); exit; }
                else $error = "Email hoặc mật khẩu không đúng!";
            }
        }
        require_once dirname(__DIR__) . "/View/login.php";
    }
    public function logout() { unset($_SESSION['user']); header("Location: index.php"); exit; }
}
$ctrl = new LoginController();
if (isset($_GET['logout'])) $ctrl->logout();
else $ctrl->index();
?>
<?php
require_once dirname(__DIR__) . "/Model/giohang.php";
require_once dirname(__DIR__) . "/Model/hanghoa.php";
class CartController {
    private $gh; private $hh;
    public function __construct() { $this->gh = new GioHang(); $this->hh = new HangHoa(); }
    public function index() { $giohang = $this->gh->getAll(); $tongTien = $this->gh->tinhTong(); require_once dirname(__DIR__) . "/View/cart.php"; }
    public function them() {
        $sp = $this->hh->getById((int)($_POST['id'] ?? 0));
        if ($sp) { $gia = $sp['gia_khuyen_mai'] > 0 ? $sp['gia_khuyen_mai'] : $sp['gia']; $this->gh->them($sp['id_hanghoa'], $sp['ten_hanghoa'], $gia, $sp['hinh_anh'], (int)($_POST['so_luong'] ?? 1), $_POST['size'] ?? 'M'); }
        header("Location: index.php?act=giohang"); exit;
    }
    public function xoa() { $this->gh->xoa($_GET['key'] ?? ''); header("Location: index.php?act=giohang"); exit; }
    public function capNhat() { if ($_SERVER['REQUEST_METHOD'] == 'POST') foreach ($_POST['so_luong'] ?? [] as $key => $sl) $this->gh->capNhat($key, (int)$sl); header("Location: index.php?act=giohang"); exit; }
}
$ctrl = new CartController(); $act = $_GET['act'] ?? '';
if ($act == 'them') $ctrl->them(); elseif ($act == 'xoa') $ctrl->xoa(); elseif ($act == 'capnhat') $ctrl->capNhat(); else $ctrl->index();
?>
<?php
require_once dirname(__DIR__) . "/Model/hoadon.php";
require_once dirname(__DIR__) . "/Model/giohang.php";
class HoaDonController {
    private $hd; private $gh;
    public function __construct() { $this->hd = new HoaDon(); $this->gh = new GioHang(); }
    public function datHang() {
        if (!isset($_SESSION['user'])) { header("Location: index.php?act=dangnhap"); exit; }
        $giohang = $this->gh->getAll(); if (empty($giohang)) { header("Location: index.php?act=giohang"); exit; }
        $error = ''; $success = '';
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $dia_chi = trim($_POST['dia_chi'] ?? ''); $sdt = trim($_POST['sdt'] ?? ''); $ghi_chu = trim($_POST['ghi_chu'] ?? '');
            if (empty($dia_chi) || empty($sdt)) $error = "Vui lòng điền đầy đủ!";
            else {
                $id_hd = $this->hd->taoHoaDon($_SESSION['user']['id_khachhang'], $this->gh->tinhTong(), $dia_chi, $sdt, $ghi_chu);
                foreach ($giohang as $item) $this->hd->themChiTiet($id_hd, $item['id'], $item['ten'], $item['so_luong'], $item['gia'], $item['size']);
                $this->gh->xoaTatCa(); $success = "Đặt hàng thành công! Mã đơn: #$id_hd";
            }
        }
        $tongTien = $this->gh->tinhTong(); require_once dirname(__DIR__) . "/View/order.php";
    }
    public function lichSu() { if (!isset($_SESSION['user'])) { header("Location: index.php?act=dangnhap"); exit; } $donhang = $this->hd->getByKhachHang($_SESSION['user']['id_khachhang']); require_once dirname(__DIR__) . "/View/lichsu.php"; }
    public function chiTietDon() {
        if (!isset($_SESSION['user'])) { header("Location: index.php?act=dangnhap"); exit; }
        $id = (int)($_GET['id'] ?? 0);
        $don = $this->hd->getById($id);
        if (!$don || (int)$don['id_khachhang'] !== (int)$_SESSION['user']['id_khachhang']) { header("Location: index.php?act=lichsu"); exit; }
        $chitiet = $this->hd->getChiTiet($id);
        require_once dirname(__DIR__) . "/View/chitietdon.php";
    }
}
$ctrl = new HoaDonController(); $act = $_GET['act'] ?? '';
if ($act == 'lichsu') $ctrl->lichSu(); elseif ($act == 'chitietdon') $ctrl->chiTietDon(); else $ctrl->datHang();
?>
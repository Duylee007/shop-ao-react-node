<?php
class GioHang {
    public function __construct() { if (!isset($_SESSION['giohang'])) $_SESSION['giohang'] = []; }
    public function them($id, $ten, $gia, $hinh, $so_luong = 1, $size = "M") {
        $key = (int)$id . "_" . strtoupper(trim($size));
        if (isset($_SESSION['giohang'][$key])) $_SESSION['giohang'][$key]['so_luong'] += (int)$so_luong;
        else $_SESSION['giohang'][$key] = ['id'=>(int)$id, 'ten'=>htmlspecialchars(trim($ten)), 'gia'=>(float)$gia, 'hinh'=>htmlspecialchars(trim($hinh)), 'so_luong'=>(int)$so_luong, 'size'=>strtoupper(trim($size))];
    }
    public function xoa($key) { if (isset($_SESSION['giohang'][$key])) unset($_SESSION['giohang'][$key]); }
    public function capNhat($key, $so_luong) { $sl = (int)$so_luong; if ($sl <= 0) unset($_SESSION['giohang'][$key]); else $_SESSION['giohang'][$key]['so_luong'] = $sl; }
    public function xoaTatCa() { $_SESSION['giohang'] = []; }
    public function getAll() { return $_SESSION['giohang'] ?? []; }
    public function tinhTong() { $tong = 0; foreach ($_SESSION['giohang'] ?? [] as $item) $tong += (float)$item['gia'] * (int)$item['so_luong']; return $tong; }
    public function demSoLuong() { $count = 0; foreach ($_SESSION['giohang'] ?? [] as $item) $count += (int)$item['so_luong']; return $count; }
}
?>
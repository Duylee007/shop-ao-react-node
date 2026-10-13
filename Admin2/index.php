<?php
session_start();
if (!isset($_SESSION['admin'])) { header("Location: View/dangnhap.php"); exit; }
$act = isset($_GET['act']) ? htmlspecialchars(trim($_GET['act'])) : 'thongke';
require_once "View/headder.php";
switch ($act) {
    case 'thongke': require_once "View/thongke.php"; break;
    case 'hanghoa': require_once "View/hanghoa.php"; break;
    case 'edithanghoa': require_once "View/edithanghoa.php"; break;
    case 'loaisanpham': require_once "View/loaisanpham.php"; break;
    case 'addloaisanpham': require_once "View/addloaisanpham.php"; break;
    case 'editloaisanpham': require_once "View/editloaisanpham.php"; break;
    case 'hoadon': require_once "View/hoadon.php"; break;
    case 'khachhang': require_once "View/khachhang.php"; break;
    default: require_once "View/thongke.php";
}
require_once "View/footer.php";
?>
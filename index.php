<?php
session_start();
$act = isset($_GET['act']) ? htmlspecialchars(trim($_GET['act'])) : 'home';
switch ($act) {
    case 'home': case 'trangchu': require_once "Controller/home.php"; break;
    case 'sanpham': require_once "Controller/sanpham.php"; break;
    case 'chitiet': $_GET['act'] = 'chitiet'; require_once "Controller/sanpham.php"; break;
    case 'dangnhap': require_once "Controller/login.php"; break;
    case 'dangky': require_once "Controller/registration.php"; break;
    case 'quenmatkhau': require_once "Controller/forget.php"; break;
    case 'resetpw': require_once "Controller/forget.php"; break;
    case 'giohang': case 'them': case 'xoa': case 'capnhat': require_once "Controller/cart.php"; break;
    case 'dathang': case 'lichsu': case 'chitietdon': require_once "Controller/hoadon.php"; break;
    default: require_once "Controller/home.php";
}
?>
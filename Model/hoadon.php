<?php
require_once __DIR__ . "/init.php";
class HoaDon {
    private $conn;
    public function __construct() { $db = new Database(); $this->conn = $db->getConnection(); }
    public function taoHoaDon($id_kh, $tong_tien, $dia_chi, $sdt, $ghi_chu = "") {
        $stmt = $this->conn->prepare("INSERT INTO hoadon (id_khachhang, ngay_dat_hang, tong_tien, trang_thai, dia_chi_giao, sdt_giao, ghi_chu) VALUES (?,NOW(),?,'Chờ xác nhận',?,?,?)");
        $stmt->execute([(int)$id_kh, (float)$tong_tien, trim($dia_chi), trim($sdt), trim($ghi_chu)]);
        return $this->conn->lastInsertId();
    }
    public function themChiTiet($id_hd, $id_hh, $ten, $sl, $dg, $size) {
        $stmt = $this->conn->prepare("INSERT INTO chitiet_hoadon (id_hoadon, id_hanghoa, ten_hanghoa, so_luong, don_gia, size) VALUES (?,?,?,?,?,?)");
        return $stmt->execute([(int)$id_hd, (int)$id_hh, htmlspecialchars(trim($ten)), (int)$sl, (float)$dg, strtoupper(trim($size))]);
    }
    public function getByKhachHang($id_kh) { $stmt = $this->conn->prepare("SELECT h.*, k.ten_khachhang FROM hoadon h LEFT JOIN khachhang k ON h.id_khachhang = k.id_khachhang WHERE h.id_khachhang = ? ORDER BY h.id_hoadon DESC"); $stmt->execute([(int)$id_kh]); return $stmt->fetchAll(); }
    public function getById($id) { $stmt = $this->conn->prepare("SELECT h.*, k.ten_khachhang FROM hoadon h LEFT JOIN khachhang k ON h.id_khachhang = k.id_khachhang WHERE h.id_hoadon = ? LIMIT 1"); $stmt->execute([(int)$id]); return $stmt->fetch(); }
    public function getChiTiet($id_hd) { $stmt = $this->conn->prepare("SELECT * FROM chitiet_hoadon WHERE id_hoadon = ?"); $stmt->execute([(int)$id_hd]); return $stmt->fetchAll(); }
    public function getAll() { return $this->conn->query("SELECT h.*, k.ten_khachhang, k.email FROM hoadon h LEFT JOIN khachhang k ON h.id_khachhang = k.id_khachhang ORDER BY h.id_hoadon DESC")->fetchAll(); }
    public function capNhatTrangThai($id, $tt) { $stmt = $this->conn->prepare("UPDATE hoadon SET trang_thai = ? WHERE id_hoadon = ?"); return $stmt->execute([trim($tt), (int)$id]); }
    public function thongKe() { return $this->conn->query("SELECT COUNT(*) as tong_don, SUM(CASE WHEN trang_thai='Chờ xác nhận' THEN 1 ELSE 0 END) as cho_xac_nhan, SUM(CASE WHEN trang_thai='Đang giao' THEN 1 ELSE 0 END) as dang_giao, SUM(CASE WHEN trang_thai='Hoàn thành' THEN 1 ELSE 0 END) as hoan_thanh, SUM(CASE WHEN trang_thai='Đã hủy' THEN 1 ELSE 0 END) as da_huy, SUM(tong_tien) as doanh_thu FROM hoadon")->fetch(); }
    public function thongKeTheoThang() { return $this->conn->query("SELECT DATE_FORMAT(ngay_dat_hang, '%Y-%m') as thang, COUNT(*) as so_don, SUM(tong_tien) as doanh_thu FROM hoadon GROUP BY thang ORDER BY thang DESC LIMIT 6")->fetchAll(); }
}
?>
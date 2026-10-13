<?php
require_once __DIR__ . "/init.php";
class KhachHang {
    private $conn;
    public function __construct() { $db = new Database(); $this->conn = $db->getConnection(); }
    public function dangKy($ten, $email, $password, $dienthoai, $diachi) {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) return false;
        $stmt = $this->conn->prepare("INSERT INTO khachhang (ten_khachhang, email, password, dien_thoai, dia_chi, ngay_dang_ky) VALUES (?,?,?,?,?,NOW())");
        return $stmt->execute([trim($ten), strtolower(trim($email)), password_hash($password, PASSWORD_BCRYPT), trim($dienthoai), trim($diachi)]);
    }
    public function dangNhap($email, $password) {
        $stmt = $this->conn->prepare("SELECT * FROM khachhang WHERE email = ? LIMIT 1");
        $stmt->execute([strtolower(trim($email))]);
        $user = $stmt->fetch();
        if ($user && password_verify($password, $user['password'])) { unset($user['password']); return $user; }
        return false;
    }
    public function getByEmail($email) { $stmt = $this->conn->prepare("SELECT * FROM khachhang WHERE email = ? LIMIT 1"); $stmt->execute([strtolower(trim($email))]); return $stmt->fetch(); }
    public function updatePassword($email, $newPassword) { $stmt = $this->conn->prepare("UPDATE khachhang SET password = ? WHERE email = ?"); return $stmt->execute([password_hash($newPassword, PASSWORD_BCRYPT), strtolower(trim($email))]); }
    public function getById($id) { $stmt = $this->conn->prepare("SELECT * FROM khachhang WHERE id_khachhang = ?"); $stmt->execute([(int)$id]); return $stmt->fetch(); }
    public function getAll() { return $this->conn->query("SELECT * FROM khachhang ORDER BY id_khachhang DESC")->fetchAll(); }
}
?>
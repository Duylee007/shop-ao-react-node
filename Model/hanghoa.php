<?php
require_once __DIR__ . "/init.php";
class HangHoa {
    private $conn;
    public function __construct() { $db = new Database(); $this->conn = $db->getConnection(); }
    public function getAll() { return $this->conn->query("SELECT h.*, l.ten_loai FROM hanghoa h LEFT JOIN loaihang l ON h.id_loai = l.id_loai ORDER BY h.id_hanghoa DESC")->fetchAll(); }
    public function getById($id) { $stmt = $this->conn->prepare("SELECT * FROM hanghoa WHERE id_hanghoa = ?"); $stmt->execute([(int)$id]); return $stmt->fetch(); }
    public function getByCategory($id_loai) { $stmt = $this->conn->prepare("SELECT * FROM hanghoa WHERE id_loai = ?"); $stmt->execute([(int)$id_loai]); return $stmt->fetchAll(); }
    public function getFeatured($limit = 8) { 
        $limit = (int)$limit;
        return $this->conn->query("SELECT * FROM hanghoa WHERE noi_bat = 1 ORDER BY id_hanghoa DESC LIMIT $limit")->fetchAll(); 
    }
    public function getByPage($page, $perPage = 12) {
        $page = max(1, (int)$page); $perPage = max(1, (int)$perPage); $offset = ($page - 1) * $perPage;
        $stmt = $this->conn->prepare("SELECT h.*, l.ten_loai FROM hanghoa h LEFT JOIN loaihang l ON h.id_loai = l.id_loai ORDER BY h.id_hanghoa DESC LIMIT :perPage OFFSET :offset");
        $stmt->bindValue(':perPage', $perPage, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    public function search($keyword) { $stmt = $this->conn->prepare("SELECT * FROM hanghoa WHERE ten_hanghoa LIKE ? OR mo_ta LIKE ?"); $kw = "%$keyword%"; $stmt->execute([$kw, $kw]); return $stmt->fetchAll(); }
    public function countAll() { return $this->conn->query("SELECT COUNT(*) FROM hanghoa")->fetchColumn(); }
    public function add($data) { $stmt = $this->conn->prepare("INSERT INTO hanghoa (ten_hanghoa, gia, gia_khuyen_mai, hinh_anh, mo_ta, id_loai, so_luong, noi_bat) VALUES (?,?,?,?,?,?,?,?)"); return $stmt->execute([$data['ten_hanghoa'], $data['gia'], $data['gia_khuyen_mai'], $data['hinh_anh'], $data['mo_ta'], $data['id_loai'], $data['so_luong'], $data['noi_bat']]); }
    public function update($id, $data) { $stmt = $this->conn->prepare("UPDATE hanghoa SET ten_hanghoa=?, gia=?, gia_khuyen_mai=?, hinh_anh=?, mo_ta=?, id_loai=?, so_luong=?, noi_bat=? WHERE id_hanghoa=?"); return $stmt->execute([$data['ten_hanghoa'], $data['gia'], $data['gia_khuyen_mai'], $data['hinh_anh'], $data['mo_ta'], $data['id_loai'], $data['so_luong'], $data['noi_bat'], (int)$id]); }
    public function delete($id) { $stmt = $this->conn->prepare("DELETE FROM hanghoa WHERE id_hanghoa = ?"); return $stmt->execute([(int)$id]); }
}
?>
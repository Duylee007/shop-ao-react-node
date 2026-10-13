<?php
// Kiểm tra xem class Database đã tồn tại chưa để tránh lỗi redeclaration
if (!class_exists('Database')) {
    class Database {
        private $host = "localhost", $db_name = "shopao", $username = "root", $password = "";
        public $conn;
        public function getConnection() {
            try {
                $this->conn = new PDO("mysql:host=".$this->host.";dbname=".$this->db_name.";charset=utf8mb4", $this->username, $this->password);
                $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $this->conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
                return $this->conn;
            } catch(PDOException $e) {
                die("Lỗi kết nối database");
            }
        }
    }
}
?>
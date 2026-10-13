<?php
session_start();
require_once __DIR__ . "/Model/init.php";

class AdminAuth {
    private $conn;
    public function __construct() { 
        $db = new Database(); 
        $this->conn = $db->getConnection(); 
    }
    
    public function login($username, $password) {
        $stmt = $this->conn->prepare("SELECT * FROM admin WHERE username = ? LIMIT 1");
        $stmt->execute([$username]);
        $admin = $stmt->fetch();
        
        if ($admin) {
            $isValid = false;
            // Kiểm tra hash bcrypt hoặc mật khẩu thường (fallback cho dữ liệu mẫu sql)
            if (password_verify($password, $admin['password'])) {
                $isValid = true;
            } elseif ($password === $admin['password']) {
                $isValid = true;
                // Tự động nâng cấp hash mật khẩu vào database cho an toàn
                $newHash = password_hash($password, PASSWORD_DEFAULT);
                $upStmt = $this->conn->prepare("UPDATE admin SET password = ? WHERE id_admin = ?");
                $upStmt->execute([$newHash, $admin['id_admin']]);
            }
            
            if ($isValid) {
                session_regenerate_id(true);
                $_SESSION['admin'] = $admin;
                return true;
            }
        }
        return false;
    }
    
    public function logout() {
        unset($_SESSION['admin']);
        header("Location: View/dangnhap.php");
        exit;
    }
}

$auth = new AdminAuth();
if (isset($_GET['act']) && $_GET['act'] == 'logout') {
    $auth->logout();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    if ($auth->login($username, $password)) { 
        header("Location: index.php"); 
        exit; 
    } else { 
        header("Location: View/dangnhap.php?loi=1"); 
        exit; 
    }
}
?>
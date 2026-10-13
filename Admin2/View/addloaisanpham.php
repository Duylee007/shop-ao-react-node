<?php
require_once dirname(__DIR__, 2) . "/Model/init.php";
$db = new Database();
$conn = $db->getConnection();

$message = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $ten = trim($_POST['ten_loai']);
    $mota = trim($_POST['mo_ta']);
    if (!empty($ten)) {
        $stmt = $conn->prepare("INSERT INTO loaihang (ten_loai, mo_ta) VALUES (:ten, :mota)");
        $stmt->execute([':ten' => $ten, ':mota' => $mota]);
        $message = '<div class="alert alert-success border-0 shadow-sm rounded-3"><i class="fas fa-check-circle me-2"></i> Thêm loại sản phẩm thành công!</div>';
    } else {
        $message = '<div class="alert alert-danger border-0 shadow-sm rounded-3">Vui lòng nhập tên loại hàng!</div>';
    }
}
?>

<div class="table-container" style="max-width: 650px;">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h5 class="fw-bold mb-1" style="font-size: 1.15rem;">
                <i class="fas fa-plus-circle text-danger me-2"></i> Thêm Loại Sản Phẩm Mới
            </h5>
            <small class="text-secondary">Tạo danh mục mới để phân loại sản phẩm</small>
        </div>
        <a href="index.php?act=loaisanpham" class="btn btn-outline-dark btn-sm">
            <i class="fas fa-arrow-left me-1"></i> Danh sách
        </a>
    </div>

    <?php echo $message; ?>

    <form method="POST">
        <div class="mb-3">
            <label class="form-label small fw-bold text-uppercase">Tên loại sản phẩm <span class="text-danger">*</span></label>
            <input type="text" name="ten_loai" class="form-control" placeholder="Ví dụ: Áo Sơ Mi Nam, Áo Polo Casual..." required autofocus>
        </div>
        <div class="mb-4">
            <label class="form-label small fw-bold text-uppercase">Mô tả ngắn</label>
            <textarea name="mo_ta" class="form-control" rows="3" placeholder="Mô tả tóm tắt về loại sản phẩm này..."></textarea>
        </div>
        <div class="d-flex gap-2">
            <button type="submit" class="btn-yame-admin py-2 px-4">
                <i class="fas fa-save me-1"></i> Lưu Danh Mục
            </button>
            <a href="index.php?act=loaisanpham" class="btn btn-outline-secondary py-2 px-4">Hủy bỏ</a>
        </div>
    </form>
</div>

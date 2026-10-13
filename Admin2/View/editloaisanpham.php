<?php
require_once dirname(__DIR__, 2) . "/Model/init.php";
$db = new Database();
$conn = $db->getConnection();

$id = (int)($_GET['id'] ?? 0);
$item = $conn->prepare("SELECT * FROM loaihang WHERE id_loai = :id");
$item->execute([':id' => $id]);
$item = $item->fetch();

$message = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $ten = trim($_POST['ten_loai']);
    $mota = trim($_POST['mo_ta']);
    if (!empty($ten)) {
        $stmt = $conn->prepare("UPDATE loaihang SET ten_loai = :ten, mo_ta = :mota WHERE id_loai = :id");
        $stmt->execute([':ten' => $ten, ':mota' => $mota, ':id' => $id]);
        $message = '<div class="alert alert-success border-0 shadow-sm rounded-3"><i class="fas fa-check-circle me-2"></i> Cập nhật loại sản phẩm thành công!</div>';
        $item['ten_loai'] = $ten;
        $item['mo_ta'] = $mota;
    } else {
        $message = '<div class="alert alert-danger border-0 shadow-sm rounded-3">Tên loại hàng không được để trống!</div>';
    }
}
?>

<div class="table-container" style="max-width: 650px;">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h5 class="fw-bold mb-1" style="font-size: 1.15rem;">
                <i class="fas fa-edit text-danger me-2"></i> Chỉnh Sửa Loại Sản Phẩm #<?php echo $id; ?>
            </h5>
            <small class="text-secondary">Cập nhật tên danh mục và mô tả hiển thị</small>
        </div>
        <a href="index.php?act=loaisanpham" class="btn btn-outline-dark btn-sm">
            <i class="fas fa-arrow-left me-1"></i> Danh sách
        </a>
    </div>

    <?php echo $message; ?>

    <form method="POST">
        <div class="mb-3">
            <label class="form-label small fw-bold text-uppercase">Tên loại sản phẩm <span class="text-danger">*</span></label>
            <input type="text" name="ten_loai" class="form-control" value="<?php echo htmlspecialchars($item['ten_loai'] ?? ''); ?>" required>
        </div>
        <div class="mb-4">
            <label class="form-label small fw-bold text-uppercase">Mô tả ngắn</label>
            <textarea name="mo_ta" class="form-control" rows="3"><?php echo htmlspecialchars($item['mo_ta'] ?? ''); ?></textarea>
        </div>
        <div class="d-flex gap-2">
            <button type="submit" class="btn-yame-admin py-2 px-4">
                <i class="fas fa-save me-1"></i> Lưu Thay Đổi
            </button>
            <a href="index.php?act=loaisanpham" class="btn btn-outline-secondary py-2 px-4">Hủy bỏ</a>
        </div>
    </form>
</div>

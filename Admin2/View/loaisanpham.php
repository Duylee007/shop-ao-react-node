<?php
require_once dirname(__DIR__, 2) . "/Model/init.php";

$db = new Database();
$conn = $db->getConnection();

$message = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete_id'])) {
    $stmt = $conn->prepare("DELETE FROM loaihang WHERE id_loai = :id");
    $stmt->execute([':id' => (int)$_POST['delete_id']]);
    $message = '<div class="alert alert-success border-0 shadow-sm rounded-3"><i class="fas fa-check-circle me-2"></i> Đã xóa loại sản phẩm!</div>';
}

$ds = $conn->query("SELECT l.*, COUNT(h.id_hanghoa) as tong_sp FROM loaihang l LEFT JOIN hanghoa h ON l.id_loai = h.id_loai GROUP BY l.id_loai ORDER BY l.id_loai DESC")->fetchAll();
?>

<div class="table-container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h5 class="fw-bold mb-1" style="font-size: 1.15rem;">Quản Lý Danh Mục Loại Hàng</h5>
            <small class="text-secondary">Phân loại các dòng sản phẩm áo nam, nữ, unisex, thể thao</small>
        </div>
        <a href="index.php?act=addloaisanpham" class="btn-yame-admin">
            <i class="fas fa-plus"></i> Thêm Loại Mới
        </a>
    </div>

    <?php echo $message; ?>

    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light text-uppercase small" style="letter-spacing: 0.5px;">
                <tr>
                    <th class="ps-3 py-3" style="width: 80px;">Mã</th>
                    <th class="py-3">Tên loại hàng</th>
                    <th class="py-3">Mô tả danh mục</th>
                    <th class="py-3 text-center">Số sản phẩm</th>
                    <th class="pe-3 py-3 text-end">Thao tác</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($ds)): ?>
                    <tr><td colspan="5" class="text-center py-4 text-muted">Chưa có loại sản phẩm nào</td></tr>
                <?php else: ?>
                    <?php foreach ($ds as $item): ?>
                    <tr class="border-bottom">
                        <td class="ps-3 fw-bold text-secondary">#<?php echo $item['id_loai']; ?></td>
                        <td>
                            <strong class="text-dark fs-6"><?php echo htmlspecialchars($item['ten_loai']); ?></strong>
                        </td>
                        <td>
                            <span class="text-secondary small"><?php echo htmlspecialchars($item['mo_ta'] ?: 'Không có mô tả'); ?></span>
                        </td>
                        <td class="text-center">
                            <span class="badge bg-light text-dark border px-3 py-1"><?php echo $item['tong_sp']; ?> sản phẩm</span>
                        </td>
                        <td class="pe-3 text-end">
                            <a href="index.php?act=editloaisanpham&id=<?php echo $item['id_loai']; ?>" class="btn btn-sm btn-outline-dark me-1" title="Sửa">
                                <i class="fas fa-pen-to-square"></i> Sửa
                            </a>
                            <form method="POST" class="d-inline" onsubmit="return confirm('Bạn có chắc muốn xóa loại này? Các sản phẩm thuộc loại này sẽ không còn danh mục.')">
                                <input type="hidden" name="delete_id" value="<?php echo $item['id_loai']; ?>">
                                <button type="submit" class="btn btn-sm btn-outline-danger" title="Xóa">
                                    <i class="fas fa-trash-can"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

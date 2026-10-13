<?php
require_once dirname(__DIR__, 2) . "/Model/init.php";
require_once dirname(__DIR__, 2) . "/Model/hanghoa.php";

$hh = new HangHoa();
$db = new Database();
$conn = $db->getConnection();

// Xử lý thêm/sửa/xóa
$message = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['delete_id'])) {
        $hh->delete((int)$_POST['delete_id']);
        $message = '<div class="alert alert-success border-0 shadow-sm rounded-3"><i class="fas fa-check-circle me-2"></i> Đã xóa sản phẩm thành công!</div>';
    }
}

$keyword = $_GET['search'] ?? '';
if ($keyword) {
    $ds = $hh->search($keyword);
} else {
    $ds = $hh->getAll();
}
?>

<div class="table-container">
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
        <div>
            <h5 class="fw-bold mb-1" style="font-size: 1.15rem;">Kho Hàng Hóa Sản Phẩm</h5>
            <small class="text-secondary">Quản lý giá bán, hình ảnh, khuyến mãi và số lượng tồn kho</small>
        </div>
        <div class="d-flex flex-wrap align-items-center gap-2">
            <form class="d-flex" method="GET" action="index.php">
                <input type="hidden" name="act" value="hanghoa">
                <div class="input-group">
                    <input type="search" name="search" class="form-control" placeholder="Tìm tên áo..." value="<?php echo htmlspecialchars($keyword); ?>" style="font-size: 0.88rem; border-radius: 8px 0 0 8px;">
                    <button class="btn btn-dark" style="border-radius: 0 8px 8px 0;"><i class="fas fa-search"></i></button>
                </div>
            </form>
            <a href="index.php?act=edithanghoa" class="btn-yame-admin py-2">
                <i class="fas fa-plus"></i> Thêm Sản Phẩm Mới
            </a>
        </div>
    </div>

    <?php echo $message; ?>

    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light text-uppercase small" style="letter-spacing: 0.5px;">
                <tr>
                    <th class="ps-3 py-3">Mã</th>
                    <th class="py-3">Hình ảnh</th>
                    <th class="py-3">Tên sản phẩm</th>
                    <th class="py-3">Phân loại</th>
                    <th class="py-3">Giá gốc</th>
                    <th class="py-3">Giá khuyến mãi</th>
                    <th class="py-3 text-center">Tồn kho</th>
                    <th class="py-3 text-center">Nổi bật</th>
                    <th class="pe-3 py-3 text-end">Thao tác</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($ds)): ?>
                    <tr><td colspan="9" class="text-center py-4 text-muted">Không tìm thấy sản phẩm nào phù hợp</td></tr>
                <?php else: ?>
                    <?php foreach ($ds as $item): ?>
                    <tr class="border-bottom">
                        <td class="ps-3 fw-bold text-secondary">#<?php echo $item['id_hanghoa']; ?></td>
                        <td>
                            <?php
                                $imgSrc = 'data:image/svg+xml;base64,' . base64_encode('<svg xmlns="http://www.w3.org/2000/svg" width="60" height="60" viewBox="0 0 60 60"><rect width="60" height="60" fill="#f4f4f5"/><text x="50%" y="55%" dominant-baseline="middle" text-anchor="middle" fill="#a1a1aa" font-size="10" font-family="sans-serif">No img</text></svg>');
                                if (!empty($item['hinh_anh'])) {
                                    $imgSrc = (strpos($item['hinh_anh'], 'http') === 0) ? $item['hinh_anh'] : '../'.$item['hinh_anh'];
                                }
                            ?>
                            <img src="<?php echo $imgSrc; ?>" 
                                 width="54" height="60" class="rounded border shadow-2sm" style="object-fit:cover;">
                        </td>
                        <td>
                            <span class="fw-bold text-dark d-block"><?php echo htmlspecialchars($item['ten_hanghoa']); ?></span>
                            <small class="text-secondary">Ngày thêm: <?php echo date('d/m/Y', strtotime($item['ngay_tao'] ?? 'now')); ?></small>
                        </td>
                        <td>
                            <span class="badge bg-light text-dark border px-2 py-1"><?php echo $item['ten_loai'] ?? 'Áo Thun'; ?></span>
                        </td>
                        <td>
                            <span class="fw-semibold text-dark"><?php echo number_format($item['gia']); ?>đ</span>
                        </td>
                        <td>
                            <?php if ($item['gia_khuyen_mai'] > 0): ?>
                                <span class="fw-bold text-danger"><?php echo number_format($item['gia_khuyen_mai']); ?>đ</span>
                                <small class="badge bg-danger-subtle text-danger ms-1">-<?php echo round((1 - $item['gia_khuyen_mai']/$item['gia'])*100); ?>%</small>
                            <?php else: ?>
                                <span class="text-muted">-</span>
                            <?php endif; ?>
                        </td>
                        <td class="text-center">
                            <span class="badge rounded-pill <?php echo $item['so_luong'] > 10 ? 'bg-success' : 'bg-warning text-dark'; ?> px-2 py-1">
                                <?php echo $item['so_luong']; ?> cái
                            </span>
                        </td>
                        <td class="text-center">
                            <?php if ($item['noi_bat']): ?>
                                <span class="badge rounded-pill bg-danger px-2 py-1"><i class="fas fa-fire me-1"></i> HOT</span>
                            <?php else: ?>
                                <span class="badge rounded-pill bg-light text-secondary border px-2 py-1">Thường</span>
                            <?php endif; ?>
                        </td>
                        <td class="pe-3 text-end">
                            <a href="index.php?act=edithanghoa&id=<?php echo $item['id_hanghoa']; ?>" class="btn btn-sm btn-outline-dark me-1" title="Chỉnh sửa">
                                <i class="fas fa-pen-to-square"></i> Sửa
                            </a>
                            <form method="POST" class="d-inline" onsubmit="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này khỏi hệ thống?')">
                                <input type="hidden" name="delete_id" value="<?php echo $item['id_hanghoa']; ?>">
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

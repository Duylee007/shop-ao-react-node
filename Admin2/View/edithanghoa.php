<?php
require_once dirname(__DIR__, 2) . "/Model/init.php";
require_once dirname(__DIR__, 2) . "/Model/hanghoa.php";

$hh = new HangHoa();
$db = new Database();
$conn = $db->getConnection();

$loai = $conn->query("SELECT * FROM loaihang ORDER BY id_loai")->fetchAll();
$message = '';
$edit = null;

if (isset($_GET['id'])) {
    $edit = $hh->getById((int)$_GET['id']);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $data = [
        'ten_hanghoa' => trim($_POST['ten_hanghoa']),
        'gia' => (float)$_POST['gia'],
        'gia_khuyen_mai' => (float)($_POST['gia_khuyen_mai'] ?? 0),
        'mo_ta' => trim($_POST['mo_ta']),
        'id_loai' => (int)$_POST['id_loai'],
        'so_luong' => (int)$_POST['so_luong'],
        'noi_bat' => isset($_POST['noi_bat']) ? 1 : 0,
        'hinh_anh' => ''
    ];

    // Upload hình an toàn
    if (!empty($_FILES['hinh_anh']['name']) && $_FILES['hinh_anh']['error'] === UPLOAD_ERR_OK) {
        $file = $_FILES['hinh_anh'];
        $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        $allowedExts = ['jpg', 'jpeg', 'png', 'webp', 'gif'];
        if (in_array($ext, $allowedExts)) {
            $filename = uniqid('sp_') . '.' . $ext;
            $uploadDir = dirname(__DIR__, 2) . '/Content/imageaothun/';
            if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);
            move_uploaded_file($file['tmp_name'], $uploadDir . $filename);
            $data['hinh_anh'] = 'Content/imageaothun/' . $filename;
        }
    } elseif ($edit) {
        $data['hinh_anh'] = $edit['hinh_anh'];
    }

    if ($edit) {
        $hh->update($edit['id_hanghoa'], $data);
        $message = '<div class="alert alert-success border-0 shadow-sm rounded-3"><i class="fas fa-check-circle me-2"></i> Cập nhật thông tin sản phẩm thành công!</div>';
        $edit = $hh->getById($edit['id_hanghoa']);
    } else {
        $hh->add($data);
        $message = '<div class="alert alert-success border-0 shadow-sm rounded-3"><i class="fas fa-check-circle me-2"></i> Đã thêm sản phẩm mới thành công!</div>';
    }
}
?>

<div class="table-container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h5 class="fw-bold mb-1" style="font-size: 1.15rem;">
                <?php echo $edit ? '<i class="fas fa-edit text-danger me-2"></i> Cập Nhật Sản Phẩm #'.$edit['id_hanghoa'] : '<i class="fas fa-plus-circle text-danger me-2"></i> Thêm Sản Phẩm Mới'; ?>
            </h5>
            <small class="text-secondary">Điền đầy đủ các thông tin của sản phẩm dưới đây</small>
        </div>
        <a href="index.php?act=hanghoa" class="btn btn-outline-dark btn-sm px-3">
            <i class="fas fa-arrow-left me-1"></i> Quay lại kho
        </a>
    </div>

    <?php echo $message; ?>

    <form method="POST" enctype="multipart/form-data">
        <div class="row g-4">
            <!-- Left inputs -->
            <div class="col-lg-8">
                <div class="p-3 bg-light rounded-3 border mb-3">
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-uppercase">Tên sản phẩm áo thun <span class="text-danger">*</span></label>
                        <input type="text" name="ten_hanghoa" class="form-control" placeholder="Ví dụ: Áo Thun Nam Cổ Tròn Basic..." value="<?php echo $edit ? htmlspecialchars($edit['ten_hanghoa']) : ''; ?>" required>
                    </div>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-uppercase">Giá bán gốc (VNĐ) <span class="text-danger">*</span></label>
                            <input type="number" name="gia" class="form-control" placeholder="199000" value="<?php echo $edit ? $edit['gia'] : ''; ?>" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-uppercase">Giá khuyến mãi (0 nếu không giảm)</label>
                            <input type="number" name="gia_khuyen_mai" class="form-control" placeholder="149000" value="<?php echo $edit ? $edit['gia_khuyen_mai'] : '0'; ?>">
                        </div>
                    </div>
                </div>

                <div class="p-3 bg-light rounded-3 border">
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-uppercase">Mô tả sản phẩm</label>
                        <textarea name="mo_ta" class="form-control" rows="5" placeholder="Thông tin chi tiết về chất liệu, form dáng, cách bảo quản..."><?php echo $edit ? htmlspecialchars($edit['mo_ta']) : ''; ?></textarea>
                    </div>
                </div>
            </div>

            <!-- Right settings & image -->
            <div class="col-lg-4">
                <div class="p-3 bg-light rounded-3 border mb-3">
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-uppercase">Danh mục loại áo</label>
                        <select name="id_loai" class="form-select">
                            <?php foreach ($loai as $l): ?>
                            <option value="<?php echo $l['id_loai']; ?>" <?php echo ($edit && $edit['id_loai']==$l['id_loai']) ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($l['ten_loai']); ?>
                            </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-uppercase">Số lượng nhập kho</label>
                        <input type="number" name="so_luong" class="form-control" value="<?php echo $edit ? $edit['so_luong'] : '100'; ?>">
                    </div>
                    <div class="form-check form-switch mb-2">
                        <input type="checkbox" name="noi_bat" class="form-check-input" id="noibat" <?php echo ($edit && $edit['noi_bat']) ? 'checked' : ''; ?>>
                        <label class="form-check-label fw-bold small text-uppercase" for="noibat">Sản phẩm nổi bật (HOT)</label>
                    </div>
                </div>

                <div class="p-3 bg-light rounded-3 border">
                    <label class="form-label small fw-bold text-uppercase">Hình ảnh sản phẩm</label>
                    <input type="file" name="hinh_anh" class="form-control mb-2" accept="image/*">
                    <?php 
                        $previewImg = '';
                        if ($edit && !empty($edit['hinh_anh'])) {
                            $previewImg = (strpos($edit['hinh_anh'], 'http') === 0) ? $edit['hinh_anh'] : '../'.$edit['hinh_anh'];
                        }
                    ?>
                    <?php if ($previewImg): ?>
                        <div class="mt-2 text-center p-2 bg-white rounded border">
                            <img src="<?php echo $previewImg; ?>" class="img-fluid rounded" style="max-height: 180px; object-fit: cover;">
                            <div class="small text-muted mt-1">Ảnh hiện tại</div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="d-flex gap-2 mt-4 pt-3 border-top">
            <button type="submit" class="btn-yame-admin py-2 px-4">
                <i class="fas fa-save me-1"></i> <?php echo $edit ? 'Lưu Thay Đổi' : 'Thêm Sản Phẩm'; ?>
            </button>
            <a href="index.php?act=hanghoa" class="btn btn-outline-secondary py-2 px-4">Hủy bỏ</a>
        </div>
    </form>
</div>

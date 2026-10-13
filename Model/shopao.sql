-- Database: shopao
-- Website bán áo thun PHP MVC - Shop Áo Thun của Duy

-- Xóa bảng cũ nếu tồn tại
DROP TABLE IF EXISTS chitiet_hoadon;
DROP TABLE IF EXISTS hoadon;
DROP TABLE IF EXISTS hanghoa;
DROP TABLE IF EXISTS password_resets;
DROP TABLE IF EXISTS admin;
DROP TABLE IF EXISTS khachhang;
DROP TABLE IF EXISTS loaihang;

-- Bảng khách hàng
CREATE TABLE khachhang (
    id_khachhang INT AUTO_INCREMENT PRIMARY KEY,
    ten_khachhang VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    dien_thoai VARCHAR(20),
    dia_chi TEXT,
    ngay_dang_ky DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Bảng loại hàng
CREATE TABLE loaihang (
    id_loai INT AUTO_INCREMENT PRIMARY KEY,
    ten_loai VARCHAR(100) NOT NULL,
    mo_ta TEXT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Bảng hàng hóa (sản phẩm)
CREATE TABLE hanghoa (
    id_hanghoa INT AUTO_INCREMENT PRIMARY KEY,
    ten_hanghoa VARCHAR(200) NOT NULL,
    gia DECIMAL(12,2) NOT NULL DEFAULT 0,
    gia_khuyen_mai DECIMAL(12,2) DEFAULT 0,
    hinh_anh VARCHAR(255),
    mo_ta TEXT,
    id_loai INT,
    so_luong INT DEFAULT 0,
    noi_bat TINYINT(1) DEFAULT 0,
    ngay_tao DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_loai) REFERENCES loaihang(id_loai) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Bảng hóa đơn
CREATE TABLE hoadon (
    id_hoadon INT AUTO_INCREMENT PRIMARY KEY,
    id_khachhang INT NOT NULL,
    ngay_dat_hang DATETIME DEFAULT CURRENT_TIMESTAMP,
    tong_tien DECIMAL(12,2) NOT NULL DEFAULT 0,
    trang_thai VARCHAR(50) DEFAULT 'Chờ xác nhận',
    dia_chi_giao TEXT,
    sdt_giao VARCHAR(20),
    ghi_chu TEXT,
    FOREIGN KEY (id_khachhang) REFERENCES khachhang(id_khachhang) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Bảng chi tiết hóa đơn
CREATE TABLE chitiet_hoadon (
    id_ct INT AUTO_INCREMENT PRIMARY KEY,
    id_hoadon INT NOT NULL,
    id_hanghoa INT,
    ten_hanghoa VARCHAR(200),
    so_luong INT NOT NULL DEFAULT 1,
    don_gia DECIMAL(12,2) NOT NULL DEFAULT 0,
    size VARCHAR(10) DEFAULT 'M',
    FOREIGN KEY (id_hoadon) REFERENCES hoadon(id_hoadon) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Bảng admin
CREATE TABLE admin (
    id_admin INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    ten_hien_thi VARCHAR(100),
    ngay_tao DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Bảng password_resets
CREATE TABLE password_resets (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(100) NOT NULL,
    token VARCHAR(255) NOT NULL,
    expires_at DATETIME NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- DỮ LIỆU MẪU
-- ============================================

-- Loại sản phẩm
INSERT INTO loaihang (ten_loai, mo_ta) VALUES
('Áo Nam', 'Các mẫu áo thun nam thờitrang'),
('Áo Nữ', 'Các mẫu áo thun nữ thanh lịch'),
('Áo Unisex', 'Áo thun phù hợp cả nam và nữ'),
('Áo Đôi', 'Áo đôi cho các cặp đôi'),
('Áo Thể Thao', 'Áo thun thể thao, tập gym');

-- Sản phẩm mẫu với ảnh online (đã sửa URL lỗi)
INSERT INTO hanghoa (ten_hanghoa, gia, gia_khuyen_mai, hinh_anh, mo_ta, id_loai, so_luong, noi_bat) VALUES
('Áo Thun Nam Cổ Tròn Basic Trắng', 199000, 149000, 'https://images.unsplash.com/photo-1521572163474-6864f9cf17ab?w=400&h=400&fit=crop', 'Áo thun nam cổ tròn basic màu trắng, chất liệu cotton 100%.', 1, 100, 1),
('Áo Thun Nam Cổ Tròn Basic Đen', 199000, 0, 'https://images.unsplash.com/photo-1618354691373-d851c5c3a990?w=400&h=400&fit=crop', 'Áo thun nam cổ tròn basic màu đen, chất liệu cotton cao cấp.', 1, 80, 1),
('Áo Thun Nam In Hình Streetwear', 299000, 249000, 'https://images.unsplash.com/photo-1583743814966-8936f5b7be1a?w=400&h=400&fit=crop', 'Áo thun nam phong cách streetwear với họa tiết in nổi bật.', 1, 50, 1),
('Áo Thun Nam Polo Xanh Navy', 349000, 299000, 'https://images.unsplash.com/photo-1625910513413-5fc4e5e6727a?w=400&h=400&fit=crop', 'Áo polo nam màu xanh navy, cổ bẻ sang trọng.', 1, 60, 0),
('Áo Thun Nam Tay Dài Đen', 249000, 0, 'https://images.unsplash.com/photo-1618354691373-d851c5c3a990?w=400&h=400&fit=crop', 'Áo thun nam tay dài màu đen, giữ ấm tốt.', 1, 40, 0),

('Áo Thun Nữ Cổ Tròn Basic Trắng', 179000, 129000, 'https://images.unsplash.com/photo-1503342217505-b0a15ec3261c?w=400&h=400&fit=crop', 'Áo thun nữ cổ tròn basic màu trắng, chất liệu cotton mềm mại.', 2, 120, 1),
('Áo Thun Nữ Croptop Hồng Pastel', 219000, 0, 'https://images.unsplash.com/photo-1515886657613-9f3515b0c78f?w=400&h=400&fit=crop', 'Áo thun nữ croptop màu hồng pastel, phong cách trẻ trung.', 2, 80, 1),
('Áo Thun Nữ In Hoa Vintage', 279000, 229000, 'https://images.unsplash.com/photo-1576566588028-4147f3842f27?w=400&h=400&fit=crop', 'Áo thun nữ in hoa phong cách vintage, chất liệu cotton cao cấp.', 2, 45, 1),
('Áo Thun Nữ Oversize Trắng', 229000, 0, 'https://images.unsplash.com/photo-1503342217505-b0a15ec3261c?w=400&h=400&fit=crop', 'Áo thun nữ form oversize màu trắng, phong cách Hàn Quốc.', 2, 70, 0),
('Áo Thun Nữ Tank Top Đen', 159000, 0, 'https://images.unsplash.com/photo-1503341504253-dff4815485f1?w=400&h=400&fit=crop', 'Áo tank top nữ màu đen, phù hợp tập gym, yoga.', 2, 55, 0),

('Áo Thun Unisex Basic Trắng', 189000, 149000, 'https://images.unsplash.com/photo-1521572163474-6864f9cf17ab?w=400&h=400&fit=crop', 'Áo thun unisex basic màu trắng, phù hợp cả nam và nữ.', 3, 150, 1),
('Áo Thun Unisex Basic Đen', 189000, 0, 'https://images.unsplash.com/photo-1618354691373-d851c5c3a990?w=400&h=400&fit=crop', 'Áo thun unisex basic màu đen, form rộng thoải mái.', 3, 130, 1),
('Áo Thun Unisex In Logo Minimal', 249000, 199000, 'https://images.unsplash.com/photo-1583743814966-8936f5b7be1a?w=400&h=400&fit=crop', 'Áo thun unisex in logo minimal, phong cách đơn giản.', 3, 90, 0),
('Áo Thun Unisex Tie Dye', 299000, 0, 'https://images.unsplash.com/photo-1576566588028-4147f3842f27?w=400&h=400&fit=crop', 'Áo thun unisex phong cách tie dye độc đáo.', 3, 35, 0),

('Áo Đôi Nam Nữ Trắng', 349000, 299000, 'https://images.unsplash.com/photo-1521572163474-6864f9cf17ab?w=400&h=400&fit=crop', 'Set áo đôi nam nữ màu trắng, thiết kế đồng điệu.', 4, 40, 1),
('Áo Đôi Nam Nữ Đen', 349000, 0, 'https://images.unsplash.com/photo-1618354691373-d851c5c3a990?w=400&h=400&fit=crop', 'Set áo đôi nam nữ màu đen, phong cách cá tính.', 4, 30, 0),

('Áo Thun Thể Thao Nam Xám', 229000, 189000, 'https://images.unsplash.com/photo-1583743814966-8936f5b7be1a?w=400&h=400&fit=crop', 'Áo thun thể thao nam màu xám, chất liệu thấm hút mồ hôi.', 5, 100, 1),
('Áo Thun Thể Thao Nữ Tím', 229000, 0, 'https://images.unsplash.com/photo-1515886657613-9f3515b0c78f?w=400&h=400&fit=crop', 'Áo thun thể thao nữ màu tím, thiết kế ôm body.', 5, 80, 0);

-- Admin mặc định (username: admin, password: admin123)
INSERT INTO admin (username, password, ten_hien_thi) VALUES
('admin1', 'admin123', 'Quản Trị Viên');

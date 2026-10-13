import { db } from './connection.js';
import bcrypt from 'bcryptjs';

console.log('--- KHỞI TẠO BẢNG CƠ SỞ DỮ LIỆU ---');

// Tạo các bảng
db.exec(`
  DROP TABLE IF EXISTS chitiet_hoadon;
  DROP TABLE IF EXISTS hoadon;
  DROP TABLE IF EXISTS hanghoa;
  DROP TABLE IF EXISTS admin;
  DROP TABLE IF EXISTS khachhang;
  DROP TABLE IF EXISTS loaihang;

  CREATE TABLE loaihang (
    id_loai INTEGER PRIMARY KEY AUTOINCREMENT,
    ten_loai TEXT NOT NULL,
    mo_ta TEXT
  );

  CREATE TABLE hanghoa (
    id_hanghoa INTEGER PRIMARY KEY AUTOINCREMENT,
    ten_hanghoa TEXT NOT NULL,
    gia REAL NOT NULL DEFAULT 0,
    gia_khuyen_mai REAL DEFAULT 0,
    hinh_anh TEXT,
    mo_ta TEXT,
    id_loai INTEGER,
    so_luong INTEGER DEFAULT 0,
    noi_bat INTEGER DEFAULT 0,
    ngay_tao TEXT DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_loai) REFERENCES loaihang(id_loai) ON DELETE SET NULL
  );

  CREATE TABLE khachhang (
    id_khachhang INTEGER PRIMARY KEY AUTOINCREMENT,
    ten_khachhang TEXT NOT NULL,
    email TEXT NOT NULL UNIQUE,
    password TEXT NOT NULL,
    dien_thoai TEXT,
    dia_chi TEXT,
    ngay_dang_ky TEXT DEFAULT CURRENT_TIMESTAMP
  );

  CREATE TABLE hoadon (
    id_hoadon INTEGER PRIMARY KEY AUTOINCREMENT,
    id_khachhang INTEGER NOT NULL,
    ngay_dat_hang TEXT DEFAULT CURRENT_TIMESTAMP,
    tong_tien REAL NOT NULL DEFAULT 0,
    trang_thai TEXT DEFAULT 'Chờ xác nhận',
    dia_chi_giao TEXT,
    sdt_giao TEXT,
    ghi_chu TEXT,
    FOREIGN KEY (id_khachhang) REFERENCES khachhang(id_khachhang) ON DELETE CASCADE
  );

  CREATE TABLE chitiet_hoadon (
    id_ct INTEGER PRIMARY KEY AUTOINCREMENT,
    id_hoadon INTEGER NOT NULL,
    id_hanghoa INTEGER,
    ten_hanghoa TEXT,
    so_luong INTEGER NOT NULL DEFAULT 1,
    don_gia REAL NOT NULL DEFAULT 0,
    size TEXT DEFAULT 'M',
    FOREIGN KEY (id_hoadon) REFERENCES hoadon(id_hoadon) ON DELETE CASCADE
  );

  CREATE TABLE admin (
    id_admin INTEGER PRIMARY KEY AUTOINCREMENT,
    username TEXT NOT NULL UNIQUE,
    password TEXT NOT NULL,
    ten_hien_thi TEXT,
    ngay_tao TEXT DEFAULT CURRENT_TIMESTAMP
  );
`);

console.log('--- NẠP DỮ LIỆU MẪU TỪ SHOPAO.SQL ---');

// Thêm loại hàng
const insertLoai = db.prepare('INSERT INTO loaihang (ten_loai, mo_ta) VALUES (?, ?)');
const categories = [
  ['Áo Nam', 'Các mẫu áo thun nam thời trang'],
  ['Áo Nữ', 'Các mẫu áo thun nữ thanh lịch'],
  ['Áo Unisex', 'Áo thun phù hợp cả nam và nữ'],
  ['Áo Đôi', 'Áo đôi cho các cặp đôi'],
  ['Áo Thể Thao', 'Áo thun thể thao, tập gym']
];
for (const cat of categories) {
  insertLoai.run(...cat);
}

// Thêm hàng hóa
const insertHangHoa = db.prepare(`
  INSERT INTO hanghoa (ten_hanghoa, gia, gia_khuyen_mai, hinh_anh, mo_ta, id_loai, so_luong, noi_bat)
  VALUES (?, ?, ?, ?, ?, ?, ?, ?)
`);

const products = [
  ['Áo Thun Nam Cổ Tròn Basic Trắng', 199000, 149000, 'https://images.unsplash.com/photo-1521572163474-6864f9cf17ab?w=500&h=500&fit=crop', 'Áo thun nam cổ tròn basic màu trắng, chất liệu cotton 100% thấm hút mồ hôi cực tốt.', 1, 100, 1],
  ['Áo Thun Nam Cổ Tròn Basic Đen', 199000, 0, 'https://images.unsplash.com/photo-1618354691373-d851c5c3a990?w=500&h=500&fit=crop', 'Áo thun nam cổ tròn basic màu đen, chất liệu cotton cao cấp co giãn 4 chiều.', 1, 80, 1],
  ['Áo Thun Nam In Hình Streetwear', 299000, 249000, 'https://images.unsplash.com/photo-1583743814966-8936f5b7be1a?w=500&h=500&fit=crop', 'Áo thun nam phong cách streetwear với họa tiết in sắc nét, cá tính.', 1, 50, 1],
  ['Áo Thun Nam Polo Xanh Navy', 349000, 299000, 'https://images.unsplash.com/photo-1625910513413-5fc4e5e6727a?w=500&h=500&fit=crop', 'Áo polo nam màu xanh navy, cổ bẻ sang trọng và lịch lãm.', 1, 60, 0],
  ['Áo Thun Nam Tay Dài Đen', 249000, 0, 'https://images.unsplash.com/photo-1618354691373-d851c5c3a990?w=500&h=500&fit=crop', 'Áo thun nam tay dài màu đen, giữ ấm tốt cho mùa thu đông.', 1, 40, 0],

  ['Áo Thun Nữ Cổ Tròn Basic Trắng', 179000, 129000, 'https://images.unsplash.com/photo-1503342217505-b0a15ec3261c?w=500&h=500&fit=crop', 'Áo thun nữ cổ tròn basic màu trắng, chất liệu cotton mềm mại, tôn dáng.', 2, 120, 1],
  ['Áo Thun Nữ Croptop Hồng Pastel', 219000, 0, 'https://images.unsplash.com/photo-1515886657613-9f3515b0c78f?w=500&h=500&fit=crop', 'Áo thun nữ croptop màu hồng pastel, phong cách trẻ trung năng động.', 2, 80, 1],
  ['Áo Thun Nữ In Hoa Vintage', 279000, 229000, 'https://images.unsplash.com/photo-1576566588028-4147f3842f27?w=500&h=500&fit=crop', 'Áo thun nữ in hoa phong cách vintage, nhẹ nhàng thanh lịch.', 2, 45, 1],
  ['Áo Thun Nữ Oversize Trắng', 229000, 0, 'https://images.unsplash.com/photo-1503342217505-b0a15ec3261c?w=500&h=500&fit=crop', 'Áo thun nữ form oversize màu trắng, phong cách Hàn Quốc thời thượng.', 2, 70, 0],
  ['Áo Thun Nữ Tank Top Đen', 159000, 0, 'https://images.unsplash.com/photo-1503341504253-dff4815485f1?w=500&h=500&fit=crop', 'Áo tank top nữ màu đen, phù hợp tập gym, yoga, dạo phố.', 2, 55, 0],

  ['Áo Thun Unisex Basic Trắng', 189000, 149000, 'https://images.unsplash.com/photo-1521572163474-6864f9cf17ab?w=500&h=500&fit=crop', 'Áo thun unisex basic màu trắng, phù hợp cho cả nam và nữ.', 3, 150, 1],
  ['Áo Thun Unisex Basic Đen', 189000, 0, 'https://images.unsplash.com/photo-1618354691373-d851c5c3a990?w=500&h=500&fit=crop', 'Áo thun unisex basic màu đen, form rộng thoải mái tự tin.', 3, 130, 1],
  ['Áo Thun Unisex In Logo Minimal', 249000, 199000, 'https://images.unsplash.com/photo-1583743814966-8936f5b7be1a?w=500&h=500&fit=crop', 'Áo thun unisex in logo minimal, thiết kế đơn giản tinh tế.', 3, 90, 0],
  ['Áo Thun Unisex Tie Dye', 299000, 0, 'https://images.unsplash.com/photo-1576566588028-4147f3842f27?w=500&h=500&fit=crop', 'Áo thun unisex phong cách tie dye nghệ thuật phá cách.', 3, 35, 0],

  ['Áo Đôi Nam Nữ Trắng', 349000, 299000, 'https://images.unsplash.com/photo-1521572163474-6864f9cf17ab?w=500&h=500&fit=crop', 'Set áo đôi nam nữ màu trắng đồng điệu, thiết kế thanh lịch ngọt ngào.', 4, 40, 1],
  ['Áo Đôi Nam Nữ Đen', 349000, 0, 'https://images.unsplash.com/photo-1618354691373-d851c5c3a990?w=500&h=500&fit=crop', 'Set áo đôi nam nữ màu đen, phong cách cá tính hiện đại.', 4, 30, 0],

  ['Áo Thun Thể Thao Nam Xám', 229000, 189000, 'https://images.unsplash.com/photo-1583743814966-8936f5b7be1a?w=500&h=500&fit=crop', 'Áo thun thể thao nam màu xám, co giãn 4 chiều và thoáng khí tối đa.', 5, 100, 1],
  ['Áo Thun Thể Thao Nữ Tím', 229000, 0, 'https://images.unsplash.com/photo-1515886657613-9f3515b0c78f?w=500&h=500&fit=crop', 'Áo thun thể thao nữ màu tím, kiểu dáng ôm body tôn dáng.', 5, 80, 0]
];

for (const p of products) {
  insertHangHoa.run(...p);
}

// Thêm tài khoản Admin và tài khoản Khách hàng thử nghiệm
const hashPassword = (pwd) => bcrypt.hashSync(pwd, 10);

const insertAdmin = db.prepare('INSERT INTO admin (username, password, ten_hien_thi) VALUES (?, ?, ?)');
insertAdmin.run('admin1', hashPassword('admin123'), 'Quản Trị Viên');

const insertUser = db.prepare(`
  INSERT INTO khachhang (ten_khachhang, email, password, dien_thoai, dia_chi)
  VALUES (?, ?, ?, ?, ?)
`);
insertUser.run('Duy Lê', 'user@gmail.com', hashPassword('123456'), '0987654321', 'TP. Hồ Chí Minh');

console.log('✅ Khởi tạo và nạp dữ liệu CSDL shopao.db hoàn tất!');

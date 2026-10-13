# 🚀 Hướng Dẫn Hệ Thống Shop Áo Thun (ReactJS + NodeJS)

Dự án đã được chuyển đổi hoàn toàn từ **PHP MVC (XAMPP)** sang **ReactJS + NodeJS (Express + SQLite)**. 
Bạn **không cần bật XAMPP** nữa, dự án chạy độc lập 100%.

---

## 📌 1. Địa chỉ truy cập đang chạy

| Dịch vụ | Đường dẫn | Mô tả |
| :--- | :--- | :--- |
| **Giao diện Web (ReactJS)** | [http://localhost:3000](http://localhost:3000) | Mua sắm, giỏ hàng, đặt hàng, quản trị |
| **Backend REST API (NodeJS)** | [http://localhost:5000](http://localhost:5000) | API dữ liệu JSON |
| **Kiểm tra API Health** | [http://localhost:5000/api/health](http://localhost:5000/api/health) | Trạng thái máy chủ backend |

---

## 🔑 2. Tài khoản thử nghiệm có sẵn

- **Quản trị viên (Admin):**
  - Tên đăng nhập: `admin1`
  - Mật khẩu: `admin123`
  - *Quyền hạn:* Quản lý sản phẩm (Thêm/Sửa/Xóa), quản lý đơn hàng (đổi trạng thái giao hàng), thống kê doanh thu.
- **Khách hàng (Customer):**
  - Email: `user@gmail.com`
  - Mật khẩu: `123456`
  - Hoặc bạn có thể tự bấm **Đăng ký** tài khoản mới trên giao diện.

---

## 📁 3. Cấu trúc thư mục mới

```text
DuAnMau/
├── start.bat                   <-- File kích hoạt 1 cú click để chạy cả 2 bên
│
├── server/                     <-- BACKEND (Node.js + Express)
│   ├── database/
│   │   └── shopao.db           <-- CSDL SQLite (đã nạp đủ từ shopao.sql)
│   ├── src/
│   │   ├── controllers/        <-- Logic xử lý (product, auth, order, stats)
│   │   ├── routes/             <-- Định tuyến API (/api/products, /api/orders,...)
│   │   ├── middlewares/        <-- Xác thực JWT & phân quyền Admin
│   │   ├── db/                 <-- Kết nối database & file nạp dữ liệu (seed.js)
│   │   └── index.js            <-- File chạy chính Backend (Port 5000)
│   └── package.json
│
└── client/                     <-- FRONTEND (ReactJS + Vite)
    ├── src/
    │   ├── components/         <-- Header, Hero, ProductCard, Cart, Auth, Admin
    │   ├── index.css           <-- Toàn bộ hệ thống giao diện hiện đại
    │   ├── App.jsx             <-- Giao diện chính điều phối state
    │   └── main.jsx
    ├── index.html
    └── package.json
```

---

## ⚡ 4. Cách chạy lại dự án sau này

### Cách 1: Click đúp vào file `start.bat`
Chỉ cần nhấp đúp chuột vào file [start.bat](file:///c:/XAMPP/htdocs/DuAnMau/start.bat) ở thư mục gốc, hệ thống sẽ tự mở 2 cửa sổ terminal cho Backend & Frontend và tự động mở trình duyệt!

### Cách 2: Mở bằng lệnh dòng lệnh (Terminal)
- **Cửa sổ 1 (Backend):**
  ```bash
  cd server
  npm run dev
  ```
- **Cửa sổ 2 (Frontend):**
  ```bash
  cd client
  npm run dev
  ```

---

## 📦 5. Các tính năng đã hoàn thiện

1. **Khách hàng (Client):**
   - Xem toàn bộ danh sách sản phẩm với hình ảnh và giá khuyến mãi.
   - Lọc sản phẩm theo danh mục (`Áo Nam`, `Áo Nữ`, `Áo Unisex`, `Áo Đôi`, `Áo Thể Thao`).
   - Tìm kiếm trực tiếp theo tên sản phẩm.
   - Sắp xếp theo giá tăng/giảm dần, mới nhất/cũ nhất.
   - Xem chi tiết sản phẩm, chọn size (`S`, `M`, `L`, `XL`, `2XL`), chọn số lượng.
   - Thêm vào giỏ hàng, tăng/giảm số lượng, xóa món.
   - Đặt hàng trực tiếp: Nhập họ tên, SĐT, địa chỉ nhận hàng $\rightarrow$ Lưu đơn và chi tiết vào CSDL.
   - Đăng ký & Đăng nhập tài khoản.
2. **Quản trị viên (Admin Dashboard):**
   - Đăng nhập quyền Admin.
   - Thẻ thống kê: Tổng doanh thu, tổng số đơn hàng, tổng sản phẩm, số khách hàng.
   - Bảng quản lý sản phẩm: Thêm sản phẩm mới, sửa thông tin, xóa sản phẩm.
   - Bảng quản lý đơn hàng: Xem danh sách hóa đơn và đổi trạng thái (`Chờ xác nhận`, `Đang giao hàng`, `Đã hoàn thành`, `Đã hủy`).
   - Xem danh sách danh mục hàng hóa.

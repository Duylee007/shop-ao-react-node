import { db } from '../db/connection.js';

// Tạo đơn hàng mới
export const createOrder = (req, res) => {
  try {
    const {
      dia_chi_giao,
      sdt_giao,
      ghi_chu,
      items = []
    } = req.body;

    // Lấy id khách hàng từ token nếu đã đăng nhập, hoặc người dùng gửi
    const id_khachhang = req.user ? req.user.id : (req.body.id_khachhang || 1);

    if (!items || items.length === 0) {
      return res.status(400).json({ success: false, message: 'Giỏ hàng trống, không thể đặt hàng' });
    }

    if (!dia_chi_giao || !sdt_giao) {
      return res.status(400).json({ success: false, message: 'Vui lòng điền đầy đủ địa chỉ và số điện thoại nhận hàng' });
    }

    // Tính tổng tiền
    let tong_tien = 0;
    for (const item of items) {
      const price = item.gia_khuyen_mai > 0 ? item.gia_khuyen_mai : item.gia || item.don_gia;
      tong_tien += price * (item.quantity || item.so_luong || 1);
    }

    // Lưu vào bảng hoadon
    const insertHoadon = db.prepare(`
      INSERT INTO hoadon (id_khachhang, tong_tien, trang_thai, dia_chi_giao, sdt_giao, ghi_chu)
      VALUES (?, ?, ?, ?, ?, ?)
    `);

    const orderResult = insertHoadon.run(
      id_khachhang,
      tong_tien,
      'Chờ xác nhận',
      dia_chi_giao,
      sdt_giao,
      ghi_chu || ''
    );

    const id_hoadon = orderResult.lastInsertRowid;

    // Lưu chi tiết từng món vào bảng chitiet_hoadon
    const insertChiTiet = db.prepare(`
      INSERT INTO chitiet_hoadon (id_hoadon, id_hanghoa, ten_hanghoa, so_luong, don_gia, size)
      VALUES (?, ?, ?, ?, ?, ?)
    `);

    for (const item of items) {
      const price = item.gia_khuyen_mai > 0 ? item.gia_khuyen_mai : item.gia || item.don_gia;
      const qty = item.quantity || item.so_luong || 1;
      insertChiTiet.run(
        id_hoadon,
        item.id_hanghoa || null,
        item.ten_hanghoa || item.name || '',
        qty,
        price,
        item.size || 'M'
      );
    }

    res.status(201).json({
      success: true,
      message: 'Đặt hàng thành công!',
      orderId: id_hoadon,
      total: tong_tien
    });
  } catch (error) {
    res.status(500).json({ success: false, message: 'Lỗi server: ' + error.message });
  }
};

// Lấy danh sách đơn hàng của khách hàng đang đăng nhập
export const getMyOrders = (req, res) => {
  try {
    const id_khachhang = req.user.id;
    const orders = db.prepare(`
      SELECT * FROM hoadon
      WHERE id_khachhang = ?
      ORDER BY id_hoadon DESC
    `).all(id_khachhang);

    // Ghép chi tiết từng đơn
    const getItems = db.prepare('SELECT * FROM chitiet_hoadon WHERE id_hoadon = ?');
    const fullOrders = orders.map(order => ({
      ...order,
      items: getItems.all(order.id_hoadon)
    }));

    res.json({ success: true, orders: fullOrders });
  } catch (error) {
    res.status(500).json({ success: false, message: 'Lỗi server: ' + error.message });
  }
};

// Admin: Lấy tất cả đơn hàng
export const getAllOrders = (req, res) => {
  try {
    const orders = db.prepare(`
      SELECT h.*, k.ten_khachhang, k.email
      FROM hoadon h
      LEFT JOIN khachhang k ON h.id_khachhang = k.id_khachhang
      ORDER BY h.id_hoadon DESC
    `).all();

    const getItems = db.prepare('SELECT * FROM chitiet_hoadon WHERE id_hoadon = ?');
    const fullOrders = orders.map(order => ({
      ...order,
      items: getItems.all(order.id_hoadon)
    }));

    res.json({ success: true, orders: fullOrders });
  } catch (error) {
    res.status(500).json({ success: false, message: 'Lỗi server: ' + error.message });
  }
};

// Admin: Cập nhật trạng thái đơn hàng
export const updateOrderStatus = (req, res) => {
  try {
    const { id } = req.params;
    const { trang_thai } = req.body;

    const existing = db.prepare('SELECT * FROM hoadon WHERE id_hoadon = ?').get(id);
    if (!existing) {
      return res.status(404).json({ success: false, message: 'Không tìm thấy đơn hàng' });
    }

    db.prepare('UPDATE hoadon SET trang_thai = ? WHERE id_hoadon = ?').run(trang_thai, id);
    res.json({ success: true, message: 'Cập nhật trạng thái đơn hàng thành công' });
  } catch (error) {
    res.status(500).json({ success: false, message: 'Lỗi server: ' + error.message });
  }
};

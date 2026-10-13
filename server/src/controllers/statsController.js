import { db } from '../db/connection.js';

export const getDashboardStats = (req, res) => {
  try {
    const totalProducts = db.prepare('SELECT COUNT(*) as c FROM hanghoa').get().c;
    const totalCategories = db.prepare('SELECT COUNT(*) as c FROM loaihang').get().c;
    const totalOrders = db.prepare('SELECT COUNT(*) as c FROM hoadon').get().c;
    const totalCustomers = db.prepare('SELECT COUNT(*) as c FROM khachhang').get().c;
    const revenueRow = db.prepare("SELECT SUM(tong_tien) as total FROM hoadon WHERE trang_thai != 'Đã hủy'").get();
    const totalRevenue = revenueRow.total || 0;

    // Doanh số theo trạng thái
    const ordersByStatus = db.prepare(`
      SELECT trang_thai, COUNT(*) as count
      FROM hoadon
      GROUP BY trang_thai
    `).all();

    // Top 5 sản phẩm bán chạy hoặc nổi bật
    const topProducts = db.prepare(`
      SELECT h.id_hanghoa, h.ten_hanghoa, h.gia, h.hinh_anh, h.so_luong, l.ten_loai
      FROM hanghoa h
      LEFT JOIN loaihang l ON h.id_loai = l.id_loai
      WHERE h.noi_bat = 1
      LIMIT 5
    `).all();

    res.json({
      success: true,
      stats: {
        totalProducts,
        totalCategories,
        totalOrders,
        totalCustomers,
        totalRevenue
      },
      ordersByStatus,
      topProducts
    });
  } catch (error) {
    res.status(500).json({ success: false, message: 'Lỗi server: ' + error.message });
  }
};

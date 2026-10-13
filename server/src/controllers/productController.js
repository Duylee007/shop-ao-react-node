import { db } from '../db/connection.js';

// Lấy danh sách sản phẩm (có tìm kiếm, lọc theo loại, sắp xếp, phân trang)
export const getProducts = (req, res) => {
  try {
    const {
      page = 1,
      limit = 12,
      category,
      search,
      featured,
      sort = 'latest'
    } = req.query;

    const pageNum = parseInt(page, 10) || 1;
    const limitNum = parseInt(limit, 10) || 12;
    const offset = (pageNum - 1) * limitNum;

    let whereConditions = [];
    let params = [];

    if (category) {
      whereConditions.push('h.id_loai = ?');
      params.push(category);
    }

    if (search) {
      whereConditions.push('(h.ten_hanghoa LIKE ? OR h.mo_ta LIKE ?)');
      params.push(`%${search}%`, `%${search}%`);
    }

    if (featured !== undefined && featured !== '') {
      whereConditions.push('h.noi_bat = ?');
      params.push(featured === 'true' || featured === '1' ? 1 : 0);
    }

    const whereClause = whereConditions.length > 0 ? `WHERE ${whereConditions.join(' AND ')}` : '';

    // Sắp xếp
    let orderByClause = 'ORDER BY h.id_hanghoa DESC';
    if (sort === 'price-asc') {
      orderByClause = 'ORDER BY (CASE WHEN h.gia_khuyen_mai > 0 THEN h.gia_khuyen_mai ELSE h.gia END) ASC';
    } else if (sort === 'price-desc') {
      orderByClause = 'ORDER BY (CASE WHEN h.gia_khuyen_mai > 0 THEN h.gia_khuyen_mai ELSE h.gia END) DESC';
    } else if (sort === 'oldest') {
      orderByClause = 'ORDER BY h.id_hanghoa ASC';
    }

    // Đếm tổng số lượng
    const countQuery = `SELECT COUNT(*) as total FROM hanghoa h ${whereClause}`;
    const totalRow = db.prepare(countQuery).get(...params);
    const total = totalRow.total;

    // Lấy dữ liệu phân trang kèm thông tin loại hàng
    const dataQuery = `
      SELECT h.*, l.ten_loai
      FROM hanghoa h
      LEFT JOIN loaihang l ON h.id_loai = l.id_loai
      ${whereClause}
      ${orderByClause}
      LIMIT ? OFFSET ?
    `;

    const products = db.prepare(dataQuery).all(...params, limitNum, offset);

    res.json({
      success: true,
      products,
      pagination: {
        total,
        page: pageNum,
        limit: limitNum,
        totalPages: Math.ceil(total / limitNum)
      }
    });
  } catch (error) {
    res.status(500).json({ success: false, message: 'Lỗi server: ' + error.message });
  }
};

// Chi tiết 1 sản phẩm
export const getProductById = (req, res) => {
  try {
    const { id } = req.params;
    const query = `
      SELECT h.*, l.ten_loai
      FROM hanghoa h
      LEFT JOIN loaihang l ON h.id_loai = l.id_loai
      WHERE h.id_hanghoa = ?
    `;
    const product = db.prepare(query).get(id);

    if (!product) {
      return res.status(404).json({ success: false, message: 'Không tìm thấy sản phẩm' });
    }

    // Lấy sản phẩm liên quan cùng loại
    const related = db.prepare(`
      SELECT h.*, l.ten_loai
      FROM hanghoa h
      LEFT JOIN loaihang l ON h.id_loai = l.id_loai
      WHERE h.id_loai = ? AND h.id_hanghoa != ?
      LIMIT 4
    `).all(product.id_loai, id);

    res.json({ success: true, product, related });
  } catch (error) {
    res.status(500).json({ success: false, message: 'Lỗi server: ' + error.message });
  }
};

// Thêm sản phẩm mới (Admin)
export const createProduct = (req, res) => {
  try {
    const {
      ten_hanghoa,
      gia,
      gia_khuyen_mai,
      hinh_anh,
      mo_ta,
      id_loai,
      so_luong,
      noi_bat
    } = req.body;

    if (!ten_hanghoa || gia === undefined) {
      return res.status(400).json({ success: false, message: 'Tên hàng hóa và giá là bắt buộc' });
    }

    const insert = db.prepare(`
      INSERT INTO hanghoa (ten_hanghoa, gia, gia_khuyen_mai, hinh_anh, mo_ta, id_loai, so_luong, noi_bat)
      VALUES (?, ?, ?, ?, ?, ?, ?, ?)
    `);

    const result = insert.run(
      ten_hanghoa,
      parseFloat(gia) || 0,
      parseFloat(gia_khuyen_mai) || 0,
      hinh_anh || 'https://images.unsplash.com/photo-1521572163474-6864f9cf17ab?w=500&h=500&fit=crop',
      mo_ta || '',
      id_loai ? parseInt(id_loai, 10) : null,
      parseInt(so_luong, 10) || 0,
      noi_bat ? 1 : 0
    );

    const newProduct = db.prepare('SELECT * FROM hanghoa WHERE id_hanghoa = ?').get(result.lastInsertRowid);
    res.status(201).json({ success: true, message: 'Thêm sản phẩm thành công', product: newProduct });
  } catch (error) {
    res.status(500).json({ success: false, message: 'Lỗi server: ' + error.message });
  }
};

// Cập nhật sản phẩm (Admin)
export const updateProduct = (req, res) => {
  try {
    const { id } = req.params;
    const {
      ten_hanghoa,
      gia,
      gia_khuyen_mai,
      hinh_anh,
      mo_ta,
      id_loai,
      so_luong,
      noi_bat
    } = req.body;

    const existing = db.prepare('SELECT * FROM hanghoa WHERE id_hanghoa = ?').get(id);
    if (!existing) {
      return res.status(404).json({ success: false, message: 'Không tìm thấy sản phẩm' });
    }

    db.prepare(`
      UPDATE hanghoa
      SET ten_hanghoa = ?, gia = ?, gia_khuyen_mai = ?, hinh_anh = ?, mo_ta = ?, id_loai = ?, so_luong = ?, noi_bat = ?
      WHERE id_hanghoa = ?
    `).run(
      ten_hanghoa !== undefined ? ten_hanghoa : existing.ten_hanghoa,
      gia !== undefined ? parseFloat(gia) : existing.gia,
      gia_khuyen_mai !== undefined ? parseFloat(gia_khuyen_mai) : existing.gia_khuyen_mai,
      hinh_anh !== undefined ? hinh_anh : existing.hinh_anh,
      mo_ta !== undefined ? mo_ta : existing.mo_ta,
      id_loai !== undefined ? (id_loai ? parseInt(id_loai, 10) : null) : existing.id_loai,
      so_luong !== undefined ? parseInt(so_luong, 10) : existing.so_luong,
      noi_bat !== undefined ? (noi_bat ? 1 : 0) : existing.noi_bat,
      id
    );

    const updated = db.prepare('SELECT * FROM hanghoa WHERE id_hanghoa = ?').get(id);
    res.json({ success: true, message: 'Cập nhật sản phẩm thành công', product: updated });
  } catch (error) {
    res.status(500).json({ success: false, message: 'Lỗi server: ' + error.message });
  }
};

// Xóa sản phẩm (Admin)
export const deleteProduct = (req, res) => {
  try {
    const { id } = req.params;
    const existing = db.prepare('SELECT * FROM hanghoa WHERE id_hanghoa = ?').get(id);
    if (!existing) {
      return res.status(404).json({ success: false, message: 'Không tìm thấy sản phẩm' });
    }

    db.prepare('DELETE FROM hanghoa WHERE id_hanghoa = ?').run(id);
    res.json({ success: true, message: 'Xóa sản phẩm thành công' });
  } catch (error) {
    res.status(500).json({ success: false, message: 'Lỗi server: ' + error.message });
  }
};

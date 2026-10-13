import { db } from '../db/connection.js';

// Lấy tất cả loại hàng kèm số lượng sản phẩm
export const getCategories = (req, res) => {
  try {
    const query = `
      SELECT l.id_loai, l.ten_loai, l.mo_ta, COUNT(h.id_hanghoa) AS so_san_pham
      FROM loaihang l
      LEFT JOIN hanghoa h ON l.id_loai = h.id_loai
      GROUP BY l.id_loai
      ORDER BY l.id_loai ASC
    `;
    const categories = db.prepare(query).all();
    res.json({ success: true, categories });
  } catch (error) {
    res.status(500).json({ success: false, message: 'Lỗi server: ' + error.message });
  }
};

// Thêm loại hàng mới (Admin)
export const createCategory = (req, res) => {
  try {
    const { ten_loai, mo_ta } = req.body;
    if (!ten_loai) {
      return res.status(400).json({ success: false, message: 'Tên loại hàng không được để trống' });
    }

    const insert = db.prepare('INSERT INTO loaihang (ten_loai, mo_ta) VALUES (?, ?)');
    const result = insert.run(ten_loai, mo_ta || '');
    const newCategory = db.prepare('SELECT * FROM loaihang WHERE id_loai = ?').get(result.lastInsertRowid);

    res.status(201).json({ success: true, message: 'Thêm loại hàng thành công', category: newCategory });
  } catch (error) {
    res.status(500).json({ success: false, message: 'Lỗi server: ' + error.message });
  }
};

// Cập nhật loại hàng (Admin)
export const updateCategory = (req, res) => {
  try {
    const { id } = req.params;
    const { ten_loai, mo_ta } = req.body;

    const existing = db.prepare('SELECT * FROM loaihang WHERE id_loai = ?').get(id);
    if (!existing) {
      return res.status(404).json({ success: false, message: 'Không tìm thấy loại hàng' });
    }

    db.prepare('UPDATE loaihang SET ten_loai = ?, mo_ta = ? WHERE id_loai = ?').run(
      ten_loai || existing.ten_loai,
      mo_ta !== undefined ? mo_ta : existing.mo_ta,
      id
    );

    const updated = db.prepare('SELECT * FROM loaihang WHERE id_loai = ?').get(id);
    res.json({ success: true, message: 'Cập nhật loại hàng thành công', category: updated });
  } catch (error) {
    res.status(500).json({ success: false, message: 'Lỗi server: ' + error.message });
  }
};

// Xóa loại hàng (Admin)
export const deleteCategory = (req, res) => {
  try {
    const { id } = req.params;
    const existing = db.prepare('SELECT * FROM loaihang WHERE id_loai = ?').get(id);
    if (!existing) {
      return res.status(404).json({ success: false, message: 'Không tìm thấy loại hàng' });
    }

    db.prepare('DELETE FROM loaihang WHERE id_loai = ?').run(id);
    res.json({ success: true, message: 'Xóa loại hàng thành công' });
  } catch (error) {
    res.status(500).json({ success: false, message: 'Lỗi server: ' + error.message });
  }
};

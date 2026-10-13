import React, { useState, useEffect } from 'react';
import {
  Package,
  Layers,
  ShoppingBag,
  Users,
  DollarSign,
  Plus,
  Trash2,
  Edit,
  ArrowLeft,
  CheckCircle,
  Clock,
  Truck,
  XCircle,
  Save,
  X
} from 'lucide-react';

const formatCurrency = (val) => {
  return new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(val);
};

export default function AdminDashboard({ onBackToShop, showToast }) {
  const [activeTab, setActiveTab] = useState('stats'); // 'stats' | 'products' | 'orders' | 'categories'
  const [stats, setStats] = useState(null);
  const [products, setProducts] = useState([]);
  const [categories, setCategories] = useState([]);
  const [orders, setOrders] = useState([]);
  const [loading, setLoading] = useState(false);

  // Modal thêm/sửa sản phẩm
  const [isProductModalOpen, setIsProductModalOpen] = useState(false);
  const [editingProduct, setEditingProduct] = useState(null);
  const [productForm, setProductForm] = useState({
    ten_hanghoa: '',
    gia: '',
    gia_khuyen_mai: '',
    hinh_anh: '',
    mo_ta: '',
    id_loai: '',
    so_luong: 100,
    noi_bat: 1
  });

  const getHeaders = () => {
    const token = localStorage.getItem('shopao_token');
    return {
      'Content-Type': 'application/json',
      Authorization: `Bearer ${token}`
    };
  };

  // Load Data
  const loadStats = async () => {
    try {
      const res = await fetch('/api/stats', { headers: getHeaders() });
      const data = await res.json();
      if (data.success) setStats(data.stats);
    } catch (e) {
      console.error(e);
    }
  };

  const loadProducts = async () => {
    try {
      const res = await fetch('/api/products?limit=100');
      const data = await res.json();
      if (data.success) setProducts(data.products);
    } catch (e) {
      console.error(e);
    }
  };

  const loadCategories = async () => {
    try {
      const res = await fetch('/api/categories');
      const data = await res.json();
      if (data.success) setCategories(data.categories);
    } catch (e) {
      console.error(e);
    }
  };

  const loadOrders = async () => {
    try {
      const res = await fetch('/api/orders', { headers: getHeaders() });
      const data = await res.json();
      if (data.success) setOrders(data.orders);
    } catch (e) {
      console.error(e);
    }
  };

  useEffect(() => {
    loadStats();
    loadProducts();
    loadCategories();
    loadOrders();
  }, []);

  // Submit Product Form
  const handleSaveProduct = async (e) => {
    e.preventDefault();
    setLoading(true);
    try {
      const url = editingProduct
        ? `/api/products/${editingProduct.id_hanghoa}`
        : '/api/products';
      const method = editingProduct ? 'PUT' : 'POST';

      const res = await fetch(url, {
        method,
        headers: getHeaders(),
        body: JSON.stringify(productForm)
      });
      const data = await res.json();
      if (data.success) {
        showToast(editingProduct ? 'Cập nhật sản phẩm thành công!' : 'Thêm sản phẩm thành công!');
        setIsProductModalOpen(false);
        setEditingProduct(null);
        loadProducts();
        loadStats();
      } else {
        alert(data.message || 'Lỗi khi lưu sản phẩm');
      }
    } catch (err) {
      alert('Lỗi: ' + err.message);
    } finally {
      setLoading(false);
    }
  };

  // Delete Product
  const handleDeleteProduct = async (id) => {
    if (!window.confirm('Bạn có chắc chắn muốn xóa sản phẩm này?')) return;
    try {
      const res = await fetch(`/api/products/${id}`, {
        method: 'DELETE',
        headers: getHeaders()
      });
      const data = await res.json();
      if (data.success) {
        showToast('Đã xóa sản phẩm!');
        loadProducts();
        loadStats();
      }
    } catch (err) {
      alert('Lỗi: ' + err.message);
    }
  };

  // Change Order Status
  const handleUpdateOrderStatus = async (id, status) => {
    try {
      const res = await fetch(`/api/orders/${id}/status`, {
        method: 'PUT',
        headers: getHeaders(),
        body: JSON.stringify({ trang_thai: status })
      });
      const data = await res.json();
      if (data.success) {
        showToast(`Đơn hàng #${id} đổi thành: ${status}`);
        loadOrders();
        loadStats();
      }
    } catch (err) {
      alert('Lỗi: ' + err.message);
    }
  };

  const openAddProduct = () => {
    setEditingProduct(null);
    setProductForm({
      ten_hanghoa: '',
      gia: '',
      gia_khuyen_mai: '',
      hinh_anh: 'https://images.unsplash.com/photo-1521572163474-6864f9cf17ab?w=500&h=500&fit=crop',
      mo_ta: '',
      id_loai: categories.length > 0 ? categories[0].id_loai : '1',
      so_luong: 100,
      noi_bat: 1
    });
    setIsProductModalOpen(true);
  };

  const openEditProduct = (p) => {
    setEditingProduct(p);
    setProductForm({
      ten_hanghoa: p.ten_hanghoa,
      gia: p.gia,
      gia_khuyen_mai: p.gia_khuyen_mai,
      hinh_anh: p.hinh_anh,
      mo_ta: p.mo_ta || '',
      id_loai: p.id_loai || '',
      so_luong: p.so_luong || 0,
      noi_bat: p.noi_bat || 0
    });
    setIsProductModalOpen(true);
  };

  return (
    <div style={{ padding: '2rem 1.5rem', maxWidth: '1300px', margin: '0 auto' }}>
      {/* Top Header */}
      <div style={{ display: 'flex', alignItems: 'center', justifyContent: 'space-between', marginBottom: '2rem', flexWrap: 'wrap', gap: '1rem' }}>
        <div style={{ display: 'flex', alignItems: 'center', gap: '1rem' }}>
          <button className="btn-outline" onClick={onBackToShop} style={{ padding: '0.5rem 1rem' }}>
            <ArrowLeft size={18} /> Về Cửa Hàng
          </button>
          <h1 style={{ fontSize: '1.8rem', fontWeight: 800 }}>
            Quản Trị Hệ Thống <span style={{ color: '#ec4899', fontSize: '1rem' }}>(Admin Panel)</span>
          </h1>
        </div>

        {activeTab === 'products' && (
          <button className="btn-primary" onClick={openAddProduct}>
            <Plus size={18} /> Thêm Sản Phẩm Mới
          </button>
        )}
      </div>

      {/* Tabs */}
      <div style={{ display: 'flex', gap: '0.75rem', marginBottom: '2rem', borderBottom: '1px solid var(--border-subtle)', paddingBottom: '0.75rem' }}>
        {[
          { id: 'stats', label: 'Thống kê Tổng quan', icon: DollarSign },
          { id: 'products', label: `Sản phẩm (${products.length})`, icon: Package },
          { id: 'orders', label: `Đơn hàng (${orders.length})`, icon: ShoppingBag },
          { id: 'categories', label: `Danh mục (${categories.length})`, icon: Layers }
        ].map((t) => {
          const Icon = t.icon;
          const isActive = activeTab === t.id;
          return (
            <button
              key={t.id}
              onClick={() => setActiveTab(t.id)}
              style={{
                display: 'flex',
                alignItems: 'center',
                gap: '0.5rem',
                padding: '0.65rem 1.25rem',
                borderRadius: '8px',
                border: 'none',
                background: isActive ? 'var(--primary)' : 'rgba(255,255,255,0.05)',
                color: isActive ? '#fff' : 'var(--text-muted)',
                fontWeight: 600,
                fontSize: '0.92rem',
                cursor: 'pointer'
              }}
            >
              <Icon size={17} /> {t.label}
            </button>
          );
        })}
      </div>

      {/* TAB 1: STATS */}
      {activeTab === 'stats' && stats && (
        <div>
          <div style={{ display: 'grid', gridTemplateColumns: 'repeat(auto-fit, minmax(220px, 1fr))', gap: '1.25rem', marginBottom: '2rem' }}>
            <div style={{ background: 'var(--bg-surface)', padding: '1.5rem', borderRadius: '16px', border: '1px solid var(--border-subtle)' }}>
              <div style={{ color: 'var(--text-muted)', fontSize: '0.85rem', marginBottom: '0.5rem' }}>TỔNG DOANH THU</div>
              <div style={{ fontSize: '1.75rem', fontWeight: 800, color: '#10b981' }}>{formatCurrency(stats.totalRevenue)}</div>
            </div>

            <div style={{ background: 'var(--bg-surface)', padding: '1.5rem', borderRadius: '16px', border: '1px solid var(--border-subtle)' }}>
              <div style={{ color: 'var(--text-muted)', fontSize: '0.85rem', marginBottom: '0.5rem' }}>TỔNG ĐƠN HÀNG</div>
              <div style={{ fontSize: '1.75rem', fontWeight: 800, color: '#818cf8' }}>{stats.totalOrders} đơn</div>
            </div>

            <div style={{ background: 'var(--bg-surface)', padding: '1.5rem', borderRadius: '16px', border: '1px solid var(--border-subtle)' }}>
              <div style={{ color: 'var(--text-muted)', fontSize: '0.85rem', marginBottom: '0.5rem' }}>TỔNG SẢN PHẨM</div>
              <div style={{ fontSize: '1.75rem', fontWeight: 800, color: '#f59e0b' }}>{stats.totalProducts} mặt hàng</div>
            </div>

            <div style={{ background: 'var(--bg-surface)', padding: '1.5rem', borderRadius: '16px', border: '1px solid var(--border-subtle)' }}>
              <div style={{ color: 'var(--text-muted)', fontSize: '0.85rem', marginBottom: '0.5rem' }}>KHÁCH HÀNG ĐĂNG KÝ</div>
              <div style={{ fontSize: '1.75rem', fontWeight: 800, color: '#ec4899' }}>{stats.totalCustomers} tài khoản</div>
            </div>
          </div>

          <div style={{ background: 'var(--bg-surface)', padding: '1.5rem', borderRadius: '16px', border: '1px solid var(--border-subtle)' }}>
            <h3 style={{ fontSize: '1.15rem', fontWeight: 700, marginBottom: '1rem' }}>Đơn hàng mới nhất</h3>
            <div className="data-table-wrap">
              <table className="data-table">
                <thead>
                  <tr>
                    <th>Mã đơn</th>
                    <th>Khách hàng</th>
                    <th>Tổng tiền</th>
                    <th>Trạng thái</th>
                    <th>Ngày đặt</th>
                  </tr>
                </thead>
                <tbody>
                  {orders.slice(0, 5).map((o) => (
                    <tr key={o.id_hoadon}>
                      <td>#{o.id_hoadon}</td>
                      <td>{o.ten_khachhang || 'Khách vãng lai'}</td>
                      <td style={{ fontWeight: 700 }}>{formatCurrency(o.tong_tien)}</td>
                      <td>
                        <span style={{ padding: '0.2rem 0.6rem', borderRadius: '99px', fontSize: '0.78rem', background: o.trang_thai === 'Đã hoàn thành' ? 'rgba(16,185,129,0.2)' : 'rgba(245,158,11,0.2)', color: o.trang_thai === 'Đã hoàn thành' ? '#10b981' : '#f59e0b' }}>
                          {o.trang_thai}
                        </span>
                      </td>
                      <td style={{ color: 'var(--text-dim)', fontSize: '0.85rem' }}>{o.ngay_dat_hang}</td>
                    </tr>
                  ))}
                </tbody>
              </table>
            </div>
          </div>
        </div>
      )}

      {/* TAB 2: PRODUCTS */}
      {activeTab === 'products' && (
        <div className="data-table-wrap">
          <table className="data-table">
            <thead>
              <tr>
                <th>Ảnh</th>
                <th>Tên sản phẩm</th>
                <th>Loại</th>
                <th>Giá bán</th>
                <th>Giá KM</th>
                <th>Kho</th>
                <th>Nổi bật</th>
                <th>Thao tác</th>
              </tr>
            </thead>
            <tbody>
              {products.map((p) => (
                <tr key={p.id_hanghoa}>
                  <td>
                    <img src={p.hinh_anh} alt="" style={{ width: 44, height: 44, borderRadius: 8, objectFit: 'cover' }} />
                  </td>
                  <td style={{ fontWeight: 600, maxWidth: 260 }}>{p.ten_hanghoa}</td>
                  <td><span style={{ color: '#818cf8' }}>{p.ten_loai}</span></td>
                  <td>{formatCurrency(p.gia)}</td>
                  <td style={{ color: p.gia_khuyen_mai > 0 ? '#10b981' : 'var(--text-dim)' }}>
                    {p.gia_khuyen_mai > 0 ? formatCurrency(p.gia_khuyen_mai) : '-'}
                  </td>
                  <td>{p.so_luong}</td>
                  <td>{p.noi_bat ? '⭐ Có' : 'Không'}</td>
                  <td>
                    <div style={{ display: 'flex', gap: '0.4rem' }}>
                      <button
                        className="btn-icon"
                        style={{ width: 32, height: 32 }}
                        onClick={() => openEditProduct(p)}
                        title="Sửa"
                      >
                        <Edit size={15} />
                      </button>
                      <button
                        className="btn-icon"
                        style={{ width: 32, height: 32, color: '#ef4444' }}
                        onClick={() => handleDeleteProduct(p.id_hanghoa)}
                        title="Xóa"
                      >
                        <Trash2 size={15} />
                      </button>
                    </div>
                  </td>
                </tr>
              ))}
            </tbody>
          </table>
        </div>
      )}

      {/* TAB 3: ORDERS */}
      {activeTab === 'orders' && (
        <div className="data-table-wrap">
          <table className="data-table">
            <thead>
              <tr>
                <th>Mã đơn</th>
                <th>Khách hàng & SĐT</th>
                <th>Địa chỉ giao hàng</th>
                <th>Sản phẩm</th>
                <th>Tổng tiền</th>
                <th>Trạng thái</th>
                <th>Đổi trạng thái</th>
              </tr>
            </thead>
            <tbody>
              {orders.map((o) => (
                <tr key={o.id_hoadon}>
                  <td><strong>#{o.id_hoadon}</strong></td>
                  <td>
                    <div>{o.ten_khachhang || 'Khách mua'}</div>
                    <div style={{ fontSize: '0.8rem', color: 'var(--text-muted)' }}>{o.sdt_giao}</div>
                  </td>
                  <td style={{ maxWidth: 220, fontSize: '0.85rem' }}>{o.dia_chi_giao}</td>
                  <td>
                    {o.items && o.items.map((it, idx) => (
                      <div key={idx} style={{ fontSize: '0.8rem', color: 'var(--text-muted)' }}>
                        • {it.ten_hanghoa} (Size {it.size} x{it.so_luong})
                      </div>
                    ))}
                  </td>
                  <td style={{ fontWeight: 700, color: '#fff' }}>{formatCurrency(o.tong_tien)}</td>
                  <td>
                    <span style={{ padding: '0.2rem 0.6rem', borderRadius: '99px', fontSize: '0.78rem', background: o.trang_thai === 'Đã hoàn thành' ? 'rgba(16,185,129,0.2)' : o.trang_thai === 'Đã hủy' ? 'rgba(239,68,68,0.2)' : 'rgba(245,158,11,0.2)', color: o.trang_thai === 'Đã hoàn thành' ? '#10b981' : o.trang_thai === 'Đã hủy' ? '#ef4444' : '#f59e0b' }}>
                      {o.trang_thai}
                    </span>
                  </td>
                  <td>
                    <select
                      className="form-select"
                      style={{ padding: '0.35rem 0.6rem', fontSize: '0.82rem', width: 'auto' }}
                      value={o.trang_thai}
                      onChange={(e) => handleUpdateOrderStatus(o.id_hoadon, e.target.value)}
                    >
                      <option value="Chờ xác nhận">Chờ xác nhận</option>
                      <option value="Đang giao hàng">Đang giao hàng</option>
                      <option value="Đã hoàn thành">Đã hoàn thành</option>
                      <option value="Đã hủy">Đã hủy</option>
                    </select>
                  </td>
                </tr>
              ))}
            </tbody>
          </table>
        </div>
      )}

      {/* TAB 4: CATEGORIES */}
      {activeTab === 'categories' && (
        <div className="data-table-wrap">
          <table className="data-table">
            <thead>
              <tr>
                <th>ID</th>
                <th>Tên loại hàng</th>
                <th>Mô tả</th>
                <th>Số lượng sản phẩm</th>
              </tr>
            </thead>
            <tbody>
              {categories.map((c) => (
                <tr key={c.id_loai}>
                  <td>#{c.id_loai}</td>
                  <td style={{ fontWeight: 700 }}>{c.ten_loai}</td>
                  <td style={{ color: 'var(--text-muted)' }}>{c.mo_ta}</td>
                  <td><span style={{ color: '#818cf8', fontWeight: 600 }}>{c.so_san_pham}</span> sản phẩm</td>
                </tr>
              ))}
            </tbody>
          </table>
        </div>
      )}

      {/* MODAL THÊM / SỬA SẢN PHẨM */}
      {isProductModalOpen && (
        <div className="modal-overlay" onClick={() => setIsProductModalOpen(false)}>
          <div className="modal-card" onClick={(e) => e.stopPropagation()}>
            <div className="modal-header">
              <h3 style={{ fontSize: '1.2rem', fontWeight: 700 }}>
                {editingProduct ? 'Chỉnh sửa sản phẩm' : 'Thêm sản phẩm mới'}
              </h3>
              <button className="modal-close-btn" onClick={() => setIsProductModalOpen(false)}>
                <X size={22} />
              </button>
            </div>

            <form onSubmit={handleSaveProduct} className="modal-body">
              <div className="form-group">
                <label className="form-label">Tên sản phẩm *</label>
                <input
                  type="text"
                  className="form-input"
                  required
                  value={productForm.ten_hanghoa}
                  onChange={(e) => setProductForm({ ...productForm, ten_hanghoa: e.target.value })}
                />
              </div>

              <div style={{ display: 'grid', gridTemplateColumns: '1fr 1fr', gap: '1rem' }}>
                <div className="form-group">
                  <label className="form-label">Giá gốc (VNĐ) *</label>
                  <input
                    type="number"
                    className="form-input"
                    required
                    value={productForm.gia}
                    onChange={(e) => setProductForm({ ...productForm, gia: e.target.value })}
                  />
                </div>
                <div className="form-group">
                  <label className="form-label">Giá khuyến mãi (VNĐ)</label>
                  <input
                    type="number"
                    className="form-input"
                    value={productForm.gia_khuyen_mai}
                    onChange={(e) => setProductForm({ ...productForm, gia_khuyen_mai: e.target.value })}
                  />
                </div>
              </div>

              <div style={{ display: 'grid', gridTemplateColumns: '1fr 1fr', gap: '1rem' }}>
                <div className="form-group">
                  <label className="form-label">Loại hàng</label>
                  <select
                    className="form-select"
                    value={productForm.id_loai}
                    onChange={(e) => setProductForm({ ...productForm, id_loai: e.target.value })}
                  >
                    {categories.map((c) => (
                      <option key={c.id_loai} value={c.id_loai}>{c.ten_loai}</option>
                    ))}
                  </select>
                </div>
                <div className="form-group">
                  <label className="form-label">Số lượng trong kho</label>
                  <input
                    type="number"
                    className="form-input"
                    value={productForm.so_luong}
                    onChange={(e) => setProductForm({ ...productForm, so_luong: e.target.value })}
                  />
                </div>
              </div>

              <div className="form-group">
                <label className="form-label">Link ảnh (URL)</label>
                <input
                  type="url"
                  className="form-input"
                  required
                  value={productForm.hinh_anh}
                  onChange={(e) => setProductForm({ ...productForm, hinh_anh: e.target.value })}
                />
              </div>

              <div className="form-group">
                <label className="form-label">Mô tả sản phẩm</label>
                <textarea
                  className="form-textarea"
                  value={productForm.mo_ta}
                  onChange={(e) => setProductForm({ ...productForm, mo_ta: e.target.value })}
                />
              </div>

              <div className="form-group" style={{ display: 'flex', alignItems: 'center', gap: '0.6rem' }}>
                <input
                  type="checkbox"
                  id="noi_bat"
                  checked={productForm.noi_bat === 1}
                  onChange={(e) => setProductForm({ ...productForm, noi_bat: e.target.checked ? 1 : 0 })}
                  style={{ width: 18, height: 18 }}
                />
                <label htmlFor="noi_bat" style={{ fontSize: '0.92rem', cursor: 'pointer' }}>
                  Đánh dấu là Sản phẩm nổi bật (Hiển thị ưu tiên)
                </label>
              </div>

              <div style={{ display: 'flex', justifyContent: 'flex-end', gap: '0.75rem', marginTop: '1.5rem' }}>
                <button
                  type="button"
                  className="btn-outline"
                  onClick={() => setIsProductModalOpen(false)}
                >
                  Hủy
                </button>
                <button
                  type="submit"
                  className="btn-primary"
                  disabled={loading}
                >
                  <Save size={18} /> {loading ? 'Đang lưu...' : 'Lưu sản phẩm'}
                </button>
              </div>
            </form>
          </div>
        </div>
      )}
    </div>
  );
}

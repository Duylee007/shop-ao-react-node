import React, { useState } from 'react';
import { X, Trash2, ShoppingBag, ArrowRight, CheckCircle2 } from 'lucide-react';

const formatCurrency = (val) => {
  return new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(val);
};

export default function CartDrawer({
  isOpen,
  onClose,
  cart,
  onUpdateQty,
  onRemoveItem,
  onClearCart,
  user,
  showToast
}) {
  const [step, setStep] = useState('cart'); // 'cart' or 'checkout' or 'success'
  const [loading, setLoading] = useState(false);
  const [orderInfo, setOrderInfo] = useState({
    name: user ? user.ten_khachhang : '',
    phone: user ? (user.dien_thoai || '') : '',
    address: user ? (user.dia_chi || '') : '',
    notes: ''
  });
  const [lastOrderId, setLastOrderId] = useState(null);

  if (!isOpen) return null;

  const subtotal = cart.reduce((acc, item) => {
    const price = item.gia_khuyen_mai > 0 ? item.gia_khuyen_mai : item.gia;
    return acc + price * item.quantity;
  }, 0);

  const handleCheckoutSubmit = async (e) => {
    e.preventDefault();
    if (!orderInfo.phone || !orderInfo.address) {
      alert('Vui lòng cung cấp số điện thoại và địa chỉ nhận hàng!');
      return;
    }

    setLoading(true);
    try {
      const token = localStorage.getItem('shopao_token');
      const headers = { 'Content-Type': 'application/json' };
      if (token) headers['Authorization'] = `Bearer ${token}`;

      const res = await fetch('/api/orders', {
        method: 'POST',
        headers,
        body: JSON.stringify({
          dia_chi_giao: `${orderInfo.address} (Người nhận: ${orderInfo.name || 'Khách lẻ'})`,
          sdt_giao: orderInfo.phone,
          ghi_chu: orderInfo.notes,
          items: cart
        })
      });

      const data = await res.json();
      if (data.success) {
        setLastOrderId(data.orderId);
        setStep('success');
        onClearCart();
        showToast('Đặt hàng thành công! Mã đơn #' + data.orderId);
      } else {
        alert(data.message || 'Lỗi khi đặt hàng');
      }
    } catch (err) {
      alert('Lỗi kết nối tới máy chủ: ' + err.message);
    } finally {
      setLoading(false);
    }
  };

  return (
    <div className="modal-overlay" onClick={onClose}>
      <div className="modal-card" style={{ maxWidth: '580px' }} onClick={(e) => e.stopPropagation()}>
        <div className="modal-header">
          <div style={{ display: 'flex', alignItems: 'center', gap: '0.6rem' }}>
            <ShoppingBag size={20} color="var(--primary)" />
            <h3 style={{ fontSize: '1.15rem', fontWeight: 700 }}>
              {step === 'cart' && `Giỏ hàng của bạn (${cart.length} món)`}
              {step === 'checkout' && 'Thông tin thanh toán & giao hàng'}
              {step === 'success' && 'Đặt hàng thành công!'}
            </h3>
          </div>
          <button className="modal-close-btn" onClick={onClose}>
            <X size={22} />
          </button>
        </div>

        <div className="modal-body">
          {/* STEP 1: CART LIST */}
          {step === 'cart' && (
            <>
              {cart.length === 0 ? (
                <div style={{ textAlign: 'center', padding: '3rem 1rem' }}>
                  <ShoppingBag size={48} style={{ opacity: 0.3, marginBottom: '1rem' }} />
                  <p style={{ color: 'var(--text-muted)', marginBottom: '1.5rem' }}>
                    Giỏ hàng của bạn đang trống!
                  </p>
                  <button className="btn-primary" onClick={onClose}>
                    Khám phá sản phẩm ngay
                  </button>
                </div>
              ) : (
                <>
                  <div style={{ maxHeight: '350px', overflowY: 'auto', marginBottom: '1.5rem' }}>
                    {cart.map((item) => {
                      const itemPrice = item.gia_khuyen_mai > 0 ? item.gia_khuyen_mai : item.gia;
                      return (
                        <div key={`${item.id_hanghoa}-${item.size}`} className="cart-item-row">
                          <img src={item.hinh_anh} alt={item.ten_hanghoa} className="cart-item-thumb" />
                          <div>
                            <div style={{ fontWeight: 600, fontSize: '0.92rem', color: '#fff' }}>
                              {item.ten_hanghoa}
                            </div>
                            <div style={{ fontSize: '0.8rem', color: 'var(--text-muted)' }}>
                              Size: <strong style={{ color: '#818cf8' }}>{item.size}</strong> • {formatCurrency(itemPrice)}
                            </div>
                          </div>

                          <div className="cart-qty-ctrl">
                            <button
                              className="cart-qty-btn"
                              onClick={() => onUpdateQty(item.id_hanghoa, item.size, item.quantity - 1)}
                            >
                              -
                            </button>
                            <span style={{ fontSize: '0.88rem', fontWeight: 700, padding: '0 0.4rem' }}>
                              {item.quantity}
                            </span>
                            <button
                              className="cart-qty-btn"
                              onClick={() => onUpdateQty(item.id_hanghoa, item.size, item.quantity + 1)}
                            >
                              +
                            </button>
                          </div>

                          <button
                            onClick={() => onRemoveItem(item.id_hanghoa, item.size)}
                            style={{ background: 'transparent', border: 'none', color: '#ef4444', cursor: 'pointer' }}
                            title="Xóa"
                          >
                            <Trash2 size={17} />
                          </button>
                        </div>
                      );
                    })}
                  </div>

                  <div style={{ borderTop: '1px solid var(--border-subtle)', paddingTop: '1.25rem' }}>
                    <div style={{ display: 'flex', justifyContent: 'space-between', alignItems: 'center', marginBottom: '1.25rem' }}>
                      <span style={{ color: 'var(--text-muted)' }}>Tổng thanh toán:</span>
                      <span style={{ fontSize: '1.45rem', fontWeight: 800, color: '#fff' }}>
                        {formatCurrency(subtotal)}
                      </span>
                    </div>

                    <button
                      className="btn-primary"
                      style={{ width: '100%', justifyContent: 'center', padding: '0.85rem' }}
                      onClick={() => setStep('checkout')}
                    >
                      Tiến hành đặt hàng <ArrowRight size={18} />
                    </button>
                  </div>
                </>
              )}
            </>
          )}

          {/* STEP 2: CHECKOUT FORM */}
          {step === 'checkout' && (
            <form onSubmit={handleCheckoutSubmit}>
              <div className="form-group">
                <label className="form-label">Họ tên người nhận *</label>
                <input
                  type="text"
                  className="form-input"
                  required
                  placeholder="Ví dụ: Nguyễn Văn A"
                  value={orderInfo.name}
                  onChange={(e) => setOrderInfo({ ...orderInfo, name: e.target.value })}
                />
              </div>

              <div className="form-group">
                <label className="form-label">Số điện thoại *</label>
                <input
                  type="tel"
                  className="form-input"
                  required
                  placeholder="Ví dụ: 0912 345 678"
                  value={orderInfo.phone}
                  onChange={(e) => setOrderInfo({ ...orderInfo, phone: e.target.value })}
                />
              </div>

              <div className="form-group">
                <label className="form-label">Địa chỉ giao hàng chi tiết *</label>
                <input
                  type="text"
                  className="form-input"
                  required
                  placeholder="Số nhà, đường, phường/xã, quận/huyện, tỉnh/thành"
                  value={orderInfo.address}
                  onChange={(e) => setOrderInfo({ ...orderInfo, address: e.target.value })}
                />
              </div>

              <div className="form-group">
                <label className="form-label">Ghi chú thêm (tùy chọn)</label>
                <textarea
                  className="form-textarea"
                  placeholder="Ví dụ: Giao giờ hành chính, gọi trước khi đến..."
                  value={orderInfo.notes}
                  onChange={(e) => setOrderInfo({ ...orderInfo, notes: e.target.value })}
                />
              </div>

              <div style={{ background: 'rgba(255,255,255,0.03)', padding: '1rem', borderRadius: '10px', marginBottom: '1.25rem' }}>
                <div style={{ display: 'flex', justifyContent: 'space-between', marginBottom: '0.4rem', fontSize: '0.9rem', color: 'var(--text-muted)' }}>
                  <span>Tổng tiền hàng ({cart.length} món):</span>
                  <span>{formatCurrency(subtotal)}</span>
                </div>
                <div style={{ display: 'flex', justifyContent: 'space-between', fontSize: '0.9rem', color: 'var(--text-muted)' }}>
                  <span>Phí vận chuyển:</span>
                  <span style={{ color: '#10b981', fontWeight: 600 }}>Miễn phí (Freeship)</span>
                </div>
                <div style={{ display: 'flex', justifyContent: 'space-between', marginTop: '0.75rem', paddingTop: '0.75rem', borderTop: '1px solid var(--border-subtle)', fontWeight: 800, fontSize: '1.15rem' }}>
                  <span>Cần thanh toán:</span>
                  <span style={{ color: '#818cf8' }}>{formatCurrency(subtotal)}</span>
                </div>
              </div>

              <div style={{ display: 'flex', gap: '0.75rem' }}>
                <button
                  type="button"
                  className="btn-outline"
                  onClick={() => setStep('cart')}
                  style={{ flex: 1, justifyContent: 'center' }}
                >
                  Quay lại giỏ
                </button>
                <button
                  type="submit"
                  className="btn-primary"
                  disabled={loading}
                  style={{ flex: 2, justifyContent: 'center' }}
                >
                  {loading ? 'Đang xử lý...' : 'Xác nhận Đặt hàng ngay'}
                </button>
              </div>
            </form>
          )}

          {/* STEP 3: SUCCESS */}
          {step === 'success' && (
            <div style={{ textAlign: 'center', padding: '2rem 1rem' }}>
              <CheckCircle2 size={56} color="#10b981" style={{ marginBottom: '1rem' }} />
              <h4 style={{ fontSize: '1.35rem', fontWeight: 800, marginBottom: '0.5rem' }}>
                Đặt hàng thành công!
              </h4>
              <p style={{ color: 'var(--text-muted)', marginBottom: '1.5rem', lineHeight: 1.6 }}>
                Mã đơn hàng của bạn là <strong>#{lastOrderId}</strong>.<br />
                Đơn hàng đã được lưu trực tiếp vào CSDL và đang chờ xác nhận giao hàng.
              </p>
              <button
                className="btn-primary"
                onClick={() => {
                  setStep('cart');
                  onClose();
                }}
              >
                Tiếp tục mua sắm
              </button>
            </div>
          )}
        </div>
      </div>
    </div>
  );
}

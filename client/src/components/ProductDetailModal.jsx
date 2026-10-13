import React, { useState } from 'react';
import { X, ShoppingBag, Check, ShieldCheck, Truck, RefreshCw } from 'lucide-react';

const formatCurrency = (val) => {
  return new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(val);
};

export default function ProductDetailModal({ product, onClose, onAddToCart }) {
  const [selectedSize, setSelectedSize] = useState('M');
  const [qty, setQty] = useState(1);

  if (!product) return null;

  const hasDiscount = product.gia_khuyen_mai > 0 && product.gia_khuyen_mai < product.gia;
  const currentPrice = hasDiscount ? product.gia_khuyen_mai : product.gia;
  const sizes = ['S', 'M', 'L', 'XL', '2XL'];

  const handleAdd = () => {
    onAddToCart(product, selectedSize, qty);
    onClose();
  };

  return (
    <div className="modal-overlay" onClick={onClose}>
      <div className="modal-card" style={{ maxWidth: '780px' }} onClick={(e) => e.stopPropagation()}>
        <div className="modal-header">
          <span style={{ fontSize: '0.9rem', color: '#818cf8', fontWeight: 600 }}>
            {product.ten_loai || 'Áo Thun Thời Trang'}
          </span>
          <button className="modal-close-btn" onClick={onClose}>
            <X size={22} />
          </button>
        </div>

        <div className="modal-body" style={{ display: 'grid', gridTemplateColumns: 'minmax(280px, 1fr) 1.2fr', gap: '2rem' }}>
          <div>
            <img
              src={product.hinh_anh}
              alt={product.ten_hanghoa}
              style={{ width: '100%', borderRadius: '16px', objectFit: 'cover', height: '360px' }}
            />
          </div>

          <div style={{ display: 'flex', flexDirection: 'column' }}>
            <h2 style={{ fontSize: '1.45rem', fontWeight: 800, marginBottom: '0.75rem', lineHeight: 1.3 }}>
              {product.ten_hanghoa}
            </h2>

            <div style={{ display: 'flex', alignItems: 'baseline', gap: '0.75rem', marginBottom: '1.25rem' }}>
              <span style={{ fontSize: '1.65rem', fontWeight: 800, color: '#fff' }}>
                {formatCurrency(currentPrice)}
              </span>
              {hasDiscount && (
                <span style={{ color: 'var(--text-dim)', textDecoration: 'line-through' }}>
                  {formatCurrency(product.gia)}
                </span>
              )}
            </div>

            <p style={{ color: 'var(--text-muted)', fontSize: '0.92rem', marginBottom: '1.5rem', lineHeight: 1.6 }}>
              {product.mo_ta || 'Sản phẩm áo thun chất lượng cao, thoáng mát, form chuẩn phong cách trẻ trung năng động.'}
            </p>

            {/* Size selection */}
            <div style={{ marginBottom: '1.25rem' }}>
              <span className="form-label">Chọn kích cỡ (Size):</span>
              <div style={{ display: 'flex', gap: '0.5rem' }}>
                {sizes.map((s) => (
                  <button
                    key={s}
                    type="button"
                    onClick={() => setSelectedSize(s)}
                    style={{
                      padding: '0.45rem 1rem',
                      borderRadius: '8px',
                      border: selectedSize === s ? '2px solid var(--primary)' : '1px solid var(--border-subtle)',
                      background: selectedSize === s ? 'var(--primary-light)' : 'rgba(255,255,255,0.05)',
                      color: selectedSize === s ? '#fff' : 'var(--text-muted)',
                      fontWeight: 700,
                      cursor: 'pointer'
                    }}
                  >
                    {s}
                  </button>
                ))}
              </div>
            </div>

            {/* Quantity */}
            <div style={{ marginBottom: '1.75rem', display: 'flex', alignItems: 'center', gap: '1rem' }}>
              <span className="form-label" style={{ marginBottom: 0 }}>Số lượng:</span>
              <div className="cart-qty-ctrl">
                <button
                  className="cart-qty-btn"
                  onClick={() => setQty(Math.max(1, qty - 1))}
                >
                  -
                </button>
                <span style={{ padding: '0 0.6rem', fontWeight: 700 }}>{qty}</span>
                <button
                  className="cart-qty-btn"
                  onClick={() => setQty(qty + 1)}
                >
                  +
                </button>
              </div>
            </div>

            {/* Action buttons */}
            <div style={{ marginTop: 'auto' }}>
              <button
                className="btn-primary"
                style={{ width: '100%', justifyContent: 'center', padding: '0.85rem' }}
                onClick={handleAdd}
              >
                <ShoppingBag size={18} /> Thêm vào giỏ hàng • {formatCurrency(currentPrice * qty)}
              </button>
            </div>

            {/* Features */}
            <div style={{ display: 'grid', gridTemplateColumns: '1fr 1fr', gap: '0.75rem', marginTop: '1.5rem', borderTop: '1px solid var(--border-subtle)', paddingTop: '1rem' }}>
              <div style={{ display: 'flex', alignItems: 'center', gap: '0.4rem', fontSize: '0.8rem', color: 'var(--text-muted)' }}>
                <Truck size={14} color="#818cf8" /> Giao hàng toàn quốc
              </div>
              <div style={{ display: 'flex', alignItems: 'center', gap: '0.4rem', fontSize: '0.8rem', color: 'var(--text-muted)' }}>
                <ShieldCheck size={14} color="#10b981" /> Cam kết chính hãng
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  );
}

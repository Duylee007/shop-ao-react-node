import React from 'react';
import { ShoppingBag, Eye, Sparkles } from 'lucide-react';

const formatCurrency = (val) => {
  return new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(val);
};

export default function ProductCard({ product, onAddToCart, onOpenDetail }) {
  const hasDiscount = product.gia_khuyen_mai > 0 && product.gia_khuyen_mai < product.gia;
  const currentPrice = hasDiscount ? product.gia_khuyen_mai : product.gia;

  return (
    <div className="product-card">
      <div className="card-img-wrap">
        <img
          src={product.hinh_anh || 'https://images.unsplash.com/photo-1521572163474-6864f9cf17ab?w=500&h=500&fit=crop'}
          alt={product.ten_hanghoa}
          className="card-img"
          loading="lazy"
        />
        <div className="card-badges">
          {product.noi_bat === 1 && (
            <span className="badge-featured">
              <Sparkles size={11} style={{ display: 'inline', marginRight: 3 }} /> NỔI BẬT
            </span>
          )}
          {hasDiscount && (
            <span className="badge-discount">
              -{Math.round(((product.gia - product.gia_khuyen_mai) / product.gia) * 100)}%
            </span>
          )}
        </div>
      </div>

      <div className="card-body">
        <span className="card-cat">{product.ten_loai || 'Áo Thun'}</span>
        <h3 className="card-title" title={product.ten_hanghoa}>
          {product.ten_hanghoa}
        </h3>

        <div className="card-price-row">
          <span className="price-current">{formatCurrency(currentPrice)}</span>
          {hasDiscount && (
            <span className="price-original">{formatCurrency(product.gia)}</span>
          )}
        </div>

        <div className="card-actions">
          <button
            className="btn-card-add"
            onClick={() => onAddToCart(product)}
            title="Thêm vào giỏ hàng"
          >
            <ShoppingBag size={16} /> Thêm vào giỏ
          </button>
          <button
            className="btn-card-detail"
            onClick={() => onOpenDetail(product)}
            title="Xem chi tiết"
          >
            <Eye size={17} />
          </button>
        </div>
      </div>
    </div>
  );
}

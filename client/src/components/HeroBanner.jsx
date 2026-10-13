import React from 'react';
import { Sparkles, ArrowRight, Truck, ShieldCheck, RefreshCw } from 'lucide-react';

export default function HeroBanner({ onExplore }) {
  return (
    <div className="hero-banner">
      <div style={{ position: 'relative', zIndex: 2 }}>
        <span className="hero-tag">
          <Sparkles size={14} style={{ display: 'inline', marginRight: 4 }} />
          Bộ Sưu Tập Mới 2026
        </span>
        <h1 className="hero-title">
          Thời Trang Trẻ Trung <br />
          <span className="badge-gradient">Phong Cách Bứt Phá</span>
        </h1>
        <p className="hero-desc">
          Khám phá các mẫu áo thun Cotton 100% cao cấp, form dáng chuẩn đẹp, thoáng mát tối đa.
          Thiết kế đa dạng từ tối giản basic đến streetwear cá tính!
        </p>

        <div style={{ display: 'flex', gap: '1rem', flexWrap: 'wrap' }}>
          <button className="btn-primary" onClick={onExplore}>
            Mua sắm ngay <ArrowRight size={18} />
          </button>
        </div>

        {/* Feature Badges */}
        <div style={{ display: 'flex', gap: '1.5rem', marginTop: '2rem', flexWrap: 'wrap' }}>
          <div style={{ display: 'flex', alignItems: 'center', gap: '0.5rem', fontSize: '0.85rem', color: 'var(--text-muted)' }}>
            <Truck size={17} color="#818cf8" /> Giao hàng hỏa tốc
          </div>
          <div style={{ display: 'flex', alignItems: 'center', gap: '0.5rem', fontSize: '0.85rem', color: 'var(--text-muted)' }}>
            <ShieldCheck size={17} color="#ec4899" /> 100% Cotton tự nhiên
          </div>
          <div style={{ display: 'flex', alignItems: 'center', gap: '0.5rem', fontSize: '0.85rem', color: 'var(--text-muted)' }}>
            <RefreshCw size={17} color="#10b981" /> Đổi trả trong 7 ngày
          </div>
        </div>
      </div>

      <div style={{ position: 'relative', zIndex: 2, display: 'none', minWidth: '320px', maxWidth: '380px' }} className="hero-visual-desktop">
        <img
          src="https://images.unsplash.com/photo-1521572163474-6864f9cf17ab?w=600&h=600&fit=crop"
          alt="DuyShirt Collection"
          style={{
            width: '100%',
            borderRadius: '24px',
            boxShadow: '0 20px 40px rgba(0,0,0,0.6), 0 0 30px rgba(99,102,241,0.3)',
            transform: 'rotate(2deg)'
          }}
        />
      </div>
    </div>
  );
}

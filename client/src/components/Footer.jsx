import React from 'react';
import { ShoppingBag, Heart, ShieldCheck, Mail, Phone, MapPin } from 'lucide-react';

export default function Footer() {
  return (
    <footer style={{ background: '#0a0e17', borderTop: '1px solid var(--border-subtle)', padding: '3.5rem 1.5rem 2rem', marginTop: 'auto' }}>
      <div style={{ maxWidth: '1300px', margin: '0 auto', display: 'grid', gridTemplateColumns: 'repeat(auto-fit, minmax(240px, 1fr))', gap: '2.5rem', marginBottom: '2.5rem' }}>
        <div>
          <div style={{ display: 'flex', alignItems: 'center', gap: '0.6rem', marginBottom: '1rem', fontSize: '1.25rem', fontWeight: 800 }}>
            <div className="logo-icon-wrap" style={{ width: 34, height: 34 }}>
              <ShoppingBag size={18} color="#fff" />
            </div>
            <span>DUY<span className="badge-gradient">SHIRT</span></span>
          </div>
          <p style={{ color: 'var(--text-muted)', fontSize: '0.88rem', lineHeight: 1.6, marginBottom: '1rem' }}>
            Hệ thống cửa hàng áo thun nam nữ cao cấp chuẩn phong cách hiện đại.
            Chuyển giao công nghệ toàn diện từ PHP MVC sang ReactJS & NodeJS.
          </p>
        </div>

        <div>
          <h4 style={{ fontSize: '0.95rem', fontWeight: 700, color: '#fff', marginBottom: '1rem', textTransform: 'uppercase' }}>
            Danh mục sản phẩm
          </h4>
          <ul style={{ listStyle: 'none', color: 'var(--text-muted)', fontSize: '0.88rem', lineHeight: 2.2 }}>
            <li>Áo thun Nam Cổ Tròn / Polo</li>
            <li>Áo thun Nữ Croptop / Oversize</li>
            <li>Áo đôi Tình nhân Nam Nữ</li>
            <li>Áo thun Unisex Streetwear</li>
            <li>Áo thun Thể thao Gym & Yoga</li>
          </ul>
        </div>

        <div>
          <h4 style={{ fontSize: '0.95rem', fontWeight: 700, color: '#fff', marginBottom: '1rem', textTransform: 'uppercase' }}>
            Chính sách & Hỗ trợ
          </h4>
          <ul style={{ listStyle: 'none', color: 'var(--text-muted)', fontSize: '0.88rem', lineHeight: 2.2 }}>
            <li>Chính sách đổi trả trong 7 ngày</li>
            <li>Hướng dẫn chọn size chuẩn xác</li>
            <li>Chính sách vận chuyển toàn quốc</li>
            <li>Bảo mật thông tin khách hàng</li>
          </ul>
        </div>

        <div>
          <h4 style={{ fontSize: '0.95rem', fontWeight: 700, color: '#fff', marginBottom: '1rem', textTransform: 'uppercase' }}>
            Thông tin liên hệ
          </h4>
          <div style={{ display: 'flex', flexDirection: 'column', gap: '0.75rem', color: 'var(--text-muted)', fontSize: '0.88rem' }}>
            <div style={{ display: 'flex', alignItems: 'center', gap: '0.5rem' }}>
              <MapPin size={16} color="#818cf8" /> TP. Hồ Chí Minh, Việt Nam
            </div>
            <div style={{ display: 'flex', alignItems: 'center', gap: '0.5rem' }}>
              <Phone size={16} color="#ec4899" /> Hotline: 1900 8888
            </div>
            <div style={{ display: 'flex', alignItems: 'center', gap: '0.5rem' }}>
              <Mail size={16} color="#10b981" /> support@duyshirt.vn
            </div>
          </div>
        </div>
      </div>

      <div style={{ borderTop: '1px solid var(--border-subtle)', paddingTop: '1.5rem', textAlign: 'center', fontSize: '0.82rem', color: 'var(--text-dim)', maxWidth: '1300px', margin: '0 auto' }}>
        © 2026 DuyShirt. Dự Án Mẫu kiến trúc hiện đại ReactJS + NodeJS (Express + SQLite). Độc lập không cần XAMPP.
      </div>
    </footer>
  );
}

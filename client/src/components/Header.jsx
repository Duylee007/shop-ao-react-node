import React from 'react';
import { ShoppingBag, Search, User, Shield, LogOut } from 'lucide-react';

export default function Header({
  cartCount,
  onOpenCart,
  onOpenAuth,
  user,
  onLogout,
  isAdmin,
  onToggleAdmin,
  searchTerm,
  onSearchChange
}) {
  return (
    <header className="header-glass">
      <div className="nav-container">
        {/* Logo */}
        <a href="#" className="logo-brand">
          <div className="logo-icon-wrap">
            <ShoppingBag size={22} color="#fff" />
          </div>
          <div>
            <span>DUY</span>
            <span className="badge-gradient">SHIRT</span>
          </div>
        </a>

        {/* Search */}
        <div className="search-container">
          <Search size={18} className="search-icon" />
          <input
            type="text"
            className="search-input"
            placeholder="Tìm kiếm áo thun nam, nữ, unisex..."
            value={searchTerm}
            onChange={(e) => onSearchChange(e.target.value)}
          />
        </div>

        {/* Actions */}
        <div className="nav-actions">
          {/* Admin Switcher */}
          {user && user.role === 'admin' ? (
            <button
              className="btn-outline"
              onClick={onToggleAdmin}
              style={{
                borderColor: '#ec4899',
                color: '#f472b6',
                padding: '0.45rem 0.9rem',
                fontSize: '0.85rem'
              }}
            >
              <Shield size={16} /> {isAdmin ? 'Xem Cửa Hàng' : 'Trang Quản Trị'}
            </button>
          ) : null}

          {/* User Account */}
          {user ? (
            <div style={{ display: 'flex', alignItems: 'center', gap: '0.5rem' }}>
              <div
                style={{
                  display: 'flex',
                  alignItems: 'center',
                  gap: '0.4rem',
                  fontSize: '0.88rem',
                  fontWeight: 600,
                  color: '#e2e8f0',
                  padding: '0.4rem 0.8rem',
                  borderRadius: '8px',
                  background: 'rgba(255,255,255,0.06)'
                }}
              >
                <User size={15} color="#818cf8" />
                <span>{user.ten_khachhang || user.ten_hien_thi || user.username}</span>
              </div>
              <button
                className="btn-icon"
                onClick={onLogout}
                title="Đăng xuất"
                style={{ width: 36, height: 36, color: '#f87171' }}
              >
                <LogOut size={16} />
              </button>
            </div>
          ) : (
            <button className="btn-outline" onClick={onOpenAuth}>
              <User size={16} /> Đăng nhập
            </button>
          )}

          {/* Cart Icon */}
          <button className="btn-icon" onClick={onOpenCart} title="Xem giỏ hàng">
            <ShoppingBag size={20} />
            {cartCount > 0 && <span className="cart-counter">{cartCount}</span>}
          </button>
        </div>
      </div>
    </header>
  );
}

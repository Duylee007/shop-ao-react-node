import React, { useState } from 'react';
import { X, User, Lock, Mail, Phone, MapPin, Shield, Check } from 'lucide-react';

export default function AuthModal({ isOpen, onClose, onAuthSuccess, showToast }) {
  const [tab, setTab] = useState('login'); // 'login' | 'register' | 'admin'
  const [loading, setLoading] = useState(false);
  const [error, setError] = useState('');

  // Form states
  const [loginForm, setLoginForm] = useState({ email: '', password: '' });
  const [registerForm, setRegisterForm] = useState({
    ten_khachhang: '',
    email: '',
    password: '',
    dien_thoai: '',
    dia_chi: ''
  });
  const [adminForm, setAdminForm] = useState({ username: '', password: '' });

  if (!isOpen) return null;

  const handleLogin = async (e) => {
    e.preventDefault();
    setError('');
    setLoading(true);
    try {
      const res = await fetch('/api/auth/login', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(loginForm)
      });
      const data = await res.json();
      if (data.success) {
        onAuthSuccess(data.user, data.token);
        showToast('Chào mừng bạn, ' + data.user.ten_khachhang);
        onClose();
      } else {
        setError(data.message);
      }
    } catch (err) {
      setError('Lỗi kết nối máy chủ');
    } finally {
      setLoading(false);
    }
  };

  const handleRegister = async (e) => {
    e.preventDefault();
    setError('');
    setLoading(true);
    try {
      const res = await fetch('/api/auth/register', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(registerForm)
      });
      const data = await res.json();
      if (data.success) {
        onAuthSuccess(data.user, data.token);
        showToast('Đăng ký tài khoản thành công!');
        onClose();
      } else {
        setError(data.message);
      }
    } catch (err) {
      setError('Lỗi kết nối máy chủ');
    } finally {
      setLoading(false);
    }
  };

  const handleAdminLogin = async (e) => {
    e.preventDefault();
    setError('');
    setLoading(true);
    try {
      const res = await fetch('/api/auth/admin-login', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(adminForm)
      });
      const data = await res.json();
      if (data.success) {
        onAuthSuccess(data.user, data.token);
        showToast('Đăng nhập Quản trị viên thành công!');
        onClose();
      } else {
        setError(data.message);
      }
    } catch (err) {
      setError('Lỗi kết nối máy chủ');
    } finally {
      setLoading(false);
    }
  };

  return (
    <div className="modal-overlay" onClick={onClose}>
      <div className="modal-card" style={{ maxWidth: '460px' }} onClick={(e) => e.stopPropagation()}>
        <div className="modal-header">
          <h3 style={{ fontSize: '1.2rem', fontWeight: 700 }}>Tài khoản</h3>
          <button className="modal-close-btn" onClick={onClose}>
            <X size={22} />
          </button>
        </div>

        {/* Tab selector */}
        <div style={{ display: 'grid', gridTemplateColumns: '1fr 1fr 1fr', borderBottom: '1px solid var(--border-subtle)', background: 'rgba(255,255,255,0.02)' }}>
          <button
            type="button"
            onClick={() => { setTab('login'); setError(''); }}
            style={{
              padding: '0.85rem 0.5rem',
              background: 'transparent',
              border: 'none',
              borderBottom: tab === 'login' ? '2px solid var(--primary)' : 'none',
              color: tab === 'login' ? '#fff' : 'var(--text-muted)',
              fontWeight: 600,
              fontSize: '0.85rem',
              cursor: 'pointer'
            }}
          >
            Đăng nhập
          </button>
          <button
            type="button"
            onClick={() => { setTab('register'); setError(''); }}
            style={{
              padding: '0.85rem 0.5rem',
              background: 'transparent',
              border: 'none',
              borderBottom: tab === 'register' ? '2px solid var(--primary)' : 'none',
              color: tab === 'register' ? '#fff' : 'var(--text-muted)',
              fontWeight: 600,
              fontSize: '0.85rem',
              cursor: 'pointer'
            }}
          >
            Đăng ký
          </button>
          <button
            type="button"
            onClick={() => { setTab('admin'); setError(''); }}
            style={{
              padding: '0.85rem 0.5rem',
              background: 'transparent',
              border: 'none',
              borderBottom: tab === 'admin' ? '2px solid #ec4899' : 'none',
              color: tab === 'admin' ? '#ec4899' : 'var(--text-muted)',
              fontWeight: 600,
              fontSize: '0.85rem',
              cursor: 'pointer'
            }}
          >
            Quản trị
          </button>
        </div>

        <div className="modal-body">
          {error && (
            <div style={{ background: 'rgba(239, 68, 68, 0.15)', border: '1px solid rgba(239,68,68,0.3)', color: '#f87171', padding: '0.65rem 1rem', borderRadius: '8px', fontSize: '0.88rem', marginBottom: '1.25rem' }}>
              {error}
            </div>
          )}

          {/* TAB LOGIN */}
          {tab === 'login' && (
            <form onSubmit={handleLogin}>
              <div className="form-group">
                <label className="form-label">Email</label>
                <input
                  type="email"
                  className="form-input"
                  required
                  placeholder="user@gmail.com"
                  value={loginForm.email}
                  onChange={(e) => setLoginForm({ ...loginForm, email: e.target.value })}
                />
              </div>
              <div className="form-group">
                <label className="form-label">Mật khẩu</label>
                <input
                  type="password"
                  className="form-input"
                  required
                  placeholder="••••••••"
                  value={loginForm.password}
                  onChange={(e) => setLoginForm({ ...loginForm, password: e.target.value })}
                />
              </div>

              <div style={{ fontSize: '0.8rem', color: 'var(--text-dim)', marginBottom: '1.25rem' }}>
                💡 Tài khoản thử nghiệm: <code>user@gmail.com</code> / Mật khẩu: <code>123456</code>
              </div>

              <button
                type="submit"
                className="btn-primary"
                disabled={loading}
                style={{ width: '100%', justifyContent: 'center', padding: '0.8rem' }}
              >
                {loading ? 'Đang xác thực...' : 'Đăng nhập ngay'}
              </button>
            </form>
          )}

          {/* TAB REGISTER */}
          {tab === 'register' && (
            <form onSubmit={handleRegister}>
              <div className="form-group">
                <label className="form-label">Họ và tên *</label>
                <input
                  type="text"
                  className="form-input"
                  required
                  placeholder="Nguyễn Văn A"
                  value={registerForm.ten_khachhang}
                  onChange={(e) => setRegisterForm({ ...registerForm, ten_khachhang: e.target.value })}
                />
              </div>
              <div className="form-group">
                <label className="form-label">Email *</label>
                <input
                  type="email"
                  className="form-input"
                  required
                  placeholder="name@example.com"
                  value={registerForm.email}
                  onChange={(e) => setRegisterForm({ ...registerForm, email: e.target.value })}
                />
              </div>
              <div className="form-group">
                <label className="form-label">Mật khẩu *</label>
                <input
                  type="password"
                  className="form-input"
                  required
                  placeholder="Ít nhất 6 ký tự"
                  value={registerForm.password}
                  onChange={(e) => setRegisterForm({ ...registerForm, password: e.target.value })}
                />
              </div>
              <div className="form-group">
                <label className="form-label">Số điện thoại</label>
                <input
                  type="tel"
                  className="form-input"
                  placeholder="0912 345 678"
                  value={registerForm.dien_thoai}
                  onChange={(e) => setRegisterForm({ ...registerForm, dien_thoai: e.target.value })}
                />
              </div>
              <div className="form-group">
                <label className="form-label">Địa chỉ</label>
                <input
                  type="text"
                  className="form-input"
                  placeholder="Địa chỉ giao nhận hàng"
                  value={registerForm.dia_chi}
                  onChange={(e) => setRegisterForm({ ...registerForm, dia_chi: e.target.value })}
                />
              </div>

              <button
                type="submit"
                className="btn-primary"
                disabled={loading}
                style={{ width: '100%', justifyContent: 'center', padding: '0.8rem' }}
              >
                {loading ? 'Đang đăng ký...' : 'Tạo tài khoản mới'}
              </button>
            </form>
          )}

          {/* TAB ADMIN */}
          {tab === 'admin' && (
            <form onSubmit={handleAdminLogin}>
              <div style={{ background: 'rgba(236,72,153,0.1)', border: '1px solid rgba(236,72,153,0.3)', padding: '0.75rem', borderRadius: '8px', fontSize: '0.84rem', color: '#f472b6', marginBottom: '1.25rem' }}>
                <Shield size={16} style={{ display: 'inline', marginRight: 5, verticalAlign: 'middle' }} />
                Đăng nhập dành cho Ban Quản trị hệ thống (Admin).
              </div>

              <div className="form-group">
                <label className="form-label">Tên đăng nhập (Username)</label>
                <input
                  type="text"
                  className="form-input"
                  required
                  placeholder="admin1"
                  value={adminForm.username}
                  onChange={(e) => setAdminForm({ ...adminForm, username: e.target.value })}
                />
              </div>
              <div className="form-group">
                <label className="form-label">Mật khẩu Admin</label>
                <input
                  type="password"
                  className="form-input"
                  required
                  placeholder="••••••••"
                  value={adminForm.password}
                  onChange={(e) => setAdminForm({ ...adminForm, password: e.target.value })}
                />
              </div>

              <div style={{ fontSize: '0.8rem', color: 'var(--text-dim)', marginBottom: '1.25rem' }}>
                🔑 Tài khoản admin mặc định: <code>admin1</code> / Mật khẩu: <code>admin123</code>
              </div>

              <button
                type="submit"
                className="btn-primary"
                disabled={loading}
                style={{ width: '100%', justifyContent: 'center', padding: '0.8rem', background: 'linear-gradient(135deg, #ec4899 0%, #8b5cf6 100%)' }}
              >
                {loading ? 'Đang đăng nhập...' : 'Vào trang Quản trị'}
              </button>
            </form>
          )}
        </div>
      </div>
    </div>
  );
}

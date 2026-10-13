import React, { useState, useEffect, useRef } from 'react';
import Header from './components/Header';
import HeroBanner from './components/HeroBanner';
import ProductCard from './components/ProductCard';
import ProductDetailModal from './components/ProductDetailModal';
import CartDrawer from './components/CartDrawer';
import AuthModal from './components/AuthModal';
import AdminDashboard from './components/AdminDashboard';
import Footer from './components/Footer';
import { Filter, SlidersHorizontal, Check } from 'lucide-react';

export default function App() {
  // Products and Categories State
  const [products, setProducts] = useState([]);
  const [categories, setCategories] = useState([]);
  const [activeCategory, setActiveCategory] = useState('all');
  const [searchTerm, setSearchTerm] = useState('');
  const [sortBy, setSortBy] = useState('latest');
  const [loading, setLoading] = useState(true);

  // Cart State (Persisted in localStorage)
  const [cart, setCart] = useState(() => {
    try {
      const saved = localStorage.getItem('shopao_cart');
      return saved ? JSON.parse(saved) : [];
    } catch {
      return [];
    }
  });

  // Auth & User State
  const [user, setUser] = useState(() => {
    try {
      const savedUser = localStorage.getItem('shopao_user');
      return savedUser ? JSON.parse(savedUser) : null;
    } catch {
      return null;
    }
  });

  // Modals & View States
  const [isAdminView, setIsAdminView] = useState(false);
  const [isCartOpen, setIsCartOpen] = useState(false);
  const [isAuthOpen, setIsAuthOpen] = useState(false);
  const [selectedProduct, setSelectedProduct] = useState(null);

  // Toast notification
  const [toastMessage, setToastMessage] = useState('');
  const productsRef = useRef(null);

  const showToast = (msg) => {
    setToastMessage(msg);
    setTimeout(() => setToastMessage(''), 3000);
  };

  // Save cart to localStorage
  useEffect(() => {
    localStorage.setItem('shopao_cart', JSON.stringify(cart));
  }, [cart]);

  // Load Categories
  const fetchCategories = async () => {
    try {
      const res = await fetch('/api/categories');
      const data = await res.json();
      if (data.success) {
        setCategories(data.categories);
      }
    } catch (err) {
      console.error('Error fetching categories:', err);
    }
  };

  // Load Products
  const fetchProducts = async () => {
    setLoading(true);
    try {
      let url = `/api/products?limit=50&sort=${sortBy}`;
      if (activeCategory !== 'all') {
        url += `&category=${activeCategory}`;
      }
      if (searchTerm.trim()) {
        url += `&search=${encodeURIComponent(searchTerm.trim())}`;
      }

      const res = await fetch(url);
      const data = await res.json();
      if (data.success) {
        setProducts(data.products);
      }
    } catch (err) {
      console.error('Error fetching products:', err);
    } finally {
      setLoading(false);
    }
  };

  useEffect(() => {
    fetchCategories();
  }, []);

  useEffect(() => {
    fetchProducts();
  }, [activeCategory, searchTerm, sortBy]);

  // Cart actions
  const handleAddToCart = (product, size = 'M', quantity = 1) => {
    setCart((prev) => {
      const existingIndex = prev.findIndex(
        (it) => it.id_hanghoa === product.id_hanghoa && it.size === size
      );
      if (existingIndex > -1) {
        const nextCart = [...prev];
        nextCart[existingIndex].quantity += quantity;
        return nextCart;
      } else {
        return [
          ...prev,
          {
            ...product,
            size,
            quantity
          }
        ];
      }
    });
    showToast(`Đã thêm "${product.ten_hanghoa}" (Size ${size}) vào giỏ!`);
  };

  const handleUpdateQty = (id, size, newQty) => {
    if (newQty <= 0) {
      handleRemoveItem(id, size);
      return;
    }
    setCart((prev) =>
      prev.map((it) =>
        it.id_hanghoa === id && it.size === size ? { ...it, quantity: newQty } : it
      )
    );
  };

  const handleRemoveItem = (id, size) => {
    setCart((prev) => prev.filter((it) => !(it.id_hanghoa === id && it.size === size)));
    showToast('Đã xóa món khỏi giỏ hàng');
  };

  const handleClearCart = () => {
    setCart([]);
  };

  // Auth actions
  const handleAuthSuccess = (userData, token) => {
    setUser(userData);
    localStorage.setItem('shopao_user', JSON.stringify(userData));
    localStorage.setItem('shopao_token', token);
    if (userData.role === 'admin') {
      setIsAdminView(true);
    }
  };

  const handleLogout = () => {
    setUser(null);
    setIsAdminView(false);
    localStorage.removeItem('shopao_user');
    localStorage.removeItem('shopao_token');
    showToast('Đã đăng xuất');
  };

  const totalCartCount = cart.reduce((sum, item) => sum + item.quantity, 0);

  const scrollToProducts = () => {
    if (productsRef.current) {
      productsRef.current.scrollIntoView({ behavior: 'smooth' });
    }
  };

  return (
    <div style={{ display: 'flex', flexDirection: 'column', minHeight: '100vh' }}>
      {/* Toast Alert */}
      {toastMessage && (
        <div className="toast-notice">
          <Check size={18} color="#10b981" />
          <span>{toastMessage}</span>
        </div>
      )}

      {/* Navigation Header */}
      <Header
        cartCount={totalCartCount}
        onOpenCart={() => setIsCartOpen(true)}
        onOpenAuth={() => setIsAuthOpen(true)}
        user={user}
        onLogout={handleLogout}
        isAdmin={isAdminView}
        onToggleAdmin={() => setIsAdminView(!isAdminView)}
        searchTerm={searchTerm}
        onSearchChange={setSearchTerm}
      />

      {/* VIEW SWITCH: ADMIN vs CLIENT */}
      {isAdminView ? (
        <AdminDashboard
          onBackToShop={() => setIsAdminView(false)}
          showToast={showToast}
        />
      ) : (
        <main className="main-content">
          {/* Hero Section */}
          <HeroBanner onExplore={scrollToProducts} />

          {/* Catalog Section */}
          <div ref={productsRef}>
            {/* Category Filter Chips */}
            <div className="category-chips">
              <button
                className={`category-chip ${activeCategory === 'all' ? 'active' : ''}`}
                onClick={() => setActiveCategory('all')}
              >
                Tất cả sản phẩm
              </button>
              {categories.map((c) => (
                <button
                  key={c.id_loai}
                  className={`category-chip ${activeCategory === String(c.id_loai) ? 'active' : ''}`}
                  onClick={() => setActiveCategory(String(c.id_loai))}
                >
                  {c.ten_loai} ({c.so_san_pham})
                </button>
              ))}
            </div>

            {/* Filter Bar */}
            <div
              style={{
                display: 'flex',
                justifyContent: 'space-between',
                alignItems: 'center',
                marginBottom: '1.5rem',
                flexWrap: 'wrap',
                gap: '1rem'
              }}
            >
              <div style={{ fontSize: '0.95rem', color: 'var(--text-muted)' }}>
                Hiển thị <strong style={{ color: '#fff' }}>{products.length}</strong> mẫu áo thun
                {searchTerm && ` cho từ khóa "${searchTerm}"`}
              </div>

              <div style={{ display: 'flex', alignItems: 'center', gap: '0.6rem' }}>
                <SlidersHorizontal size={16} color="var(--text-muted)" />
                <span style={{ fontSize: '0.88rem', color: 'var(--text-muted)' }}>Sắp xếp:</span>
                <select
                  className="form-select"
                  style={{ width: 'auto', padding: '0.4rem 0.8rem', fontSize: '0.88rem' }}
                  value={sortBy}
                  onChange={(e) => setSortBy(e.target.value)}
                >
                  <option value="latest">Mới nhất</option>
                  <option value="price-asc">Giá tăng dần</option>
                  <option value="price-desc">Giá giảm dần</option>
                  <option value="oldest">Cũ nhất</option>
                </select>
              </div>
            </div>

            {/* Products Grid */}
            {loading ? (
              <div style={{ textAlign: 'center', padding: '4rem 1rem', color: 'var(--text-muted)' }}>
                Đang tải danh sách sản phẩm...
              </div>
            ) : products.length === 0 ? (
              <div
                style={{
                  textAlign: 'center',
                  padding: '4rem 1rem',
                  background: 'var(--bg-surface)',
                  borderRadius: '16px',
                  border: '1px solid var(--border-subtle)'
                }}
              >
                <p style={{ color: 'var(--text-muted)', marginBottom: '1rem', fontSize: '1.05rem' }}>
                  Không tìm thấy sản phẩm nào phù hợp!
                </p>
                <button
                  className="btn-outline"
                  onClick={() => {
                    setActiveCategory('all');
                    setSearchTerm('');
                  }}
                >
                  Xóa bộ lọc
                </button>
              </div>
            ) : (
              <div className="products-grid">
                {products.map((p) => (
                  <ProductCard
                    key={p.id_hanghoa}
                    product={p}
                    onAddToCart={handleAddToCart}
                    onOpenDetail={(prod) => setSelectedProduct(prod)}
                  />
                ))}
              </div>
            )}
          </div>
        </main>
      )}

      {/* FOOTER */}
      <Footer />

      {/* MODALS */}
      {selectedProduct && (
        <ProductDetailModal
          product={selectedProduct}
          onClose={() => setSelectedProduct(null)}
          onAddToCart={handleAddToCart}
        />
      )}

      <CartDrawer
        isOpen={isCartOpen}
        onClose={() => setIsCartOpen(false)}
        cart={cart}
        onUpdateQty={handleUpdateQty}
        onRemoveItem={handleRemoveItem}
        onClearCart={handleClearCart}
        user={user}
        showToast={showToast}
      />

      <AuthModal
        isOpen={isAuthOpen}
        onClose={() => setIsAuthOpen(false)}
        onAuthSuccess={handleAuthSuccess}
        showToast={showToast}
      />
    </div>
  );
}

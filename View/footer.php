    <!-- YaMe Style Footer -->
    <footer class="yame-footer">
        <div class="container">
            <div class="row g-4">
                <!-- Column 1: Brand Info -->
                <div class="col-lg-4 col-md-6">
                    <div class="footer-brand">
                        DUY<span class="text-danger">.</span>STUDIO
                    </div>
                    <p class="text-secondary mb-3" style="font-size: 0.9rem;">
                        Thương hiệu thời trang nam nữ phát triển theo triết lý <strong>Mặc Bền, Mặc Mềm, Không Lỗi Mốt</strong>. Thiết kế tinh tế, tôn dáng người Việt và mang lại sự tự tin tối đa.
                    </p>
                    <p class="text-secondary mb-1 small"><i class="fas fa-map-marker-alt text-danger me-2"></i> Hệ thống 15+ cửa hàng trên toàn quốc</p>
                    <p class="text-secondary mb-1 small"><i class="fas fa-phone text-danger me-2"></i> Tổng đài CSKH: <strong>1900 1234</strong> (8:30 - 21:30)</p>
                    <p class="text-secondary mb-3 small"><i class="fas fa-envelope text-danger me-2"></i> Email: cskh@duystudio.vn</p>
                    
                    <div class="d-flex mt-3">
                        <a href="#" class="social-icon-btn"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="social-icon-btn"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="social-icon-btn"><i class="fab fa-tiktok"></i></a>
                        <a href="#" class="social-icon-btn"><i class="fab fa-youtube"></i></a>
                    </div>
                </div>

                <!-- Column 2: Quick Links -->
                <div class="col-lg-2 col-md-6 col-6">
                    <h5 class="footer-title">DANH MỤC</h5>
                    <ul class="footer-links">
                        <li><a href="index.php">Trang Chủ</a></li>
                        <li><a href="index.php?act=sanpham">Tất Cả Sản Phẩm</a></li>
                        <li><a href="index.php?act=sanpham&loai=1">Áo Thun Nam</a></li>
                        <li><a href="index.php?act=sanpham&loai=2">Áo Thun Nữ</a></li>
                        <li><a href="index.php?act=sanpham&loai=3">Áo Unisex</a></li>
                        <li><a href="index.php?act=sanpham">Bộ Sưu Tập Mới</a></li>
                    </ul>
                </div>

                <!-- Column 3: Customer Policies -->
                <div class="col-lg-2 col-md-6 col-6">
                    <h5 class="footer-title">CHÍNH SÁCH</h5>
                    <ul class="footer-links">
                        <li><a href="#">Đổi Hàng 15 Ngày</a></li>
                        <li><a href="#">Bảo Hành Form & Vải</a></li>
                        <li><a href="#">Chính Sách Vận Chuyển</a></li>
                        <li><a href="#">Bảo Mật Thông Tin</a></li>
                        <li><a href="#">Hướng Dẫn Chọn Size</a></li>
                        <li><a href="#">Khách Hàng Thân Thiết</a></li>
                    </ul>
                </div>

                <!-- Column 4: Newsletter & Trust -->
                <div class="col-lg-4 col-md-6">
                    <h5 class="footer-title">ĐĂNG KÝ NHẬN TIN</h5>
                    <p class="text-secondary small mb-3">Đăng ký thành viên ngay hôm nay để nhận voucher giảm giá <strong>50.000đ</strong> cho đơn hàng đầu tiên!</p>
                    
                    <form class="newsletter-box mb-4" onsubmit="event.preventDefault(); showToast('Đăng ký nhận tin thành công! Mã voucher: DUY50K', 'success');">
                        <input type="email" class="newsletter-input" placeholder="Nhập địa chỉ email của bạn..." required>
                        <button type="submit" class="newsletter-btn">Đăng Ký</button>
                    </form>

                    <h6 class="text-white-50 text-uppercase small fw-bold mb-2" style="letter-spacing: 1px;">Phương Thức Thanh Toán</h6>
                    <div class="d-flex gap-2 text-white-50 fs-4">
                        <i class="fab fa-cc-visa" title="Visa"></i>
                        <i class="fab fa-cc-mastercard" title="Mastercard"></i>
                        <i class="fas fa-money-bill-wave text-success" title="COD Tiền Mặt"></i>
                        <i class="fas fa-qrcode text-info" title="Chuyển khoản QR"></i>
                    </div>
                </div>
            </div>

            <!-- Bottom Line -->
            <div class="footer-bottom-line d-flex flex-wrap justify-content-between align-items-center">
                <div>
                    © <?php echo date('Y'); ?> <strong>DUY STUDIO</strong>. Bản quyền thuộc về Shop Duy Fashion.
                </div>
                <div class="mt-2 mt-md-0">
                    <span class="badge bg-secondary me-2">Chuẩn ISO 9001:2015</span>
                    <span class="badge bg-dark border border-secondary">Cotton Compact 100%</span>
                </div>
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="Content/CSS/main.js"></script>
</body>
</html>

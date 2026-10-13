<?php require_once dirname(__DIR__) . "/View/headder.php"; ?>

<section class="py-5 bg-light min-vh-100 d-flex align-items-center">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
                    <div class="card-body p-5">
                        <div class="text-center mb-4">
                            <div class="yame-brand justify-content-center mb-2">
                                DUY<span class="yame-brand-dot"></span>
                            </div>
                            <h3 class="fw-bold text-uppercase" style="letter-spacing: 1px;">Đăng Ký Thành Viên</h3>
                            <p class="text-secondary small">Trở thành thành viên YaMe để nhận ngay voucher giảm 50.000đ</p>
                        </div>

                        <?php if (!empty($error)): ?>
                        <div class="alert alert-danger rounded-3"><?php echo $error; ?></div>
                        <?php endif; ?>
                        <?php if (!empty($success)): ?>
                        <div class="alert alert-success rounded-3"><?php echo $success; ?></div>
                        <?php endif; ?>

                        <form action="index.php?act=dangky" method="POST">
                            <div class="mb-3">
                                <label class="form-label small fw-bold text-uppercase">Họ và tên <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0"><i class="fas fa-user text-muted"></i></span>
                                    <input type="text" name="ten" class="form-control border-start-0" placeholder="Nhập họ và tên đầy đủ" required>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label small fw-bold text-uppercase">Email <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0"><i class="fas fa-envelope text-muted"></i></span>
                                    <input type="email" name="email" class="form-control border-start-0" placeholder="Nhập địa chỉ email" required>
                                </div>
                            </div>
                            <div class="row g-3 mb-3">
                                <div class="col-md-6">
                                    <label class="form-label small fw-bold text-uppercase">Mật khẩu <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0"><i class="fas fa-lock text-muted"></i></span>
                                        <input type="password" name="password" class="form-control border-start-0" placeholder="Tối thiểu 6 ký tự" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label small fw-bold text-uppercase">Xác nhận MK <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0"><i class="fas fa-lock text-muted"></i></span>
                                        <input type="password" name="confirm_password" class="form-control border-start-0" placeholder="Nhập lại mật khẩu" required>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label small fw-bold text-uppercase">Số điện thoại</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0"><i class="fas fa-phone text-muted"></i></span>
                                    <input type="tel" name="dienthoai" class="form-control border-start-0" placeholder="Nhập số điện thoại">
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label small fw-bold text-uppercase">Địa chỉ nhận hàng</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0"><i class="fas fa-map-marker-alt text-muted"></i></span>
                                    <textarea name="diachi" class="form-control border-start-0" rows="2" placeholder="Nhập địa chỉ của bạn"></textarea>
                                </div>
                            </div>
                            <div class="form-check mb-4">
                                <input class="form-check-input" type="checkbox" id="terms" required checked>
                                <label class="form-check-label small text-secondary" for="terms">
                                    Tôi đồng ý với các <a href="#" class="text-dark fw-bold">điều khoản sử dụng</a> & <a href="#" class="text-dark fw-bold">chính sách bảo mật</a>
                                </label>
                            </div>
                            <button type="submit" class="btn-yame-dark w-100 py-3 mb-3">ĐĂNG KÝ TÀI KHOẢN</button>
                        </form>

                        <div class="text-center">
                            <p class="mb-0 small text-secondary">Đã có tài khoản? <a href="index.php?act=dangnhap" class="text-danger fw-bold text-decoration-none">Đăng nhập ngay</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php require_once dirname(__DIR__) . "/View/footer.php"; ?>
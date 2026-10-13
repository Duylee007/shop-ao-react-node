<?php require_once dirname(__DIR__) . "/View/headder.php"; ?>

<section class="py-5 bg-light min-vh-100 d-flex align-items-center">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
                    <div class="card-body p-5">
                        <div class="text-center mb-4">
                            <div class="yame-brand justify-content-center mb-2">
                                DUY<span class="yame-brand-dot"></span>
                            </div>
                            <h3 class="fw-bold text-uppercase" style="letter-spacing: 1px;">Đăng Nhập</h3>
                            <p class="text-secondary small">Chào mừng bạn trở lại với YaMe Duy Studio</p>
                        </div>

                        <?php if (!empty($error)): ?>
                        <div class="alert alert-danger rounded-3"><?php echo $error; ?></div>
                        <?php endif; ?>

                        <form action="index.php?act=dangnhap" method="POST">
                            <div class="mb-3">
                                <label class="form-label small fw-bold text-uppercase">Email</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0"><i class="fas fa-envelope text-muted"></i></span>
                                    <input type="email" name="email" class="form-control border-start-0" placeholder="Nhập địa chỉ email của bạn" required>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label small fw-bold text-uppercase">Mật khẩu</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0"><i class="fas fa-lock text-muted"></i></span>
                                    <input type="password" name="password" class="form-control border-start-0" placeholder="Nhập mật khẩu" required>
                                </div>
                            </div>
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="remember">
                                    <label class="form-check-label small text-secondary" for="remember">Ghi nhớ đăng nhập</label>
                                </div>
                                <a href="index.php?act=quenmatkhau" class="small text-secondary text-decoration-underline">Quên mật khẩu?</a>
                            </div>
                            <button type="submit" class="btn-yame-dark w-100 py-3 mb-3">ĐĂNG NHẬP</button>
                        </form>

                        <div class="text-center">
                            <p class="mb-0 small text-secondary">Chưa có tài khoản? <a href="index.php?act=dangky" class="fw-bold text-danger text-decoration-none">Đăng ký thành viên nhận 50K</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php require_once dirname(__DIR__) . "/View/footer.php"; ?>
<?php require_once dirname(__DIR__) . "/View/headder.php"; ?>

<section class="py-5 bg-light min-vh-100 d-flex align-items-center">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="card border-0 shadow-lg">
                    <div class="card-body p-5">
                        <div class="text-center mb-4">
                            <i class="fas fa-lock-open fa-4x text-primary mb-3"></i>
                            <h3 class="fw-bold">Đặt Lại Mật Khẩu</h3>
                            <p class="text-muted">Nhập mật khẩu mới cho tài khoản của bạn</p>
                        </div>

                        <?php if (!empty($error)): ?>
                        <div class="alert alert-danger"><?php echo $error; ?></div>
                        <?php endif; ?>
                        <?php if (!empty($success)): ?>
                        <div class="alert alert-success"><?php echo $success; ?> <a href="index.php?act=dangnhap">Đăng nhập ngay</a></div>
                        <?php endif; ?>

                        <form action="index.php?act=resetpw" method="POST">
                            <input type="hidden" name="token" value="<?php echo $_GET['token'] ?? ''; ?>">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Mật khẩu mới</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                    <input type="password" name="password" class="form-control" placeholder="Ít nhất 6 ký tự" required>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Xác nhận mật khẩu</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                    <input type="password" name="confirm_password" class="form-control" placeholder="Nhập lại mật khẩu" required>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary w-100 btn-lg">Cập Nhật Mật Khẩu</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php require_once dirname(__DIR__) . "/View/footer.php"; ?>
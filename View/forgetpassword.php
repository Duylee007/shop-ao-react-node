<?php require_once dirname(__DIR__) . "/View/headder.php"; ?>

<section class="py-5 bg-light min-vh-100 d-flex align-items-center">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="card border-0 shadow-lg">
                    <div class="card-body p-5">
                        <div class="text-center mb-4">
                            <i class="fas fa-key fa-4x text-primary mb-3"></i>
                            <h3 class="fw-bold">Quên Mật Khẩu</h3>
                            <p class="text-muted">Nhập email để nhận hướng dẫn khôi phục</p>
                        </div>

                        <?php if (!empty($error)): ?>
                        <div class="alert alert-danger"><?php echo $error; ?></div>
                        <?php endif; ?>
                        <?php if (!empty($success)): ?>
                        <div class="alert alert-success"><?php echo $success; ?></div>
                        <?php endif; ?>

                        <form action="index.php?act=quenmatkhau" method="POST">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Email</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                    <input type="email" name="email" class="form-control" placeholder="Nhập email đã đăng ký" required>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary w-100 btn-lg mb-3">Gửi Yêu Cầu</button>
                        </form>

                        <div class="text-center">
                            <a href="index.php?act=dangnhap" class="text-decoration-none"><i class="fas fa-arrow-left me-1"></i>Quay lại đăng nhập</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php require_once dirname(__DIR__) . "/View/footer.php"; ?>
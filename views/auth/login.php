<?php $this->layout('layouts/app', ['title' => 'تسجيل الدخول - Tewiiq']) ?>

<nav class="navbar navbar-expand-lg navbar-light fixed-top">
    <div class="container">
        <a class="navbar-brand" href="/">
            <i class="bi bi-twitter me-2"></i>Tewiiq
        </a>
        <div class="navbar-nav ms-auto">
            <a class="nav-link" href="/register">إنشاء حساب</a>
        </div>
    </div>
</nav>

<div class="container-fluid">
    <div class="row justify-content-center min-vh-100 align-items-center">
        <div class="col-md-6 col-lg-4">
            <div class="card shadow">
                <div class="card-header text-center bg-primary text-white">
                    <h3 class="mb-0">مرحباً بعودتك</h3>
                    <p class="mb-0">سجل الدخول إلى حسابك</p>
                </div>
                <div class="card-body p-4">
                    <?php if (isset($_SESSION['error'])): ?>
                        <div class="alert alert-danger">
                            <?=$this->e($_SESSION['error'])?>
                            <?php unset($_SESSION['error']); ?>
                        </div>
                    <?php endif; ?>
                    
                    <?php if (isset($_SESSION['success'])): ?>
                        <div class="alert alert-success">
                            <?=$this->e($_SESSION['success'])?>
                            <?php unset($_SESSION['success']); ?>
                        </div>
                    <?php endif; ?>

                    <form method="POST" action="/login">
                        <div class="mb-3">
                            <label for="identifier" class="form-label">اسم المستخدم أو البريد الإلكتروني</label>
                            <input type="text" class="form-control" id="identifier" name="identifier" required>
                        </div>
                        
                        <div class="mb-3">
                            <label for="password" class="form-label">كلمة المرور</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                        
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" id="remember" name="remember">
                            <label class="form-check-label" for="remember">تذكرني</label>
                        </div>
                        
                        <button type="submit" class="btn btn-primary w-100 mb-3">تسجيل الدخول</button>
                    </form>
                    
                    <div class="text-center">
                        <p class="mb-0">لا تملك حساب؟ <a href="/register" class="text-primary">إنشاء حساب جديد</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
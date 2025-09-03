<?php $this->layout('layouts/app', ['title' => 'إنشاء حساب جديد - Tewiiq']) ?>

<nav class="navbar navbar-expand-lg navbar-light fixed-top">
    <div class="container">
        <a class="navbar-brand" href="/">
            <i class="bi bi-twitter me-2"></i>Tewiiq
        </a>
        <div class="navbar-nav ms-auto">
            <a class="nav-link" href="/login">تسجيل الدخول</a>
        </div>
    </div>
</nav>

<div class="container-fluid">
    <div class="row justify-content-center min-vh-100 align-items-center">
        <div class="col-md-6 col-lg-5">
            <div class="card shadow">
                <div class="card-header text-center bg-primary text-white">
                    <h3 class="mb-0">انضم إلى Tewiiq</h3>
                    <p class="mb-0">أنشئ حسابك الجديد</p>
                </div>
                <div class="card-body p-4">
                    <?php if (isset($_SESSION['errors'])): ?>
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                <?php foreach ($_SESSION['errors'] as $error): ?>
                                    <li><?=$this->e($error)?></li>
                                <?php endforeach; ?>
                            </ul>
                            <?php unset($_SESSION['errors']); ?>
                        </div>
                    <?php endif; ?>
                    
                    <?php if (isset($_SESSION['error'])): ?>
                        <div class="alert alert-danger">
                            <?=$this->e($_SESSION['error'])?>
                            <?php unset($_SESSION['error']); ?>
                        </div>
                    <?php endif; ?>

                    <form method="POST" action="/register">
                        <div class="mb-3">
                            <label for="fullname" class="form-label">الاسم الكامل</label>
                            <input type="text" class="form-control" id="fullname" name="fullname" 
                                   value="<?=$this->e($_SESSION['form_data']['fullname'] ?? '')?>" required>
                        </div>
                        
                        <div class="mb-3">
                            <label for="username" class="form-label">اسم المستخدم</label>
                            <input type="text" class="form-control" id="username" name="username" 
                                   value="<?=$this->e($_SESSION['form_data']['username'] ?? '')?>" required>
                        </div>
                        
                        <div class="mb-3">
                            <label for="email" class="form-label">البريد الإلكتروني</label>
                            <input type="email" class="form-control" id="email" name="email" 
                                   value="<?=$this->e($_SESSION['form_data']['email'] ?? '')?>" required>
                        </div>
                        
                        <div class="mb-3">
                            <label for="password" class="form-label">كلمة المرور</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                        
                        <div class="mb-3">
                            <label for="confirm_password" class="form-label">تأكيد كلمة المرور</label>
                            <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                        </div>
                        
                        <button type="submit" class="btn btn-primary w-100 mb-3">إنشاء الحساب</button>
                    </form>
                    
                    <div class="text-center">
                        <p class="mb-0">لديك حساب بالفعل؟ <a href="/login" class="text-primary">تسجيل الدخول</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php unset($_SESSION['form_data']); ?>
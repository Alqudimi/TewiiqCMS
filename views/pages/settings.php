<?php $this->layout('layouts/app', ['title' => $title]) ?>

<style>
    /* تصميم الشريط الجانبي */
    .settings-sidebar {
        background-color: var(--card);
        border-radius: var(--border-radius);
        box-shadow: var(--box-shadow);
        padding: 1.5rem;
        height: fit-content;
        position: sticky;
        top: 90px;
    }

    .sidebar-title {
        font-size: 1.5rem;
        font-weight: 700;
        margin-bottom: 1.5rem;
        color: var(--primary);
        display: flex;
        align-items: center;
    }

    .sidebar-title i {
        margin-left: 0.5rem;
    }

    .nav-pills .nav-link {
        color: var(--text);
        background: transparent;
        border-radius: var(--border-radius);
        padding: 0.75rem 1rem;
        margin-bottom: 0.5rem;
        transition: var(--transition);
        text-align: right;
        display: flex;
        align-items: center;
    }

    .nav-pills .nav-link i {
        margin-left: 0.75rem;
        font-size: 1.125rem;
    }

    .nav-pills .nav-link:hover {
        background-color: var(--input);
        color: var(--primary);
    }

    .nav-pills .nav-link.active {
        background-color: var(--primary);
        color: white;
    }

    /* تصميم منطقة المحتوى */
    .settings-content {
        background-color: var(--card);
        border-radius: var(--border-radius);
        box-shadow: var(--box-shadow);
        padding: 2rem;
    }

    .content-header {
        margin-bottom: 2rem;
        padding-bottom: 1rem;
        border-bottom: 2px solid var(--accent);
    }

    .content-title {
        font-size: 1.75rem;
        font-weight: 700;
        color: var(--primary);
        margin-bottom: 0.5rem;
        display: flex;
        align-items: center;
    }

    .content-title i {
        margin-left: 0.75rem;
        font-size: 1.5rem;
    }

    /* تصميم بطاقات الإعدادات */
    .settings-card {
        background-color: var(--input);
        border-radius: var(--border-radius);
        padding: 1.5rem;
        margin-bottom: 1.5rem;
        transition: var(--transition);
    }

    .settings-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
    }

    .settings-card-header {
        display: flex;
        align-items: center;
        margin-bottom: 1rem;
        font-weight: 700;
        font-size: 1.125rem;
        color: var(--text);
    }

    .settings-card-header i {
        margin-left: 0.5rem;
        color: var(--primary);
    }

    /* تصميم عناصر الإعدادات */
    .setting-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 1rem 0;
        border-bottom: 1px solid var(--border);
    }

    .setting-item:last-child {
        border-bottom: none;
    }

    .setting-info {
        flex: 1;
    }

    .setting-title {
        font-weight: 600;
        margin-bottom: 0.25rem;
        color: var(--text);
    }

    .setting-description {
        font-size: 0.875rem;
        color: var(--secondary);
    }

    .setting-control {
        margin-right: 1rem;
    }

    /* تصميم المفاتيح */
    .toggle-switch {
        position: relative;
        display: inline-block;
        width: 50px;
        height: 24px;
    }

    .toggle-switch input {
        opacity: 0;
        width: 0;
        height: 0;
    }

    .slider {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: #ccc;
        transition: 0.4s;
        border-radius: 24px;
    }

    .slider:before {
        position: absolute;
        content: "";
        height: 18px;
        width: 18px;
        left: 3px;
        bottom: 3px;
        background-color: white;
        transition: 0.4s;
        border-radius: 50%;
    }

    input:checked + .slider {
        background-color: var(--primary);
    }

    input:checked + .slider:before {
        transform: translateX(26px);
    }

    /* تصميم النماذج */
    .form-group {
        margin-bottom: 1.5rem;
    }

    .form-label {
        font-weight: 600;
        margin-bottom: 0.5rem;
        color: var(--text);
        display: block;
    }

    .form-control {
        width: 100%;
        padding: 0.75rem 1rem;
        background-color: var(--card);
        border: 2px solid var(--border);
        border-radius: var(--border-radius);
        color: var(--text);
        transition: var(--transition);
    }

    .form-control:focus {
        outline: none;
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(124, 77, 255, 0.2);
    }

    .form-text {
        font-size: 0.875rem;
        color: var(--secondary);
        margin-top: 0.25rem;
    }

    /* تصميم الأزرار */
    .btn {
        padding: 0.75rem 1.5rem;
        border-radius: var(--border-radius);
        font-weight: 600;
        transition: var(--transition);
        border: none;
        cursor: pointer;
    }

    .btn-primary {
        background-color: var(--primary);
        color: white;
    }

    .btn-primary:hover {
        background-color: var(--secondary);
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(124, 77, 255, 0.4);
    }

    .btn-secondary {
        background-color: var(--input);
        color: var(--text);
    }

    .btn-secondary:hover {
        background-color: var(--border);
    }

    .btn-danger {
        background-color: #dc3545;
        color: white;
    }

    .btn-danger:hover {
        background-color: #c82333;
    }

    /* شريط التنقل */
    .navbar {
        background-color: var(--card);
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        padding: 0.75rem 1rem;
        transition: var(--transition);
    }

    .navbar-brand {
        font-weight: 700;
        color: var(--primary);
        text-decoration: none;
    }

    .nav-link {
        color: var(--text);
        font-weight: 500;
        padding: 0.5rem 1rem;
        border-radius: var(--border-radius);
        text-decoration: none;
    }

    .nav-link:hover, .nav-link:focus {
        background-color: var(--input);
        color: var(--primary);
    }

    .nav-link.active {
        background-color: var(--primary);
        color: white;
    }

    /* الرسائل التنبيهية */
    .alert {
        border-radius: var(--border-radius);
        padding: 1rem 1.5rem;
        margin-bottom: 1rem;
        border: none;
    }

    .alert-success {
        background-color: rgba(44, 224, 200, 0.1);
        color: var(--accent);
    }

    .alert-danger {
        background-color: rgba(255, 110, 108, 0.1);
        color: var(--secondary);
    }

    /* التجاوب مع الأجهزة المحمولة */
    @media (max-width: 768px) {
        .settings-sidebar {
            position: static;
            margin-bottom: 1rem;
        }
        
        .nav-pills {
            display: flex;
            overflow-x: auto;
            gap: 0.5rem;
            padding-bottom: 0.5rem;
        }
        
        .nav-pills .nav-link {
            white-space: nowrap;
            margin-bottom: 0;
        }
    }
</style>

<!-- شريط التنقل -->
<nav class="navbar navbar-expand-lg fixed-top">
    <div class="container">
        <a class="navbar-brand" href="/">
            <i class="bi bi-twitter"></i>
            Tewiiq
        </a>
        
        <div class="navbar-nav ms-auto">
            <a class="nav-link" href="/">الرئيسية</a>
            <a class="nav-link" href="/search">البحث</a>
            <a class="nav-link" href="/lists">القوائم</a>
            <a class="nav-link" href="/events">الفعاليات</a>
            <a class="nav-link active" href="/settings">الإعدادات</a>
            <a class="nav-link" href="/profile/<?=$_SESSION['username'] ?? ''?>">الملف الشخصي</a>
            <a class="nav-link" href="/logout">تسجيل الخروج</a>
        </div>
    </div>
</nav>

<div class="container mt-4">
    <?php if (isset($_SESSION['success'])): ?>
        <div class="alert alert-success">
            <i class="bi bi-check-circle me-2"></i>
            <?=$this->e($_SESSION['success'])?>
        </div>
        <?php unset($_SESSION['success']); ?>
    <?php endif; ?>

    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger">
            <i class="bi bi-exclamation-triangle me-2"></i>
            <?=$this->e($_SESSION['error'])?>
        </div>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>

    <div class="row">
        <!-- الشريط الجانبي -->
        <div class="col-lg-3">
            <div class="settings-sidebar">
                <div class="sidebar-title">
                    <i class="bi bi-gear-fill"></i>
                    الإعدادات
                </div>
                
                <ul class="nav nav-pills flex-column">
                    <li class="nav-item">
                        <a class="nav-link active" data-section="profile">
                            <i class="bi bi-person-circle"></i>
                            الملف الشخصي
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-section="privacy">
                            <i class="bi bi-shield-lock"></i>
                            الخصوصية والأمان
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-section="notifications">
                            <i class="bi bi-bell"></i>
                            الإشعارات
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-section="appearance">
                            <i class="bi bi-palette"></i>
                            المظهر
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-section="account">
                            <i class="bi bi-person-gear"></i>
                            إدارة الحساب
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        <!-- المحتوى الرئيسي -->
        <div class="col-lg-9">
            <div class="settings-content">
                <!-- قسم الملف الشخصي -->
                <div id="profile-section" class="settings-section">
                    <div class="content-header">
                        <h2 class="content-title">
                            <i class="bi bi-person-circle"></i>
                            الملف الشخصي
                        </h2>
                        <p class="text-muted">قم بتحديث معلوماتك الشخصية وإعدادات الحساب</p>
                    </div>

                    <form method="POST" action="/settings/profile">
                        <div class="settings-card">
                            <div class="settings-card-header">
                                <i class="bi bi-person"></i>
                                المعلومات الأساسية
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">الاسم الكامل</label>
                                        <input type="text" name="fullname" class="form-control" 
                                               value="<?=$this->e($user->fullname)?>" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">اسم المستخدم</label>
                                        <input type="text" name="username" class="form-control" 
                                               value="<?=$this->e($user->username)?>" required>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label class="form-label">البريد الإلكتروني</label>
                                <input type="email" name="email" class="form-control" 
                                       value="<?=$this->e($user->email)?>" required>
                            </div>
                            
                            <div class="form-group">
                                <label class="form-label">النبذة الشخصية</label>
                                <textarea name="bio" class="form-control" rows="3" maxlength="160"><?=$this->e($user->bio)?></textarea>
                                <div class="form-text">160 حرف كحد أقصى</div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">الموقع</label>
                                        <input type="text" name="location" class="form-control" 
                                               value="<?=$this->e($user->location)?>">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">الموقع الإلكتروني</label>
                                        <input type="url" name="website" class="form-control" 
                                               value="<?=$this->e($user->website)?>">
                                    </div>
                                </div>
                            </div>
                            
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-check2"></i>
                                حفظ التغييرات
                            </button>
                        </div>
                    </form>
                </div>

                <!-- قسم الخصوصية -->
                <div id="privacy-section" class="settings-section" style="display: none;">
                    <div class="content-header">
                        <h2 class="content-title">
                            <i class="bi bi-shield-lock"></i>
                            الخصوصية والأمان
                        </h2>
                        <p class="text-muted">تحكم في إعدادات الخصوصية والأمان الخاصة بك</p>
                    </div>

                    <form method="POST" action="/settings/privacy">
                        <div class="settings-card">
                            <div class="settings-card-header">
                                <i class="bi bi-eye"></i>
                                إعدادات الخصوصية
                            </div>
                            
                            <div class="setting-item">
                                <div class="setting-info">
                                    <div class="setting-title">مرئية الملف الشخصي</div>
                                    <div class="setting-description">تحديد من يمكنه رؤية ملفك الشخصي</div>
                                </div>
                                <div class="setting-control">
                                    <select name="profile_visibility" class="form-control">
                                        <option value="public" <?=$settings->profile_visibility === 'public' ? 'selected' : ''?>>عام</option>
                                        <option value="private" <?=$settings->profile_visibility === 'private' ? 'selected' : ''?>>خاص</option>
                                        <option value="followers" <?=$settings->profile_visibility === 'followers' ? 'selected' : ''?>>للمتابعين فقط</option>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="setting-item">
                                <div class="setting-info">
                                    <div class="setting-title">خصوصية التغريدات</div>
                                    <div class="setting-description">تحديد من يمكنه رؤية تغريداتك</div>
                                </div>
                                <div class="setting-control">
                                    <select name="tweet_privacy" class="form-control">
                                        <option value="public" <?=$settings->tweet_privacy === 'public' ? 'selected' : ''?>>عام</option>
                                        <option value="private" <?=$settings->tweet_privacy === 'private' ? 'selected' : ''?>>خاص</option>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="setting-item">
                                <div class="setting-info">
                                    <div class="setting-title">مشاركة الموقع</div>
                                    <div class="setting-description">السماح بمشاركة موقعك في التغريدات</div>
                                </div>
                                <div class="setting-control">
                                    <label class="toggle-switch">
                                        <input type="checkbox" name="location_sharing" <?=$settings->location_sharing ? 'checked' : ''?>>
                                        <span class="slider"></span>
                                    </label>
                                </div>
                            </div>
                            
                            <div class="setting-item">
                                <div class="setting-info">
                                    <div class="setting-title">البحث بالبريد الإلكتروني</div>
                                    <div class="setting-description">السماح للآخرين بالعثور عليك عبر بريدك الإلكتروني</div>
                                </div>
                                <div class="setting-control">
                                    <label class="toggle-switch">
                                        <input type="checkbox" name="search_by_email" <?=$settings->search_by_email ? 'checked' : ''?>>
                                        <span class="slider"></span>
                                    </label>
                                </div>
                            </div>
                            
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-check2"></i>
                                حفظ إعدادات الخصوصية
                            </button>
                        </div>
                    </form>
                </div>

                <!-- قسم الإشعارات -->
                <div id="notifications-section" class="settings-section" style="display: none;">
                    <div class="content-header">
                        <h2 class="content-title">
                            <i class="bi bi-bell"></i>
                            الإشعارات
                        </h2>
                        <p class="text-muted">تخصيص الإشعارات والتنبيهات</p>
                    </div>

                    <form method="POST" action="/settings/notifications">
                        <div class="settings-card">
                            <div class="settings-card-header">
                                <i class="bi bi-bell-fill"></i>
                                إعدادات الإشعارات
                            </div>
                            
                            <div class="setting-item">
                                <div class="setting-info">
                                    <div class="setting-title">إشعارات البريد الإلكتروني</div>
                                    <div class="setting-description">تلقي الإشعارات عبر البريد الإلكتروني</div>
                                </div>
                                <div class="setting-control">
                                    <label class="toggle-switch">
                                        <input type="checkbox" name="email_notifications" <?=$settings->email_notifications ? 'checked' : ''?>>
                                        <span class="slider"></span>
                                    </label>
                                </div>
                            </div>
                            
                            <div class="setting-item">
                                <div class="setting-info">
                                    <div class="setting-title">الإشعارات الفورية</div>
                                    <div class="setting-description">تلقي إشعارات فورية على المتصفح</div>
                                </div>
                                <div class="setting-control">
                                    <label class="toggle-switch">
                                        <input type="checkbox" name="push_notifications" <?=$settings->push_notifications ? 'checked' : ''?>>
                                        <span class="slider"></span>
                                    </label>
                                </div>
                            </div>
                            
                            <div class="setting-item">
                                <div class="setting-info">
                                    <div class="setting-title">إشعارات الإعجاب</div>
                                    <div class="setting-description">تلقي إشعار عند إعجاب شخص بتغريداتك</div>
                                </div>
                                <div class="setting-control">
                                    <label class="toggle-switch">
                                        <input type="checkbox" name="like_notifications" <?=$settings->like_notifications ? 'checked' : ''?>>
                                        <span class="slider"></span>
                                    </label>
                                </div>
                            </div>
                            
                            <div class="setting-item">
                                <div class="setting-info">
                                    <div class="setting-title">إشعارات الردود</div>
                                    <div class="setting-description">تلقي إشعار عند رد شخص على تغريداتك</div>
                                </div>
                                <div class="setting-control">
                                    <label class="toggle-switch">
                                        <input type="checkbox" name="reply_notifications" <?=$settings->reply_notifications ? 'checked' : ''?>>
                                        <span class="slider"></span>
                                    </label>
                                </div>
                            </div>
                            
                            <div class="setting-item">
                                <div class="setting-info">
                                    <div class="setting-title">إشعارات المتابعة</div>
                                    <div class="setting-description">تلقي إشعار عند متابعة شخص لك</div>
                                </div>
                                <div class="setting-control">
                                    <label class="toggle-switch">
                                        <input type="checkbox" name="follow_notifications" <?=$settings->follow_notifications ? 'checked' : ''?>>
                                        <span class="slider"></span>
                                    </label>
                                </div>
                            </div>
                            
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-check2"></i>
                                حفظ إعدادات الإشعارات
                            </button>
                        </div>
                    </form>
                </div>

                <!-- قسم المظهر -->
                <div id="appearance-section" class="settings-section" style="display: none;">
                    <div class="content-header">
                        <h2 class="content-title">
                            <i class="bi bi-palette"></i>
                            المظهر
                        </h2>
                        <p class="text-muted">تخصيص مظهر التطبيق حسب تفضيلاتك</p>
                    </div>

                    <form method="POST" action="/settings/appearance">
                        <div class="settings-card">
                            <div class="settings-card-header">
                                <i class="bi bi-moon-stars"></i>
                                إعدادات المظهر
                            </div>
                            
                            <div class="setting-item">
                                <div class="setting-info">
                                    <div class="setting-title">السمة</div>
                                    <div class="setting-description">اختر بين الوضع الفاتح والمظلم</div>
                                </div>
                                <div class="setting-control">
                                    <select name="theme" class="form-control">
                                        <option value="light" <?=$settings->theme === 'light' ? 'selected' : ''?>>فاتح</option>
                                        <option value="dark" <?=$settings->theme === 'dark' ? 'selected' : ''?>>مظلم</option>
                                        <option value="auto" <?=$settings->theme === 'auto' ? 'selected' : ''?>>تلقائي</option>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="setting-item">
                                <div class="setting-info">
                                    <div class="setting-title">حجم الخط</div>
                                    <div class="setting-description">تحديد حجم الخط في التطبيق</div>
                                </div>
                                <div class="setting-control">
                                    <select name="font_size" class="form-control">
                                        <option value="small" <?=$settings->font_size === 'small' ? 'selected' : ''?>>صغير</option>
                                        <option value="medium" <?=$settings->font_size === 'medium' ? 'selected' : ''?>>متوسط</option>
                                        <option value="large" <?=$settings->font_size === 'large' ? 'selected' : ''?>>كبير</option>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="setting-item">
                                <div class="setting-info">
                                    <div class="setting-title">اللغة</div>
                                    <div class="setting-description">لغة واجهة التطبيق</div>
                                </div>
                                <div class="setting-control">
                                    <select name="language" class="form-control">
                                        <option value="ar" <?=$settings->language === 'ar' ? 'selected' : ''?>>العربية</option>
                                        <option value="en" <?=$settings->language === 'en' ? 'selected' : ''?>>English</option>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="setting-item">
                                <div class="setting-info">
                                    <div class="setting-title">تشغيل الفيديوهات تلقائياً</div>
                                    <div class="setting-description">تشغيل الفيديوهات عند التمرير</div>
                                </div>
                                <div class="setting-control">
                                    <label class="toggle-switch">
                                        <input type="checkbox" name="autoplay_videos" <?=$settings->autoplay_videos ? 'checked' : ''?>>
                                        <span class="slider"></span>
                                    </label>
                                </div>
                            </div>
                            
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-check2"></i>
                                حفظ إعدادات المظهر
                            </button>
                        </div>
                    </form>
                </div>

                <!-- قسم إدارة الحساب -->
                <div id="account-section" class="settings-section" style="display: none;">
                    <div class="content-header">
                        <h2 class="content-title">
                            <i class="bi bi-person-gear"></i>
                            إدارة الحساب
                        </h2>
                        <p class="text-muted">إعدادات الأمان وإدارة الحساب</p>
                    </div>

                    <!-- تغيير كلمة المرور -->
                    <div class="settings-card">
                        <div class="settings-card-header">
                            <i class="bi bi-key"></i>
                            تغيير كلمة المرور
                        </div>
                        
                        <form method="POST" action="/settings/password">
                            <div class="form-group">
                                <label class="form-label">كلمة المرور الحالية</label>
                                <input type="password" name="current_password" class="form-control" required>
                            </div>
                            
                            <div class="form-group">
                                <label class="form-label">كلمة المرور الجديدة</label>
                                <input type="password" name="new_password" class="form-control" required>
                            </div>
                            
                            <div class="form-group">
                                <label class="form-label">تأكيد كلمة المرور الجديدة</label>
                                <input type="password" name="confirm_password" class="form-control" required>
                            </div>
                            
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-shield-check"></i>
                                تغيير كلمة المرور
                            </button>
                        </form>
                    </div>

                    <!-- الأمان المتقدم -->
                    <div class="settings-card">
                        <div class="settings-card-header">
                            <i class="bi bi-shield-fill-check"></i>
                            الأمان المتقدم
                        </div>
                        
                        <div class="setting-item">
                            <div class="setting-info">
                                <div class="setting-title">المصادقة الثنائية</div>
                                <div class="setting-description">حماية إضافية لحسابك بخطوة تحقق ثانية</div>
                            </div>
                            <div class="setting-control">
                                <label class="toggle-switch">
                                    <input type="checkbox" <?=$settings->two_factor_auth ? 'checked' : ''?>>
                                    <span class="slider"></span>
                                </label>
                            </div>
                        </div>
                        
                        <div class="setting-item">
                            <div class="setting-info">
                                <div class="setting-title">تأكيد تسجيل الدخول</div>
                                <div class="setting-description">طلب تأكيد عند تسجيل الدخول من جهاز جديد</div>
                            </div>
                            <div class="setting-control">
                                <label class="toggle-switch">
                                    <input type="checkbox" <?=$settings->login_verification ? 'checked' : ''?>>
                                    <span class="slider"></span>
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- منطقة الخطر -->
                    <div class="settings-card" style="border: 2px solid #dc3545;">
                        <div class="settings-card-header" style="color: #dc3545;">
                            <i class="bi bi-exclamation-triangle"></i>
                            منطقة الخطر
                        </div>
                        
                        <div class="setting-item">
                            <div class="setting-info">
                                <div class="setting-title">حذف الحساب</div>
                                <div class="setting-description">حذف حسابك نهائياً - هذا الإجراء لا يمكن التراجع عنه</div>
                            </div>
                            <div class="setting-control">
                                <button type="button" class="btn btn-danger" onclick="confirmDeleteAccount()">
                                    <i class="bi bi-trash"></i>
                                    حذف الحساب
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// تبديل الأقسام
document.addEventListener('DOMContentLoaded', function() {
    const navLinks = document.querySelectorAll('.nav-pills .nav-link');
    const sections = document.querySelectorAll('.settings-section');

    navLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            
            // إزالة الفئة النشطة من جميع الروابط
            navLinks.forEach(l => l.classList.remove('active'));
            
            // إضافة الفئة النشطة للرابط المحدد
            this.classList.add('active');
            
            // إخفاء جميع الأقسام
            sections.forEach(section => section.style.display = 'none');
            
            // إظهار القسم المحدد
            const sectionId = this.getAttribute('data-section') + '-section';
            const targetSection = document.getElementById(sectionId);
            if (targetSection) {
                targetSection.style.display = 'block';
            }
        });
    });
});

// تأكيد حذف الحساب
function confirmDeleteAccount() {
    if (confirm('هل أنت متأكد من رغبتك في حذف حسابك نهائياً؟ هذا الإجراء لا يمكن التراجع عنه.')) {
        if (confirm('تأكيد أخير: سيتم حذف جميع بياناتك وتغريداتك نهائياً!')) {
            // إرسال طلب حذف الحساب
            window.location.href = '/settings/delete-account';
        }
    }
}

// حفظ الإعدادات تلقائياً عند التغيير
document.querySelectorAll('input[type="checkbox"]').forEach(checkbox => {
    checkbox.addEventListener('change', function() {
        // يمكن إضافة حفظ تلقائي هنا
        console.log('تم تغيير الإعداد:', this.name, this.checked);
    });
});

// تطبيق السمة
document.addEventListener('DOMContentLoaded', function() {
    const themeSelect = document.querySelector('select[name="theme"]');
    if (themeSelect) {
        themeSelect.addEventListener('change', function() {
            const theme = this.value;
            if (theme === 'dark') {
                document.body.classList.add('dark-mode');
            } else {
                document.body.classList.remove('dark-mode');
            }
        });
        
        // تطبيق السمة الحالية
        if (themeSelect.value === 'dark') {
            document.body.classList.add('dark-mode');
        }
    }
});
</script>
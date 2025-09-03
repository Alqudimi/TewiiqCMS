<?php
// التحقق من المستخدم المسجل الدخول
$currentUser = $_SESSION['user'] ?? null;
$isLoggedIn = !empty($currentUser);
?>

<style>
/* متغيرات السايد بار */
:root {
    --primary-color: #7c4dff;
    --secondary-color: #ff6e6c;
    --accent-color: #2ce0c8;
    --bg-primary: #f8f9fa;
    --bg-secondary: #ffffff;
    --bg-tertiary: #f1f3f4;
    --text-primary: #2d3748;
    --text-secondary: #718096;
    --text-muted: #a0aec0;
    --border-color: rgba(0, 0, 0, 0.1);
    --bg-glass: rgba(255, 255, 255, 0.7);
    --border-radius: 16px;
    --transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    --box-shadow: 0 12px 36px rgba(0, 0, 0, 0.15);
    --spacing-xs: 0.5rem;
    --spacing-sm: 0.75rem;
    --spacing-md: 1rem;
    --spacing-lg: 1.5rem;
    --spacing-xl: 2rem;
}

[data-theme="dark"] {
    --primary-color: #9370ff;
    --secondary-color: #ff8c8a;
    --accent-color: #3af0da;
    --bg-primary: #1a202c;
    --bg-secondary: #2d3748;
    --bg-tertiary: #4a5568;
    --text-primary: #e2e8f0;
    --text-secondary: #a0aec0;
    --text-muted: #718096;
    --border-color: rgba(255, 255, 255, 0.1);
    --bg-glass: rgba(45, 55, 72, 0.7);
}

/* أنماط السايد بار الرئيسي */
.main-sidebar {
    position: fixed;
    top: 64px; /* مع مراعاة ارتفاع الـ navbar */
    right: 0;
    width: 320px;
    height: calc(100vh - 64px);
    background: linear-gradient(180deg, var(--bg-secondary) 0%, var(--bg-tertiary) 100%);
    border-left: 1px solid var(--border-color);
    transition: var(--transition);
    z-index: 999;
    overflow-y: auto;
    overflow-x: hidden;
    display: flex;
    flex-direction: column;
    box-shadow: var(--box-shadow);
    transform: translateX(100%);
}

.main-sidebar.show {
    transform: translateX(0);
}

.main-sidebar::-webkit-scrollbar {
    width: 4px;
}

.main-sidebar::-webkit-scrollbar-track {
    background: transparent;
}

.main-sidebar::-webkit-scrollbar-thumb {
    background: var(--primary-color);
    border-radius: 2px;
}

/* حالة السايد بار المطوي */
.main-sidebar.collapsed {
    width: 80px;
}

.main-sidebar.collapsed .menu-text,
.main-sidebar.collapsed .sidebar-stats,
.main-sidebar.collapsed .menu-arrow {
    opacity: 0;
    visibility: hidden;
}

.main-sidebar.collapsed .submenu {
    display: none;
}

/* قائمة التنقل */
.sidebar-navigation {
    flex: 1;
    padding: var(--spacing-lg) 0;
}

.sidebar-menu {
    list-style: none;
    margin: 0;
    padding: 0;
}

.menu-item {
    margin-bottom: var(--spacing-xs);
    position: relative;
}

.menu-link {
    display: flex;
    align-items: center;
    gap: var(--spacing-md);
    padding: var(--spacing-md) var(--spacing-lg);
    text-decoration: none;
    color: var(--text-secondary);
    transition: var(--transition);
    position: relative;
    overflow: hidden;
    border-radius: 0 var(--border-radius) var(--border-radius) 0;
    margin-left: var(--spacing-md);
}

.menu-link:hover,
.menu-item.active .menu-link {
    color: var(--text-primary);
    background: var(--bg-glass);
    transform: translateX(-5px);
}

.menu-item.active .menu-link {
    background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
    color: white;
    box-shadow: 0 0 15px rgba(124, 77, 255, 0.4);
}

.menu-icon {
    width: 20px;
    height: 20px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.125rem;
    flex-shrink: 0;
}

.menu-text {
    flex: 1;
    font-weight: 500;
    transition: var(--transition);
}

.menu-arrow {
    transition: transform 0.3s ease;
}

.menu-item.open .menu-arrow {
    transform: rotate(180deg);
}

.menu-indicator {
    position: absolute;
    left: 0;
    top: 0;
    bottom: 0;
    width: 0;
    background: linear-gradient(180deg, var(--primary-color), var(--secondary-color));
    transition: width 0.3s ease;
}

.menu-item.active .menu-indicator {
    width: 4px;
}

/* القوائم الفرعية */
.submenu {
    list-style: none;
    margin: 0;
    padding: 0;
    max-height: 0;
    overflow: hidden;
    transition: var(--transition);
    background: rgba(0, 0, 0, 0.1);
    margin-left: var(--spacing-md);
    border-radius: 0 0 var(--border-radius) 0;
}

.menu-item.open .submenu {
    max-height: 300px;
    padding: var(--spacing-sm) 0;
}

.submenu-link {
    display: flex;
    align-items: center;
    gap: var(--spacing-sm);
    padding: var(--spacing-sm) var(--spacing-xl);
    text-decoration: none;
    color: var(--text-muted);
    font-size: 0.875rem;
    transition: var(--transition);
    position: relative;
}

.submenu-link:hover {
    color: var(--text-primary);
    background: var(--bg-glass);
    transform: translateX(-3px);
}

/* إحصائيات سريعة */
.sidebar-stats {
    padding: var(--spacing-lg);
    border-top: 1px solid var(--border-color);
    background: var(--bg-glass);
    margin: var(--spacing-md);
    border-radius: var(--border-radius);
    transition: var(--transition);
    backdrop-filter: blur(10px);
}

.stats-title {
    display: flex;
    align-items: center;
    gap: var(--spacing-sm);
    font-size: 1rem;
    font-weight: 600;
    color: var(--text-primary);
    margin-bottom: var(--spacing-md);
}

.stats-grid {
    display: flex;
    flex-direction: column;
    gap: var(--spacing-sm);
}

.stat-item {
    display: flex;
    align-items: center;
    gap: var(--spacing-sm);
    padding: var(--spacing-sm);
    background: var(--bg-glass);
    border-radius: var(--border-radius);
    border: 1px solid var(--border-color);
    transition: var(--transition);
}

.stat-item:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.07);
}

.stat-icon {
    width: 35px;
    height: 35px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
    border-radius: var(--border-radius);
    color: white;
    flex-shrink: 0;
}

.stat-info {
    display: flex;
    flex-direction: column;
}

.stat-value {
    font-weight: 700;
    color: var(--text-primary);
}

.stat-label {
    font-size: 0.75rem;
    color: var(--text-muted);
}

/* الـ overlay للأجهزة المحمولة */
.sidebar-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.5);
    z-index: 998;
    opacity: 0;
    visibility: hidden;
    transition: var(--transition);
}

.sidebar-overlay.show {
    opacity: 1;
    visibility: visible;
}

/* Responsive */
@media (max-width: 992px) {
    .main-sidebar {
        top: 64px;
        transform: translateX(100%);
    }
    
    .main-sidebar.show {
        transform: translateX(0);
    }
}

@media (max-width: 768px) {
    .main-sidebar {
        width: 100%;
        transform: translateX(100%);
    }
}
</style>

<!-- السايد بار الرئيسي -->
<aside class="main-sidebar" id="mainSidebar">
    <!-- قائمة التنقل الرئيسية -->
    <nav class="sidebar-navigation">
        <ul class="sidebar-menu">
            <?php $currentPage = $currentPage ?? ''; ?>
            <!-- الرئيسية -->
            <li class="menu-item <?= $currentPage === 'home' ? 'active' : '' ?>">
                <a href="/" class="menu-link">
                    <div class="menu-icon">
                        <i class="bi bi-house-fill"></i>
                    </div>
                    <span class="menu-text">الرئيسية</span>
                    <div class="menu-indicator"></div>
                </a>
            </li>

            <?php if ($isLoggedIn): ?>
            <!-- الملف الشخصي -->
            <li class="menu-item <?= $currentPage === 'profile' ? 'active' : '' ?>">
                <a href="/profile/<?= $currentUser['username'] ?>" class="menu-link">
                    <div class="menu-icon">
                        <i class="bi bi-person-fill"></i>
                    </div>
                    <span class="menu-text">الملف الشخصي</span>
                    <div class="menu-indicator"></div>
                </a>
            </li>

            <!-- الإشعارات (إذا كانت متوفرة) -->
            <li class="menu-item">
                <a href="/messages" class="menu-link">
                    <div class="menu-icon">
                        <i class="bi bi-envelope-fill"></i>
                    </div>
                    <span class="menu-text">الرسائل</span>
                    <div class="menu-indicator"></div>
                </a>
            </li>

            <!-- الإعدادات -->
            <li class="menu-item <?= $currentPage === 'settings' ? 'active' : '' ?>">
                <a href="/settings" class="menu-link">
                    <div class="menu-icon">
                        <i class="bi bi-gear-fill"></i>
                    </div>
                    <span class="menu-text">الإعدادات</span>
                    <div class="menu-indicator"></div>
                </a>
            </li>

            <!-- القوائم -->
            <li class="menu-item <?= $currentPage === 'lists' ? 'active' : '' ?>">
                <a href="/lists" class="menu-link">
                    <div class="menu-icon">
                        <i class="bi bi-list-ul"></i>
                    </div>
                    <span class="menu-text">القوائم</span>
                    <div class="menu-indicator"></div>
                </a>
            </li>

            <!-- الأحداث -->
            <li class="menu-item <?= $currentPage === 'events' ? 'active' : '' ?>">
                <a href="/events" class="menu-link">
                    <div class="menu-icon">
                        <i class="bi bi-calendar-event"></i>
                    </div>
                    <span class="menu-text">الأحداث</span>
                    <div class="menu-indicator"></div>
                </a>
            </li>

            <!-- الريلز -->
            <li class="menu-item <?= $currentPage === 'reels' ? 'active' : '' ?>">
                <a href="/reels" class="menu-link">
                    <div class="menu-icon">
                        <i class="bi bi-play-circle-fill"></i>
                    </div>
                    <span class="menu-text">الريلز</span>
                    <div class="menu-indicator"></div>
                </a>
            </li>
            <?php endif; ?>

            <!-- البحث -->
            <li class="menu-item <?= $currentPage === 'search' ? 'active' : '' ?>">
                <a href="/search" class="menu-link">
                    <div class="menu-icon">
                        <i class="bi bi-search"></i>
                    </div>
                    <span class="menu-text">البحث</span>
                    <div class="menu-indicator"></div>
                </a>
            </li>

            <!-- معلومات عامة -->
            <li class="menu-item has-submenu">
                <a href="#" class="menu-link">
                    <div class="menu-icon">
                        <i class="bi bi-info-circle-fill"></i>
                    </div>
                    <span class="menu-text">معلومات</span>
                    <div class="menu-arrow">
                        <i class="bi bi-chevron-down"></i>
                    </div>
                    <div class="menu-indicator"></div>
                </a>
                <ul class="submenu">
                    <li><a href="/about" class="submenu-link"><i class="bi bi-building"></i> من نحن</a></li>
                    <li><a href="/help" class="submenu-link"><i class="bi bi-question-circle"></i> المساعدة</a></li>
                </ul>
            </li>

            <?php if (!$isLoggedIn): ?>
            <!-- تسجيل الدخول -->
            <li class="menu-item">
                <a href="/login" class="menu-link">
                    <div class="menu-icon">
                        <i class="bi bi-box-arrow-in-right"></i>
                    </div>
                    <span class="menu-text">تسجيل الدخول</span>
                    <div class="menu-indicator"></div>
                </a>
            </li>

            <!-- إنشاء حساب -->
            <li class="menu-item">
                <a href="/register" class="menu-link">
                    <div class="menu-icon">
                        <i class="bi bi-person-plus-fill"></i>
                    </div>
                    <span class="menu-text">إنشاء حساب</span>
                    <div class="menu-indicator"></div>
                </a>
            </li>
            <?php endif; ?>
        </ul>
    </nav>

    <?php if ($isLoggedIn): ?>
    <!-- قسم الإحصائيات السريعة -->
    <div class="sidebar-stats">
        <h4 class="stats-title">
            <i class="bi bi-graph-up"></i>
            إحصائيات سريعة
        </h4>
        <div class="stats-grid">
            <div class="stat-item">
                <div class="stat-icon">
                    <i class="bi bi-chat-dots"></i>
                </div>
                <div class="stat-info">
                    <span class="stat-value"><?= \RedBeanPHP\R::count('tweets', 'user_id = ?', [$currentUser['id']]) ?></span>
                    <span class="stat-label">تغريداتي</span>
                </div>
            </div>
            <div class="stat-item">
                <div class="stat-icon">
                    <i class="bi bi-people"></i>
                </div>
                <div class="stat-info">
                    <span class="stat-value"><?= \RedBeanPHP\R::count('follows', 'following_id = ?', [$currentUser['id']]) ?></span>
                    <span class="stat-label">متابعين</span>
                </div>
            </div>
            <div class="stat-item">
                <div class="stat-icon">
                    <i class="bi bi-person-check"></i>
                </div>
                <div class="stat-info">
                    <span class="stat-value"><?= \RedBeanPHP\R::count('follows', 'follower_id = ?', [$currentUser['id']]) ?></span>
                    <span class="stat-label">أتابع</span>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>
</aside>

<!-- خلفية السايد بار للأجهزة المحمولة -->
<div class="sidebar-overlay" id="sidebarOverlay"></div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const sidebar = document.getElementById('mainSidebar');
    const sidebarToggle = document.getElementById('sidebarToggle');
    const sidebarOverlay = document.getElementById('sidebarOverlay');
    const submenuToggles = document.querySelectorAll('.has-submenu > .menu-link');
    
    // تبديل السايد بار
    if (sidebarToggle) {
        sidebarToggle.addEventListener('click', function() {
            sidebar.classList.toggle('show');
            sidebarOverlay.classList.toggle('show');
        });
    }
    
    // إغلاق السايد بار بالنقر على الخلفية
    if (sidebarOverlay) {
        sidebarOverlay.addEventListener('click', function() {
            sidebar.classList.remove('show');
            sidebarOverlay.classList.remove('show');
        });
    }
    
    // تبديل القوائم الفرعية
    submenuToggles.forEach(toggle => {
        toggle.addEventListener('click', function(e) {
            e.preventDefault();
            const parent = this.parentElement;
            parent.classList.toggle('open');
        });
    });
    
    // إغلاق السايد بار عند النقر على رابط (للأجهزة المحمولة)
    const menuLinks = document.querySelectorAll('.menu-link:not(.has-submenu .menu-link)');
    menuLinks.forEach(link => {
        link.addEventListener('click', function() {
            if (window.innerWidth <= 992) {
                sidebar.classList.remove('show');
                sidebarOverlay.classList.remove('show');
            }
        });
    });
});
</script>
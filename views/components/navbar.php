<?php
// التحقق من المستخدم المسجل الدخول
$currentUser = $_SESSION['user'] ?? null;
$isLoggedIn = !empty($currentUser);
?>

<style>
/* متغيرات الألوان */
:root {
    --navbar-primary: #7c4dff;
    --navbar-secondary: #ff6e6c;
    --navbar-accent: #2ce0c8;
    --navbar-background: #ffffff;
    --navbar-text: #2d3748;
    --navbar-text-inactive: #718096;
    --navbar-border: #e2e8f0;
    --navbar-hover: #f7fafc;
    --navbar-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    --border-radius-sm: 8px;
    --border-radius-md: 16px;
    --transition-fast: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
    --transition-medium: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

[data-theme="dark"] {
    --navbar-primary: #9370ff;
    --navbar-secondary: #ff8c8a;
    --navbar-accent: #3af0da;
    --navbar-background: #1a202c;
    --navbar-text: #e2e8f0;
    --navbar-text-inactive: #a0aec0;
    --navbar-border: #4a5568;
    --navbar-hover: #2d3748;
    --navbar-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
}

/* Navbar Styles */
.navbar {
    background-color: var(--navbar-background);
    box-shadow: var(--navbar-shadow);
    padding: 0.5rem 1rem;
    transition: var(--transition-medium);
    border-bottom: 1px solid var(--navbar-border);
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    z-index: 1030;
    height: 64px;
    display: flex;
    align-items: center;
}

.navbar-container {
    display: flex;
    align-items: center;
    justify-content: space-between;
    width: 100%;
    max-width: 1400px;
    margin: 0 auto;
}

.navbar-section {
    display: flex;
    align-items: center;
    flex: 1;
}

.navbar-section-left {
    justify-content: flex-start;
}

.navbar-section-center {
    justify-content: center;
}

.navbar-section-right {
    justify-content: flex-end;
}

.navbar-brand {
    font-weight: 800;
    color: var(--navbar-primary);
    font-size: 1.75rem;
    display: flex;
    align-items: center;
    transition: var(--transition-medium);
    text-decoration: none;
}

.navbar-brand:hover {
    color: var(--navbar-primary);
    transform: scale(1.05);
}

.navbar-brand i {
    margin-left: 0.5rem;
    transition: var(--transition-medium);
}

.navbar-toggler {
    background: transparent;
    border: none;
    color: var(--navbar-text);
    font-size: 1.5rem;
    padding: 0.5rem;
    border-radius: var(--border-radius-sm);
    transition: var(--transition-fast);
    display: none;
}

.navbar-toggler:hover {
    background-color: var(--navbar-hover);
}

.nav-search {
    position: relative;
    max-width: 400px;
    width: 100%;
    transition: var(--transition-medium);
}

.nav-search-input {
    background-color: var(--navbar-hover);
    border: 2px solid transparent;
    border-radius: 50px;
    padding: 0.6rem 1rem 0.6rem 3rem;
    width: 100%;
    transition: var(--transition-medium);
    color: var(--navbar-text);
    font-family: 'Tajawal', sans-serif;
}

.nav-search-input:focus {
    box-shadow: 0 0 0 3px rgba(124, 77, 255, 0.2);
    border-color: var(--navbar-primary);
    outline: none;
    background-color: var(--navbar-background);
}

.nav-search-icon {
    position: absolute;
    right: 1.2rem;
    top: 50%;
    transform: translateY(-50%);
    color: var(--navbar-text);
    opacity: 0.7;
    transition: var(--transition-medium);
}

.nav-search-input:focus + .nav-search-icon {
    color: var(--navbar-primary);
    opacity: 1;
}

.nav-tabs {
    display: flex;
    gap: 0.5rem;
    margin: 0 1rem;
}

.nav-tab {
    background: transparent;
    border: none;
    padding: 0.5rem 1rem;
    border-radius: var(--border-radius-md);
    font-weight: 600;
    color: var(--navbar-text-inactive);
    transition: var(--transition-fast);
    position: relative;
    text-decoration: none;
    display: flex;
    align-items: center;
}

.nav-tab i {
    margin-left: 0.5rem;
}

.nav-tab:hover {
    color: var(--navbar-text);
    background-color: var(--navbar-hover);
}

.nav-tab.active {
    color: var(--navbar-primary);
}

.nav-tab.active::after {
    content: '';
    position: absolute;
    bottom: -8px;
    right: 50%;
    transform: translateX(50%);
    width: 6px;
    height: 6px;
    background-color: var(--navbar-primary);
    border-radius: 50%;
}

.nav-icon {
    background: transparent;
    border: none;
    color: var(--navbar-text);
    width: 40px;
    height: 40px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: var(--transition-fast);
    position: relative;
    margin: 0 0.25rem;
}

.nav-icon:hover {
    background-color: var(--navbar-hover);
    color: var(--navbar-primary);
}

.nav-badge {
    position: absolute;
    top: -5px;
    left: -5px;
    background-color: var(--navbar-secondary);
    color: white;
    border-radius: 50%;
    width: 20px;
    height: 20px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.7rem;
    font-weight: 700;
    transition: var(--transition-medium);
}

.btn-tweet {
    background: linear-gradient(135deg, var(--navbar-primary), var(--navbar-secondary));
    color: white;
    border-radius: 50px;
    padding: 0.6rem 1.5rem;
    font-weight: 700;
    transition: var(--transition-medium);
    border: none;
    box-shadow: var(--navbar-shadow);
    display: flex;
    align-items: center;
    margin: 0 0.5rem;
}

.btn-tweet:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
}

.btn-tweet i {
    margin-left: 0.5rem;
}

.theme-toggle {
    background: var(--navbar-hover);
    border: none;
    color: var(--navbar-text);
    font-size: 1.25rem;
    transition: var(--transition-medium);
    width: 40px;
    height: 40px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 0.5rem;
}

.theme-toggle:hover {
    background-color: var(--navbar-primary);
    color: white;
    transform: rotate(30deg);
}

.user-dropdown {
    position: relative;
}

.user-dropdown-toggle {
    background: transparent;
    border: none;
    padding: 0.25rem;
    border-radius: 50px;
    display: flex;
    align-items: center;
    transition: var(--transition-fast);
    text-decoration: none;
    color: var(--navbar-text);
}

.user-dropdown-toggle:hover {
    background-color: var(--navbar-hover);
}

.user-avatar {
    width: 36px;
    height: 36px;
    border-radius: 50%;
    object-fit: cover;
    margin-left: 0.5rem;
    border: 2px solid var(--navbar-primary);
    padding: 2px;
    transition: var(--transition-medium);
}

.user-dropdown-toggle:hover .user-avatar {
    border-color: var(--navbar-primary);
    transform: scale(1.05);
}

.user-name {
    font-weight: 700;
    font-size: 0.9rem;
    margin: 0 0.5rem;
}

.dropdown-menu {
    background-color: var(--navbar-background);
    border: 1px solid var(--navbar-border);
    border-radius: var(--border-radius-md);
    box-shadow: var(--navbar-shadow);
    padding: 0.5rem;
    transition: var(--transition-medium);
    min-width: 250px;
    position: absolute;
    left: 0;
    top: 100%;
    margin-top: 0.5rem;
    z-index: 1000;
    display: none;
}

.dropdown-menu.show {
    display: block;
    animation: fadeIn 0.3s ease;
}

.dropdown-item {
    padding: 0.5rem 1rem;
    display: block;
    color: var(--navbar-text);
    text-decoration: none;
    border-radius: var(--border-radius-sm);
    transition: var(--transition-fast);
}

.dropdown-item:hover {
    background-color: var(--navbar-hover);
    color: var(--navbar-primary);
}

/* Responsive Styles */
@media (max-width: 992px) {
    .navbar-toggler {
        display: block;
    }
    
    .nav-tabs {
        display: none;
    }
}

@media (max-width: 768px) {
    .nav-search {
        max-width: 200px;
    }
    
    .navbar-brand span {
        display: none;
    }
    
    .btn-tweet span {
        display: none;
    }
    
    .btn-tweet {
        padding: 0.6rem;
        width: 40px;
        height: 40px;
    }
    
    .btn-tweet i {
        margin: 0;
    }
    
    .user-name {
        display: none;
    }
}

@media (max-width: 576px) {
    .nav-search {
        display: none;
    }
    
    .navbar-section-center {
        display: none;
    }
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(-10px); }
    to { opacity: 1; transform: translateY(0); }
}
</style>

<!-- Navigation Bar -->
<nav class="navbar">
    <div class="navbar-container">
        <!-- Left Section -->
        <div class="navbar-section navbar-section-left">
            <button class="navbar-toggler" id="sidebarToggle" aria-label="تبديل القائمة الجانبية">
                <i class="bi bi-list"></i>
            </button>
            
            <a href="/" class="navbar-brand">
                <i class="bi bi-twitter"></i>
                <span>تويق</span>
            </a>
            
            <div class="nav-tabs d-none d-xl-flex">
                <?php $activeTab = $activeTab ?? ''; ?>
                <a href="/" class="nav-tab <?= $activeTab === 'home' ? 'active' : '' ?>">
                    <i class="bi bi-house-fill"></i>
                    <span>الرئيسية</span>
                </a>
                <a href="/search" class="nav-tab <?= $activeTab === 'explore' ? 'active' : '' ?>">
                    <i class="bi bi-hash"></i>
                    <span>استكشاف</span>
                </a>
                <?php if ($isLoggedIn): ?>
                <a href="/messages" class="nav-tab <?= $activeTab === 'messages' ? 'active' : '' ?>">
                    <i class="bi bi-envelope"></i>
                    <span>الرسائل</span>
                </a>
                <?php endif; ?>
            </div>
        </div>
        
        <!-- Center Section -->
        <div class="navbar-section navbar-section-center">
            <form action="/search" method="GET" class="nav-search">
                <input type="text" class="nav-search-input" name="q" placeholder="بحث في تويق" aria-label="بحث في تويق">
                <i class="bi bi-search nav-search-icon"></i>
            </form>
        </div>
        
        <!-- Right Section -->
        <div class="navbar-section navbar-section-right">
            <?php if ($isLoggedIn): ?>
                <button class="nav-icon" onclick="window.location.href='/messages'" aria-label="الرسائل">
                    <i class="bi bi-envelope"></i>
                    <?php
                    // يمكن إضافة منطق لحساب عدد الرسائل غير المقروءة
                    $unreadMessages = 0; // مؤقت
                    if ($unreadMessages > 0): ?>
                    <span class="nav-badge"><?= $unreadMessages ?></span>
                    <?php endif; ?>
                </button>
                
                <button class="btn-tweet" onclick="openTweetModal()">
                    <i class="bi bi-pencil"></i>
                    <span>تغريدة</span>
                </button>
                
                <button class="theme-toggle" id="themeToggle" aria-label="تبديل الوضع المظلم">
                    <i class="bi bi-moon"></i>
                </button>
                
                <div class="user-dropdown">
                    <button class="user-dropdown-toggle" id="userDropdownToggle" aria-expanded="false" aria-label="قائمة المستخدم">
                        <img src="<?= $currentUser['avatar'] ?? 'https://via.placeholder.com/36' ?>" alt="صورة المستخدم" class="user-avatar">
                        <span class="user-name"><?= htmlspecialchars($currentUser['fullname'] ?? '') ?></span>
                        <i class="bi bi-chevron-down"></i>
                    </button>
                    
                    <div class="dropdown-menu" id="userDropdown">
                        <a href="/profile/<?= $currentUser['username'] ?>" class="dropdown-item">
                            <i class="bi bi-person"></i> الملف الشخصي
                        </a>
                        <a href="/settings" class="dropdown-item">
                            <i class="bi bi-gear"></i> الإعدادات
                        </a>
                        <a href="/about" class="dropdown-item">
                            <i class="bi bi-info-circle"></i> من نحن
                        </a>
                        <a href="/help" class="dropdown-item">
                            <i class="bi bi-question-circle"></i> المساعدة
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="/logout" class="dropdown-item">
                            <i class="bi bi-box-arrow-right"></i> تسجيل الخروج
                        </a>
                    </div>
                </div>
            <?php else: ?>
                <a href="/login" class="btn btn-outline-primary me-2">تسجيل الدخول</a>
                <a href="/register" class="btn btn-primary">إنشاء حساب</a>
            <?php endif; ?>
        </div>
    </div>
</nav>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // User dropdown functionality
    const userDropdownToggle = document.getElementById('userDropdownToggle');
    const userDropdown = document.getElementById('userDropdown');
    
    if (userDropdownToggle && userDropdown) {
        userDropdownToggle.addEventListener('click', function() {
            userDropdown.classList.toggle('show');
        });
        
        // Close dropdown when clicking outside
        document.addEventListener('click', function(event) {
            if (!userDropdownToggle.contains(event.target) && !userDropdown.contains(event.target)) {
                userDropdown.classList.remove('show');
            }
        });
    }
    
    // Theme toggle functionality
    const themeToggle = document.getElementById('themeToggle');
    if (themeToggle) {
        themeToggle.addEventListener('click', function() {
            const currentTheme = document.documentElement.getAttribute('data-theme');
            const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
            
            document.documentElement.setAttribute('data-theme', newTheme);
            localStorage.setItem('theme', newTheme);
            
            // Update icon
            const icon = themeToggle.querySelector('i');
            if (newTheme === 'dark') {
                icon.className = 'bi bi-sun';
            } else {
                icon.className = 'bi bi-moon';
            }
        });
        
        // Load saved theme
        const savedTheme = localStorage.getItem('theme') || 'light';
        document.documentElement.setAttribute('data-theme', savedTheme);
        const icon = themeToggle.querySelector('i');
        if (savedTheme === 'dark') {
            icon.className = 'bi bi-sun';
        }
    }
});

// Tweet modal function (to be implemented)
function openTweetModal() {
    // يمكن إضافة منطق لفتح نافذة كتابة التغريدة
    window.location.href = '/';
}
</script>
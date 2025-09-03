<?php $this->layout('layouts/app', [
    'title' => 'المركز المساعد - تويق',
    'activeTab' => 'help',
    'currentPage' => 'help'
]) ?>

<!-- أنماط خاصة بصفحة المساعدة -->
<style>
    /* أنماط الهيرو */
    .help-hero {
        background: linear-gradient(135deg, var(--primary), var(--accent));
        color: white;
        padding: 3rem 2rem;
        border-radius: var(--border-radius);
        margin: -2rem -1rem 2rem -1rem;
        text-align: center;
    }

    .search-container {
        position: relative;
        max-width: 600px;
        margin: 2rem auto 0;
    }

    .search-input {
        padding: 1.2rem 1.5rem 1.2rem 3.5rem;
        border-radius: 50px;
        font-size: 1.1rem;
        border: none;
        box-shadow: var(--box-shadow);
        width: 100%;
        background-color: white;
        color: var(--text);
    }

    .search-icon {
        position: absolute;
        right: 1.5rem;
        top: 50%;
        transform: translateY(-50%);
        color: var(--primary);
        font-size: 1.2rem;
    }

    /* بطاقات المساعدة */
    .help-section {
        margin-bottom: 3rem;
    }

    .section-title {
        font-weight: 700;
        margin-bottom: 1.5rem;
        color: var(--primary);
        position: relative;
        padding-bottom: 0.5rem;
    }

    .section-title::after {
        content: '';
        position: absolute;
        bottom: 0;
        right: 0;
        width: 60px;
        height: 4px;
        background: linear-gradient(135deg, var(--primary), var(--accent));
        border-radius: 2px;
    }

    .common-issues-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 1.5rem;
        margin-bottom: 3rem;
    }

    .common-issue-card {
        background-color: var(--card);
        border: 1px solid var(--border);
        border-radius: var(--border-radius);
        padding: 1.5rem;
        transition: var(--transition);
        cursor: pointer;
        height: 100%;
        border-left: 4px solid transparent;
    }

    .common-issue-card:hover {
        transform: translateY(-3px);
        border-left-color: var(--primary);
        box-shadow: var(--box-shadow);
    }

    .issue-icon {
        font-size: 2rem;
        color: var(--primary);
        margin-bottom: 1rem;
    }

    .issue-title {
        font-weight: 600;
        margin-bottom: 0.5rem;
        color: var(--text);
    }

    .issue-description {
        color: var(--text-secondary);
        font-size: 0.9rem;
    }

    /* فئات المساعدة */
    .help-category {
        margin-bottom: 2rem;
        background-color: var(--card);
        border: 1px solid var(--border);
        border-radius: var(--border-radius);
        overflow: hidden;
    }

    .category-header {
        display: flex;
        align-items: center;
        padding: 1.5rem;
        cursor: pointer;
        background-color: var(--input);
        transition: var(--transition);
    }

    .category-header:hover {
        background-color: var(--border);
    }

    .category-icon {
        width: 50px;
        height: 50px;
        border-radius: 12px;
        background: linear-gradient(135deg, var(--primary), var(--accent));
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1.5rem;
        margin-left: 1rem;
        transition: var(--transition);
    }

    .category-header:hover .category-icon {
        transform: scale(1.1) rotate(5deg);
    }

    .category-title {
        font-weight: 600;
        margin: 0;
        color: var(--text);
    }

    .category-toggle {
        margin-right: auto;
        color: var(--text-secondary);
        transition: var(--transition);
    }

    .category-content {
        padding: 0 1.5rem;
        max-height: 0;
        overflow: hidden;
        transition: max-height 0.3s ease;
    }

    .category-content.active {
        max-height: 500px;
        padding: 1.5rem;
    }

    .articles-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .article-item {
        padding: 0.8rem 0;
        border-bottom: 1px solid var(--border);
        transition: var(--transition);
    }

    .article-item:last-child {
        border-bottom: none;
    }

    .article-item:hover {
        padding-right: 1rem;
    }

    .article-item a {
        color: var(--text);
        text-decoration: none;
        display: flex;
        align-items: center;
        transition: var(--transition);
    }

    .article-item:hover a {
        color: var(--primary);
    }

    .article-item i {
        margin-left: 0.5rem;
        color: var(--primary);
        transition: var(--transition);
    }

    .article-item:hover i {
        transform: translateX(-5px);
    }

    /* خيارات التواصل */
    .contact-options {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 1.5rem;
        margin-top: 2rem;
    }

    .contact-option {
        background-color: var(--card);
        border: 1px solid var(--border);
        padding: 1.5rem;
        border-radius: var(--border-radius);
        text-align: center;
        transition: var(--transition);
        height: 100%;
        border: 2px solid transparent;
    }

    .contact-option:hover {
        border-color: var(--primary);
        transform: translateY(-5px);
        box-shadow: var(--box-shadow);
    }

    .contact-icon {
        width: 70px;
        height: 70px;
        border-radius: 50%;
        background: linear-gradient(135deg, var(--primary), var(--accent));
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 2rem;
        margin: 0 auto 1rem;
        transition: var(--transition);
    }

    .contact-option:hover .contact-icon {
        transform: scale(1.1) rotate(5deg);
    }

    .contact-title {
        font-weight: 600;
        margin-bottom: 0.5rem;
        color: var(--text);
    }

    .contact-description {
        color: var(--text-secondary);
        font-size: 0.9rem;
        margin-bottom: 1rem;
    }

    .support-status {
        display: inline-block;
        padding: 0.3rem 0.8rem;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 600;
        margin-top: 0.5rem;
    }

    .status-online {
        background-color: var(--success-light);
        color: var(--success-dark);
    }

    .status-offline {
        background-color: var(--error-light);
        color: var(--error-dark);
    }

    .status-busy {
        background-color: var(--warning-light);
        color: var(--warning-dark);
    }

    /* أزرار التقييم */
    .helpful-section {
        text-align: center;
        padding: 2rem;
        margin-top: 3rem;
        background-color: var(--input);
        border-radius: var(--border-radius);
    }

    .helpful-buttons {
        display: flex;
        gap: 1rem;
        justify-content: center;
        margin-top: 1rem;
    }

    .helpful-btn {
        display: inline-flex;
        align-items: center;
        padding: 0.5rem 1rem;
        border-radius: 20px;
        background-color: var(--card);
        color: var(--text);
        border: 1px solid var(--border);
        transition: var(--transition);
        cursor: pointer;
        text-decoration: none;
    }

    .helpful-btn:hover, .helpful-btn.active {
        background-color: var(--success-light);
        color: var(--success-dark);
        border-color: var(--success-light);
    }

    .helpful-btn i {
        margin-left: 0.5rem;
    }

    /* الاستجابة للأجهزة */
    @media (max-width: 768px) {
        .help-hero {
            padding: 2rem 1rem;
        }
        
        .search-input {
            padding: 1rem 1rem 1rem 3rem;
        }
        
        .category-header {
            padding: 1rem;
        }
        
        .category-icon {
            width: 40px;
            height: 40px;
            font-size: 1.2rem;
        }
        
        .helpful-buttons {
            flex-direction: column;
            align-items: center;
        }
    }

    /* متغيرات الألوان للحالات */
    :root {
        --success-light: rgba(72, 187, 120, 0.1);
        --success-dark: #48bb78;
        --error-light: rgba(245, 101, 101, 0.1);
        --error-dark: #f56565;
        --warning-light: rgba(237, 137, 54, 0.1);
        --warning-dark: #ed8936;
    }
</style>

<!-- هيرو المساعدة -->
<section class="help-hero">
    <div class="container">
        <h1 class="mb-3">كيف يمكننا مساعدتك؟</h1>
        <p class="mb-0">ابحث في مركز المساعدة أو تصفح الموضوعات الشائعة أدناه</p>
        
        <div class="search-container">
            <input type="text" class="search-input" id="helpSearch" placeholder="ابحث عن إجابة لسؤالك...">
            <i class="bi bi-search search-icon"></i>
        </div>
    </div>
</section>

<!-- المشاكل الشائعة -->
<section class="help-section">
    <div class="container">
        <h2 class="section-title">المشاكل الشائعة</h2>
        <div class="common-issues-grid">
            <div class="common-issue-card" onclick="openHelpArticle('login-issues')">
                <div class="issue-icon">
                    <i class="bi bi-person-x"></i>
                </div>
                <h4 class="issue-title">مشاكل تسجيل الدخول</h4>
                <p class="issue-description">لا أستطيع تسجيل الدخول إلى حسابي أو نسيت كلمة المرور</p>
            </div>
            
            <div class="common-issue-card" onclick="openHelpArticle('privacy-settings')">
                <div class="issue-icon">
                    <i class="bi bi-shield-lock"></i>
                </div>
                <h4 class="issue-title">إعدادات الخصوصية</h4>
                <p class="issue-description">كيفية تغيير إعدادات الخصوصية وحماية حسابي</p>
            </div>
            
            <div class="common-issue-card" onclick="openHelpArticle('notifications')">
                <div class="issue-icon">
                    <i class="bi bi-bell-slash"></i>
                </div>
                <h4 class="issue-title">الإشعارات</h4>
                <p class="issue-description">لا أتلقى إشعارات أو أريد تخصيص الإشعارات</p>
            </div>
            
            <div class="common-issue-card" onclick="openHelpArticle('account-verification')">
                <div class="issue-icon">
                    <i class="bi bi-patch-check"></i>
                </div>
                <h4 class="issue-title">توثيق الحساب</h4>
                <p class="issue-description">كيفية الحصول على العلامة الزرقاء لتوثيق الحساب</p>
            </div>
            
            <div class="common-issue-card" onclick="openHelpArticle('blocking-users')">
                <div class="issue-icon">
                    <i class="bi bi-person-slash"></i>
                </div>
                <h4 class="issue-title">حظر المستخدمين</h4>
                <p class="issue-description">كيفية حظر أو إلغاء حظر المستخدمين المزعجين</p>
            </div>
            
            <div class="common-issue-card" onclick="openHelpArticle('content-moderation')">
                <div class="issue-icon">
                    <i class="bi bi-flag"></i>
                </div>
                <h4 class="issue-title">الإبلاغ عن محتوى</h4>
                <p class="issue-description">كيفية الإبلاغ عن محتوى مخل أو غير لائق</p>
            </div>
        </div>
    </div>
</section>

<!-- فئات المساعدة -->
<section class="help-section">
    <div class="container">
        <h2 class="section-title">موضوعات المساعدة</h2>
        
        <div class="help-category">
            <div class="category-header" onclick="toggleCategory('account-management')">
                <div class="category-icon">
                    <i class="bi bi-person-gear"></i>
                </div>
                <h3 class="category-title">إدارة الحساب</h3>
                <i class="bi bi-chevron-down category-toggle"></i>
            </div>
            <div class="category-content" id="account-management">
                <ul class="articles-list">
                    <li class="article-item">
                        <a href="#"><i class="bi bi-arrow-left"></i> إنشاء حساب جديد</a>
                    </li>
                    <li class="article-item">
                        <a href="#"><i class="bi bi-arrow-left"></i> تغيير كلمة المرور</a>
                    </li>
                    <li class="article-item">
                        <a href="#"><i class="bi bi-arrow-left"></i> تحديث معلومات الملف الشخصي</a>
                    </li>
                    <li class="article-item">
                        <a href="#"><i class="bi bi-arrow-left"></i> حذف الحساب نهائياً</a>
                    </li>
                    <li class="article-item">
                        <a href="#"><i class="bi bi-arrow-left"></i> استرداد حساب محذوف</a>
                    </li>
                </ul>
            </div>
        </div>
        
        <div class="help-category">
            <div class="category-header" onclick="toggleCategory('privacy-security')">
                <div class="category-icon">
                    <i class="bi bi-shield-check"></i>
                </div>
                <h3 class="category-title">الخصوصية والأمان</h3>
                <i class="bi bi-chevron-down category-toggle"></i>
            </div>
            <div class="category-content" id="privacy-security">
                <ul class="articles-list">
                    <li class="article-item">
                        <a href="#"><i class="bi bi-arrow-left"></i> إعدادات الخصوصية</a>
                    </li>
                    <li class="article-item">
                        <a href="#"><i class="bi bi-arrow-left"></i> التحقق بخطوتين</a>
                    </li>
                    <li class="article-item">
                        <a href="#"><i class="bi bi-arrow-left"></i> إدارة الأجهزة المتصلة</a>
                    </li>
                    <li class="article-item">
                        <a href="#"><i class="bi bi-arrow-left"></i> تنزيل بياناتك</a>
                    </li>
                </ul>
            </div>
        </div>
        
        <div class="help-category">
            <div class="category-header" onclick="toggleCategory('using-features')">
                <div class="category-icon">
                    <i class="bi bi-star"></i>
                </div>
                <h3 class="category-title">استخدام الميزات</h3>
                <i class="bi bi-chevron-down category-toggle"></i>
            </div>
            <div class="category-content" id="using-features">
                <ul class="articles-list">
                    <li class="article-item">
                        <a href="#"><i class="bi bi-arrow-left"></i> كيفية كتابة تغريدة</a>
                    </li>
                    <li class="article-item">
                        <a href="#"><i class="bi bi-arrow-left"></i> استخدام الهاشتاجات</a>
                    </li>
                    <li class="article-item">
                        <a href="#"><i class="bi bi-arrow-left"></i> إنشاء وإدارة القوائم</a>
                    </li>
                    <li class="article-item">
                        <a href="#"><i class="bi bi-arrow-left"></i> الرسائل المباشرة</a>
                    </li>
                    <li class="article-item">
                        <a href="#"><i class="bi bi-arrow-left"></i> استخدام الريلز</a>
                    </li>
                </ul>
            </div>
        </div>
        
        <div class="help-category">
            <div class="category-header" onclick="toggleCategory('troubleshooting')">
                <div class="category-icon">
                    <i class="bi bi-tools"></i>
                </div>
                <h3 class="category-title">حل المشاكل</h3>
                <i class="bi bi-chevron-down category-toggle"></i>
            </div>
            <div class="category-content" id="troubleshooting">
                <ul class="articles-list">
                    <li class="article-item">
                        <a href="#"><i class="bi bi-arrow-left"></i> التطبيق لا يعمل بشكل صحيح</a>
                    </li>
                    <li class="article-item">
                        <a href="#"><i class="bi bi-arrow-left"></i> مشاكل تحميل الصور</a>
                    </li>
                    <li class="article-item">
                        <a href="#"><i class="bi bi-arrow-left"></i> بطء في التطبيق</a>
                    </li>
                    <li class="article-item">
                        <a href="#"><i class="bi bi-arrow-left"></i> مشاكل الإشعارات</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</section>

<!-- تواصل معنا -->
<section class="help-section">
    <div class="container">
        <h2 class="section-title">تواصل معنا</h2>
        <p class="text-center mb-4">لم تجد إجابة لسؤالك؟ فريق الدعم جاهز لمساعدتك</p>
        
        <div class="contact-options">
            <div class="contact-option">
                <div class="contact-icon">
                    <i class="bi bi-chat-dots"></i>
                </div>
                <h4 class="contact-title">المحادثة المباشرة</h4>
                <p class="contact-description">تحدث مع فريق الدعم مباشرة للحصول على مساعدة فورية</p>
                <span class="support-status status-online">متاح الآن</span>
            </div>
            
            <div class="contact-option">
                <div class="contact-icon">
                    <i class="bi bi-envelope"></i>
                </div>
                <h4 class="contact-title">البريد الإلكتروني</h4>
                <p class="contact-description">أرسل لنا رسالة مفصلة وسنرد عليك خلال 24 ساعة</p>
                <span class="support-status status-online">يرد خلال 24 ساعة</span>
            </div>
            
            <div class="contact-option">
                <div class="contact-icon">
                    <i class="bi bi-telephone"></i>
                </div>
                <h4 class="contact-title">الدعم الهاتفي</h4>
                <p class="contact-description">اتصل بنا للحالات العاجلة والمشاكل المعقدة</p>
                <span class="support-status status-busy">الأحد - الخميس 9ص - 6م</span>
            </div>
        </div>
    </div>
</section>

<!-- تقييم المساعدة -->
<section class="helpful-section">
    <div class="container">
        <h3>هل كانت هذه الصفحة مفيدة؟</h3>
        <div class="helpful-buttons">
            <button class="helpful-btn" onclick="rateHelp(true)">
                <i class="bi bi-hand-thumbs-up"></i>
                نعم، مفيدة
            </button>
            <button class="helpful-btn" onclick="rateHelp(false)">
                <i class="bi bi-hand-thumbs-down"></i>
                لا، غير مفيدة
            </button>
        </div>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // البحث في المساعدة
    const searchInput = document.getElementById('helpSearch');
    searchInput.addEventListener('input', function() {
        const query = this.value.toLowerCase();
        const issueCards = document.querySelectorAll('.common-issue-card');
        
        issueCards.forEach(card => {
            const title = card.querySelector('.issue-title').textContent.toLowerCase();
            const description = card.querySelector('.issue-description').textContent.toLowerCase();
            
            if (title.includes(query) || description.includes(query)) {
                card.style.display = 'block';
            } else {
                card.style.display = query === '' ? 'block' : 'none';
            }
        });
    });
});

// تبديل فئات المساعدة
function toggleCategory(categoryId) {
    const content = document.getElementById(categoryId);
    const header = content.previousElementSibling;
    const toggle = header.querySelector('.category-toggle');
    
    if (content.classList.contains('active')) {
        content.classList.remove('active');
        toggle.style.transform = 'rotate(0deg)';
    } else {
        // إغلاق جميع الفئات الأخرى
        document.querySelectorAll('.category-content.active').forEach(el => {
            el.classList.remove('active');
            el.previousElementSibling.querySelector('.category-toggle').style.transform = 'rotate(0deg)';
        });
        
        content.classList.add('active');
        toggle.style.transform = 'rotate(180deg)';
    }
}

// فتح مقال المساعدة
function openHelpArticle(articleId) {
    // يمكن إضافة منطق لفتح صفحة المقال أو عرض محتوى مفصل
    console.log('Opening help article:', articleId);
    // مثال: window.location.href = `/help/article/${articleId}`;
}

// تقييم المساعدة
function rateHelp(isHelpful) {
    const buttons = document.querySelectorAll('.helpful-btn');
    buttons.forEach(btn => btn.classList.remove('active'));
    
    if (isHelpful) {
        buttons[0].classList.add('active');
        // إرسال تقييم إيجابي
        console.log('Positive feedback sent');
    } else {
        buttons[1].classList.add('active');
        // إرسال تقييم سلبي
        console.log('Negative feedback sent');
    }
    
    // إظهار رسالة شكر
    setTimeout(() => {
        alert('شكراً لك على تقييمك! سنعمل على تحسين تجربتك.');
    }, 500);
}
</script>
<style>
/* متغيرات الفوتر */
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
    --bg-glass: rgba(255, 255, 255, 0.1);
    --border-radius: 16px;
    --transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    --box-shadow: 0 12px 36px rgba(0, 0, 0, 0.15);
    --spacing-xs: 0.5rem;
    --spacing-sm: 0.75rem;
    --spacing-md: 1rem;
    --spacing-lg: 1.5rem;
    --spacing-xl: 2rem;
    --spacing-2xl: 3rem;
    --text-xs: 0.75rem;
    --text-sm: 0.875rem;
    --text-base: 1rem;
    --text-lg: 1.125rem;
    --text-xl: 1.25rem;
    --text-2xl: 1.5rem;
    --font-primary: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    --font-secondary: 'Cairo', 'Tahoma', sans-serif;
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

/* أنماط الفوتر الرئيسي */
.main-footer {
    position: relative;
    margin-top: var(--spacing-2xl);
    padding: var(--spacing-2xl) 0 var(--spacing-lg);
    background: linear-gradient(135deg, var(--bg-secondary) 0%, var(--bg-tertiary) 100%);
    border-top: 1px solid var(--border-color);
    overflow: hidden;
    font-family: var(--font-primary);
    transition: var(--transition);
}

.main-footer::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 1px;
    background: linear-gradient(90deg, transparent, var(--primary-color), transparent);
}

.container {
    max-width: 1280px;
    margin: 0 auto;
    padding: 0 var(--spacing-lg);
}

/* الجزء العلوي من الفوتر */
.footer-top {
    margin-bottom: var(--spacing-2xl);
}

.footer-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: var(--spacing-2xl);
}

.footer-section {
    position: relative;
}

/* معلومات الشركة */
.company-info .footer-logo {
    display: flex;
    align-items: center;
    gap: var(--spacing-sm);
    margin-bottom: var(--spacing-lg);
}

.company-info .logo-icon {
    font-size: var(--text-2xl);
    color: var(--primary-color);
    animation: floating 3s ease-in-out infinite;
}

.company-info .logo-text {
    font-size: var(--text-xl);
    font-weight: 700;
    font-family: var(--font-secondary);
    background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
    -webkit-background-clip: text;
    background-clip: text;
    -webkit-text-fill-color: transparent;
}

.company-description {
    color: var(--text-secondary);
    line-height: 1.8;
    margin-bottom: var(--spacing-lg);
    transition: var(--transition);
}

/* الروابط الاجتماعية */
.social-links {
    display: flex;
    gap: var(--spacing-sm);
    flex-wrap: wrap;
}

.social-link {
    width: 45px;
    height: 45px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: var(--bg-glass);
    border: 1px solid var(--border-color);
    border-radius: var(--border-radius);
    color: var(--text-secondary);
    text-decoration: none;
    transition: var(--transition);
    position: relative;
    overflow: hidden;
}

.social-link:hover {
    transform: translateY(-3px);
    box-shadow: var(--box-shadow);
}

.social-link[data-platform="facebook"]:hover {
    background: #1877f2;
    color: white;
    box-shadow: 0 10px 25px rgba(24, 119, 242, 0.3);
}

.social-link[data-platform="twitter"]:hover {
    background: #1da1f2;
    color: white;
    box-shadow: 0 10px 25px rgba(29, 161, 242, 0.3);
}

.social-link[data-platform="instagram"]:hover {
    background: linear-gradient(45deg, #f09433, #e6683c, #dc2743, #cc2366, #bc1888);
    color: white;
    box-shadow: 0 10px 25px rgba(225, 48, 108, 0.3);
}

.social-link[data-platform="linkedin"]:hover {
    background: #0077b5;
    color: white;
    box-shadow: 0 10px 25px rgba(0, 119, 181, 0.3);
}

.social-link[data-platform="youtube"]:hover {
    background: #ff0000;
    color: white;
    box-shadow: 0 10px 25px rgba(255, 0, 0, 0.3);
}

/* عناوين الأقسام */
.footer-title {
    display: flex;
    align-items: center;
    gap: var(--spacing-sm);
    font-size: var(--text-lg);
    font-weight: 600;
    color: var(--text-primary);
    margin-bottom: var(--spacing-lg);
    position: relative;
    transition: var(--transition);
}

.footer-title::after {
    content: '';
    position: absolute;
    bottom: -5px;
    right: 0;
    width: 30px;
    height: 2px;
    background: linear-gradient(90deg, var(--primary-color), var(--secondary-color));
    border-radius: 1px;
}

/* قوائم الروابط */
.footer-links {
    list-style: none;
    margin: 0;
    padding: 0;
}

.footer-links li {
    margin-bottom: var(--spacing-sm);
}

.footer-link {
    display: flex;
    align-items: center;
    gap: var(--spacing-sm);
    color: var(--text-secondary);
    text-decoration: none;
    padding: var(--spacing-xs) 0;
    transition: var(--transition);
    position: relative;
}

.footer-link:hover {
    color: var(--text-primary);
    transform: translateX(5px);
}

.footer-link::before {
    content: '';
    position: absolute;
    right: -10px;
    top: 50%;
    transform: translateY(-50%);
    width: 0;
    height: 2px;
    background: var(--primary-color);
    transition: var(--transition);
}

.footer-link:hover::before {
    width: 20px;
}

/* معلومات التواصل */
.contact-items {
    display: flex;
    flex-direction: column;
    gap: var(--spacing-md);
}

.contact-item {
    display: flex;
    align-items: flex-start;
    gap: var(--spacing-md);
    padding: var(--spacing-sm);
    background: var(--bg-glass);
    border-radius: var(--border-radius);
    border: 1px solid var(--border-color);
    transition: var(--transition);
    cursor: pointer;
}

.contact-item:hover {
    transform: translateY(-2px);
    box-shadow: var(--box-shadow);
}

.contact-icon {
    width: 40px;
    height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
    border-radius: var(--border-radius);
    color: white;
    flex-shrink: 0;
}

.contact-details {
    display: flex;
    flex-direction: column;
    gap: var(--spacing-xs);
}

.contact-label {
    font-size: var(--text-sm);
    color: var(--text-muted);
    font-weight: 500;
}

.contact-value {
    color: var(--text-primary);
    font-weight: 600;
}

/* الجزء السفلي من الفوتر */
.footer-bottom {
    border-top: 1px solid var(--border-color);
    padding-top: var(--spacing-lg);
    margin-top: var(--spacing-2xl);
}

.footer-bottom-content {
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: var(--spacing-md);
}

.footer-copyright {
    color: var(--text-muted);
    font-size: var(--text-sm);
}

.footer-bottom-links {
    display: flex;
    gap: var(--spacing-lg);
    list-style: none;
    margin: 0;
    padding: 0;
}

.footer-bottom-links a {
    color: var(--text-secondary);
    text-decoration: none;
    font-size: var(--text-sm);
    transition: var(--transition);
}

.footer-bottom-links a:hover {
    color: var(--primary-color);
}

/* زر العودة لأعلى */
.back-to-top {
    position: fixed;
    bottom: var(--spacing-xl);
    left: var(--spacing-xl);
    width: 50px;
    height: 50px;
    background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
    color: white;
    border: none;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    z-index: 1000;
    transition: var(--transition);
    opacity: 0;
    visibility: hidden;
    box-shadow: var(--box-shadow);
}

.back-to-top.show {
    opacity: 1;
    visibility: visible;
}

.back-to-top:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 30px rgba(0, 0, 0, 0.2);
}

/* أنيميشن التحويم */
@keyframes floating {
    0%, 100% {
        transform: translateY(0);
    }
    50% {
        transform: translateY(-10px);
    }
}

/* الاستجابة للأجهزة المختلفة */
@media (max-width: 900px) {
    .footer-grid {
        grid-template-columns: repeat(2, 1fr);
    }
}

@media (max-width: 768px) {
    .main-footer {
        padding: var(--spacing-xl) 0 var(--spacing-md);
    }
    
    .footer-grid {
        grid-template-columns: 1fr;
        gap: var(--spacing-xl);
    }
    
    .footer-bottom-content {
        flex-direction: column;
        text-align: center;
        gap: var(--spacing-md);
    }
    
    .footer-bottom-links {
        justify-content: center;
    }
    
    .social-links {
        justify-content: center;
    }
    
    .back-to-top {
        bottom: var(--spacing-md);
        left: var(--spacing-md);
        width: 45px;
        height: 45px;
    }
}

@media (max-width: 600px) {
    .contact-item {
        flex-direction: column;
        text-align: center;
        align-items: center;
    }
    
    .footer-bottom-links {
        flex-direction: column;
        gap: var(--spacing-sm);
    }
}

@media (max-width: 480px) {
    .container {
        padding: 0 var(--spacing-sm);
    }
    
    .footer-title {
        justify-content: center;
    }
    
    .footer-title::after {
        right: 50%;
        transform: translateX(50%);
    }
}

/* تأثيرات إضافية */
.footer-section {
    animation: fadeInUp 0.6s ease-out;
}

.footer-section:nth-child(2) {
    animation-delay: 0.1s;
}

.footer-section:nth-child(3) {
    animation-delay: 0.2s;
}

.footer-section:nth-child(4) {
    animation-delay: 0.3s;
}

@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}
</style>

<!-- الفوتر الرئيسي -->
<footer class="main-footer">
    <div class="container">
        <!-- الجزء العلوي من الفوتر -->
        <div class="footer-top">
            <div class="footer-grid">
                <!-- معلومات الشركة -->
                <div class="footer-section company-info">
                    <div class="footer-logo">
                        <div class="logo-icon">
                            <i class="bi bi-twitter"></i>
                        </div>
                        <span class="logo-text">تويق</span>
                    </div>
                    <p class="company-description">
                        منصة التواصل الاجتماعي العربية الرائدة التي تربط بين المستخدمين من جميع أنحاء العالم العربي لمشاركة الأفكار والآراء والمحتوى المميز.
                    </p>
                    <div class="social-links">
                        <a href="#" class="social-link" data-platform="facebook">
                            <i class="bi bi-facebook"></i>
                        </a>
                        <a href="#" class="social-link" data-platform="twitter">
                            <i class="bi bi-twitter"></i>
                        </a>
                        <a href="#" class="social-link" data-platform="instagram">
                            <i class="bi bi-instagram"></i>
                        </a>
                        <a href="#" class="social-link" data-platform="linkedin">
                            <i class="bi bi-linkedin"></i>
                        </a>
                        <a href="#" class="social-link" data-platform="youtube">
                            <i class="bi bi-youtube"></i>
                        </a>
                    </div>
                </div>

                <!-- روابط سريعة -->
                <div class="footer-section quick-links">
                    <h3 class="footer-title">
                        <i class="bi bi-link-45deg"></i>
                        روابط سريعة
                    </h3>
                    <ul class="footer-links">
                        <li><a href="/" class="footer-link"><i class="bi bi-house"></i> الرئيسية</a></li>
                        <li><a href="/about" class="footer-link"><i class="bi bi-info-circle"></i> من نحن</a></li>
                        <li><a href="/search" class="footer-link"><i class="bi bi-search"></i> البحث</a></li>
                        <li><a href="/events" class="footer-link"><i class="bi bi-calendar-event"></i> الأحداث</a></li>
                        <li><a href="/reels" class="footer-link"><i class="bi bi-play-circle"></i> الريلز</a></li>
                    </ul>
                </div>

                <!-- الخدمات -->
                <div class="footer-section services-links">
                    <h3 class="footer-title">
                        <i class="bi bi-gear"></i>
                        الخدمات
                    </h3>
                    <ul class="footer-links">
                        <li><a href="/help" class="footer-link"><i class="bi bi-question-circle"></i> المساعدة</a></li>
                        <li><a href="/settings" class="footer-link"><i class="bi bi-sliders"></i> الإعدادات</a></li>
                        <li><a href="/lists" class="footer-link"><i class="bi bi-list-ul"></i> القوائم</a></li>
                        <li><a href="/messages" class="footer-link"><i class="bi bi-envelope"></i> الرسائل</a></li>
                    </ul>
                </div>

                <!-- معلومات التواصل -->
                <div class="footer-section contact-info">
                    <h3 class="footer-title">
                        <i class="bi bi-envelope-at"></i>
                        تواصل معنا
                    </h3>
                    <div class="contact-items">
                        <div class="contact-item">
                            <div class="contact-icon">
                                <i class="bi bi-geo-alt"></i>
                            </div>
                            <div class="contact-details">
                                <span class="contact-label">العنوان</span>
                                <span class="contact-value">الرياض، المملكة العربية السعودية</span>
                            </div>
                        </div>
                        <div class="contact-item">
                            <div class="contact-icon">
                                <i class="bi bi-telephone"></i>
                            </div>
                            <div class="contact-details">
                                <span class="contact-label">الهاتف</span>
                                <span class="contact-value">+966 50 123 4567</span>
                            </div>
                        </div>
                        <div class="contact-item">
                            <div class="contact-icon">
                                <i class="bi bi-envelope"></i>
                            </div>
                            <div class="contact-details">
                                <span class="contact-label">البريد الإلكتروني</span>
                                <span class="contact-value">info@tewiiq.com</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- الجزء السفلي من الفوتر -->
        <div class="footer-bottom">
            <div class="footer-bottom-content">
                <div class="footer-copyright">
                    <p>&copy; <?= date('Y') ?> تويق. جميع الحقوق محفوظة.</p>
                </div>
                <ul class="footer-bottom-links">
                    <li><a href="#">الشروط والأحكام</a></li>
                    <li><a href="#">سياسة الخصوصية</a></li>
                    <li><a href="#">ملفات تعريف الارتباط</a></li>
                </ul>
            </div>
        </div>
    </div>
</footer>

<!-- زر العودة لأعلى -->
<button class="back-to-top" id="backToTop" onclick="scrollToTop()">
    <i class="bi bi-arrow-up"></i>
</button>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const backToTopBtn = document.getElementById('backToTop');
    
    // إظهار/إخفاء زر العودة لأعلى
    window.addEventListener('scroll', function() {
        if (window.pageYOffset > 300) {
            backToTopBtn.classList.add('show');
        } else {
            backToTopBtn.classList.remove('show');
        }
    });
});

// دالة العودة لأعلى
function scrollToTop() {
    window.scrollTo({
        top: 0,
        behavior: 'smooth'
    });
}
</script>
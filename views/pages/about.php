<?php $this->layout('layouts/app', [
    'title' => 'من نحن - تويق',
    'activeTab' => 'about',
    'currentPage' => 'about'
]) ?>

<!-- أنماط خاصة بصفحة من نحن -->
<style>
    /* الهيرو سيكشن */
    .hero-section {
        position: relative;
        height: 80vh;
        min-height: 600px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.7)), url('https://images.unsplash.com/photo-1467232004584-a241de8bcf5d?ixlib=rb-4.0.3&auto=format&fit=crop&w=2000&q=80') no-repeat center center;
        background-size: cover;
        color: white;
        text-align: center;
        padding: 2rem;
        border-radius: 0 0 var(--border-radius) var(--border-radius);
        margin: -2rem -1rem 2rem -1rem;
    }

    .hero-content {
        max-width: 800px;
        z-index: 2;
    }

    .hero-title {
        font-size: 2.25rem;
        font-weight: 800;
        margin-bottom: 1.5rem;
        animation: fadeInUp 1s ease;
    }

    .hero-subtitle {
        font-size: 1.25rem;
        margin-bottom: 2rem;
        animation: fadeInUp 1s ease 0.2s both;
    }

    .hero-cta {
        display: flex;
        gap: 1rem;
        justify-content: center;
        flex-wrap: wrap;
        animation: fadeInUp 1s ease 0.4s both;
    }

    .btn-hero {
        background-color: var(--primary);
        border: none;
        padding: 0.75rem 1.5rem;
        border-radius: var(--border-radius);
        font-weight: 600;
        transition: var(--transition);
        color: white;
        text-decoration: none;
    }

    .btn-hero:hover {
        background-color: var(--secondary);
        transform: translateY(-2px);
        color: white;
    }

    .btn-outline {
        background-color: transparent;
        border: 2px solid white;
        color: white;
        padding: 0.75rem 1.5rem;
        border-radius: var(--border-radius);
        font-weight: 600;
        transition: var(--transition);
        text-decoration: none;
    }

    .btn-outline:hover {
        background-color: white;
        color: var(--primary);
    }

    /* أقسام الصفحة */
    .section {
        padding: 5rem 0;
    }

    .section-title {
        text-align: center;
        font-size: 1.875rem;
        font-weight: 800;
        margin-bottom: 3rem;
        color: var(--primary);
        position: relative;
    }

    .section-title::after {
        content: '';
        position: absolute;
        bottom: -0.75rem;
        left: 50%;
        transform: translateX(-50%);
        width: 80px;
        height: 4px;
        background-color: var(--accent);
        border-radius: 2px;
    }

    /* مكونات التايم لاين */
    .timeline {
        position: relative;
        max-width: 1000px;
        margin: 0 auto;
    }

    .timeline::before {
        content: '';
        position: absolute;
        top: 0;
        bottom: 0;
        right: 50%;
        transform: translateX(50%);
        width: 4px;
        background-color: var(--primary);
        border-radius: 2px;
    }

    .timeline-item {
        display: flex;
        margin-bottom: 4rem;
        position: relative;
    }

    .timeline-item:nth-child(even) {
        flex-direction: row-reverse;
    }

    .timeline-content {
        flex: 1;
        background-color: var(--card);
        padding: 2rem;
        border-radius: var(--border-radius);
        box-shadow: var(--box-shadow);
        position: relative;
        border: 1px solid var(--border);
    }

    .timeline-item:nth-child(odd) .timeline-content {
        margin-left: 2rem;
    }

    .timeline-item:nth-child(even) .timeline-content {
        margin-right: 2rem;
    }

    .timeline-year {
        position: absolute;
        top: -1.5rem;
        background-color: var(--primary);
        color: white;
        padding: 0.5rem 1.5rem;
        border-radius: var(--border-radius);
        font-weight: 700;
        box-shadow: var(--box-shadow);
    }

    .timeline-item:nth-child(odd) .timeline-year {
        left: -2rem;
    }

    .timeline-item:nth-child(even) .timeline-year {
        right: -2rem;
    }

    .timeline-dot {
        position: absolute;
        top: 2rem;
        right: 50%;
        transform: translateX(50%);
        width: 20px;
        height: 20px;
        background-color: var(--accent);
        border: 4px solid var(--card);
        border-radius: 50%;
        z-index: 2;
    }

    /* كروت المهمة والرؤية */
    .mission-cards {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 2rem;
        margin-top: 3rem;
    }

    .mission-card {
        background-color: var(--card);
        padding: 2.5rem 2rem;
        border-radius: var(--border-radius);
        box-shadow: var(--box-shadow);
        text-align: center;
        transition: var(--transition);
        border: 1px solid var(--border);
    }

    .mission-card:hover {
        transform: translateY(-10px);
    }

    .mission-icon {
        font-size: 3rem;
        color: var(--primary);
        margin-bottom: 1.5rem;
    }

    .mission-title {
        font-size: 1.25rem;
        font-weight: 700;
        margin-bottom: 1rem;
        color: var(--primary);
    }

    /* كروت الفريق */
    .team-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 2rem;
        margin-top: 3rem;
    }

    .team-card {
        background-color: var(--card);
        border-radius: var(--border-radius);
        overflow: hidden;
        box-shadow: var(--box-shadow);
        transition: var(--transition);
        border: 1px solid var(--border);
    }

    .team-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
    }

    .team-image {
        width: 100%;
        height: 300px;
        object-fit: cover;
    }

    .team-info {
        padding: 1.5rem;
    }

    .team-name {
        font-weight: 700;
        font-size: 1.125rem;
        margin-bottom: 0.25rem;
        color: var(--text);
    }

    .team-role {
        color: var(--secondary);
        margin-bottom: 1rem;
    }

    .team-social {
        display: flex;
        gap: 0.75rem;
        margin-top: 1rem;
    }

    .social-link {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        background-color: var(--input);
        color: var(--text);
        transition: var(--transition);
        text-decoration: none;
    }

    .social-link:hover {
        background-color: var(--primary);
        color: white;
    }

    /* قيم الشركة */
    .values-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 2rem;
    }

    .value-item {
        background-color: var(--card);
        padding: 2rem;
        border-radius: var(--border-radius);
        box-shadow: var(--box-shadow);
        text-align: center;
        border: 1px solid var(--border);
    }

    .value-icon {
        font-size: 2.5rem;
        color: var(--accent);
        margin-bottom: 1rem;
    }

    .value-title {
        font-weight: 700;
        margin-bottom: 1rem;
        color: var(--primary);
    }

    /* الإحصائيات */
    .stats-section {
        background: linear-gradient(to bottom, var(--primary), var(--secondary));
        color: white;
        margin: 2rem -1rem;
        padding: 4rem 2rem;
        border-radius: var(--border-radius);
    }

    .stats-section .section-title {
        color: white;
    }

    .stats-section .section-title::after {
        background-color: white;
    }

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 2rem;
        text-align: center;
    }

    .stat-item {
        padding: 2rem;
    }

    .stat-number {
        font-size: 1.875rem;
        font-weight: 800;
        margin-bottom: 0.5rem;
    }

    .stat-label {
        font-size: 1.125rem;
    }

    /* أنيميشن */
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

    /* الاستجابة للأجهزة المختلفة */
    @media (max-width: 768px) {
        .hero-section {
            height: 60vh;
            min-height: 400px;
        }
        
        .hero-title {
            font-size: 1.75rem;
        }
        
        .timeline::before {
            right: 2rem;
            transform: none;
        }
        
        .timeline-item {
            flex-direction: column !important;
        }
        
        .timeline-item:nth-child(even) .timeline-content,
        .timeline-item:nth-child(odd) .timeline-content {
            margin: 0 0 0 3rem;
        }
        
        .timeline-year {
            position: static;
            display: inline-block;
            margin-bottom: 1rem;
        }
        
        .timeline-dot {
            right: 2rem;
            transform: translateX(50%);
        }
    }
</style>

<!-- الهيرو سيكشن -->
<section class="hero-section">
    <div class="hero-content">
        <h1 class="hero-title">من نحن</h1>
        <p class="hero-subtitle">نحن فريق متحمس يعمل على بناء منصة التواصل الاجتماعي العربية الرائدة</p>
        <div class="hero-cta">
            <a href="/register" class="btn-hero">انضم إلينا</a>
            <a href="#our-story" class="btn-outline">اعرف قصتنا</a>
        </div>
    </div>
</section>

<!-- قصتنا -->
<section class="section" id="our-story">
    <div class="container">
        <h2 class="section-title">قصتنا</h2>
        <div class="timeline">
            <div class="timeline-item">
                <div class="timeline-content">
                    <div class="timeline-year">2023</div>
                    <h3>البداية</h3>
                    <p>بدأت فكرة تويق من حاجتنا لمنصة تواصل اجتماعي تفهم الثقافة العربية وتدعم اللغة العربية بشكل كامل. أردنا إنشاء مساحة آمنة ومريحة للمستخدمين العرب للتواصل ومشاركة أفكارهم.</p>
                </div>
                <div class="timeline-dot"></div>
            </div>
            
            <div class="timeline-item">
                <div class="timeline-content">
                    <div class="timeline-year">2024</div>
                    <h3>التطوير</h3>
                    <p>طوّرنا النسخة الأولى من المنصة بميزات أساسية تشمل التغريدات، المتابعة، والرسائل المباشرة. ركزنا على تجربة مستخدم سلسة وتصميم يدعم النصوص العربية بشكل مثالي.</p>
                </div>
                <div class="timeline-dot"></div>
            </div>
            
            <div class="timeline-item">
                <div class="timeline-content">
                    <div class="timeline-year">2025</div>
                    <h3>الإطلاق</h3>
                    <p>أطلقنا تويق للجمهور مع ميزات متقدمة مثل الريلز، الفعاليات، والقوائم. نهدف إلى أن نكون المنصة المفضلة للتواصل الاجتماعي في العالم العربي.</p>
                </div>
                <div class="timeline-dot"></div>
            </div>
        </div>
    </div>
</section>

<!-- مهمتنا ورؤيتنا -->
<section class="section">
    <div class="container">
        <h2 class="section-title">مهمتنا ورؤيتنا</h2>
        <div class="mission-cards">
            <div class="mission-card">
                <div class="mission-icon">
                    <i class="bi bi-bullseye"></i>
                </div>
                <h3 class="mission-title">مهمتنا</h3>
                <p>إنشاء منصة تواصل اجتماعي عربية تربط بين المجتمعات العربية حول العالم وتساعد في نشر المحتوى الإيجابي والبناء باللغة العربية.</p>
            </div>
            
            <div class="mission-card">
                <div class="mission-icon">
                    <i class="bi bi-eye"></i>
                </div>
                <h3 class="mission-title">رؤيتنا</h3>
                <p>أن نكون المنصة الرائدة للتواصل الاجتماعي في العالم العربي، ونساهم في تعزيز التواصل الثقافي والفكري بين الشعوب العربية.</p>
            </div>
            
            <div class="mission-card">
                <div class="mission-icon">
                    <i class="bi bi-heart"></i>
                </div>
                <h3 class="mission-title">قيمنا</h3>
                <p>نؤمن بالشفافية، الاحترام المتبادل، الخصوصية، والابتكار. نسعى لخلق بيئة آمنة ومحترمة لجميع مستخدمينا.</p>
            </div>
        </div>
    </div>
</section>

<!-- فريقنا -->
<section class="section">
    <div class="container">
        <h2 class="section-title">فريقنا</h2>
        <div class="team-grid">
            <div class="team-card">
                <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=300&h=300&fit=crop&crop=face" alt="أحمد محمد" class="team-image">
                <div class="team-info">
                    <h4 class="team-name">أحمد محمد</h4>
                    <p class="team-role">المؤسس والرئيس التنفيذي</p>
                    <p>مهندس برمجيات بخبرة 10 سنوات في تطوير منصات التواصل الاجتماعي.</p>
                    <div class="team-social">
                        <a href="#" class="social-link"><i class="bi bi-twitter"></i></a>
                        <a href="#" class="social-link"><i class="bi bi-linkedin"></i></a>
                        <a href="#" class="social-link"><i class="bi bi-github"></i></a>
                    </div>
                </div>
            </div>
            
            <div class="team-card">
                <img src="https://images.unsplash.com/photo-1494790108755-2616b612b786?w=300&h=300&fit=crop&crop=face" alt="فاطمة أحمد" class="team-image">
                <div class="team-info">
                    <h4 class="team-name">فاطمة أحمد</h4>
                    <p class="team-role">مديرة التصميم</p>
                    <p>مصممة UX/UI مبدعة تركز على تجربة المستخدم العربي.</p>
                    <div class="team-social">
                        <a href="#" class="social-link"><i class="bi bi-dribbble"></i></a>
                        <a href="#" class="social-link"><i class="bi bi-behance"></i></a>
                        <a href="#" class="social-link"><i class="bi bi-instagram"></i></a>
                    </div>
                </div>
            </div>
            
            <div class="team-card">
                <img src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=300&h=300&fit=crop&crop=face" alt="محمد علي" class="team-image">
                <div class="team-info">
                    <h4 class="team-name">محمد علي</h4>
                    <p class="team-role">مطور رئيسي</p>
                    <p>خبير في تطوير الواجهات الأمامية والخلفية للتطبيقات العربية.</p>
                    <div class="team-social">
                        <a href="#" class="social-link"><i class="bi bi-github"></i></a>
                        <a href="#" class="social-link"><i class="bi bi-stack-overflow"></i></a>
                        <a href="#" class="social-link"><i class="bi bi-twitter"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- قيمنا -->
<section class="section">
    <div class="container">
        <h2 class="section-title">قيمنا</h2>
        <div class="values-grid">
            <div class="value-item">
                <div class="value-icon">
                    <i class="bi bi-shield-check"></i>
                </div>
                <h4 class="value-title">الخصوصية والأمان</h4>
                <p>نحمي بيانات مستخدمينا ونضمن خصوصيتهم بأعلى معايير الأمان.</p>
            </div>
            
            <div class="value-item">
                <div class="value-icon">
                    <i class="bi bi-translate"></i>
                </div>
                <h4 class="value-title">اللغة العربية</h4>
                <p>نفخر بدعمنا الكامل للغة العربية وثقافتها في كل جوانب المنصة.</p>
            </div>
            
            <div class="value-item">
                <div class="value-icon">
                    <i class="bi bi-people"></i>
                </div>
                <h4 class="value-title">المجتمع</h4>
                <p>نبني مجتمعاً متفاعلاً وإيجابياً يساهم في التطوير والنمو.</p>
            </div>
            
            <div class="value-item">
                <div class="value-icon">
                    <i class="bi bi-lightbulb"></i>
                </div>
                <h4 class="value-title">الابتكار</h4>
                <p>نسعى دائماً للابتكار وتطوير ميزات جديدة تخدم مستخدمينا.</p>
            </div>
        </div>
    </div>
</section>

<!-- الإحصائيات -->
<section class="stats-section">
    <div class="container">
        <h2 class="section-title">إنجازاتنا</h2>
        <div class="stats-grid">
            <div class="stat-item">
                <div class="stat-number" data-target="10000">0</div>
                <div class="stat-label">مستخدم نشط</div>
            </div>
            <div class="stat-item">
                <div class="stat-number" data-target="50000">0</div>
                <div class="stat-label">تغريدة يومياً</div>
            </div>
            <div class="stat-item">
                <div class="stat-number" data-target="15">0</div>
                <div class="stat-label">دولة عربية</div>
            </div>
            <div class="stat-item">
                <div class="stat-number" data-target="99">0</div>
                <div class="stat-label">رضا المستخدمين</div>
            </div>
        </div>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // أنيميشن العدادات
    const statNumbers = document.querySelectorAll('.stat-number');
    
    const animateCounter = (element) => {
        const target = parseInt(element.getAttribute('data-target'));
        const increment = target / 100;
        let current = 0;
        
        const timer = setInterval(() => {
            current += increment;
            if (current >= target) {
                element.textContent = target.toLocaleString('ar-EG');
                clearInterval(timer);
            } else {
                element.textContent = Math.floor(current).toLocaleString('ar-EG');
            }
        }, 20);
    };
    
    // تشغيل الأنيميشن عند وصول العنصر للشاشة
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                animateCounter(entry.target);
                observer.unobserve(entry.target);
            }
        });
    });
    
    statNumbers.forEach(stat => {
        observer.observe(stat);
    });
});
</script>
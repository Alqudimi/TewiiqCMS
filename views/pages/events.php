<?php $this->layout('layouts/app', ['title' => $title]) ?>

<style>
    /* تخطيط الصفحة */
    .events-container {
        min-height: 100vh;
        padding: 0;
        overflow-x: hidden;
        background-color: var(--background);
    }

    /* شريط الفعاليات الحية */
    .live-events-bar {
        background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
        color: white;
        padding: 0.75rem 1rem;
        overflow-x: auto;
        white-space: nowrap;
        position: sticky;
        top: 56px;
        z-index: 100;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    .live-events-bar::-webkit-scrollbar {
        height: 5px;
    }

    .live-events-bar::-webkit-scrollbar-thumb {
        background: rgba(255, 255, 255, 0.3);
        border-radius: 10px;
    }

    .live-event-pill {
        display: inline-flex;
        align-items: center;
        background-color: rgba(255, 255, 255, 0.2);
        border-radius: 50px;
        padding: 0.5rem 1rem;
        margin-left: 0.5rem;
        transition: var(--transition);
        cursor: pointer;
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.1);
        text-decoration: none;
        color: white;
    }

    .live-event-pill:hover {
        background-color: rgba(255, 255, 255, 0.3);
        transform: translateY(-2px);
        color: white;
    }

    .live-indicator {
        width: 10px;
        height: 10px;
        background-color: #ff4444;
        border-radius: 50%;
        margin-left: 0.5rem;
        animation: pulse 1.5s infinite;
        box-shadow: 0 0 10px rgba(255, 68, 68, 0.5);
    }

    @keyframes pulse {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.5; }
    }

    /* فلتر الفعاليات */
    .events-filter {
        padding: 1.25rem 1.5rem;
        background-color: var(--card);
        border-bottom: 1px solid var(--border);
        position: sticky;
        top: 105px;
        z-index: 90;
        backdrop-filter: blur(10px);
    }

    .filter-options {
        display: flex;
        gap: 0.75rem;
        overflow-x: auto;
        padding-bottom: 0.5rem;
    }

    .filter-options::-webkit-scrollbar {
        height: 4px;
    }

    .filter-options::-webkit-scrollbar-thumb {
        background: var(--primary);
        border-radius: 10px;
    }

    .filter-option {
        padding: 0.6rem 1.1rem;
        background-color: var(--input);
        border-radius: 50px;
        font-size: 0.9rem;
        cursor: pointer;
        transition: var(--transition);
        white-space: nowrap;
        border: 1px solid transparent;
        text-decoration: none;
        color: var(--text);
    }

    .filter-option:hover {
        background-color: var(--primary);
        color: white;
        transform: translateY(-2px);
    }

    .filter-option.active {
        background-color: var(--primary);
        color: white;
        box-shadow: 0 4px 12px rgba(124, 77, 255, 0.3);
    }

    /* شبكة الفعاليات */
    .events-grid {
        padding: 1.5rem;
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
        gap: 1.5rem;
    }

    .event-card {
        background-color: var(--card);
        border-radius: var(--border-radius);
        box-shadow: var(--box-shadow);
        position: relative;
        overflow: hidden;
        transition: var(--transition);
        cursor: pointer;
        height: 100%;
        display: flex;
        flex-direction: column;
    }

    .event-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 20px 50px rgba(0, 0, 0, 0.25);
    }

    .event-image {
        height: 200px;
        object-fit: cover;
        width: 100%;
        transition: var(--transition);
    }

    .event-card:hover .event-image {
        transform: scale(1.05);
    }

    .event-badge {
        position: absolute;
        top: 1rem;
        right: 1rem;
        background-color: var(--primary);
        color: white;
        padding: 0.35rem 0.85rem;
        border-radius: 50px;
        font-size: 0.8rem;
        font-weight: bold;
        z-index: 2;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    }

    .event-badge.live {
        background-color: #ff4d4d;
        animation: pulse 2s infinite;
    }

    .event-badge.upcoming {
        background-color: var(--accent);
        color: var(--text);
    }

    .event-badge.ended {
        background-color: #6c757d;
        opacity: 0.7;
    }

    .event-content {
        padding: 1.25rem;
        flex-grow: 1;
        display: flex;
        flex-direction: column;
    }

    .event-title {
        font-weight: bold;
        margin-bottom: 0.75rem;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        font-size: 1.1rem;
        line-height: 1.4;
        color: var(--text);
    }

    .event-host {
        display: flex;
        align-items: center;
        margin-bottom: 0.75rem;
    }

    .host-avatar {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        object-fit: cover;
        margin-left: 0.75rem;
        border: 2px solid var(--border);
    }

    .host-info h6 {
        margin: 0;
        font-weight: 600;
        color: var(--text);
    }

    .host-info span {
        font-size: 0.875rem;
        color: var(--secondary);
    }

    .event-description {
        color: var(--text);
        opacity: 0.8;
        margin-bottom: 1rem;
        flex-grow: 1;
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
        font-size: 0.95rem;
    }

    .event-meta {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: auto;
        font-size: 0.85rem;
        color: var(--secondary);
    }

    .event-time {
        display: flex;
        align-items: center;
    }

    .event-time i {
        margin-left: 0.5rem;
    }

    .participants-count {
        display: flex;
        align-items: center;
        background-color: var(--input);
        padding: 0.35rem 0.75rem;
        border-radius: 50px;
    }

    .participants-count i {
        margin-left: 0.5rem;
    }

    /* حالة فارغة */
    .empty-state {
        text-align: center;
        padding: 3rem;
        color: var(--secondary);
    }

    .empty-state i {
        font-size: 4rem;
        margin-bottom: 1rem;
    }

    .empty-state h3 {
        margin-bottom: 0.5rem;
        color: var(--text);
    }

    /* زر إنشاء فعالية */
    .create-event-btn {
        position: fixed;
        bottom: 2rem;
        left: 2rem;
        background: linear-gradient(135deg, var(--primary), var(--secondary));
        color: white;
        border: none;
        border-radius: 50%;
        width: 60px;
        height: 60px;
        font-size: 1.5rem;
        box-shadow: var(--box-shadow);
        transition: var(--transition);
        z-index: 1000;
    }

    .create-event-btn:hover {
        transform: scale(1.1);
        box-shadow: 0 16px 32px rgba(0, 0, 0, 0.3);
    }

    /* تصميم شريط التنقل */
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

    /* استجابة للهواتف */
    @media (max-width: 768px) {
        .events-grid {
            grid-template-columns: 1fr;
            padding: 1rem;
        }
        
        .live-events-bar {
            padding: 0.5rem;
        }
        
        .live-event-pill {
            padding: 0.4rem 0.8rem;
            font-size: 0.85rem;
        }
        
        .create-event-btn {
            bottom: 1rem;
            left: 1rem;
            width: 50px;
            height: 50px;
            font-size: 1.25rem;
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
            <a class="nav-link active" href="/events">الفعاليات</a>
            <a class="nav-link" href="/settings">الإعدادات</a>
            <a class="nav-link" href="/profile/<?=$_SESSION['username'] ?? ''?>">الملف الشخصي</a>
            <a class="nav-link" href="/logout">تسجيل الخروج</a>
        </div>
    </div>
</nav>

<div class="events-container">
    <!-- شريط الفعاليات الحية -->
    <?php if (!empty($liveEvents)): ?>
        <div class="live-events-bar">
            <strong style="margin-left: 1rem;">الآن مباشر:</strong>
            <?php foreach ($liveEvents as $liveEvent): ?>
                <a href="/events/<?=$liveEvent['id']?>" class="live-event-pill">
                    <div class="live-indicator"></div>
                    <?=$this->e($liveEvent['title'])?>
                    <small style="margin-right: 0.5rem;">
                        (<?=$liveEvent['participants_count']?> مشارك)
                    </small>
                </a>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <!-- فلتر الفعاليات -->
    <div class="events-filter">
        <div class="filter-options">
            <a href="/events?filter=all" 
               class="filter-option <?=$filter === 'all' ? 'active' : ''?>">
                <i class="bi bi-grid"></i>
                الكل
            </a>
            <a href="/events?filter=live" 
               class="filter-option <?=$filter === 'live' ? 'active' : ''?>">
                <i class="bi bi-broadcast"></i>
                مباشر الآن
            </a>
            <a href="/events?filter=upcoming" 
               class="filter-option <?=$filter === 'upcoming' ? 'active' : ''?>">
                <i class="bi bi-calendar-event"></i>
                قريباً
            </a>
            <a href="/events?filter=sports" 
               class="filter-option <?=$filter === 'sports' ? 'active' : ''?>">
                <i class="bi bi-trophy"></i>
                رياضة
            </a>
            <a href="/events?filter=news" 
               class="filter-option <?=$filter === 'news' ? 'active' : ''?>">
                <i class="bi bi-newspaper"></i>
                أخبار
            </a>
            <a href="/events?filter=entertainment" 
               class="filter-option <?=$filter === 'entertainment' ? 'active' : ''?>">
                <i class="bi bi-music-note"></i>
                ترفيه
            </a>
        </div>
    </div>

    <!-- شبكة الفعاليات -->
    <?php if (empty($events)): ?>
        <div class="empty-state">
            <i class="bi bi-calendar-x"></i>
            <h3>لا توجد فعاليات</h3>
            <p>لم يتم العثور على أي فعاليات في هذا القسم حالياً</p>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createEventModal">
                <i class="bi bi-plus-lg"></i>
                أنشئ فعالية جديدة
            </button>
        </div>
    <?php else: ?>
        <div class="events-grid">
            <?php foreach ($events as $event): ?>
                <div class="event-card" onclick="goToEvent(<?=$event['id']?>)">
                    <?php if ($event['image_url']): ?>
                        <img src="<?=$this->e($event['image_url'])?>" alt="صورة الفعالية" class="event-image">
                    <?php else: ?>
                        <div class="event-image" style="background: linear-gradient(135deg, var(--primary), var(--accent)); display: flex; align-items: center; justify-content: center; color: white; font-size: 3rem;">
                            <i class="bi bi-calendar-event"></i>
                        </div>
                    <?php endif; ?>
                    
                    <div class="event-badge <?=$event['is_live'] ? 'live' : (strtotime($event['start_time']) > time() ? 'upcoming' : 'ended')?>">
                        <?php if ($event['is_live']): ?>
                            <i class="bi bi-broadcast"></i> مباشر
                        <?php elseif (strtotime($event['start_time']) > time()): ?>
                            <i class="bi bi-clock"></i> قريباً
                        <?php else: ?>
                            <i class="bi bi-check-circle"></i> انتهت
                        <?php endif; ?>
                    </div>
                    
                    <div class="event-content">
                        <h3 class="event-title"><?=$this->e($event['title'])?></h3>
                        
                        <div class="event-host">
                            <img src="<?=$event['avatar'] ? '/uploads/avatars/' . $event['avatar'] : 'https://via.placeholder.com/36'?>" 
                                 alt="صورة المضيف" class="host-avatar">
                            <div class="host-info">
                                <h6><?=$this->e($event['fullname'])?></h6>
                                <span>@<?=$this->e($event['username'])?></span>
                            </div>
                        </div>
                        
                        <?php if ($event['description']): ?>
                            <p class="event-description"><?=$this->e($event['description'])?></p>
                        <?php endif; ?>
                        
                        <div class="event-meta">
                            <div class="event-time">
                                <i class="bi bi-calendar3"></i>
                                <?=date('d M - H:i', strtotime($event['start_time']))?>
                            </div>
                            <div class="participants-count">
                                <i class="bi bi-people"></i>
                                <?=$event['participants_count']?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<!-- زر إنشاء فعالية جديدة -->
<button class="create-event-btn" data-bs-toggle="modal" data-bs-target="#createEventModal">
    <i class="bi bi-plus-lg"></i>
</button>

<!-- مودال إنشاء فعالية جديدة -->
<div class="modal fade" id="createEventModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="bi bi-calendar-plus"></i>
                    إنشاء فعالية جديدة
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" action="/events/create">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="form-group mb-3">
                                <label class="form-label">عنوان الفعالية *</label>
                                <input type="text" name="title" class="form-control" required 
                                       placeholder="أدخل عنوان الفعالية">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group mb-3">
                                <label class="form-label">نوع الفعالية</label>
                                <select name="event_type" class="form-control">
                                    <option value="general">عام</option>
                                    <option value="sports">رياضة</option>
                                    <option value="news">أخبار</option>
                                    <option value="entertainment">ترفيه</option>
                                    <option value="education">تعليمية</option>
                                    <option value="business">أعمال</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group mb-3">
                        <label class="form-label">الوصف</label>
                        <textarea name="description" class="form-control" rows="3" 
                                  placeholder="وصف موجز عن الفعالية"></textarea>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label class="form-label">تاريخ ووقت البداية *</label>
                                <input type="datetime-local" name="start_time" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label class="form-label">تاريخ ووقت النهاية</label>
                                <input type="datetime-local" name="end_time" class="form-control">
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group mb-3">
                        <label class="form-label">الموقع</label>
                        <input type="text" name="location" class="form-control" 
                               placeholder="الموقع الجغرافي أو الرابط">
                    </div>
                    
                    <div class="form-group mb-3">
                        <label class="form-label">الهاشتاجز</label>
                        <input type="text" name="hashtags" class="form-control" 
                               placeholder="#فعالية #تقنية #ريادة_أعمال">
                        <div class="form-text">افصل بين الهاشتاجز بمسافات</div>
                    </div>
                    
                    <div class="form-check">
                        <input type="checkbox" name="is_live" class="form-check-input" id="isLive">
                        <label class="form-check-label" for="isLive">
                            <i class="bi bi-broadcast"></i>
                            فعالية مباشرة الآن
                        </label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check2"></i>
                        إنشاء الفعالية
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
// الانتقال إلى صفحة الفعالية
function goToEvent(eventId) {
    window.location.href = '/events/' + eventId;
}

// تحديث الفعاليات المباشرة كل 30 ثانية
setInterval(function() {
    fetch('/events/live')
        .then(response => response.json())
        .then(data => {
            if (data.success && data.events.length > 0) {
                // تحديث شريط الفعاليات المباشرة
                updateLiveEventsBar(data.events);
            }
        })
        .catch(error => console.error('خطأ في تحديث الفعاليات المباشرة:', error));
}, 30000);

function updateLiveEventsBar(liveEvents) {
    const liveBar = document.querySelector('.live-events-bar');
    if (!liveBar && liveEvents.length > 0) {
        // إنشاء شريط جديد إذا لم يكن موجوداً
        const newBar = document.createElement('div');
        newBar.className = 'live-events-bar';
        newBar.innerHTML = '<strong style="margin-left: 1rem;">الآن مباشر:</strong>';
        
        liveEvents.forEach(event => {
            const pill = document.createElement('a');
            pill.href = '/events/' + event.id;
            pill.className = 'live-event-pill';
            pill.innerHTML = `
                <div class="live-indicator"></div>
                ${event.title}
                <small style="margin-right: 0.5rem;">
                    (${event.participants_count} مشارك)
                </small>
            `;
            newBar.appendChild(pill);
        });
        
        document.querySelector('.events-container').prepend(newBar);
    }
}

// تعيين التاريخ والوقت الحالي كافتراضي
document.addEventListener('DOMContentLoaded', function() {
    const startTimeInput = document.querySelector('input[name="start_time"]');
    if (startTimeInput) {
        const now = new Date();
        now.setMinutes(now.getMinutes() - now.getTimezoneOffset());
        startTimeInput.value = now.toISOString().slice(0, 16);
    }
});
</script>
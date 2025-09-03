<?php $this->layout('layouts/app', ['title' => $title]) ?>

<style>
    /* تصميم البطاقات */
    .card {
        background-color: var(--card);
        border: none;
        border-radius: var(--border-radius);
        box-shadow: var(--box-shadow);
        margin-bottom: 1.5rem;
        overflow: hidden;
        transition: var(--transition);
    }

    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 16px 42px rgba(0, 0, 0, 0.2);
    }

    .card-header {
        background-color: transparent;
        border-bottom: 1px solid var(--border);
        padding: 1rem 1.5rem;
        font-weight: 600;
    }

    .card-body {
        padding: 1.5rem;
    }

    /* تصميم التغريدة */
    .tweet {
        position: relative;
    }

    .tweet-header {
        display: flex;
        align-items: center;
        margin-bottom: 1rem;
    }

    .user-avatar {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        object-fit: cover;
        margin-left: 1rem;
        border: 2px solid var(--primary);
    }

    .user-info h5 {
        margin-bottom: 0.25rem;
        font-weight: 700;
    }

    .user-info span {
        color: var(--secondary);
        font-size: var(--font-sm);
    }

    .tweet-time {
        color: var(--secondary);
        font-size: var(--font-sm);
        margin-top: 0.5rem;
    }

    .tweet-content {
        font-size: 1.125rem;
        margin-bottom: 1.5rem;
        line-height: 1.8;
    }

    .tweet-stats {
        display: flex;
        justify-content: space-around;
        border-top: 1px solid var(--border);
        border-bottom: 1px solid var(--border);
        padding: 1rem 0;
        margin-bottom: 1.5rem;
    }

    .stat {
        text-align: center;
        color: var(--text);
    }

    .stat-number {
        font-weight: 700;
        font-size: 1.125rem;
        color: var(--primary);
    }

    .stat-label {
        font-size: 0.875rem;
        color: var(--secondary);
    }

    .tweet-actions {
        display: flex;
        justify-content: space-around;
        padding: 0.5rem 0;
    }

    .action-btn {
        background: none;
        border: none;
        color: var(--text);
        font-size: 1.125rem;
        cursor: pointer;
        padding: 0.5rem;
        border-radius: 50%;
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
        transition: var(--transition);
    }

    .action-btn:hover {
        background-color: var(--input);
        transform: scale(1.1);
    }

    .action-btn.liked {
        color: #e0245e;
    }

    .action-btn.retweeted {
        color: #17bf63;
    }

    /* تصميم حقل الرد */
    .reply-input {
        display: flex;
        align-items: flex-start;
        margin-bottom: 1.5rem;
    }

    .reply-input .user-avatar {
        width: 40px;
        height: 40px;
        margin-left: 1rem;
    }

    .reply-form {
        flex: 1;
        position: relative;
    }

    .reply-textarea {
        width: 100%;
        background-color: var(--input);
        border: 2px solid transparent;
        border-radius: var(--border-radius);
        padding: 1rem;
        color: var(--text);
        resize: none;
        min-height: 100px;
        transition: var(--transition);
    }

    .reply-textarea:focus {
        outline: none;
        border-color: var(--primary);
        background-color: var(--card);
    }

    .reply-actions {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: 0.5rem;
    }

    .tweet-btn {
        background-color: var(--primary);
        color: white;
        border: none;
        border-radius: 50px;
        padding: 0.5rem 1.5rem;
        font-weight: 600;
        cursor: pointer;
        transition: var(--transition);
    }

    .tweet-btn:hover {
        background-color: var(--secondary);
        transform: translateY(-2px);
    }

    .tweet-btn:disabled {
        background-color: var(--input);
        color: var(--text);
        cursor: not-allowed;
    }

    .char-count {
        color: var(--secondary);
        font-size: 0.875rem;
        margin-left: 0.5rem;
    }

    /* تصميم قائمة الردود */
    .reply {
        padding: 1.5rem;
        border-bottom: 1px solid var(--border);
        transition: var(--transition);
    }

    .reply:last-child {
        border-bottom: none;
    }

    .reply:hover {
        background-color: var(--input);
    }

    .reply-header {
        display: flex;
        align-items: center;
        margin-bottom: 0.75rem;
    }

    .reply-content {
        margin-bottom: 1rem;
        padding-right: 3rem;
    }

    .reply-actions-small {
        display: flex;
        gap: 1.5rem;
    }

    .reply-action-btn {
        background: none;
        border: none;
        color: var(--text);
        font-size: 0.875rem;
        cursor: pointer;
        display: flex;
        align-items: center;
        transition: var(--transition);
    }

    .reply-action-btn:hover {
        color: var(--primary);
    }

    .reply-action-btn i {
        margin-left: 0.5rem;
    }

    /* تصميم الشريط الجانبي */
    .sidebar-section {
        margin-bottom: 2rem;
    }

    .sidebar-title {
        font-size: 1.125rem;
        font-weight: 700;
        margin-bottom: 1rem;
        color: var(--primary);
        padding-bottom: 0.5rem;
        border-bottom: 2px solid var(--accent);
    }

    .user-stats {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 1rem;
        margin-bottom: 1.5rem;
    }

    .user-stat {
        text-align: center;
        padding: 1rem;
        background-color: var(--input);
        border-radius: var(--border-radius);
        transition: var(--transition);
    }

    .user-stat:hover {
        background-color: var(--primary);
        color: white;
        transform: translateY(-3px);
    }

    .user-stat-number {
        font-size: 1.25rem;
        font-weight: 700;
        margin-bottom: 0.25rem;
    }

    .user-stat-label {
        font-size: 0.875rem;
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
            <a class="nav-link" href="/settings">الإعدادات</a>
            <a class="nav-link" href="/profile/<?=$this->e($_SESSION['username'] ?? '')?>">الملف الشخصي</a>
            <a class="nav-link" href="/logout">تسجيل الخروج</a>
        </div>
    </div>
</nav>

<div class="container mt-4">
    <div class="row">
        <!-- العمود الرئيسي -->
        <div class="col-lg-8">
            <!-- التغريدة الأساسية -->
            <div class="card tweet">
                <div class="card-body">
                    <div class="tweet-header">
                        <img src="<?=$tweet['avatar'] ? '/uploads/avatars/' . $tweet['avatar'] : 'https://via.placeholder.com/50'?>" 
                             alt="صورة المستخدم" class="user-avatar">
                        <div class="user-info">
                            <h5>
                                <?=$this->e($tweet['fullname'])?>
                                <?php if ($tweet['is_verified']): ?>
                                    <i class="bi bi-patch-check-fill text-primary"></i>
                                <?php endif; ?>
                            </h5>
                            <span>@<?=$this->e($tweet['username'])?></span>
                        </div>
                    </div>
                    
                    <div class="tweet-content">
                        <?=$this->e($tweet['content'])?>
                    </div>
                    
                    <?php if ($tweet['image_url']): ?>
                        <div class="tweet-image mb-3">
                            <img src="<?=$this->e($tweet['image_url'])?>" 
                                 class="img-fluid rounded" alt="صورة التغريدة">
                        </div>
                    <?php endif; ?>
                    
                    <div class="tweet-time">
                        <?=date('h:i A • d M Y', strtotime($tweet['created_at']))?>
                    </div>
                </div>
            </div>

            <!-- إحصائيات التغريدة -->
            <div class="card">
                <div class="card-body">
                    <div class="tweet-stats">
                        <div class="stat">
                            <div class="stat-number"><?=$this->e($tweet['retweets_count'])?></div>
                            <div class="stat-label">إعادة تغريد</div>
                        </div>
                        <div class="stat">
                            <div class="stat-number"><?=$this->e($tweet['likes_count'])?></div>
                            <div class="stat-label">إعجاب</div>
                        </div>
                        <div class="stat">
                            <div class="stat-number"><?=$this->e(count($replies))?></div>
                            <div class="stat-label">رد</div>
                        </div>
                    </div>
                    
                    <div class="tweet-actions">
                        <button class="action-btn" onclick="toggleReply()">
                            <i class="bi bi-chat"></i>
                        </button>
                        <button class="action-btn">
                            <i class="bi bi-arrow-repeat"></i>
                        </button>
                        <button class="action-btn <?=$isLiked ? 'liked' : ''?>" 
                                onclick="toggleLike(<?=$tweet['id']?>)">
                            <i class="bi <?=$isLiked ? 'bi-heart-fill' : 'bi-heart'?>"></i>
                        </button>
                        <button class="action-btn">
                            <i class="bi bi-share"></i>
                        </button>
                    </div>
                </div>
            </div>

            <!-- نموذج الرد -->
            <div class="card" id="reply-form" style="display: none;">
                <div class="card-body">
                    <form method="POST" action="/tweet/<?=$tweet['id']?>/reply">
                        <div class="reply-input">
                            <img src="<?=$currentUser->avatar ? '/uploads/avatars/' . $currentUser->avatar : 'https://via.placeholder.com/40'?>" 
                                 alt="صورتك" class="user-avatar">
                            <div class="reply-form">
                                <textarea class="reply-textarea" name="content" 
                                          placeholder="اكتب ردك..." required></textarea>
                                <div class="reply-actions">
                                    <div class="media-buttons">
                                        <!-- أزرار الوسائط -->
                                    </div>
                                    <div>
                                        <span class="char-count">280</span>
                                        <button type="submit" class="tweet-btn">رد</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- قائمة الردود -->
            <div class="card">
                <div class="card-header">
                    <strong>الردود (<?=count($replies)?>)</strong>
                </div>
                <div class="card-body p-0">
                    <?php if (empty($replies)): ?>
                        <div class="p-4 text-center text-muted">
                            لا توجد ردود بعد. كن أول من يرد على هذه التغريدة!
                        </div>
                    <?php else: ?>
                        <?php foreach ($replies as $reply): ?>
                            <div class="reply">
                                <div class="reply-header">
                                    <img src="<?=$reply['avatar'] ? '/uploads/avatars/' . $reply['avatar'] : 'https://via.placeholder.com/40'?>" 
                                         alt="صورة المستخدم" class="user-avatar" style="width: 40px; height: 40px;">
                                    <div class="user-info">
                                        <h6 class="mb-1">
                                            <?=$this->e($reply['fullname'])?>
                                            <?php if ($reply['is_verified']): ?>
                                                <i class="bi bi-patch-check-fill text-primary"></i>
                                            <?php endif; ?>
                                        </h6>
                                        <span class="text-muted">@<?=$this->e($reply['username'])?></span>
                                        <span class="text-muted">•</span>
                                        <span class="text-muted"><?=date('h:i A • d M', strtotime($reply['created_at']))?></span>
                                    </div>
                                </div>
                                
                                <div class="reply-content">
                                    <?=$this->e($reply['content'])?>
                                </div>
                                
                                <?php if ($reply['image_url']): ?>
                                    <div class="reply-image mb-3">
                                        <img src="<?=$this->e($reply['image_url'])?>" 
                                             class="img-fluid rounded" alt="صورة الرد">
                                    </div>
                                <?php endif; ?>
                                
                                <div class="reply-actions-small">
                                    <button class="reply-action-btn" onclick="likeReply(<?=$reply['id']?>)">
                                        <i class="bi bi-heart"></i>
                                        <?=$reply['likes_count'] > 0 ? $reply['likes_count'] : ''?>
                                    </button>
                                    <button class="reply-action-btn">
                                        <i class="bi bi-arrow-repeat"></i>
                                    </button>
                                    <button class="reply-action-btn">
                                        <i class="bi bi-share"></i>
                                    </button>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- الشريط الجانبي -->
        <div class="col-lg-4">
            <!-- معلومات الكاتب -->
            <div class="card">
                <div class="card-body text-center">
                    <img src="<?=$author->avatar ? '/uploads/avatars/' . $author->avatar : 'https://via.placeholder.com/100'?>" 
                         alt="صورة الكاتب" class="rounded-circle mb-3" style="width: 100px; height: 100px; object-fit: cover;">
                    
                    <h5>
                        <?=$this->e($author->fullname)?>
                        <?php if ($author->is_verified): ?>
                            <i class="bi bi-patch-check-fill text-primary"></i>
                        <?php endif; ?>
                    </h5>
                    <p class="text-muted">@<?=$this->e($author->username)?></p>
                    
                    <?php if ($author->bio): ?>
                        <p><?=$this->e($author->bio)?></p>
                    <?php endif; ?>
                    
                    <div class="user-stats">
                        <div class="user-stat">
                            <div class="user-stat-number"><?=$this->e($authorStats['tweets'])?></div>
                            <div class="user-stat-label">تغريدة</div>
                        </div>
                        <div class="user-stat">
                            <div class="user-stat-number"><?=$this->e($authorStats['followers'])?></div>
                            <div class="user-stat-label">متابع</div>
                        </div>
                        <div class="user-stat">
                            <div class="user-stat-number"><?=$this->e($authorStats['following'])?></div>
                            <div class="user-stat-label">يتابع</div>
                        </div>
                    </div>
                    
                    <?php if ($author->id != $_SESSION['user_id']): ?>
                        <button class="btn btn-primary w-100">متابعة</button>
                    <?php endif; ?>
                </div>
            </div>

            <!-- اقتراحات -->
            <div class="card">
                <div class="card-header">
                    <strong>قد يعجبك أيضاً</strong>
                </div>
                <div class="card-body">
                    <div class="text-center text-muted">
                        <i class="bi bi-lightbulb" style="font-size: 2rem;"></i>
                        <p>اقتراحات قريباً</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// إظهار/إخفاء نموذج الرد
function toggleReply() {
    const replyForm = document.getElementById('reply-form');
    if (replyForm.style.display === 'none') {
        replyForm.style.display = 'block';
        replyForm.scrollIntoView({ behavior: 'smooth' });
    } else {
        replyForm.style.display = 'none';
    }
}

// تبديل الإعجاب
function toggleLike(tweetId) {
    fetch('/like', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: 'tweet_id=' + tweetId
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload(); // إعادة تحميل الصفحة لتحديث الإحصائيات
        }
    });
}

// تبديل إعجاب الرد
function likeReply(replyId) {
    fetch('/reply/like', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: 'reply_id=' + replyId
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        }
    });
}

// عداد الأحرف
document.addEventListener('DOMContentLoaded', function() {
    const textarea = document.querySelector('.reply-textarea');
    const charCount = document.querySelector('.char-count');
    
    if (textarea && charCount) {
        textarea.addEventListener('input', function() {
            const remaining = 280 - this.value.length;
            charCount.textContent = remaining;
            charCount.style.color = remaining < 20 ? '#e0245e' : '';
        });
    }
});
</script>
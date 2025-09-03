<?php $this->layout('layouts/app', ['title' => $title]) ?>

<style>
    /* شريط البحث الرئيسي */
    .search-hero {
        background: linear-gradient(135deg, var(--primary), var(--accent));
        padding: 2rem 0;
        margin-bottom: 2rem;
        border-radius: 0 0 var(--border-radius) var(--border-radius);
    }

    .search-container {
        max-width: 800px;
        margin: 0 auto;
        position: relative;
    }

    .search-input-container {
        position: relative;
    }

    .search-input {
        width: 100%;
        padding: 1.25rem 4rem 1.25rem 1.25rem;
        border: none;
        border-radius: 50px;
        font-size: 1.125rem;
        box-shadow: var(--box-shadow);
        background-color: var(--card);
        color: var(--text);
        transition: var(--transition);
    }

    .search-input:focus {
        outline: none;
        box-shadow: 0 0 0 3px rgba(124, 77, 255, 0.3);
    }

    .search-icon {
        position: absolute;
        left: 1.5rem;
        top: 50%;
        transform: translateY(-50%);
        color: var(--primary);
        font-size: 1.25rem;
    }

    .search-options {
        display: flex;
        justify-content: center;
        margin-top: 1rem;
        flex-wrap: wrap;
        gap: 0.5rem;
    }

    .search-option {
        background-color: rgba(255, 255, 255, 0.2);
        color: white;
        border: none;
        padding: 0.5rem 1rem;
        border-radius: 50px;
        font-size: 0.875rem;
        cursor: pointer;
        transition: var(--transition);
    }

    .search-option:hover, .search-option.active {
        background-color: rgba(255, 255, 255, 0.3);
        transform: translateY(-2px);
    }

    /* لوحة التصفية */
    .filter-panel {
        position: sticky;
        top: 90px;
        height: calc(100vh - 100px);
        overflow-y: auto;
        padding-right: 0.5rem;
    }

    .filter-section {
        margin-bottom: 1.5rem;
    }

    .filter-title {
        font-size: 1.125rem;
        font-weight: 700;
        margin-bottom: 1rem;
        color: var(--primary);
        padding-bottom: 0.5rem;
        border-bottom: 2px solid var(--accent);
    }

    .filter-group {
        margin-bottom: 1rem;
    }

    .filter-label {
        display: block;
        margin-bottom: 0.5rem;
        font-weight: 600;
        color: var(--text);
    }

    .filter-select, .filter-input {
        width: 100%;
        padding: 0.75rem;
        border: 1px solid var(--border);
        border-radius: var(--border-radius);
        background-color: var(--input);
        color: var(--text);
        transition: var(--transition);
    }

    .filter-select:focus, .filter-input:focus {
        outline: none;
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(124, 77, 255, 0.1);
    }

    /* شريط ترتيب النتائج */
    .results-toolbar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.5rem;
        padding: 1rem;
        background-color: var(--card);
        border-radius: var(--border-radius);
        box-shadow: var(--box-shadow);
    }

    .results-info {
        font-size: 0.875rem;
        color: var(--secondary);
    }

    .results-sort {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .sort-select {
        padding: 0.5rem;
        border: 1px solid var(--border);
        border-radius: var(--border-radius);
        background-color: var(--input);
        color: var(--text);
    }

    /* نتائج البحث */
    .results-container {
        min-height: 500px;
    }

    .result-item {
        padding: 1.5rem;
        border-bottom: 1px solid var(--border);
        transition: var(--transition);
    }

    .result-item:hover {
        background-color: var(--input);
        transform: translateX(5px);
    }

    .result-item:last-child {
        border-bottom: none;
    }

    .result-header {
        display: flex;
        align-items: center;
        margin-bottom: 1rem;
    }

    .result-avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        object-fit: cover;
        margin-left: 1rem;
    }

    .result-user-info {
        flex: 1;
    }

    .result-user-name {
        font-weight: 700;
        margin-bottom: 0.25rem;
    }

    .result-user-handle {
        color: var(--secondary);
        font-size: 0.875rem;
    }

    .result-time {
        color: var(--secondary);
        font-size: 0.875rem;
    }

    .result-content {
        margin-bottom: 1rem;
        line-height: 1.6;
    }

    .highlight {
        background-color: rgba(255, 110, 108, 0.2);
        padding: 0.1rem 0.25rem;
        border-radius: 4px;
        font-weight: 600;
    }

    .result-stats {
        display: flex;
        gap: 1.5rem;
        color: var(--secondary);
        font-size: 0.875rem;
    }

    .result-stat {
        display: flex;
        align-items: center;
        gap: 0.25rem;
    }

    .result-actions {
        display: flex;
        justify-content: space-around;
        margin-top: 1rem;
        padding-top: 1rem;
        border-top: 1px solid var(--border);
    }

    .result-action {
        background: none;
        border: none;
        color: var(--text);
        cursor: pointer;
        padding: 0.5rem;
        border-radius: 50%;
        transition: var(--transition);
    }

    .result-action:hover {
        background-color: var(--input);
        color: var(--primary);
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
            <a class="nav-link active" href="/search">البحث</a>
            <a class="nav-link" href="/lists">القوائم</a>
            <a class="nav-link" href="/events">الفعاليات</a>
            <a class="nav-link" href="/settings">الإعدادات</a>
            <a class="nav-link" href="/profile/<?=$_SESSION['username'] ?? ''?>">الملف الشخصي</a>
            <a class="nav-link" href="/logout">تسجيل الخروج</a>
        </div>
    </div>
</nav>

<!-- شريط البحث الرئيسي -->
<div class="search-hero">
    <div class="container">
        <div class="search-container">
            <form method="GET" action="/search">
                <div class="search-input-container">
                    <input type="text" name="q" class="search-input" 
                           placeholder="البحث في Tewiiq..." 
                           value="<?=$this->e($query)?>" autocomplete="off">
                    <i class="bi bi-search search-icon"></i>
                </div>
                
                <div class="search-options">
                    <button type="submit" name="type" value="all" 
                            class="search-option <?=$type === 'all' ? 'active' : ''?>">الكل</button>
                    <button type="submit" name="type" value="tweets" 
                            class="search-option <?=$type === 'tweets' ? 'active' : ''?>">التغريدات</button>
                    <button type="submit" name="type" value="users" 
                            class="search-option <?=$type === 'users' ? 'active' : ''?>">المستخدمون</button>
                    <button type="submit" name="type" value="events" 
                            class="search-option <?=$type === 'events' ? 'active' : ''?>">الفعاليات</button>
                    <button type="submit" name="type" value="lists" 
                            class="search-option <?=$type === 'lists' ? 'active' : ''?>">القوائم</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="container">
    <div class="row">
        <!-- لوحة التصفية -->
        <div class="col-lg-3">
            <div class="filter-panel">
                <div class="card">
                    <div class="card-body">
                        <div class="filter-section">
                            <div class="filter-title">تصفية النتائج</div>
                            
                            <form method="GET" action="/search">
                                <input type="hidden" name="q" value="<?=$this->e($query)?>">
                                <input type="hidden" name="type" value="<?=$this->e($type)?>">
                                
                                <div class="filter-group">
                                    <label class="filter-label">ترتيب حسب</label>
                                    <select name="sort" class="filter-select">
                                        <option value="recent" <?=$sortBy === 'recent' ? 'selected' : ''?>>الأحدث</option>
                                        <option value="popular" <?=$sortBy === 'popular' ? 'selected' : ''?>>الأكثر شعبية</option>
                                        <option value="relevant" <?=$sortBy === 'relevant' ? 'selected' : ''?>>الأكثر صلة</option>
                                    </select>
                                </div>
                                
                                <div class="filter-group">
                                    <button type="submit" class="btn btn-primary w-100">تطبيق الفلاتر</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- النتائج -->
        <div class="col-lg-9">
            <!-- شريط النتائج -->
            <div class="results-toolbar">
                <div class="results-info">
                    <?php if ($query): ?>
                        <strong><?=$totalResults?></strong> نتيجة للبحث عن "<strong><?=$this->e($query)?></strong>"
                    <?php else: ?>
                        ابحث عن أي شيء في Tewiiq
                    <?php endif; ?>
                </div>
            </div>

            <!-- النتائج -->
            <div class="card results-container">
                <div class="card-body p-0">
                    <?php if (!$query): ?>
                        <!-- الحالة الافتراضية -->
                        <div class="p-5 text-center">
                            <i class="bi bi-search" style="font-size: 3rem; color: var(--secondary);"></i>
                            <h3 class="mt-3">ابحث في Tewiiq</h3>
                            <p class="text-muted">اعثر على التغريدات والأشخاص والفعاليات والمزيد</p>
                        </div>
                    <?php elseif ($totalResults === 0): ?>
                        <!-- لا توجد نتائج -->
                        <div class="p-5 text-center">
                            <i class="bi bi-search" style="font-size: 3rem; color: var(--secondary);"></i>
                            <h3 class="mt-3">لا توجد نتائج</h3>
                            <p class="text-muted">جرب البحث عن شيء آخر</p>
                        </div>
                    <?php elseif ($type === 'all' && is_array($results)): ?>
                        <!-- نتائج متنوعة -->
                        <?php if (!empty($results['users'])): ?>
                            <div class="p-3 border-bottom">
                                <h5><i class="bi bi-people"></i> مستخدمون</h5>
                            </div>
                            <?php foreach (array_slice($results['users'], 0, 3) as $user): ?>
                                <div class="result-item">
                                    <div class="result-header">
                                        <img src="<?=$user['avatar'] ? '/uploads/avatars/' . $user['avatar'] : 'https://via.placeholder.com/40'?>" 
                                             alt="صورة المستخدم" class="result-avatar">
                                        <div class="result-user-info">
                                            <div class="result-user-name">
                                                <?=$this->e($user['fullname'])?>
                                                <?php if ($user['is_verified']): ?>
                                                    <i class="bi bi-patch-check-fill text-primary"></i>
                                                <?php endif; ?>
                                            </div>
                                            <div class="result-user-handle">@<?=$this->e($user['username'])?></div>
                                        </div>
                                        <button class="btn btn-outline-primary btn-sm">متابعة</button>
                                    </div>
                                    <?php if ($user['bio']): ?>
                                        <div class="result-content">
                                            <?=str_ireplace($query, '<span class="highlight">' . $query . '</span>', $this->e($user['bio']))?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>

                        <?php if (!empty($results['tweets'])): ?>
                            <div class="p-3 border-bottom">
                                <h5><i class="bi bi-chat-square-text"></i> تغريدات</h5>
                            </div>
                            <?php foreach (array_slice($results['tweets'], 0, 5) as $tweet): ?>
                                <div class="result-item">
                                    <div class="result-header">
                                        <img src="<?=$tweet['avatar'] ? '/uploads/avatars/' . $tweet['avatar'] : 'https://via.placeholder.com/40'?>" 
                                             alt="صورة المستخدم" class="result-avatar">
                                        <div class="result-user-info">
                                            <div class="result-user-name">
                                                <?=$this->e($tweet['fullname'])?>
                                                <?php if ($tweet['is_verified']): ?>
                                                    <i class="bi bi-patch-check-fill text-primary"></i>
                                                <?php endif; ?>
                                            </div>
                                            <div class="result-user-handle">@<?=$this->e($tweet['username'])?></div>
                                        </div>
                                        <div class="result-time">
                                            <?=date('d M', strtotime($tweet['created_at']))?>
                                        </div>
                                    </div>
                                    
                                    <div class="result-content">
                                        <a href="/tweet/<?=$tweet['id']?>" class="text-decoration-none text-dark">
                                            <?=str_ireplace($query, '<span class="highlight">' . $query . '</span>', $this->e($tweet['content']))?>
                                        </a>
                                    </div>
                                    
                                    <div class="result-stats">
                                        <div class="result-stat">
                                            <i class="bi bi-chat"></i>
                                            <?=$tweet['replies_count']?>
                                        </div>
                                        <div class="result-stat">
                                            <i class="bi bi-arrow-repeat"></i>
                                            <?=$tweet['retweets_count']?>
                                        </div>
                                        <div class="result-stat">
                                            <i class="bi bi-heart"></i>
                                            <?=$tweet['likes_count']?>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>

                    <?php else: ?>
                        <!-- نتائج محددة -->
                        <?php foreach ($results as $item): ?>
                            <?php if ($type === 'tweets'): ?>
                                <div class="result-item">
                                    <div class="result-header">
                                        <img src="<?=$item['avatar'] ? '/uploads/avatars/' . $item['avatar'] : 'https://via.placeholder.com/40'?>" 
                                             alt="صورة المستخدم" class="result-avatar">
                                        <div class="result-user-info">
                                            <div class="result-user-name">
                                                <?=$this->e($item['fullname'])?>
                                                <?php if ($item['is_verified']): ?>
                                                    <i class="bi bi-patch-check-fill text-primary"></i>
                                                <?php endif; ?>
                                            </div>
                                            <div class="result-user-handle">@<?=$this->e($item['username'])?></div>
                                        </div>
                                        <div class="result-time">
                                            <?=date('d M', strtotime($item['created_at']))?>
                                        </div>
                                    </div>
                                    
                                    <div class="result-content">
                                        <a href="/tweet/<?=$item['id']?>" class="text-decoration-none text-dark">
                                            <?=str_ireplace($query, '<span class="highlight">' . $query . '</span>', $this->e($item['content']))?>
                                        </a>
                                    </div>
                                    
                                    <div class="result-stats">
                                        <div class="result-stat">
                                            <i class="bi bi-chat"></i>
                                            <?=$item['replies_count']?>
                                        </div>
                                        <div class="result-stat">
                                            <i class="bi bi-arrow-repeat"></i>
                                            <?=$item['retweets_count']?>
                                        </div>
                                        <div class="result-stat">
                                            <i class="bi bi-heart"></i>
                                            <?=$item['likes_count']?>
                                        </div>
                                    </div>
                                </div>
                            <?php elseif ($type === 'users'): ?>
                                <div class="result-item">
                                    <div class="result-header">
                                        <img src="<?=$item['avatar'] ? '/uploads/avatars/' . $item['avatar'] : 'https://via.placeholder.com/40'?>" 
                                             alt="صورة المستخدم" class="result-avatar">
                                        <div class="result-user-info">
                                            <div class="result-user-name">
                                                <?=str_ireplace($query, '<span class="highlight">' . $query . '</span>', $this->e($item['fullname']))?>
                                                <?php if ($item['is_verified']): ?>
                                                    <i class="bi bi-patch-check-fill text-primary"></i>
                                                <?php endif; ?>
                                            </div>
                                            <div class="result-user-handle">@<?=str_ireplace($query, '<span class="highlight">' . $query . '</span>', $this->e($item['username']))?></div>
                                        </div>
                                        <button class="btn btn-outline-primary btn-sm">متابعة</button>
                                    </div>
                                    <?php if ($item['bio']): ?>
                                        <div class="result-content">
                                            <?=str_ireplace($query, '<span class="highlight">' . $query . '</span>', $this->e($item['bio']))?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// تفعيل البحث المباشر
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.querySelector('.search-input');
    let searchTimeout;

    searchInput.addEventListener('input', function() {
        clearTimeout(searchTimeout);
        const query = this.value.trim();
        
        if (query.length >= 2) {
            searchTimeout = setTimeout(() => {
                // يمكن إضافة اقتراحات البحث هنا
                console.log('البحث عن:', query);
            }, 300);
        }
    });
});
</script>
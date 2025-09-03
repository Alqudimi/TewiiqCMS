<?php $this->layout('layouts/app', ['title' => $title]) ?>

<style>
.main-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 1.5rem;
}

.profile-header {
    background-color: var(--card);
    border-radius: var(--border-radius);
    box-shadow: var(--box-shadow);
    padding: 2rem;
    margin-bottom: 1.5rem;
    display: flex;
    align-items: center;
}

.profile-avatar {
    width: 80px;
    height: 80px;
    border-radius: 50%;
    object-fit: cover;
    margin-left: 1.5rem;
    border: 3px solid var(--primary);
}

.profile-info {
    flex: 1;
}

.profile-name {
    font-weight: 700;
    font-size: 1.25rem;
    margin-bottom: 0.25rem;
}

.profile-handle {
    color: var(--secondary);
    margin-bottom: 1rem;
}

.profile-stats {
    display: flex;
    gap: 1.5rem;
}

.stat {
    text-align: center;
}

.stat-number {
    font-weight: 700;
    font-size: 1.125rem;
    color: var(--primary);
}

.stat-label {
    font-size: 0.875rem;
    color: var(--text);
}

.tabs-container {
    background-color: var(--card);
    border-radius: var(--border-radius);
    box-shadow: var(--box-shadow);
    margin-bottom: 1.5rem;
    overflow: hidden;
}

.tabs {
    display: flex;
    border-bottom: 1px solid var(--border);
}

.tab {
    flex: 1;
    padding: 1rem 1.5rem;
    text-align: center;
    color: var(--text);
    text-decoration: none;
    font-weight: 600;
    position: relative;
    transition: var(--transition);
}

.tab.active {
    color: var(--primary);
}

.tab.active::after {
    content: '';
    position: absolute;
    bottom: -1px;
    left: 0;
    right: 0;
    height: 3px;
    background-color: var(--primary);
    border-radius: 3px 3px 0 0;
}

.tab:hover {
    background-color: var(--input);
}

.tab-badge {
    background-color: var(--primary);
    color: white;
    border-radius: 50px;
    padding: 0.15rem 0.5rem;
    font-size: 0.875rem;
    margin-right: 0.5rem;
}

.search-filters {
    background-color: var(--card);
    border-radius: var(--border-radius);
    box-shadow: var(--box-shadow);
    padding: 1.5rem;
    margin-bottom: 1.5rem;
}

.search-container {
    position: relative;
    margin-bottom: 1rem;
}

.search-input {
    width: 100%;
    padding: 0.75rem 1rem 0.75rem 3rem;
    border: 1px solid var(--border);
    border-radius: var(--border-radius);
    background-color: var(--background);
    color: var(--text);
    transition: var(--transition);
}

.search-input:focus {
    outline: none;
    border-color: var(--primary);
    box-shadow: 0 0 0 3px rgba(124, 77, 255, 0.1);
}

.search-icon {
    position: absolute;
    right: 1rem;
    top: 50%;
    transform: translateY(-50%);
    color: var(--primary);
}

.users-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: 1.5rem;
}

.user-card {
    background-color: var(--card);
    border-radius: var(--border-radius);
    box-shadow: var(--box-shadow);
    padding: 1.5rem;
    transition: var(--transition);
    position: relative;
}

.user-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 16px 42px rgba(0, 0, 0, 0.2);
}

.user-header {
    display: flex;
    align-items: center;
    margin-bottom: 1rem;
}

.user-avatar {
    width: 60px;
    height: 60px;
    border-radius: 50%;
    object-fit: cover;
    margin-left: 1rem;
    border: 2px solid var(--primary);
}

.user-info {
    flex: 1;
}

.user-name {
    font-weight: 700;
    margin-bottom: 0.25rem;
}

.user-handle {
    color: var(--secondary);
    font-size: 0.875rem;
    margin-bottom: 0.5rem;
}

.user-bio {
    font-size: 0.875rem;
    margin-bottom: 1rem;
    line-height: 1.5;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.user-stats {
    display: flex;
    gap: 1rem;
    margin-bottom: 1rem;
    font-size: 0.875rem;
    color: var(--text);
}

.user-stat {
    display: flex;
    align-items: center;
}

.user-stat i {
    margin-left: 0.25rem;
    color: var(--primary);
}

.user-actions {
    display: flex;
    gap: 0.5rem;
}

.follow-btn {
    flex: 1;
    padding: 0.5rem;
    background-color: var(--primary);
    color: white;
    border: none;
    border-radius: var(--border-radius);
    font-weight: 600;
    cursor: pointer;
    transition: var(--transition);
}

.follow-btn:hover {
    background-color: var(--secondary);
}

.follow-btn.following {
    background-color: var(--accent);
}

.action-btn {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    background-color: var(--background);
    color: var(--text);
    border: none;
    cursor: pointer;
    transition: var(--transition);
}

.action-btn:hover {
    background-color: var(--input);
    color: var(--primary);
}

.badge {
    padding: 0.25rem 0.5rem;
    border-radius: 50px;
    font-size: 0.875rem;
    font-weight: 600;
}

.badge-verified {
    background-color: var(--primary);
    color: white;
}

.badge-mutual {
    background-color: var(--accent);
    color: var(--text);
}

.empty-state {
    text-align: center;
    padding: 3rem;
    color: var(--text);
    opacity: 0.7;
}

.empty-state i {
    font-size: 4rem;
    color: var(--primary);
    margin-bottom: 1rem;
}

@media (max-width: 768px) {
    .profile-header {
        flex-direction: column;
        text-align: center;
    }
    
    .profile-avatar {
        margin-left: 0;
        margin-bottom: 1rem;
    }
    
    .users-grid {
        grid-template-columns: 1fr;
    }
}
</style>

<div class="main-container">
    <!-- رأس الملف الشخصي -->
    <div class="profile-header">
        <img src="<?= $user->avatar ?? '/images/default-avatar.png' ?>" 
             alt="<?= $this->e($user->fullname) ?>" 
             class="profile-avatar">
        <div class="profile-info">
            <h2 class="profile-name"><?= $this->e($user->fullname) ?></h2>
            <div class="profile-handle">@<?= $this->e($user->username) ?></div>
            <div class="profile-stats">
                <div class="stat">
                    <div class="stat-number"><?= count($followers ?? []) ?></div>
                    <div class="stat-label">متابع</div>
                </div>
                <div class="stat">
                    <div class="stat-number"><?= User::getFollowingCount($user->id) ?></div>
                    <div class="stat-label">يتابع</div>
                </div>
                <div class="stat">
                    <div class="stat-number"><?= User::getTweetsCount($user->id) ?></div>
                    <div class="stat-label">تغريدة</div>
                </div>
            </div>
        </div>
    </div>

    <!-- التبويبات -->
    <div class="tabs-container">
        <div class="tabs">
            <a href="/<?= $user->username ?>/followers" class="tab <?= $type === 'followers' ? 'active' : '' ?>">
                <span class="tab-badge"><?= count($followers ?? []) ?></span>
                المتابعون
            </a>
            <a href="/<?= $user->username ?>/following" class="tab <?= $type === 'following' ? 'active' : '' ?>">
                <span class="tab-badge"><?= User::getFollowingCount($user->id) ?></span>
                يتابع
            </a>
        </div>
    </div>

    <!-- شريط البحث -->
    <div class="search-filters">
        <div class="search-container">
            <input type="text" class="search-input" placeholder="ابحث في <?= $type === 'followers' ? 'المتابعين' : 'المتابعين' ?>..." id="userSearch">
            <i class="bi bi-search search-icon"></i>
        </div>
    </div>

    <!-- شبكة المستخدمين -->
    <?php if (empty($followers) && empty($following)): ?>
        <div class="empty-state">
            <i class="bi bi-people"></i>
            <h4><?= $type === 'followers' ? 'لا يوجد متابعون بعد' : 'لا يتابع أحد بعد' ?></h4>
            <p>عندما يبدأ <?= $this->e($user->fullname) ?> في <?= $type === 'followers' ? 'جذب المتابعين' : 'متابعة الآخرين' ?>، ستظهر هنا</p>
        </div>
    <?php else: ?>
        <div class="users-grid">
            <?php 
            $users = $type === 'followers' ? ($followers ?? []) : ($following ?? []);
            foreach ($users as $userItem): 
            ?>
                <div class="user-card">
                    <div class="user-header">
                        <img src="<?= $userItem['user']->avatar ?? '/images/default-avatar.png' ?>" 
                             alt="<?= $this->e($userItem['user']->fullname) ?>" 
                             class="user-avatar">
                        <div class="user-info">
                            <div class="user-name">
                                <?= $this->e($userItem['user']->fullname) ?>
                                <?php if ($userItem['user']->is_verified): ?>
                                    <span class="badge badge-verified">موثق</span>
                                <?php endif; ?>
                                <?php if ($userItem['is_mutual']): ?>
                                    <span class="badge badge-mutual">متبادل</span>
                                <?php endif; ?>
                            </div>
                            <div class="user-handle">@<?= $this->e($userItem['user']->username) ?></div>
                        </div>
                    </div>
                    
                    <?php if ($userItem['user']->bio): ?>
                        <div class="user-bio"><?= $this->e($userItem['user']->bio) ?></div>
                    <?php endif; ?>
                    
                    <div class="user-stats">
                        <div class="user-stat">
                            <i class="bi bi-people"></i>
                            <?= User::getFollowersCount($userItem['user']->id) ?> متابع
                        </div>
                        <div class="user-stat">
                            <i class="bi bi-chat"></i>
                            <?= User::getTweetsCount($userItem['user']->id) ?> تغريدة
                        </div>
                    </div>
                    
                    <div class="user-actions">
                        <?php if ($userItem['user']->id !== $current_user->id): ?>
                            <form method="POST" action="/<?= $userItem['is_following'] ? 'unfollow' : 'follow' ?>">
                                <input type="hidden" name="user_id" value="<?= $userItem['user']->id ?>">
                                <button type="submit" class="follow-btn <?= $userItem['is_following'] ? 'following' : '' ?>">
                                    <?= $userItem['is_following'] ? 'إلغاء المتابعة' : 'متابعة' ?>
                                </button>
                            </form>
                            <button class="action-btn" title="رسالة">
                                <i class="bi bi-envelope"></i>
                            </button>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>
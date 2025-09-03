<?php $this->layout('layouts/app', ['title' => $profileUser->fullname . ' - Tewiiq']) ?>

<nav class="navbar navbar-expand-lg navbar-light fixed-top">
    <div class="container-fluid">
        <a class="navbar-brand" href="/">
            <i class="bi bi-twitter me-2"></i>Tewiiq
        </a>
        
        <div class="navbar-nav ms-auto">
            <a class="nav-link" href="/">
                <i class="bi bi-house me-1"></i>الرئيسية
            </a>
            <a class="nav-link" href="/logout">
                <i class="bi bi-box-arrow-right me-1"></i>خروج
            </a>
        </div>
    </div>
</nav>

<div class="container-fluid">
    <div class="row">
        <div class="col-lg-8 col-md-12">
            <!-- Profile Header -->
            <div class="card mb-4">
                <div class="card-body">
                    <div class="d-flex align-items-start">
                        <img src="<?=$profileUser->avatar ? '/uploads/' . $profileUser->avatar : 'https://via.placeholder.com/80'?>" 
                             class="rounded-circle me-4" width="80" height="80" alt="صورة المستخدم">
                        
                        <div class="flex-grow-1">
                            <div class="d-flex justify-content-between align-items-start mb-3">
                                <div>
                                    <h4 class="mb-1">
                                        <?=$this->e($profileUser->fullname)?>
                                        <?php if ($profileUser->is_verified): ?>
                                            <i class="bi bi-patch-check-fill text-primary ms-1"></i>
                                        <?php endif; ?>
                                    </h4>
                                    <p class="text-muted mb-0">@<?=$this->e($profileUser->username)?></p>
                                </div>
                                
                                <?php if (!$isOwnProfile): ?>
                                    <button class="btn <?=$isFollowing ? 'btn-outline-primary' : 'btn-primary'?> follow-btn" 
                                            data-user-id="<?=$profileUser->id?>">
                                        <?=$isFollowing ? 'إلغاء المتابعة' : 'متابعة'?>
                                    </button>
                                <?php endif; ?>
                            </div>
                            
                            <?php if ($profileUser->bio): ?>
                                <p class="mb-3"><?=$this->e($profileUser->bio)?></p>
                            <?php endif; ?>
                            
                            <div class="d-flex gap-4">
                                <span><strong><?=$tweetsCount?></strong> تغريدة</span>
                                <span><strong id="following-count"><?=$followingCount?></strong> متابَع</span>
                                <span><strong id="followers-count"><?=$followersCount?></strong> متابع</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Tweets -->
            <div id="profile-tweets">
                <?php if (empty($tweets)): ?>
                    <div class="card">
                        <div class="card-body text-center">
                            <h5>لا توجد تغريدات</h5>
                            <p class="text-muted"><?=$isOwnProfile ? 'ابدأ بنشر تغريدتك الأولى!' : 'لم ينشر أي تغريدات بعد'?></p>
                        </div>
                    </div>
                <?php else: ?>
                    <?php foreach ($tweets as $tweet): ?>
                        <div class="card mb-3">
                            <div class="card-body">
                                <div class="d-flex align-items-start">
                                    <img src="<?=$tweet['avatar'] ? '/uploads/' . $tweet['avatar'] : 'https://via.placeholder.com/50'?>" 
                                         class="rounded-circle me-3" width="50" height="50" alt="صورة المستخدم">
                                    
                                    <div class="flex-grow-1">
                                        <div class="d-flex align-items-center mb-2">
                                            <h6 class="mb-0 me-2">
                                                <?=$this->e($tweet['fullname'])?>
                                                <?php if ($tweet['is_verified']): ?>
                                                    <i class="bi bi-patch-check-fill text-primary ms-1"></i>
                                                <?php endif; ?>
                                            </h6>
                                            <span class="text-muted">@<?=$this->e($tweet['username'])?></span>
                                            <span class="text-muted ms-2">•</span>
                                            <span class="text-muted ms-2"><?=date('H:i', strtotime($tweet['created_at']))?></span>
                                        </div>
                                        
                                        <p class="mb-3"><?=$this->e($tweet['content'])?></p>
                                        
                                        <?php if ($tweet['image_url']): ?>
                                            <img src="<?=$this->e($tweet['image_url'])?>" class="img-fluid rounded mb-3" 
                                                 style="max-height: 300px;" alt="صورة التغريدة">
                                        <?php endif; ?>
                                        
                                        <div class="d-flex justify-content-between">
                                            <button class="btn btn-sm btn-outline-secondary">
                                                <i class="bi bi-chat"></i> <?=$tweet['replies_count']?>
                                            </button>
                                            <button class="btn btn-sm btn-outline-success">
                                                <i class="bi bi-arrow-repeat"></i> <?=$tweet['retweets_count']?>
                                            </button>
                                            <button class="btn btn-sm <?=$tweet['is_liked'] ? 'btn-danger' : 'btn-outline-danger'?> like-btn" 
                                                    data-tweet-id="<?=$tweet['id']?>">
                                                <i class="bi bi-heart<?=$tweet['is_liked'] ? '-fill' : ''?>"></i> 
                                                <span class="likes-count"><?=$tweet['likes_count']?></span>
                                            </button>
                                            <button class="btn btn-sm btn-outline-primary">
                                                <i class="bi bi-share"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
        
        <!-- Sidebar -->
        <div class="col-lg-4 d-none d-lg-block">
            <div class="card">
                <div class="card-header">
                    <h6 class="mb-0">معلومات إضافية</h6>
                </div>
                <div class="card-body">
                    <?php if ($profileUser->location): ?>
                        <p><i class="bi bi-geo-alt me-2"></i><?=$this->e($profileUser->location)?></p>
                    <?php endif; ?>
                    
                    <?php if ($profileUser->website): ?>
                        <p><i class="bi bi-link-45deg me-2"></i>
                           <a href="<?=$this->e($profileUser->website)?>" target="_blank"><?=$this->e($profileUser->website)?></a>
                        </p>
                    <?php endif; ?>
                    
                    <p><i class="bi bi-calendar3 me-2"></i>انضم في <?=date('F Y', strtotime($profileUser->created_at))?></p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Follow/Unfollow functionality
    const followBtn = document.querySelector('.follow-btn');
    if (followBtn) {
        followBtn.addEventListener('click', function() {
            const userId = this.dataset.userId;
            const isFollowing = this.textContent.trim() === 'إلغاء المتابعة';
            const action = isFollowing ? 'unfollow' : 'follow';
            
            fetch('/' + action, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: 'user_id=' + userId
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    if (data.following) {
                        this.textContent = 'إلغاء المتابعة';
                        this.classList.remove('btn-primary');
                        this.classList.add('btn-outline-primary');
                    } else {
                        this.textContent = 'متابعة';
                        this.classList.remove('btn-outline-primary');
                        this.classList.add('btn-primary');
                    }
                    
                    document.getElementById('followers-count').textContent = data.followers_count;
                }
            });
        });
    }
    
    // Like functionality
    document.querySelectorAll('.like-btn').forEach(button => {
        button.addEventListener('click', function() {
            const tweetId = this.dataset.tweetId;
            const likesCountElement = this.querySelector('.likes-count');
            const heartIcon = this.querySelector('i');
            
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
                    likesCountElement.textContent = data.likes_count;
                    
                    if (data.liked) {
                        this.classList.remove('btn-outline-danger');
                        this.classList.add('btn-danger');
                        heartIcon.classList.add('bi-heart-fill');
                        heartIcon.classList.remove('bi-heart');
                    } else {
                        this.classList.remove('btn-danger');
                        this.classList.add('btn-outline-danger');
                        heartIcon.classList.remove('bi-heart-fill');
                        heartIcon.classList.add('bi-heart');
                    }
                }
            });
        });
    });
});
</script>
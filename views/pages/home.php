<?php $this->layout('layouts/app', ['title' => 'الرئيسية - Tewiiq']) ?>

<nav class="navbar navbar-expand-lg navbar-light fixed-top">
    <div class="container-fluid">
        <a class="navbar-brand" href="/">
            <i class="bi bi-twitter me-2"></i>Tewiiq
        </a>
        
        <div class="navbar-nav ms-auto">
            <a class="nav-link" href="/profile/<?=$this->e($user->username)?>">
                <i class="bi bi-person-circle me-1"></i><?=$this->e($user->fullname)?>
            </a>
            <a class="nav-link" href="/logout">
                <i class="bi bi-box-arrow-right me-1"></i>خروج
            </a>
        </div>
    </div>
</nav>

<div class="container-fluid">
    <div class="row">
        <!-- Main Content -->
        <div class="col-lg-8 col-md-12">
            <!-- Create Tweet -->
            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="card-title">ما الذي يحدث؟</h5>
                    
                    <?php if (isset($_SESSION['error'])): ?>
                        <div class="alert alert-danger">
                            <?=$this->e($_SESSION['error'])?>
                            <?php unset($_SESSION['error']); ?>
                        </div>
                    <?php endif; ?>
                    
                    <?php if (isset($_SESSION['success'])): ?>
                        <div class="alert alert-success">
                            <?=$this->e($_SESSION['success'])?>
                            <?php unset($_SESSION['success']); ?>
                        </div>
                    <?php endif; ?>
                    
                    <form method="POST" action="/tweet" enctype="multipart/form-data">
                        <div class="mb-3">
                            <textarea class="form-control" name="content" rows="3" 
                                      placeholder="شارك أفكارك..." maxlength="280" required></textarea>
                        </div>
                        
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <input type="file" class="form-control-file d-none" id="image" name="image" accept="image/*">
                                <label for="image" class="btn btn-outline-primary btn-sm me-2">
                                    <i class="bi bi-image"></i> صورة
                                </label>
                            </div>
                            <button type="submit" class="btn btn-primary">نشر</button>
                        </div>
                    </form>
                </div>
            </div>
            
            <!-- Tweets -->
            <div id="tweets-container">
                <?php if (empty($tweets)): ?>
                    <div class="card">
                        <div class="card-body text-center">
                            <h5>لا توجد تغريدات حتى الآن</h5>
                            <p class="text-muted">كن أول من ينشر تغريدة!</p>
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
                                                <a href="/profile/<?=$this->e($tweet['username'])?>" class="text-decoration-none">
                                                    <?=$this->e($tweet['fullname'])?>
                                                </a>
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
                    <h6 class="mb-0">الأشخاص المقترحون</h6>
                </div>
                <div class="card-body">
                    <p class="text-muted">لا توجد اقتراحات حالياً</p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
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
<?php $this->layout('layouts/app', ['title' => $title]) ?>

<style>
/* تصميم الريلز بدون navbar للحصول على ملء الشاشة */
body {
    padding-top: 0;
    margin: 0;
    height: 100vh;
    overflow: hidden;
}

.reels-container {
    position: relative;
    height: 100vh;
    width: 100%;
    overflow-y: auto;
    scroll-snap-type: y mandatory;
    scroll-behavior: smooth;
}

.reel {
    position: relative;
    height: 100vh;
    width: 100%;
    scroll-snap-align: start;
    overflow: hidden;
    background: #000;
    display: flex;
    align-items: center;
    justify-content: center;
}

.reel-video {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    object-fit: cover;
    background-color: #000;
}

.reel-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(to bottom, transparent 70%, rgba(0,0,0,0.6));
}

.top-controls {
    position: absolute;
    top: 0;
    right: 0;
    left: 0;
    z-index: 20;
    padding: 1rem;
    display: flex;
    justify-content: space-between;
    align-items: center;
    background: linear-gradient(to bottom, rgba(0,0,0,0.6), transparent);
}

.app-title {
    color: white;
    font-weight: 800;
    font-size: 1.5rem;
    text-shadow: 0 2px 4px rgba(0,0,0,0.5);
}

.top-actions {
    display: flex;
    gap: 1rem;
}

.top-action {
    color: white;
    font-size: 1.25rem;
    background: none;
    border: none;
    cursor: pointer;
    width: 40px;
    height: 40px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    background: rgba(0,0,0,0.3);
    backdrop-filter: blur(10px);
}

.side-controls {
    position: absolute;
    bottom: 120px;
    left: 1rem;
    z-index: 20;
    display: flex;
    flex-direction: column;
    gap: 1.5rem;
    align-items: center;
}

.side-action {
    display: flex;
    flex-direction: column;
    align-items: center;
    color: white;
    background: none;
    border: none;
    cursor: pointer;
    text-shadow: 0 2px 4px rgba(0,0,0,0.5);
}

.action-icon {
    font-size: 1.5rem;
    margin-bottom: 0.25rem;
    background: rgba(0,0,0,0.3);
    width: 50px;
    height: 50px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    backdrop-filter: blur(10px);
    transition: all 0.3s ease;
}

.action-icon:hover {
    background: rgba(0,0,0,0.5);
    transform: scale(1.1);
}

.action-icon.liked {
    color: #ff3040;
}

.action-count {
    font-size: 0.8rem;
    font-weight: 600;
    text-shadow: 0 2px 4px rgba(0,0,0,0.5);
}

.profile-action {
    position: relative;
}

.profile-avatar {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    border: 2px solid white;
    object-fit: cover;
}

.follow-btn {
    position: absolute;
    bottom: -8px;
    right: 50%;
    transform: translateX(50%);
    background-color: var(--primary);
    color: white;
    border: none;
    border-radius: 50%;
    width: 24px;
    height: 24px;
    font-size: 0.7rem;
    display: flex;
    align-items: center;
    justify-content: center;
}

.reel-info {
    position: absolute;
    bottom: 120px;
    right: 1rem;
    z-index: 20;
    max-width: 70%;
    color: white;
}

.reel-user {
    display: flex;
    align-items: center;
    margin-bottom: 0.75rem;
}

.user-avatar {
    width: 32px;
    height: 32px;
    border-radius: 50%;
    object-fit: cover;
    margin-left: 0.5rem;
    border: 1px solid white;
}

.user-name {
    font-weight: 600;
    font-size: 0.9rem;
    text-shadow: 0 2px 4px rgba(0,0,0,0.5);
}

.reel-description {
    font-size: 0.9rem;
    margin-bottom: 0.5rem;
    line-height: 1.4;
    text-shadow: 0 2px 4px rgba(0,0,0,0.5);
}

.reel-music {
    display: flex;
    align-items: center;
    font-size: 0.8rem;
    opacity: 0.9;
    margin-bottom: 0.75rem;
    text-shadow: 0 2px 4px rgba(0,0,0,0.5);
}

.music-icon {
    margin-left: 0.25rem;
}

.reel-tags {
    display: flex;
    flex-wrap: wrap;
    gap: 0.5rem;
}

.reel-tag {
    background-color: rgba(0,0,0,0.5);
    color: white;
    padding: 0.25rem 0.5rem;
    border-radius: 12px;
    font-size: 0.8rem;
    backdrop-filter: blur(10px);
}

.bottom-controls {
    position: absolute;
    bottom: 0;
    right: 0;
    left: 0;
    z-index: 20;
    padding: 1rem;
    display: flex;
    justify-content: space-between;
    align-items: center;
    background: linear-gradient(to top, rgba(0,0,0,0.6), transparent);
}

.reel-progress {
    flex: 1;
    height: 2px;
    background-color: rgba(255, 255, 255, 0.3);
    border-radius: 1px;
    overflow: hidden;
    margin: 0 0.5rem;
}

.progress-bar {
    height: 100%;
    background-color: white;
    width: 0%;
    transition: width 0.1s linear;
}

.nav-btn {
    color: white;
    background: rgba(0,0,0,0.3);
    border: none;
    font-size: 1.25rem;
    cursor: pointer;
    width: 40px;
    height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    backdrop-filter: blur(10px);
}

.comments-panel {
    position: fixed;
    bottom: 0;
    right: 0;
    left: 0;
    height: 70vh;
    background-color: var(--card);
    border-radius: 20px 20px 0 0;
    z-index: 30;
    transform: translateY(100%);
    transition: transform 0.3s ease-out;
    display: flex;
    flex-direction: column;
}

.comments-panel.open {
    transform: translateY(0);
}

.comments-header {
    padding: 1rem;
    display: flex;
    justify-content: space-between;
    align-items: center;
    border-bottom: 1px solid var(--border);
}

.comments-title {
    font-weight: 600;
    font-size: 1rem;
}

.close-comments {
    background: none;
    border: none;
    color: var(--text);
    font-size: 1.25rem;
    cursor: pointer;
}

.comments-list {
    flex: 1;
    overflow-y: auto;
    padding: 1rem;
}

.comment-item {
    display: flex;
    margin-bottom: 1rem;
}

.comment-avatar {
    width: 36px;
    height: 36px;
    border-radius: 50%;
    object-fit: cover;
    margin-left: 0.75rem;
}

.comment-content {
    flex: 1;
}

.comment-user {
    font-weight: 600;
    font-size: 0.9rem;
    margin-bottom: 0.25rem;
}

.comment-text {
    font-size: 0.9rem;
    margin-bottom: 0.25rem;
}

.comment-actions {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    font-size: 0.8rem;
    color: var(--text);
    opacity: 0.7;
}

.comment-form {
    padding: 1rem;
    display: flex;
    align-items: center;
    gap: 0.75rem;
    border-top: 1px solid var(--border);
}

.comment-input {
    flex: 1;
    padding: 0.5rem 1rem;
    background-color: var(--input);
    border: none;
    border-radius: 20px;
    color: var(--text);
    font-size: 0.9rem;
}

.comment-submit {
    background: none;
    border: none;
    color: var(--primary);
    font-size: 1.25rem;
    cursor: pointer;
}

.like-animation {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%) scale(0);
    font-size: 80px;
    color: #ff3040;
    opacity: 0;
    pointer-events: none;
    z-index: 25;
}

.like-animation.active {
    animation: likeHeart 0.8s forwards;
}

@keyframes likeHeart {
    0% {
        opacity: 0;
        transform: translate(-50%, -50%) scale(0);
    }
    15% {
        opacity: 1;
        transform: translate(-50%, -50%) scale(1.2);
    }
    30% {
        transform: translate(-50%, -50%) scale(0.95);
    }
    45%, 80% {
        opacity: 1;
        transform: translate(-50%, -50%) scale(1);
    }
    100% {
        opacity: 0;
        transform: translate(-50%, -50%) scale(1.5);
    }
}

.create-reel-btn {
    position: fixed;
    bottom: 80px;
    right: 1rem;
    z-index: 20;
    width: 50px;
    height: 50px;
    border-radius: 50%;
    background: linear-gradient(135deg, var(--primary), var(--secondary));
    color: white;
    border: none;
    font-size: 1.25rem;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 4px 12px rgba(0,0,0,0.3);
}

.empty-reels {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    text-align: center;
    color: white;
}

.empty-reels i {
    font-size: 4rem;
    margin-bottom: 1rem;
    opacity: 0.7;
}
</style>

<div class="reels-container" id="reelsContainer">
    <!-- Top Controls -->
    <div class="top-controls">
        <div class="app-title">ريلز Tewiiq</div>
        <div class="top-actions">
            <button class="top-action" onclick="window.location.href='/'">
                <i class="bi bi-house"></i>
            </button>
            <button class="top-action" onclick="window.location.href='/reels/create'">
                <i class="bi bi-camera-video"></i>
            </button>
        </div>
    </div>

    <?php if (empty($reels)): ?>
        <div class="empty-reels">
            <i class="bi bi-camera-reels"></i>
            <h3>لا توجد ريلز بعد</h3>
            <p>كن أول من ينشر ريل!</p>
            <button class="btn btn-primary mt-3" onclick="window.location.href='/reels/create'">
                إنشاء ريل
            </button>
        </div>
    <?php else: ?>
        <?php foreach ($reels as $index => $reelData): ?>
            <div class="reel" data-reel-id="<?= $reelData['reel']->id ?>" data-index="<?= $index ?>">
                <!-- Video Background -->
                <video class="reel-video" 
                       src="<?= $reelData['reel']->video_url ?>" 
                       loop 
                       muted 
                       playsinline
                       <?= $index === 0 ? 'autoplay' : '' ?>></video>
                
                <!-- Overlay -->
                <div class="reel-overlay"></div>
                
                <!-- Side Controls -->
                <div class="side-controls">
                    <!-- User Profile -->
                    <div class="side-action profile-action">
                        <img src="<?= $reelData['user']->avatar ?? '/images/default-avatar.png' ?>" 
                             alt="<?= $this->e($reelData['user']->fullname) ?>" 
                             class="profile-avatar">
                        <?php if ($reelData['user']->id !== $current_user->id && !User::isFollowing($current_user->id, $reelData['user']->id)): ?>
                            <button class="follow-btn" onclick="followUser(<?= $reelData['user']->id ?>)">
                                <i class="bi bi-plus"></i>
                            </button>
                        <?php endif; ?>
                    </div>

                    <!-- Like -->
                    <button class="side-action like-action" onclick="toggleLike(<?= $reelData['reel']->id ?>, this)">
                        <div class="action-icon <?= $reelData['is_liked'] ? 'liked' : '' ?>">
                            <i class="bi bi-heart<?= $reelData['is_liked'] ? '-fill' : '' ?>"></i>
                        </div>
                        <div class="action-count like-count"><?= $reelData['reel']->likes_count ?></div>
                    </button>

                    <!-- Comments -->
                    <button class="side-action" onclick="openComments(<?= $reelData['reel']->id ?>)">
                        <div class="action-icon">
                            <i class="bi bi-chat"></i>
                        </div>
                        <div class="action-count"><?= $reelData['reel']->comments_count ?></div>
                    </button>

                    <!-- Share -->
                    <button class="side-action" onclick="shareReel(<?= $reelData['reel']->id ?>)">
                        <div class="action-icon">
                            <i class="bi bi-share"></i>
                        </div>
                        <div class="action-count">مشاركة</div>
                    </button>
                </div>

                <!-- Reel Info -->
                <div class="reel-info">
                    <div class="reel-user">
                        <img src="<?= $reelData['user']->avatar ?? '/images/default-avatar.png' ?>" 
                             alt="<?= $this->e($reelData['user']->fullname) ?>" 
                             class="user-avatar">
                        <div class="user-name"><?= $this->e($reelData['user']->fullname) ?></div>
                    </div>

                    <?php if ($reelData['reel']->description): ?>
                        <div class="reel-description"><?= nl2br($this->e($reelData['reel']->description)) ?></div>
                    <?php endif; ?>

                    <div class="reel-music">
                        <i class="bi bi-music-note music-icon"></i>
                        <?= $this->e($reelData['reel']->music_title) ?> - <?= $this->e($reelData['reel']->music_artist ?: $reelData['user']->fullname) ?>
                    </div>

                    <?php if ($reelData['reel']->hashtags): ?>
                        <div class="reel-tags">
                            <?php 
                            $hashtags = explode(' ', $reelData['reel']->hashtags);
                            foreach ($hashtags as $hashtag): 
                                if (trim($hashtag)):
                            ?>
                                <span class="reel-tag"><?= $this->e(trim($hashtag)) ?></span>
                            <?php 
                                endif;
                            endforeach; 
                            ?>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Like Animation -->
                <div class="like-animation">
                    <i class="bi bi-heart-fill"></i>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>

    <!-- Create Reel Button -->
    <button class="create-reel-btn" onclick="window.location.href='/reels/create'">
        <i class="bi bi-plus-lg"></i>
    </button>
</div>

<!-- Comments Panel -->
<div class="comments-panel" id="commentsPanel">
    <div class="comments-header">
        <h5 class="comments-title">التعليقات</h5>
        <button class="close-comments" onclick="closeComments()">
            <i class="bi bi-x"></i>
        </button>
    </div>
    <div class="comments-list" id="commentsList">
        <!-- Comments will be loaded here -->
    </div>
    <div class="comment-form">
        <img src="<?= $current_user->avatar ?? '/images/default-avatar.png' ?>" 
             class="comment-avatar">
        <input type="text" class="comment-input" placeholder="أضف تعليق..." id="commentInput">
        <button class="comment-submit" onclick="addComment()">
            <i class="bi bi-send"></i>
        </button>
    </div>
</div>

<script>
let currentReelId = null;
let currentVideo = null;

// Initialize reels functionality
document.addEventListener('DOMContentLoaded', function() {
    const reelsContainer = document.getElementById('reelsContainer');
    const reels = document.querySelectorAll('.reel');
    
    // Play first video
    if (reels.length > 0) {
        playVideo(reels[0].querySelector('.reel-video'));
    }
    
    // Handle scroll to change videos
    reelsContainer.addEventListener('scroll', function() {
        const currentReel = getCurrentReel();
        if (currentReel) {
            const video = currentReel.querySelector('.reel-video');
            if (video !== currentVideo) {
                pauseAllVideos();
                playVideo(video);
            }
        }
    });
    
    // Handle double tap to like
    reels.forEach(reel => {
        let touchTime = 0;
        reel.addEventListener('touchend', function(e) {
            const currentTime = new Date().getTime();
            const tapLength = currentTime - touchTime;
            if (tapLength < 500 && tapLength > 0) {
                const reelId = reel.dataset.reelId;
                const likeBtn = reel.querySelector('.like-action');
                toggleLike(reelId, likeBtn);
                showLikeAnimation(reel);
                e.preventDefault();
            }
            touchTime = currentTime;
        });
    });
});

function getCurrentReel() {
    const reels = document.querySelectorAll('.reel');
    const containerHeight = window.innerHeight;
    
    for (let reel of reels) {
        const rect = reel.getBoundingClientRect();
        if (rect.top >= -containerHeight/2 && rect.top < containerHeight/2) {
            return reel;
        }
    }
    return null;
}

function playVideo(video) {
    if (currentVideo && currentVideo !== video) {
        currentVideo.pause();
    }
    currentVideo = video;
    video.play().catch(e => console.log('Play error:', e));
}

function pauseAllVideos() {
    document.querySelectorAll('.reel-video').forEach(video => {
        video.pause();
    });
}

function toggleLike(reelId, button) {
    const icon = button.querySelector('i');
    const countElement = button.querySelector('.like-count');
    const actionIcon = button.querySelector('.action-icon');
    
    fetch('/reels/like', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `reel_id=${reelId}`
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            if (data.action === 'liked') {
                icon.className = 'bi bi-heart-fill';
                actionIcon.classList.add('liked');
            } else {
                icon.className = 'bi bi-heart';
                actionIcon.classList.remove('liked');
            }
            countElement.textContent = data.likes_count;
        }
    })
    .catch(error => console.error('Error:', error));
}

function openComments(reelId) {
    currentReelId = reelId;
    const panel = document.getElementById('commentsPanel');
    panel.classList.add('open');
    loadComments(reelId);
}

function closeComments() {
    const panel = document.getElementById('commentsPanel');
    panel.classList.remove('open');
}

function loadComments(reelId) {
    fetch(`/reels/comments?reel_id=${reelId}`)
    .then(response => response.json())
    .then(data => {
        const commentsList = document.getElementById('commentsList');
        if (data.success && data.comments.length > 0) {
            let html = '';
            data.comments.forEach(comment => {
                html += `
                    <div class="comment-item">
                        <img src="${comment.user.avatar || '/images/default-avatar.png'}" 
                             class="comment-avatar">
                        <div class="comment-content">
                            <div class="comment-user">${comment.user.fullname}</div>
                            <div class="comment-text">${comment.comment.content}</div>
                            <div class="comment-actions">
                                <span>${new Date(comment.comment.created_at).toLocaleString('ar-SA')}</span>
                            </div>
                        </div>
                    </div>
                `;
            });
            commentsList.innerHTML = html;
        } else {
            commentsList.innerHTML = '<p class="text-center text-muted p-3">لا توجد تعليقات بعد</p>';
        }
    })
    .catch(error => console.error('Error:', error));
}

function addComment() {
    const input = document.getElementById('commentInput');
    const content = input.value.trim();
    
    if (!content || !currentReelId) return;
    
    fetch('/reels/comment', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `reel_id=${currentReelId}&content=${encodeURIComponent(content)}`
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            input.value = '';
            loadComments(currentReelId);
        }
    })
    .catch(error => console.error('Error:', error));
}

function showLikeAnimation(reel) {
    const animation = reel.querySelector('.like-animation');
    animation.classList.remove('active');
    setTimeout(() => {
        animation.classList.add('active');
    }, 10);
}

function followUser(userId) {
    fetch('/follow', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `user_id=${userId}`
    })
    .then(response => {
        if (response.ok) {
            // Hide follow button
            document.querySelector(`[data-user-id="${userId}"] .follow-btn`).style.display = 'none';
        }
    })
    .catch(error => console.error('Error:', error));
}

function shareReel(reelId) {
    if (navigator.share) {
        navigator.share({
            title: 'ريل من Tewiiq',
            url: `${window.location.origin}/reels/${reelId}`
        });
    } else {
        // Fallback - copy to clipboard
        navigator.clipboard.writeText(`${window.location.origin}/reels/${reelId}`)
        .then(() => alert('تم نسخ الرابط'))
        .catch(() => alert('فشل في نسخ الرابط'));
    }
}

// Handle Enter key in comment input
document.getElementById('commentInput').addEventListener('keypress', function(e) {
    if (e.key === 'Enter') {
        addComment();
    }
});
</script>
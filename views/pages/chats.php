<?php $this->layout('layouts/app', ['title' => $title]) ?>

<style>
/* Chat-specific styles */
.chat-container {
    height: calc(100vh - 76px);
    padding: 0;
    overflow: hidden;
}

.conversations-sidebar {
    height: 100%;
    border-left: 1px solid var(--border);
    background-color: var(--card);
    transition: var(--transition);
    overflow-y: auto;
}

.conversation-item {
    padding: 1rem;
    border-bottom: 1px solid var(--border);
    cursor: pointer;
    transition: var(--transition);
    display: flex;
    align-items: center;
}

.conversation-item:hover {
    background-color: var(--input);
}

.conversation-avatar {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    object-fit: cover;
    margin-left: 1rem;
}

.conversation-info {
    flex: 1;
}

.conversation-name {
    font-weight: bold;
    margin-bottom: 0.25rem;
}

.conversation-preview {
    font-size: 0.9rem;
    color: var(--text);
    opacity: 0.8;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.conversation-meta {
    text-align: left;
    display: flex;
    flex-direction: column;
    align-items: flex-end;
}

.conversation-time {
    font-size: 0.8rem;
    opacity: 0.7;
    margin-bottom: 0.25rem;
}

.unread-count {
    background-color: var(--primary);
    color: white;
    border-radius: 50%;
    width: 20px;
    height: 20px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.7rem;
}

.empty-chat {
    height: 100%;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    text-align: center;
}

.empty-chat i {
    font-size: 4rem;
    color: var(--primary);
    margin-bottom: 1rem;
}

@media (max-width: 992px) {
    .conversations-sidebar {
        position: fixed;
        top: 76px;
        right: 0;
        width: 100%;
        height: calc(100vh - 76px);
        z-index: 1000;
    }
}
</style>

<div class="container-fluid chat-container">
    <div class="row h-100">
        <!-- قائمة المحادثات الجانبية -->
        <div class="col-md-4 col-lg-3 conversations-sidebar">
            <div class="p-3 border-bottom">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="mb-0">الرسائل</h5>
                    <button class="btn btn-primary btn-sm rounded-circle" data-bs-toggle="modal" data-bs-target="#newConversationModal">
                        <i class="bi bi-plus-lg"></i>
                    </button>
                </div>
                <div class="input-group">
                    <span class="input-group-text bg-transparent border-end-0">
                        <i class="bi bi-search"></i>
                    </span>
                    <input type="text" class="form-control border-start-0" placeholder="ابحث في المحادثات" id="conversationSearch">
                </div>
            </div>

            <div class="conversations-list">
                <?php if (empty($conversations)): ?>
                    <div class="text-center p-4">
                        <i class="bi bi-chat-dots text-muted"></i>
                        <h6 class="mt-2 text-muted">لا توجد محادثات بعد</h6>
                        <p class="small text-muted">ابدأ محادثة جديدة مع أصدقائك</p>
                    </div>
                <?php else: ?>
                    <?php foreach ($conversations as $conv): ?>
                        <div class="conversation-item" onclick="window.location.href='/messages/<?= $conv['conversation']->id ?>'">
                            <img src="<?= $conv['other_user']->avatar ?? '/images/default-avatar.png' ?>" 
                                 alt="<?= $this->e($conv['other_user']->fullname) ?>" 
                                 class="conversation-avatar">
                            <div class="conversation-info">
                                <div class="conversation-name"><?= $this->e($conv['other_user']->fullname) ?></div>
                                <div class="conversation-preview">
                                    <?php if ($conv['last_message']): ?>
                                        <?php if ($conv['last_message']->sender_id == $current_user->id): ?>
                                            أنت: <?= $this->e(substr($conv['last_message']->content, 0, 50)) ?>...
                                        <?php else: ?>
                                            <?= $this->e(substr($conv['last_message']->content, 0, 50)) ?>...
                                        <?php endif; ?>
                                    <?php else: ?>
                                        ابدأ المحادثة
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="conversation-meta">
                                <div class="conversation-time">
                                    <?php if ($conv['last_message']): ?>
                                        <?= date('H:i', strtotime($conv['last_message']->created_at)) ?>
                                    <?php endif; ?>
                                </div>
                                <?php if ($conv['unread_count'] > 0): ?>
                                    <div class="unread-count"><?= $conv['unread_count'] ?></div>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>

        <!-- الشاشة الرئيسية -->
        <div class="col-md-8 col-lg-9 d-none d-md-flex">
            <div class="empty-chat">
                <i class="bi bi-chat-heart"></i>
                <h4>مرحباً بك في الرسائل</h4>
                <p class="text-muted">اختر محادثة من القائمة للبدء</p>
            </div>
        </div>
    </div>
</div>

<!-- Modal لبدء محادثة جديدة -->
<div class="modal fade" id="newConversationModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">محادثة جديدة</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <input type="text" class="form-control" placeholder="ابحث عن مستخدم..." id="userSearch">
                </div>
                <div id="userResults">
                    <!-- نتائج البحث ستظهر هنا -->
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.getElementById('userSearch').addEventListener('input', function(e) {
    const query = e.target.value.trim();
    if (query.length < 2) {
        document.getElementById('userResults').innerHTML = '';
        return;
    }
    
    // البحث عن المستخدمين
    fetch(`/api/users/search?q=${encodeURIComponent(query)}`)
        .then(response => response.json())
        .then(data => {
            let html = '';
            data.users.forEach(user => {
                html += `
                    <div class="d-flex align-items-center p-2 border-bottom user-result" 
                         style="cursor: pointer;" 
                         onclick="startConversation(${user.id})">
                        <img src="${user.avatar || '/images/default-avatar.png'}" 
                             class="rounded-circle me-3" width="40" height="40">
                        <div>
                            <div class="fw-bold">${user.fullname}</div>
                            <div class="text-muted small">@${user.username}</div>
                        </div>
                    </div>
                `;
            });
            document.getElementById('userResults').innerHTML = html;
        })
        .catch(error => console.error('Error:', error));
});

function startConversation(userId) {
    const form = document.createElement('form');
    form.method = 'POST';
    form.action = '/messages/start';
    
    const input = document.createElement('input');
    input.type = 'hidden';
    input.name = 'user_id';
    input.value = userId;
    
    form.appendChild(input);
    document.body.appendChild(form);
    form.submit();
}
</script>
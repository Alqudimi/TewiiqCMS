<?php $this->layout('layouts/app', ['title' => $title]) ?>

<style>
.chat-container {
    height: calc(100vh - 76px);
    display: flex;
    flex-direction: column;
}

.chat-header {
    padding: 1rem;
    border-bottom: 1px solid var(--border);
    background-color: var(--card);
    display: flex;
    align-items: center;
}

.chat-user-info {
    display: flex;
    align-items: center;
    flex: 1;
}

.chat-avatar {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    margin-left: 0.75rem;
}

.messages-container {
    flex: 1;
    overflow-y: auto;
    padding: 1rem;
    background-color: var(--background);
}

.message {
    max-width: 70%;
    margin-bottom: 1rem;
    animation: fadeIn 0.3s ease;
}

.message-sent {
    margin-right: auto;
}

.message-received {
    margin-left: auto;
}

.message-bubble {
    padding: 0.75rem 1rem;
    border-radius: var(--border-radius);
    position: relative;
}

.message-sent .message-bubble {
    background-color: var(--primary);
    color: white;
    border-bottom-right-radius: 4px;
}

.message-received .message-bubble {
    background-color: var(--card);
    color: var(--text);
    border-bottom-left-radius: 4px;
    border: 1px solid var(--border);
}

.message-time {
    font-size: 0.7rem;
    opacity: 0.7;
    margin-top: 0.25rem;
    text-align: left;
}

.message-input-container {
    padding: 1rem;
    background-color: var(--card);
    border-top: 1px solid var(--border);
}

.message-input-wrapper {
    display: flex;
    align-items: center;
}

.message-input {
    flex: 1;
    border-radius: var(--border-radius);
    padding: 0.75rem 1rem;
    resize: none;
    min-height: 50px;
    max-height: 120px;
}

.send-btn {
    background-color: var(--primary);
    color: white;
    border: none;
    border-radius: 50%;
    width: 40px;
    height: 40px;
    margin-right: 0.5rem;
    display: flex;
    align-items: center;
    justify-content: center;
}

.send-btn:hover {
    opacity: 0.9;
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(10px); }
    to { opacity: 1; transform: translateY(0); }
}

@media (max-width: 768px) {
    .message {
        max-width: 85%;
    }
}
</style>

<div class="chat-container">
    <!-- رأس المحادثة -->
    <div class="chat-header">
        <a href="/messages" class="btn btn-outline-secondary btn-sm me-3 d-md-none">
            <i class="bi bi-arrow-right"></i>
        </a>
        <div class="chat-user-info">
            <img src="<?= $other_user->avatar ?? '/images/default-avatar.png' ?>" 
                 alt="<?= $this->e($other_user->fullname) ?>" 
                 class="chat-avatar">
            <div>
                <div class="fw-bold"><?= $this->e($other_user->fullname) ?></div>
                <div class="text-muted small">@<?= $this->e($other_user->username) ?></div>
            </div>
        </div>
        <div class="dropdown">
            <button class="btn btn-outline-secondary btn-sm" data-bs-toggle="dropdown">
                <i class="bi bi-three-dots"></i>
            </button>
            <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="/profile/<?= $other_user->username ?>">عرض الملف الشخصي</a></li>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item text-danger" href="#">حذف المحادثة</a></li>
            </ul>
        </div>
    </div>

    <!-- منطقة الرسائل -->
    <div class="messages-container" id="messagesContainer">
        <?php if (empty($messages)): ?>
            <div class="text-center text-muted">
                <i class="bi bi-chat-dots" style="font-size: 3rem;"></i>
                <p class="mt-2">لا توجد رسائل بعد</p>
                <p class="small">ابدأ المحادثة بإرسال رسالة</p>
            </div>
        <?php else: ?>
            <?php foreach ($messages as $msg): ?>
                <div class="message <?= $msg['message']->sender_id == $current_user->id ? 'message-sent' : 'message-received' ?>">
                    <div class="message-bubble">
                        <?= nl2br($this->e($msg['message']->content)) ?>
                        <div class="message-time">
                            <?= date('H:i', strtotime($msg['message']->created_at)) ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

    <!-- منطقة إدخال الرسائل -->
    <div class="message-input-container">
        <form method="POST" action="/messages/send" id="messageForm" class="message-input-wrapper">
            <input type="hidden" name="conversation_id" value="<?= $conversation->id ?>">
            <input type="hidden" name="ajax" value="1">
            <textarea 
                name="content" 
                class="form-control message-input" 
                placeholder="اكتب رسالة..." 
                required
                id="messageInput"></textarea>
            <button type="submit" class="send-btn">
                <i class="bi bi-send"></i>
            </button>
        </form>
    </div>
</div>

<script>
const messageForm = document.getElementById('messageForm');
const messageInput = document.getElementById('messageInput');
const messagesContainer = document.getElementById('messagesContainer');

// Auto-resize textarea
messageInput.addEventListener('input', function() {
    this.style.height = 'auto';
    this.style.height = this.scrollHeight + 'px';
});

// Handle form submission
messageForm.addEventListener('submit', function(e) {
    e.preventDefault();
    
    const content = messageInput.value.trim();
    if (!content) return;
    
    const formData = new FormData(this);
    
    fetch('/messages/send', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Add message to UI
            const messageDiv = document.createElement('div');
            messageDiv.className = 'message message-sent';
            messageDiv.innerHTML = `
                <div class="message-bubble">
                    ${content.replace(/\n/g, '<br>')}
                    <div class="message-time">${new Date().toLocaleTimeString('ar-SA', {hour: '2-digit', minute: '2-digit'})}</div>
                </div>
            `;
            messagesContainer.appendChild(messageDiv);
            messagesContainer.scrollTop = messagesContainer.scrollHeight;
            
            // Clear input
            messageInput.value = '';
            messageInput.style.height = 'auto';
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('حدث خطأ أثناء إرسال الرسالة');
    });
});

// Enter key to send message
messageInput.addEventListener('keypress', function(e) {
    if (e.key === 'Enter' && !e.shiftKey) {
        e.preventDefault();
        messageForm.dispatchEvent(new Event('submit'));
    }
});

// Auto-scroll to bottom
messagesContainer.scrollTop = messagesContainer.scrollHeight;
</script>
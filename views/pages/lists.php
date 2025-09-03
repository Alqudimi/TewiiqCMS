<?php $this->layout('layouts/app', ['title' => $title]) ?>

<style>
    /* تصميم عام للصفحة */
    .lists-container {
        background-color: var(--background);
        min-height: 100vh;
        padding-top: 0;
    }

    /* تصميم الهيدر */
    .page-header {
        background: linear-gradient(135deg, var(--primary), var(--accent));
        color: white;
        padding: 2rem 0;
        margin-bottom: 2rem;
        border-radius: 0 0 var(--border-radius) var(--border-radius);
    }

    .page-title {
        font-size: 2.5rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
        display: flex;
        align-items: center;
    }

    .page-title i {
        margin-left: 1rem;
    }

    .page-subtitle {
        font-size: 1.125rem;
        opacity: 0.9;
    }

    /* تصميم التبويبات */
    .nav-tabs {
        border-bottom: 2px solid var(--border);
        margin-bottom: 2rem;
    }

    .nav-tabs .nav-link {
        color: var(--text);
        border: none;
        padding: 1rem 2rem;
        font-weight: 600;
        border-radius: var(--border-radius) var(--border-radius) 0 0;
        transition: var(--transition);
    }

    .nav-tabs .nav-link:hover {
        color: var(--primary);
        background-color: var(--input);
    }

    .nav-tabs .nav-link.active {
        color: var(--primary);
        background-color: var(--card);
        border-bottom: 3px solid var(--primary);
    }

    /* تصميم بطاقات القوائم */
    .list-card {
        background-color: var(--card);
        border: none;
        border-radius: var(--border-radius);
        box-shadow: var(--box-shadow);
        transition: var(--transition);
        overflow: hidden;
        cursor: pointer;
        height: 100%;
        display: flex;
        flex-direction: column;
    }

    .list-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 16px 42px rgba(0, 0, 0, 0.2);
    }

    .list-cover {
        height: 150px;
        background: linear-gradient(135deg, var(--primary), var(--secondary), var(--accent));
        position: relative;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 2rem;
    }

    .list-cover img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .list-cover-overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0, 0, 0, 0.3);
        display: flex;
        align-items: center;
        justify-content: center;
        opacity: 0;
        transition: var(--transition);
    }

    .list-card:hover .list-cover-overlay {
        opacity: 1;
    }

    .list-info {
        padding: 1.5rem;
        flex-grow: 1;
        display: flex;
        flex-direction: column;
    }

    .list-title {
        font-size: 1.25rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
        color: var(--text);
    }

    .list-description {
        color: var(--text);
        opacity: 0.8;
        margin-bottom: 1rem;
        flex-grow: 1;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .list-stats {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1rem;
        padding-top: 1rem;
        border-top: 1px solid var(--border);
    }

    .list-stat {
        display: flex;
        align-items: center;
        color: var(--secondary);
        font-size: 0.875rem;
    }

    .list-stat i {
        margin-left: 0.5rem;
    }

    .list-owner {
        display: flex;
        align-items: center;
        margin-bottom: 1rem;
    }

    .owner-avatar {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        object-fit: cover;
        margin-left: 0.75rem;
    }

    .owner-name {
        font-weight: 600;
        color: var(--text);
    }

    .list-actions {
        display: flex;
        gap: 0.5rem;
        margin-top: auto;
    }

    .btn-join {
        background-color: var(--primary);
        color: white;
        border: none;
        padding: 0.5rem 1rem;
        border-radius: var(--border-radius);
        font-weight: 600;
        transition: var(--transition);
        flex: 1;
    }

    .btn-join:hover {
        background-color: var(--secondary);
        transform: translateY(-2px);
    }

    .btn-joined {
        background-color: var(--accent);
        color: var(--text);
    }

    .btn-secondary {
        background-color: var(--input);
        color: var(--text);
        border: none;
        padding: 0.5rem;
        border-radius: var(--border-radius);
        transition: var(--transition);
    }

    .btn-secondary:hover {
        background-color: var(--border);
    }

    /* زر إنشاء قائمة جديدة */
    .create-list-btn {
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

    .create-list-btn:hover {
        transform: scale(1.1);
        box-shadow: 0 16px 32px rgba(0, 0, 0, 0.3);
    }

    /* تصميم المودال */
    .modal-content {
        background-color: var(--card);
        border: none;
        border-radius: var(--border-radius);
        box-shadow: var(--box-shadow);
    }

    .modal-header {
        border-bottom: 1px solid var(--border);
        padding: 1.5rem;
    }

    .modal-title {
        color: var(--primary);
        font-weight: 700;
    }

    .modal-body {
        padding: 1.5rem;
    }

    .modal-footer {
        border-top: 1px solid var(--border);
        padding: 1rem 1.5rem;
    }

    /* تصميم حالة فارغة */
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

    /* استجابة للهواتف المحمولة */
    @media (max-width: 768px) {
        .page-title {
            font-size: 2rem;
        }
        
        .nav-tabs .nav-link {
            padding: 0.75rem 1rem;
            font-size: 0.9rem;
        }
        
        .create-list-btn {
            bottom: 1rem;
            left: 1rem;
            width: 50px;
            height: 50px;
            font-size: 1.25rem;
        }
        
        .list-info {
            padding: 1rem;
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
            <a class="nav-link active" href="/lists">القوائم</a>
            <a class="nav-link" href="/events">الفعاليات</a>
            <a class="nav-link" href="/settings">الإعدادات</a>
            <a class="nav-link" href="/profile/<?=$_SESSION['username'] ?? ''?>">الملف الشخصي</a>
            <a class="nav-link" href="/logout">تسجيل الخروج</a>
        </div>
    </div>
</nav>

<!-- هيدر الصفحة -->
<div class="page-header">
    <div class="container">
        <h1 class="page-title">
            <i class="bi bi-collection"></i>
            القوائم والمجموعات
        </h1>
        <p class="page-subtitle">
            اكتشف وانضم إلى المجموعات التي تهمك، أو أنشئ قائمتك الخاصة
        </p>
    </div>
</div>

<div class="container lists-container">
    <!-- التبويبات -->
    <ul class="nav nav-tabs" id="listsTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <a class="nav-link active" id="my-lists-tab" data-bs-toggle="tab" 
               href="#my-lists" role="tab">
                <i class="bi bi-person-fill"></i>
                قوائمي (<?=count($myLists)?>)
            </a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link" id="public-lists-tab" data-bs-toggle="tab" 
               href="#public-lists" role="tab">
                <i class="bi bi-globe"></i>
                القوائم العامة
            </a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link" id="joined-lists-tab" data-bs-toggle="tab" 
               href="#joined-lists" role="tab">
                <i class="bi bi-check-circle"></i>
                القوائم المنضمة إليها
            </a>
        </li>
    </ul>

    <!-- محتوى التبويبات -->
    <div class="tab-content" id="listsTabContent">
        <!-- قوائمي -->
        <div class="tab-pane fade show active" id="my-lists" role="tabpanel">
            <?php if (empty($myLists)): ?>
                <div class="empty-state">
                    <i class="bi bi-collection"></i>
                    <h3>لم تنشئ أي قوائم بعد</h3>
                    <p>أنشئ قائمتك الأولى لتجميع المستخدمين المهتمين بنفس الموضوع</p>
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createListModal">
                        <i class="bi bi-plus-lg"></i>
                        إنشاء قائمة جديدة
                    </button>
                </div>
            <?php else: ?>
                <div class="row">
                    <?php foreach ($myLists as $list): ?>
                        <div class="col-md-6 col-lg-4 mb-4">
                            <div class="card list-card" onclick="goToList(<?=$list->id?>)">
                                <div class="list-cover">
                                    <?php if ($list->cover_image): ?>
                                        <img src="<?=$this->e($list->cover_image)?>" alt="غلاف القائمة">
                                    <?php else: ?>
                                        <i class="bi bi-collection"></i>
                                    <?php endif; ?>
                                    <div class="list-cover-overlay">
                                        <i class="bi bi-arrow-right-circle" style="font-size: 2rem;"></i>
                                    </div>
                                </div>
                                
                                <div class="list-info">
                                    <h3 class="list-title"><?=$this->e($list->name)?></h3>
                                    
                                    <?php if ($list->description): ?>
                                        <p class="list-description"><?=$this->e($list->description)?></p>
                                    <?php endif; ?>
                                    
                                    <div class="list-stats">
                                        <div class="list-stat">
                                            <i class="bi bi-people"></i>
                                            <?=$list->members_count?> عضو
                                        </div>
                                        <div class="list-stat">
                                            <i class="bi bi-<?=$list->is_private ? 'lock' : 'globe'?>"></i>
                                            <?=$list->is_private ? 'خاصة' : 'عامة'?>
                                        </div>
                                    </div>
                                    
                                    <div class="list-actions" onclick="event.stopPropagation()">
                                        <button class="btn btn-secondary" onclick="editList(<?=$list->id?>)">
                                            <i class="bi bi-pencil"></i>
                                        </button>
                                        <button class="btn btn-secondary" onclick="deleteList(<?=$list->id?>)">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>

        <!-- القوائم العامة -->
        <div class="tab-pane fade" id="public-lists" role="tabpanel">
            <?php if (empty($publicLists)): ?>
                <div class="empty-state">
                    <i class="bi bi-globe"></i>
                    <h3>لا توجد قوائم عامة حالياً</h3>
                    <p>كن أول من ينشئ قائمة عامة ليراها الجميع</p>
                </div>
            <?php else: ?>
                <div class="row">
                    <?php foreach ($publicLists as $list): ?>
                        <div class="col-md-6 col-lg-4 mb-4">
                            <div class="card list-card" onclick="goToList(<?=$list['id']?>)">
                                <div class="list-cover">
                                    <?php if ($list['cover_image']): ?>
                                        <img src="<?=$this->e($list['cover_image'])?>" alt="غلاف القائمة">
                                    <?php else: ?>
                                        <i class="bi bi-collection"></i>
                                    <?php endif; ?>
                                    <div class="list-cover-overlay">
                                        <i class="bi bi-arrow-right-circle" style="font-size: 2rem;"></i>
                                    </div>
                                </div>
                                
                                <div class="list-info">
                                    <div class="list-owner">
                                        <img src="<?=$list['avatar'] ? '/uploads/avatars/' . $list['avatar'] : 'https://via.placeholder.com/32'?>" 
                                             alt="صورة المالك" class="owner-avatar">
                                        <span class="owner-name"><?=$this->e($list['fullname'])?></span>
                                    </div>
                                    
                                    <h3 class="list-title"><?=$this->e($list['name'])?></h3>
                                    
                                    <?php if ($list['description']): ?>
                                        <p class="list-description"><?=$this->e($list['description'])?></p>
                                    <?php endif; ?>
                                    
                                    <div class="list-stats">
                                        <div class="list-stat">
                                            <i class="bi bi-people"></i>
                                            <?=$list['members_count']?> عضو
                                        </div>
                                        <div class="list-stat">
                                            <i class="bi bi-calendar3"></i>
                                            <?=date('M Y', strtotime($list['created_at']))?>
                                        </div>
                                    </div>
                                    
                                    <div class="list-actions" onclick="event.stopPropagation()">
                                        <button class="btn btn-join" onclick="joinList(<?=$list['id']?>)">
                                            <i class="bi bi-plus-lg"></i>
                                            انضمام
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>

        <!-- القوائم المنضمة إليها -->
        <div class="tab-pane fade" id="joined-lists" role="tabpanel">
            <div class="empty-state">
                <i class="bi bi-check-circle"></i>
                <h3>لم تنضم لأي قائمة بعد</h3>
                <p>تصفح القوائم العامة وانضم لما يهمك</p>
                <button class="btn btn-primary" onclick="document.getElementById('public-lists-tab').click()">
                    <i class="bi bi-search"></i>
                    تصفح القوائم العامة
                </button>
            </div>
        </div>
    </div>
</div>

<!-- زر إنشاء قائمة جديدة -->
<button class="create-list-btn" data-bs-toggle="modal" data-bs-target="#createListModal">
    <i class="bi bi-plus-lg"></i>
</button>

<!-- مودال إنشاء قائمة جديدة -->
<div class="modal fade" id="createListModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="bi bi-plus-circle"></i>
                    إنشاء قائمة جديدة
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" action="/lists/create">
                <div class="modal-body">
                    <div class="form-group mb-3">
                        <label class="form-label">اسم القائمة *</label>
                        <input type="text" name="name" class="form-control" required 
                               placeholder="أدخل اسم القائمة">
                    </div>
                    
                    <div class="form-group mb-3">
                        <label class="form-label">الوصف</label>
                        <textarea name="description" class="form-control" rows="3" 
                                  placeholder="وصف موجز عن القائمة وهدفها"></textarea>
                    </div>
                    
                    <div class="form-check">
                        <input type="checkbox" name="is_private" class="form-check-input" id="privateList">
                        <label class="form-check-label" for="privateList">
                            <i class="bi bi-lock"></i>
                            قائمة خاصة
                        </label>
                        <div class="form-text">القوائم الخاصة لا تظهر للآخرين</div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check2"></i>
                        إنشاء القائمة
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
// الانتقال إلى صفحة القائمة
function goToList(listId) {
    window.location.href = '/lists/' + listId;
}

// الانضمام للقائمة
function joinList(listId) {
    fetch('/lists/' + listId + '/join', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        } else {
            alert(data.message);
        }
    })
    .catch(error => {
        console.error('خطأ:', error);
        alert('حدث خطأ أثناء الانضمام للقائمة');
    });
}

// تحرير القائمة
function editList(listId) {
    // يمكن إضافة مودال تحرير هنا
    window.location.href = '/lists/' + listId + '/edit';
}

// حذف القائمة
function deleteList(listId) {
    if (confirm('هل أنت متأكد من حذف هذه القائمة؟')) {
        fetch('/lists/' + listId + '/delete', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert(data.message);
            }
        })
        .catch(error => {
            console.error('خطأ:', error);
            alert('حدث خطأ أثناء حذف القائمة');
        });
    }
}
</script>
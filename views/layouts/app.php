<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?=$this->e($title ?? 'Tewiiq - تويق')?></title>
    
    <!-- Bootstrap 5.3 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    
    <!-- Google Fonts - Arabic Font -->
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@300;400;500;700;800&display=swap" rel="stylesheet">
    
    <style>
        :root {
            /* Light Mode Variables */
            --primary-light: #7c4dff;
            --secondary-light: #ff6e6c;
            --accent-light: #2ce0c8;
            --background-light: #f8f9fa;
            --text-light: #2d3748;
            --card-light: #ffffff;
            --input-light: #f1f3f4;
            --border-light: #e2e8f0;
            
            /* Dark Mode Variables */
            --primary-dark: #9370ff;
            --secondary-dark: #ff8c8a;
            --accent-dark: #3af0da;
            --background-dark: #1a202c;
            --text-dark: #e2e8f0;
            --card-dark: #2d3748;
            --input-dark: #4a5568;
            --border-dark: #4a5568;
            
            --border-radius: 16px;
            --transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            --box-shadow: 0 12px 36px rgba(0, 0, 0, 0.15);
            
            /* Initial values - light mode by default */
            --primary: var(--primary-light);
            --secondary: var(--secondary-light);
            --accent: var(--accent-light);
            --background: var(--background-light);
            --text: var(--text-light);
            --card: var(--card-light);
            --input: var(--input-light);
            --border: var(--border-light);
        }

        .dark-mode {
            --primary: var(--primary-dark);
            --secondary: var(--secondary-dark);
            --accent: var(--accent-dark);
            --background: var(--background-dark);
            --text: var(--text-dark);
            --card: var(--card-dark);
            --input: var(--input-dark);
            --border: var(--border-dark);
        }

        body {
            font-family: 'Tajawal', sans-serif;
            background-color: var(--background);
            color: var(--text);
            transition: var(--transition);
            min-height: 100vh;
            line-height: 1.6;
            padding-top: 76px;
        }

        .navbar {
            background-color: var(--card);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            padding: 0.5rem 1rem;
            transition: var(--transition);
            border-bottom: 1px solid var(--border);
        }

        .navbar-brand {
            font-weight: 800;
            color: var(--primary);
            font-size: 1.75rem;
            display: flex;
            align-items: center;
        }

        .nav-link {
            color: var(--text);
            font-weight: 600;
            padding: 0.5rem 1rem;
            border-radius: var(--border-radius);
            transition: var(--transition);
        }

        .nav-link:hover, .nav-link.active {
            background-color: var(--input);
            color: var(--primary);
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            border: none;
            border-radius: var(--border-radius);
            padding: 0.6rem 1.5rem;
            font-weight: 700;
            transition: var(--transition);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(124, 77, 255, 0.4);
        }

        .form-control {
            background-color: var(--input);
            border: 2px solid var(--border);
            border-radius: var(--border-radius);
            color: var(--text);
            transition: var(--transition);
        }

        .form-control:focus {
            box-shadow: 0 0 0 3px rgba(124, 77, 255, 0.2);
            border-color: var(--primary);
            background-color: var(--card);
        }

        .card {
            background-color: var(--card);
            border: 1px solid var(--border);
            border-radius: var(--border-radius);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            transition: var(--transition);
        }

        .alert {
            border-radius: var(--border-radius);
            border: none;
        }

        .alert-success {
            background-color: rgba(44, 224, 200, 0.1);
            color: var(--accent);
        }

        .alert-danger {
            background-color: rgba(255, 110, 108, 0.1);
            color: var(--secondary);
        }
        
        /* Navbar styles */
        .navbar {
            background-color: var(--card);
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            padding: 0.75rem 1rem;
            transition: var(--transition);
            border-bottom: 1px solid var(--border);
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1030;
        }

        .navbar-brand {
            font-weight: 800;
            color: var(--primary);
            font-size: 1.75rem;
            display: flex;
            align-items: center;
            text-decoration: none;
        }

        .navbar-brand:hover {
            color: var(--primary);
        }

        .nav-link {
            color: var(--text);
            font-weight: 600;
            padding: 0.5rem 1rem;
            border-radius: var(--border-radius);
            transition: var(--transition);
            position: relative;
            text-decoration: none;
        }

        .nav-link:hover, .nav-link.active {
            background-color: var(--input);
            color: var(--primary);
        }

        .nav-link i {
            margin-left: 0.5rem;
            font-size: 1.1rem;
        }

        .user-dropdown .dropdown-toggle::after {
            display: none;
        }

        .user-avatar {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid var(--primary);
        }

        .dropdown-menu {
            background-color: var(--card);
            border: 1px solid var(--border);
            border-radius: var(--border-radius);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            padding: 0.5rem;
            transition: var(--transition);
        }

        .dropdown-item {
            color: var(--text);
            border-radius: var(--border-radius);
            padding: 0.75rem 1rem;
            transition: var(--transition);
            display: flex;
            align-items: center;
            text-decoration: none;
        }

        .dropdown-item:hover {
            background-color: var(--input);
            color: var(--primary);
        }

        .dropdown-item i {
            margin-left: 0.75rem;
            width: 20px;
            text-align: center;
        }

        .dropdown-divider {
            border-color: var(--border);
            margin: 0.5rem 0;
        }

        .message-badge {
            position: absolute;
            top: -5px;
            left: -5px;
            background-color: var(--secondary);
            color: white;
            border-radius: 50%;
            width: 18px;
            height: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.7rem;
            font-weight: 700;
        }
        
        .mobile-bottom-nav {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            background-color: var(--card);
            border-top: 1px solid var(--border);
            padding: 0.5rem;
            display: none;
            z-index: 1030;
        }

        @media (max-width: 992px) {
            .mobile-bottom-nav {
                display: flex;
                justify-content: space-around;
            }
        }
    </style>
    <?php if (isset($customCSS)): ?>
        <style><?=$customCSS?></style>
    <?php endif; ?>
</head>
<body>
    <!-- Navigation Bar -->
    <nav class="navbar navbar-expand-lg">
        <div class="container-fluid">
            <a class="navbar-brand" href="/">
                <i class="bi bi-twitter"></i>
                Tewiiq
            </a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="/">
                            <i class="bi bi-house-door"></i>
                            الرئيسية
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/search">
                            <i class="bi bi-search"></i>
                            البحث
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/reels">
                            <i class="bi bi-camera-reels"></i>
                            الريلز
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link position-relative" href="/messages">
                            <i class="bi bi-envelope"></i>
                            الرسائل
                            <?php if (isset($_SESSION['user_id'])): ?>
                                <?php
                                require_once __DIR__ . '/../../models/Message.php';
                                $unreadCount = Message::getUnreadCount($_SESSION['user_id']);
                                if ($unreadCount > 0):
                                ?>
                                    <span class="message-badge"><?= $unreadCount > 9 ? '9+' : $unreadCount ?></span>
                                <?php endif; ?>
                            <?php endif; ?>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/events">
                            <i class="bi bi-calendar-event"></i>
                            الفعاليات
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/lists">
                            <i class="bi bi-list-ul"></i>
                            القوائم
                        </a>
                    </li>
                </ul>
                
                <?php if (isset($_SESSION['user_id'])): ?>
                    <div class="dropdown user-dropdown">
                        <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" role="button" data-bs-toggle="dropdown">
                            <?php
                            require_once __DIR__ . '/../../models/User.php';
                            $currentUser = User::findById($_SESSION['user_id']);
                            ?>
                            <img src="<?= $currentUser->avatar ?? '/images/default-avatar.png' ?>" 
                                 alt="<?= $currentUser->fullname ?>" 
                                 class="user-avatar me-2">
                            <span class="d-none d-lg-inline"><?= $currentUser->fullname ?></span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="/profile/<?= $currentUser->username ?>">
                                <i class="bi bi-person"></i>
                                الملف الشخصي
                            </a></li>
                            <li><a class="dropdown-item" href="/<?= $currentUser->username ?>/followers">
                                <i class="bi bi-people"></i>
                                المتابعون
                            </a></li>
                            <li><a class="dropdown-item" href="/suggestions">
                                <i class="bi bi-person-plus"></i>
                                اقتراحات المتابعة
                            </a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="/settings">
                                <i class="bi bi-gear"></i>
                                الإعدادات
                            </a></li>
                            <li><a class="dropdown-item" href="/logout">
                                <i class="bi bi-box-arrow-right"></i>
                                تسجيل الخروج
                            </a></li>
                        </ul>
                    </div>
                <?php else: ?>
                    <div class="d-flex">
                        <a href="/login" class="btn btn-outline-primary me-2">تسجيل الدخول</a>
                        <a href="/register" class="btn btn-primary">إنشاء حساب</a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </nav>

    <!-- Mobile Bottom Navigation -->
    <div class="mobile-bottom-nav d-lg-none">
        <a href="/" class="nav-link text-center">
            <i class="bi bi-house-door d-block"></i>
            <small>الرئيسية</small>
        </a>
        <a href="/search" class="nav-link text-center">
            <i class="bi bi-search d-block"></i>
            <small>البحث</small>
        </a>
        <a href="/reels" class="nav-link text-center">
            <i class="bi bi-camera-reels d-block"></i>
            <small>الريلز</small>
        </a>
        <a href="/messages" class="nav-link text-center position-relative">
            <i class="bi bi-envelope d-block"></i>
            <small>الرسائل</small>
            <?php if (isset($_SESSION['user_id']) && $unreadCount > 0): ?>
                <span class="message-badge"><?= $unreadCount > 9 ? '9+' : $unreadCount ?></span>
            <?php endif; ?>
        </a>
        <a href="/events" class="nav-link text-center">
            <i class="bi bi-calendar-event d-block"></i>
            <small>الفعاليات</small>
        </a>
    </div>

    <?=$this->section('content')?>
    
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    
    <?php if (isset($customJS)): ?>
        <script><?=$customJS?></script>
    <?php endif; ?>
</body>
</html>
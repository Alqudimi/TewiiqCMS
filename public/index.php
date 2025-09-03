<?php

session_start();

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../controllers/AuthController.php';
require_once __DIR__ . '/../controllers/HomeController.php';
require_once __DIR__ . '/../controllers/ProfileController.php';
require_once __DIR__ . '/../controllers/TweetDetailController.php';
require_once __DIR__ . '/../controllers/SearchController.php';
require_once __DIR__ . '/../controllers/SettingsController.php';
require_once __DIR__ . '/../controllers/ListController.php';
require_once __DIR__ . '/../controllers/EventController.php';
require_once __DIR__ . '/../controllers/ChatController.php';
require_once __DIR__ . '/../controllers/FollowingController.php';
require_once __DIR__ . '/../controllers/ReelController.php';
require_once __DIR__ . '/../controllers/AboutController.php';
require_once __DIR__ . '/../controllers/HelpController.php';
require_once __DIR__ . '/../database/Database.php';

use RedBeanPHP\R;
use League\Plates\Engine;

// Set cache control headers
header('Cache-Control: no-cache, no-store, must-revalidate');
header('Pragma: no-cache');
header('Expires: 0');

// Get the request URI and method
$requestUri = $_SERVER['REQUEST_URI'];
$requestMethod = $_SERVER['REQUEST_METHOD'];

// Remove query string from URI
$path = parse_url($requestUri, PHP_URL_PATH);

// Simple router
try {
    switch (true) {
        // Authentication routes
        case $path === '/login' && $requestMethod === 'GET':
            $controller = new AuthController();
            $controller->showLogin();
            break;
            
        case $path === '/login' && $requestMethod === 'POST':
            $controller = new AuthController();
            $controller->login();
            break;
            
        case $path === '/register' && $requestMethod === 'GET':
            $controller = new AuthController();
            $controller->showRegister();
            break;
            
        case $path === '/register' && $requestMethod === 'POST':
            $controller = new AuthController();
            $controller->register();
            break;
            
        case $path === '/logout':
            $controller = new AuthController();
            $controller->logout();
            break;
            
        // Home routes
        case $path === '/' || $path === '/home':
            $controller = new HomeController();
            $controller->index();
            break;
            
        case $path === '/tweet' && $requestMethod === 'POST':
            $controller = new HomeController();
            $controller->createTweet();
            break;
            
        case $path === '/like' && $requestMethod === 'POST':
            $controller = new HomeController();
            $controller->likeTweet();
            break;
            
        // Profile routes
        case preg_match('/^\/profile\/([a-zA-Z0-9_]+)$/', $path, $matches):
            $controller = new ProfileController();
            $controller->show($matches[1]);
            break;
            
        case $path === '/follow' && $requestMethod === 'POST':
            $controller = new ProfileController();
            $controller->follow();
            break;
            
        case $path === '/unfollow' && $requestMethod === 'POST':
            $controller = new ProfileController();
            $controller->unfollow();
            break;

        // Tweet Detail routes
        case preg_match('/^\/tweet\/(\d+)$/', $path, $matches):
            $controller = new TweetDetailController();
            $controller->show($matches[1]);
            break;
            
        case preg_match('/^\/tweet\/(\d+)\/reply$/', $path, $matches) && $requestMethod === 'POST':
            $controller = new TweetDetailController();
            $controller->reply();
            break;
            
        case $path === '/reply/like' && $requestMethod === 'POST':
            $controller = new TweetDetailController();
            $controller->likeReply();
            break;

        // Search routes
        case $path === '/search':
            $controller = new SearchController();
            $controller->index();
            break;
            
        case $path === '/search/suggest':
            $controller = new SearchController();
            $controller->suggest();
            break;
            
        case $path === '/search/trends':
            $controller = new SearchController();
            $controller->trends();
            break;

        // Settings routes
        case $path === '/settings':
            $controller = new SettingsController();
            $controller->index();
            break;
            
        case $path === '/settings/profile' && $requestMethod === 'POST':
            $controller = new SettingsController();
            $controller->updateProfile();
            break;
            
        case $path === '/settings/password' && $requestMethod === 'POST':
            $controller = new SettingsController();
            $controller->updatePassword();
            break;
            
        case $path === '/settings/privacy' && $requestMethod === 'POST':
            $controller = new SettingsController();
            $controller->updatePrivacy();
            break;
            
        case $path === '/settings/notifications' && $requestMethod === 'POST':
            $controller = new SettingsController();
            $controller->updateNotifications();
            break;
            
        case $path === '/settings/appearance' && $requestMethod === 'POST':
            $controller = new SettingsController();
            $controller->updateAppearance();
            break;
            
        case $path === '/settings/api':
            $controller = new SettingsController();
            $controller->getSettings();
            break;

        // Lists routes
        case $path === '/lists':
            $controller = new ListController();
            $controller->index();
            break;
            
        case preg_match('/^\/lists\/(\d+)$/', $path, $matches):
            $controller = new ListController();
            $controller->show($matches[1]);
            break;
            
        case $path === '/lists/create' && $requestMethod === 'POST':
            $controller = new ListController();
            $controller->create();
            break;
            
        case preg_match('/^\/lists\/(\d+)\/update$/', $path, $matches) && $requestMethod === 'POST':
            $controller = new ListController();
            $controller->update($matches[1]);
            break;
            
        case preg_match('/^\/lists\/(\d+)\/delete$/', $path, $matches) && $requestMethod === 'POST':
            $controller = new ListController();
            $controller->delete($matches[1]);
            break;
            
        case preg_match('/^\/lists\/(\d+)\/join$/', $path, $matches) && $requestMethod === 'POST':
            $controller = new ListController();
            $controller->join($matches[1]);
            break;
            
        case preg_match('/^\/lists\/(\d+)\/leave$/', $path, $matches) && $requestMethod === 'POST':
            $controller = new ListController();
            $controller->leave($matches[1]);
            break;
            
        case preg_match('/^\/lists\/(\d+)\/members\/add$/', $path, $matches) && $requestMethod === 'POST':
            $controller = new ListController();
            $controller->addMember($matches[1]);
            break;
            
        case preg_match('/^\/lists\/(\d+)\/members\/(\d+)\/remove$/', $path, $matches) && $requestMethod === 'POST':
            $controller = new ListController();
            $controller->removeMember($matches[1], $matches[2]);
            break;

        // Events routes
        case $path === '/events':
            $controller = new EventController();
            $controller->index();
            break;
            
        case preg_match('/^\/events\/(\d+)$/', $path, $matches):
            $controller = new EventController();
            $controller->show($matches[1]);
            break;
            
        case $path === '/events/create' && $requestMethod === 'POST':
            $controller = new EventController();
            $controller->create();
            break;
            
        case preg_match('/^\/events\/(\d+)\/join$/', $path, $matches) && $requestMethod === 'POST':
            $controller = new EventController();
            $controller->join($matches[1]);
            break;
            
        case preg_match('/^\/events\/(\d+)\/leave$/', $path, $matches) && $requestMethod === 'POST':
            $controller = new EventController();
            $controller->leave($matches[1]);
            break;
            
        case preg_match('/^\/events\/(\d+)\/live$/', $path, $matches) && $requestMethod === 'POST':
            $controller = new EventController();
            $controller->updateLiveStatus($matches[1]);
            break;
            
        case $path === '/events/live':
            $controller = new EventController();
            $controller->getLiveEvents();
            break;
            
        case $path === '/events/search':
            $controller = new EventController();
            $controller->search();
            break;
            
        // Messages routes
        case $path === '/messages':
            $controller = new ChatController();
            $controller->index();
            break;
            
        case preg_match('/^\/messages\/(\d+)$/', $path, $matches):
            $controller = new ChatController();
            $controller->show($matches[1]);
            break;
            
        case $path === '/messages/send' && $requestMethod === 'POST':
            $controller = new ChatController();
            $controller->sendMessage();
            break;
            
        case $path === '/messages/start' && $requestMethod === 'POST':
            $controller = new ChatController();
            $controller->startConversation();
            break;
            
        case $path === '/messages/api' && $requestMethod === 'GET':
            $controller = new ChatController();
            $controller->getMessages();
            break;
            
        // Following routes
        case preg_match('/^\/([a-zA-Z0-9_]+)\/followers$/', $path, $matches):
            $controller = new FollowingController();
            $controller->followers($matches[1]);
            break;
            
        case preg_match('/^\/([a-zA-Z0-9_]+)\/following$/', $path, $matches):
            $controller = new FollowingController();
            $controller->following($matches[1]);
            break;
            
        case $path === '/suggestions':
            $controller = new FollowingController();
            $controller->suggestions();
            break;
            
        case $path === '/users/search':
            $controller = new FollowingController();
            $controller->search();
            break;
            
        // Reels routes
        case $path === '/reels':
            $controller = new ReelController();
            $controller->index();
            break;
            
        case preg_match('/^\/reels\/(\d+)$/', $path, $matches):
            $controller = new ReelController();
            $controller->show($matches[1]);
            break;
            
        case $path === '/reels/create':
            $controller = new ReelController();
            $controller->create();
            break;
            
        case $path === '/reels/like' && $requestMethod === 'POST':
            $controller = new ReelController();
            $controller->like();
            break;
            
        case $path === '/reels/comment' && $requestMethod === 'POST':
            $controller = new ReelController();
            $controller->comment();
            break;
            
        case $path === '/reels/comments' && $requestMethod === 'GET':
            $controller = new ReelController();
            $controller->getComments();
            break;
            
        // About and Help routes
        case $path === '/about':
            $templates = new Engine(__DIR__ . '/../views');
            $controller = new AboutController($templates);
            $controller->index();
            break;
            
        case $path === '/help':
            $templates = new Engine(__DIR__ . '/../views');
            $controller = new HelpController($templates);
            $controller->index();
            break;
            
        case preg_match('/^\/help\/article\/([a-zA-Z0-9_-]+)$/', $path, $matches):
            $templates = new Engine(__DIR__ . '/../views');
            $controller = new HelpController($templates);
            $controller->article($matches[1]);
            break;
            
        // API routes for user search
        case $path === '/api/users/search' && $requestMethod === 'GET':
            header('Content-Type: application/json');
            $query = $_GET['q'] ?? '';
            if (strlen($query) >= 2) {
                Database::init();
                $users = R::find('users', 'fullname LIKE ? OR username LIKE ? LIMIT 10', ["%$query%", "%$query%"]);
                $result = [];
                foreach ($users as $user) {
                    $result[] = [
                        'id' => $user->id,
                        'fullname' => $user->fullname,
                        'username' => $user->username,
                        'avatar' => $user->avatar
                    ];
                }
                echo json_encode(['users' => $result]);
            } else {
                echo json_encode(['users' => []]);
            }
            break;
            
        // Static files (uploads)
        case preg_match('/^\/uploads\/(.+)$/', $path, $matches):
            $file = __DIR__ . '/uploads/' . $matches[1];
            if (file_exists($file)) {
                $mimeType = mime_content_type($file);
                header('Content-Type: ' . $mimeType);
                readfile($file);
            } else {
                http_response_code(404);
                echo 'File not found';
            }
            break;
            
        // 404 Not Found
        default:
            http_response_code(404);
            echo '<!DOCTYPE html>
            <html lang="ar" dir="rtl">
            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>الصفحة غير موجودة - Tewiiq</title>
                <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
            </head>
            <body>
                <div class="container text-center mt-5">
                    <h1 class="display-1">404</h1>
                    <h2>الصفحة غير موجودة</h2>
                    <p class="lead">الصفحة التي تبحث عنها غير موجودة.</p>
                    <a href="/" class="btn btn-primary">العودة للرئيسية</a>
                </div>
            </body>
            </html>';
            break;
    }
    
} catch (Exception $e) {
    http_response_code(500);
    
    if ($_ENV['APP_DEBUG'] ?? false) {
        echo '<h1>خطأ في الخادم</h1>';
        echo '<pre>' . $e->getMessage() . '</pre>';
        echo '<pre>' . $e->getTraceAsString() . '</pre>';
    } else {
        echo '<!DOCTYPE html>
        <html lang="ar" dir="rtl">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>خطأ في الخادم - Tewiiq</title>
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
        </head>
        <body>
            <div class="container text-center mt-5">
                <h1 class="display-1">500</h1>
                <h2>خطأ في الخادم</h2>
                <p class="lead">حدث خطأ غير متوقع. يرجى المحاولة مرة أخرى لاحقاً.</p>
                <a href="/" class="btn btn-primary">العودة للرئيسية</a>
            </div>
        </body>
        </html>';
    }
}
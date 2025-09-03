<?php

session_start();

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../controllers/AuthController.php';
require_once __DIR__ . '/../controllers/HomeController.php';
require_once __DIR__ . '/../controllers/ProfileController.php';

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
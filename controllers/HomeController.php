<?php

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../models/Tweet.php';

class HomeController 
{
    private $templates;
    
    public function __construct() 
    {
        $this->templates = new League\Plates\Engine(__DIR__ . '/../views');
    }
    
    private function requireAuth() 
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit;
        }
    }
    
    public function index() 
    {
        $this->requireAuth();
        
        $userId = $_SESSION['user_id'];
        $user = User::findById($userId);
        
        // Get recent tweets with user data
        $tweets = Tweet::getWithUserData(20, 0);
        
        // Mark liked tweets
        foreach ($tweets as &$tweet) {
            $tweet['is_liked'] = Tweet::isLikedByUser($tweet['id'], $userId);
        }
        
        echo $this->templates->render('pages/home', [
            'user' => $user,
            'tweets' => $tweets
        ]);
    }
    
    public function createTweet() 
    {
        $this->requireAuth();
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /');
            exit;
        }
        
        $content = trim($_POST['content'] ?? '');
        $userId = $_SESSION['user_id'];
        
        if (empty($content)) {
            $_SESSION['error'] = 'لا يمكن إرسال تغريدة فارغة';
            header('Location: /');
            exit;
        }
        
        if (strlen($content) > 280) {
            $_SESSION['error'] = 'التغريدة لا يمكن أن تتجاوز 280 حرف';
            header('Location: /');
            exit;
        }
        
        $tweetData = [
            'user_id' => $userId,
            'content' => $content
        ];
        
        // Handle image upload if provided
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $imageUrl = $this->handleImageUpload($_FILES['image']);
            if ($imageUrl) {
                $tweetData['image_url'] = $imageUrl;
            }
        }
        
        $tweetId = Tweet::create($tweetData);
        
        if ($tweetId) {
            $_SESSION['success'] = 'تم نشر التغريدة بنجاح';
        } else {
            $_SESSION['error'] = 'حدث خطأ أثناء نشر التغريدة';
        }
        
        header('Location: /');
        exit;
    }
    
    public function likeTweet() 
    {
        $this->requireAuth();
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo json_encode(['error' => 'Method not allowed']);
            exit;
        }
        
        $tweetId = $_POST['tweet_id'] ?? '';
        $userId = $_SESSION['user_id'];
        
        if (empty($tweetId)) {
            http_response_code(400);
            echo json_encode(['error' => 'Tweet ID is required']);
            exit;
        }
        
        $liked = Tweet::like($tweetId, $userId);
        $likesCount = Tweet::getLikesCount($tweetId);
        
        header('Content-Type: application/json');
        echo json_encode([
            'success' => true,
            'liked' => $liked,
            'likes_count' => $likesCount
        ]);
        exit;
    }
    
    private function handleImageUpload($file) 
    {
        $config = require __DIR__ . '/../config/app.php';
        
        if ($file['size'] > $config['max_file_size']) {
            return false;
        }
        
        $extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        if (!in_array($extension, $config['allowed_extensions'])) {
            return false;
        }
        
        $uploadDir = __DIR__ . '/../public/uploads/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }
        
        $filename = uniqid() . '.' . $extension;
        $filepath = $uploadDir . $filename;
        
        if (move_uploaded_file($file['tmp_name'], $filepath)) {
            return '/uploads/' . $filename;
        }
        
        return false;
    }
}
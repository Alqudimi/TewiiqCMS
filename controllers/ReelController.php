<?php

require_once __DIR__ . '/../models/Reel.php';
require_once __DIR__ . '/../models/User.php';

class ReelController 
{
    private $templates;
    
    public function __construct() 
    {
        $this->templates = new League\Plates\Engine(__DIR__ . '/../views');
    }
    
    public function index() 
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit;
        }
        
        $reels = Reel::getAll(20);
        
        // Check if user liked each reel
        foreach ($reels as &$reel) {
            $reel['is_liked'] = Reel::isLiked($reel['reel']->id, $_SESSION['user_id']);
        }
        
        echo $this->templates->render('pages/reels', [
            'title' => 'الريلز - Tewiiq',
            'reels' => $reels,
            'current_user' => User::findById($_SESSION['user_id'])
        ]);
    }
    
    public function show($reelId) 
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit;
        }
        
        $reel = Reel::findById($reelId);
        if (!$reel->id) {
            http_response_code(404);
            echo 'الريل غير موجود';
            return;
        }
        
        $user = User::findById($reel->user_id);
        $comments = Reel::getComments($reelId);
        $isLiked = Reel::isLiked($reelId, $_SESSION['user_id']);
        
        // Add view
        Reel::addView($reelId, $_SESSION['user_id']);
        
        echo $this->templates->render('pages/reel-detail', [
            'title' => $reel->title . ' - Tewiiq',
            'reel' => $reel,
            'user' => $user,
            'comments' => $comments,
            'is_liked' => $isLiked,
            'current_user' => User::findById($_SESSION['user_id'])
        ]);
    }
    
    public function create() 
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit;
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            return $this->handleCreate();
        }
        
        echo $this->templates->render('pages/create-reel', [
            'title' => 'إنشاء ريل جديد - Tewiiq',
            'current_user' => User::findById($_SESSION['user_id'])
        ]);
    }
    
    private function handleCreate() 
    {
        $title = trim($_POST['title'] ?? '');
        $description = trim($_POST['description'] ?? '');
        $hashtags = trim($_POST['hashtags'] ?? '');
        $musicTitle = trim($_POST['music_title'] ?? 'Original Audio');
        $musicArtist = trim($_POST['music_artist'] ?? '');
        
        // Handle video upload
        if (!isset($_FILES['video']) || $_FILES['video']['error'] !== UPLOAD_ERR_OK) {
            $_SESSION['error'] = 'يرجى اختيار ملف فيديو صحيح';
            header('Location: /reels/create');
            exit;
        }
        
        $uploadDir = __DIR__ . '/../public/uploads/reels/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }
        
        $fileExtension = pathinfo($_FILES['video']['name'], PATHINFO_EXTENSION);
        $fileName = uniqid() . '_' . time() . '.' . $fileExtension;
        $filePath = $uploadDir . $fileName;
        
        if (!move_uploaded_file($_FILES['video']['tmp_name'], $filePath)) {
            $_SESSION['error'] = 'حدث خطأ أثناء رفع الفيديو';
            header('Location: /reels/create');
            exit;
        }
        
        // Generate thumbnail (placeholder for now)
        $thumbnailPath = '/uploads/reels/thumbs/' . pathinfo($fileName, PATHINFO_FILENAME) . '.jpg';
        
        $reelId = Reel::create([
            'user_id' => $_SESSION['user_id'],
            'title' => $title,
            'description' => $description,
            'video_url' => '/uploads/reels/' . $fileName,
            'thumbnail_url' => $thumbnailPath,
            'hashtags' => $hashtags,
            'music_title' => $musicTitle,
            'music_artist' => $musicArtist ?: User::findById($_SESSION['user_id'])->fullname,
            'is_public' => true
        ]);
        
        $_SESSION['success'] = 'تم إنشاء الريل بنجاح!';
        header('Location: /reels/' . $reelId);
    }
    
    public function like() 
    {
        if (!isset($_SESSION['user_id']) || $_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(400);
            echo json_encode(['error' => 'Bad request']);
            return;
        }
        
        $reelId = $_POST['reel_id'] ?? null;
        
        if (!$reelId) {
            http_response_code(400);
            echo json_encode(['error' => 'Missing reel_id']);
            return;
        }
        
        $isLiked = Reel::isLiked($reelId, $_SESSION['user_id']);
        
        if ($isLiked) {
            $success = Reel::unlike($reelId, $_SESSION['user_id']);
            $action = 'unliked';
        } else {
            $success = Reel::like($reelId, $_SESSION['user_id']);
            $action = 'liked';
        }
        
        if ($success) {
            $reel = Reel::findById($reelId);
            header('Content-Type: application/json');
            echo json_encode([
                'success' => true,
                'action' => $action,
                'likes_count' => $reel->likes_count
            ]);
        } else {
            http_response_code(400);
            echo json_encode(['error' => 'Failed to update like status']);
        }
    }
    
    public function comment() 
    {
        if (!isset($_SESSION['user_id']) || $_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(400);
            echo json_encode(['error' => 'Bad request']);
            return;
        }
        
        $reelId = $_POST['reel_id'] ?? null;
        $content = trim($_POST['content'] ?? '');
        
        if (!$reelId || !$content) {
            http_response_code(400);
            echo json_encode(['error' => 'Missing required fields']);
            return;
        }
        
        $comment = Reel::addComment($reelId, $_SESSION['user_id'], $content);
        $user = User::findById($_SESSION['user_id']);
        
        header('Content-Type: application/json');
        echo json_encode([
            'success' => true,
            'comment' => [
                'id' => $comment->id,
                'content' => $comment->content,
                'created_at' => $comment->created_at,
                'user' => [
                    'fullname' => $user->fullname,
                    'username' => $user->username,
                    'avatar' => $user->avatar
                ]
            ]
        ]);
    }
    
    public function getComments() 
    {
        if (!isset($_SESSION['user_id'])) {
            http_response_code(401);
            echo json_encode(['error' => 'Unauthorized']);
            return;
        }
        
        $reelId = $_GET['reel_id'] ?? null;
        
        if (!$reelId) {
            http_response_code(400);
            echo json_encode(['error' => 'Missing reel_id']);
            return;
        }
        
        $comments = Reel::getComments($reelId);
        
        header('Content-Type: application/json');
        echo json_encode([
            'success' => true,
            'comments' => $comments
        ]);
    }
}
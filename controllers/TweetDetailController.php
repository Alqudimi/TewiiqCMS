<?php

require_once __DIR__ . '/../models/Tweet.php';
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../models/Reply.php';

class TweetDetailController 
{
    private $templates;
    
    public function __construct() 
    {
        $this->templates = new League\Plates\Engine(__DIR__ . '/../views');
    }
    
    public function show($tweetId) 
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit;
        }
        
        $tweet = Tweet::findById($tweetId);
        if (!$tweet->id) {
            http_response_code(404);
            echo $this->templates->render('errors/404');
            return;
        }
        
        // Get tweet with user data
        $tweetData = Tweet::getWithUserData(1, 0);
        $tweetData = array_filter($tweetData, function($t) use ($tweetId) {
            return $t['id'] == $tweetId;
        });
        $tweetData = reset($tweetData);
        
        if (!$tweetData) {
            http_response_code(404);
            echo $this->templates->render('errors/404');
            return;
        }
        
        // Get replies
        $replies = Reply::getByTweetId($tweetId, 50, 0);
        
        // Check if current user liked the tweet
        $isLiked = Tweet::isLikedByUser($tweetId, $_SESSION['user_id']);
        
        // Get current user info
        $currentUser = User::findById($_SESSION['user_id']);
        
        // Get tweet author's stats
        $author = User::findById($tweetData['user_id']);
        $authorStats = [
            'tweets' => User::getTweetsCount($author->id),
            'followers' => User::getFollowersCount($author->id),
            'following' => User::getFollowingCount($author->id)
        ];
        
        echo $this->templates->render('pages/tweet-detail', [
            'tweet' => $tweetData,
            'replies' => $replies,
            'isLiked' => $isLiked,
            'currentUser' => $currentUser,
            'author' => $author,
            'authorStats' => $authorStats,
            'title' => 'تفاصيل التغريدة'
        ]);
    }
    
    public function reply() 
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            return;
        }
        
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit;
        }
        
        $tweetId = $_POST['tweet_id'] ?? null;
        $content = trim($_POST['content'] ?? '');
        
        if (!$tweetId || !$content) {
            $_SESSION['error'] = 'محتوى الرد مطلوب';
            header('Location: /tweet/' . $tweetId);
            exit;
        }
        
        // Check if tweet exists
        $tweet = Tweet::findById($tweetId);
        if (!$tweet->id) {
            $_SESSION['error'] = 'التغريدة غير موجودة';
            header('Location: /');
            exit;
        }
        
        try {
            Reply::create([
                'tweet_id' => $tweetId,
                'user_id' => $_SESSION['user_id'],
                'content' => $content,
                'image_url' => null // TODO: Handle image uploads
            ]);
            
            $_SESSION['success'] = 'تم إضافة الرد بنجاح';
        } catch (Exception $e) {
            $_SESSION['error'] = 'حدث خطأ أثناء إضافة الرد';
        }
        
        header('Location: /tweet/' . $tweetId);
        exit;
    }
    
    public function likeReply() 
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            return;
        }
        
        if (!isset($_SESSION['user_id'])) {
            echo json_encode(['success' => false, 'message' => 'غير مسجل الدخول']);
            return;
        }
        
        $replyId = $_POST['reply_id'] ?? null;
        
        if (!$replyId) {
            echo json_encode(['success' => false, 'message' => 'معرف الرد مطلوب']);
            return;
        }
        
        try {
            $isLiked = Reply::like($replyId, $_SESSION['user_id']);
            
            echo json_encode([
                'success' => true, 
                'liked' => $isLiked,
                'message' => $isLiked ? 'تم الإعجاب' : 'تم إلغاء الإعجاب'
            ]);
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'message' => 'حدث خطأ']);
        }
    }
}
<?php

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../models/Tweet.php';

class ProfileController 
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
    
    public function show($username) 
    {
        $this->requireAuth();
        
        $profileUser = User::findByUsername($username);
        
        if (!$profileUser) {
            http_response_code(404);
            echo 'المستخدم غير موجود';
            exit;
        }
        
        $currentUserId = $_SESSION['user_id'];
        $isOwnProfile = ($profileUser->id == $currentUserId);
        $isFollowing = false;
        
        if (!$isOwnProfile) {
            $isFollowing = User::isFollowing($currentUserId, $profileUser->id);
        }
        
        // Get user statistics
        $followersCount = User::getFollowersCount($profileUser->id);
        $followingCount = User::getFollowingCount($profileUser->id);
        $tweetsCount = User::getTweetsCount($profileUser->id);
        
        // Get user tweets
        $tweets = Tweet::getUserTweetsWithData($profileUser->id, 20, 0);
        
        // Mark liked tweets
        foreach ($tweets as &$tweet) {
            $tweet['is_liked'] = Tweet::isLikedByUser($tweet['id'], $currentUserId);
        }
        
        echo $this->templates->render('pages/profile', [
            'profileUser' => $profileUser,
            'tweets' => $tweets,
            'isOwnProfile' => $isOwnProfile,
            'isFollowing' => $isFollowing,
            'followersCount' => $followersCount,
            'followingCount' => $followingCount,
            'tweetsCount' => $tweetsCount
        ]);
    }
    
    public function follow() 
    {
        $this->requireAuth();
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo json_encode(['error' => 'Method not allowed']);
            exit;
        }
        
        $followingId = $_POST['user_id'] ?? '';
        $followerId = $_SESSION['user_id'];
        
        if (empty($followingId)) {
            http_response_code(400);
            echo json_encode(['error' => 'User ID is required']);
            exit;
        }
        
        if ($followerId == $followingId) {
            http_response_code(400);
            echo json_encode(['error' => 'Cannot follow yourself']);
            exit;
        }
        
        $result = User::follow($followerId, $followingId);
        $followersCount = User::getFollowersCount($followingId);
        
        header('Content-Type: application/json');
        echo json_encode([
            'success' => $result,
            'following' => true,
            'followers_count' => $followersCount
        ]);
        exit;
    }
    
    public function unfollow() 
    {
        $this->requireAuth();
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo json_encode(['error' => 'Method not allowed']);
            exit;
        }
        
        $followingId = $_POST['user_id'] ?? '';
        $followerId = $_SESSION['user_id'];
        
        if (empty($followingId)) {
            http_response_code(400);
            echo json_encode(['error' => 'User ID is required']);
            exit;
        }
        
        $result = User::unfollow($followerId, $followingId);
        $followersCount = User::getFollowersCount($followingId);
        
        header('Content-Type: application/json');
        echo json_encode([
            'success' => $result,
            'following' => false,
            'followers_count' => $followersCount
        ]);
        exit;
    }
}
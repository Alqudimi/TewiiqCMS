<?php

require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../database/Database.php';

use RedBeanPHP\R;

class FollowingController 
{
    private $templates;
    
    public function __construct() 
    {
        $this->templates = new League\Plates\Engine(__DIR__ . '/../views');
    }
    
    public function followers($username) 
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit;
        }
        
        $user = User::findByUsername($username);
        if (!$user) {
            http_response_code(404);
            echo 'المستخدم غير موجود';
            return;
        }
        
        $followers = $this->getFollowers($user->id);
        $currentUser = User::findById($_SESSION['user_id']);
        
        echo $this->templates->render('pages/followers', [
            'title' => 'متابعو ' . $user->fullname . ' - Tewiiq',
            'user' => $user,
            'followers' => $followers,
            'current_user' => $currentUser,
            'type' => 'followers'
        ]);
    }
    
    public function following($username) 
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit;
        }
        
        $user = User::findByUsername($username);
        if (!$user) {
            http_response_code(404);
            echo 'المستخدم غير موجود';
            return;
        }
        
        $following = $this->getFollowing($user->id);
        $currentUser = User::findById($_SESSION['user_id']);
        
        echo $this->templates->render('pages/following', [
            'title' => 'يتابع ' . $user->fullname . ' - Tewiiq',
            'user' => $user,
            'following' => $following,
            'current_user' => $currentUser,
            'type' => 'following'
        ]);
    }
    
    public function suggestions() 
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit;
        }
        
        $suggestions = $this->getSuggestions($_SESSION['user_id']);
        $currentUser = User::findById($_SESSION['user_id']);
        
        echo $this->templates->render('pages/suggestions', [
            'title' => 'اقتراحات المتابعة - Tewiiq',
            'suggestions' => $suggestions,
            'current_user' => $currentUser
        ]);
    }
    
    private function getFollowers($userId, $limit = 50) 
    {
        Database::init();
        
        $followers = R::find('follows', 'following_id = ? ORDER BY created_at DESC LIMIT ?', [$userId, $limit]);
        
        $result = [];
        foreach ($followers as $follow) {
            $followerUser = R::load('users', $follow->follower_id);
            if ($followerUser->id) {
                $result[] = [
                    'user' => $followerUser,
                    'followed_at' => $follow->created_at,
                    'is_following' => User::isFollowing($_SESSION['user_id'], $followerUser->id),
                    'is_mutual' => User::isFollowing($followerUser->id, $_SESSION['user_id'])
                ];
            }
        }
        
        return $result;
    }
    
    private function getFollowing($userId, $limit = 50) 
    {
        Database::init();
        
        $following = R::find('follows', 'follower_id = ? ORDER BY created_at DESC LIMIT ?', [$userId, $limit]);
        
        $result = [];
        foreach ($following as $follow) {
            $followingUser = R::load('users', $follow->following_id);
            if ($followingUser->id) {
                $result[] = [
                    'user' => $followingUser,
                    'followed_at' => $follow->created_at,
                    'is_following' => User::isFollowing($_SESSION['user_id'], $followingUser->id),
                    'is_mutual' => User::isFollowing($followingUser->id, $_SESSION['user_id'])
                ];
            }
        }
        
        return $result;
    }
    
    private function getSuggestions($userId, $limit = 20) 
    {
        Database::init();
        
        // Get users that current user's following are following (friends of friends)
        $suggestions = R::getAll('
            SELECT DISTINCT u.*, COUNT(*) as mutual_connections
            FROM users u
            JOIN follows f1 ON u.id = f1.following_id
            JOIN follows f2 ON f1.follower_id = f2.following_id
            WHERE f2.follower_id = ?
            AND u.id != ?
            AND u.id NOT IN (
                SELECT following_id FROM follows WHERE follower_id = ?
            )
            AND u.is_active = 1
            GROUP BY u.id
            ORDER BY mutual_connections DESC, u.created_at DESC
            LIMIT ?
        ', [$userId, $userId, $userId, $limit]);
        
        // If not enough suggestions, add popular users
        if (count($suggestions) < $limit) {
            $remainingLimit = $limit - count($suggestions);
            $existingIds = array_column($suggestions, 'id');
            $existingIds[] = $userId;
            
            $popularUsers = R::getAll('
                SELECT u.*, COUNT(f.id) as followers_count
                FROM users u
                LEFT JOIN follows f ON u.id = f.following_id
                WHERE u.id NOT IN (' . implode(',', array_fill(0, count($existingIds), '?')) . ')
                AND u.is_active = 1
                GROUP BY u.id
                ORDER BY followers_count DESC, u.created_at DESC
                LIMIT ?
            ', array_merge($existingIds, [$remainingLimit]));
            
            $suggestions = array_merge($suggestions, $popularUsers);
        }
        
        $result = [];
        foreach ($suggestions as $suggestion) {
            $result[] = [
                'user' => (object) $suggestion,
                'mutual_connections' => $suggestion['mutual_connections'] ?? 0,
                'is_verified' => $suggestion['is_verified'] ?? false
            ];
        }
        
        return $result;
    }
    
    public function search() 
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit;
        }
        
        $query = trim($_GET['q'] ?? '');
        $type = $_GET['type'] ?? 'all';
        
        if (!$query) {
            header('Location: /suggestions');
            exit;
        }
        
        $results = $this->searchUsers($query, $type);
        $currentUser = User::findById($_SESSION['user_id']);
        
        echo $this->templates->render('pages/user-search', [
            'title' => 'نتائج البحث: ' . $query . ' - Tewiiq',
            'query' => $query,
            'results' => $results,
            'current_user' => $currentUser,
            'type' => $type
        ]);
    }
    
    private function searchUsers($query, $type = 'all', $limit = 30) 
    {
        Database::init();
        
        $whereClause = 'u.is_active = 1 AND (u.fullname LIKE ? OR u.username LIKE ? OR u.bio LIKE ?)';
        $params = ["%$query%", "%$query%", "%$query%"];
        
        if ($type === 'verified') {
            $whereClause .= ' AND u.is_verified = 1';
        }
        
        $users = R::getAll("
            SELECT u.*, COUNT(f.id) as followers_count
            FROM users u
            LEFT JOIN follows f ON u.id = f.following_id
            WHERE $whereClause
            GROUP BY u.id
            ORDER BY u.is_verified DESC, followers_count DESC, u.created_at DESC
            LIMIT ?
        ", array_merge($params, [$limit]));
        
        $result = [];
        foreach ($users as $user) {
            $result[] = [
                'user' => (object) $user,
                'is_following' => User::isFollowing($_SESSION['user_id'], $user['id']),
                'followers_count' => $user['followers_count']
            ];
        }
        
        return $result;
    }
}
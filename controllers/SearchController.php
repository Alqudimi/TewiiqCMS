<?php

require_once __DIR__ . '/../models/Tweet.php';
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../models/Event.php';
require_once __DIR__ . '/../models/TweetList.php';

class SearchController 
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
        
        $query = $_GET['q'] ?? '';
        $type = $_GET['type'] ?? 'all'; // all, tweets, users, events, lists
        $sortBy = $_GET['sort'] ?? 'recent'; // recent, popular, relevant
        
        $results = [];
        $totalResults = 0;
        
        if ($query) {
            switch ($type) {
                case 'tweets':
                    $results = $this->searchTweets($query, $sortBy);
                    break;
                case 'users':
                    $results = $this->searchUsers($query);
                    break;
                case 'events':
                    $results = $this->searchEvents($query);
                    break;
                case 'lists':
                    $results = $this->searchLists($query);
                    break;
                default:
                    $results = $this->searchAll($query, $sortBy);
                    break;
            }
            $totalResults = count($results);
        }
        
        echo $this->templates->render('pages/search', [
            'query' => $query,
            'type' => $type,
            'sortBy' => $sortBy,
            'results' => $results,
            'totalResults' => $totalResults,
            'title' => 'البحث المتقدم'
        ]);
    }
    
    private function searchTweets($query, $sortBy = 'recent') 
    {
        Database::init();
        
        $sql = "
            SELECT t.*, u.username, u.fullname, u.avatar, u.is_verified
            FROM tweets t 
            JOIN users u ON t.user_id = u.id 
            WHERE t.content LIKE ?
        ";
        
        switch ($sortBy) {
            case 'popular':
                $sql .= " ORDER BY t.likes_count DESC, t.retweets_count DESC";
                break;
            case 'relevant':
                $sql .= " ORDER BY t.likes_count + t.retweets_count DESC";
                break;
            default:
                $sql .= " ORDER BY t.created_at DESC";
                break;
        }
        
        $sql .= " LIMIT 50";
        
        return R::getAll($sql, ["%$query%"]);
    }
    
    private function searchUsers($query) 
    {
        Database::init();
        
        $sql = "
            SELECT id, username, fullname, bio, avatar, is_verified,
                   created_at
            FROM users 
            WHERE username LIKE ? OR fullname LIKE ? OR bio LIKE ?
            ORDER BY 
                CASE 
                    WHEN username LIKE ? THEN 1
                    WHEN fullname LIKE ? THEN 2
                    ELSE 3
                END,
                fullname ASC
            LIMIT 50
        ";
        
        $searchTerm = "%$query%";
        $exactMatch = "$query%";
        
        return R::getAll($sql, [
            $searchTerm, $searchTerm, $searchTerm,
            $exactMatch, $exactMatch
        ]);
    }
    
    private function searchEvents($query) 
    {
        return Event::search($query);
    }
    
    private function searchLists($query) 
    {
        Database::init();
        
        $sql = "
            SELECT l.*, u.username, u.fullname, u.avatar
            FROM tweet_lists l 
            JOIN users u ON l.user_id = u.id 
            WHERE (l.name LIKE ? OR l.description LIKE ?) AND l.is_private = 0
            ORDER BY l.members_count DESC
            LIMIT 30
        ";
        
        return R::getAll($sql, ["%$query%", "%$query%"]);
    }
    
    private function searchAll($query, $sortBy = 'recent') 
    {
        $tweets = $this->searchTweets($query, $sortBy);
        $users = array_slice($this->searchUsers($query), 0, 10);
        $events = array_slice($this->searchEvents($query), 0, 10);
        $lists = array_slice($this->searchLists($query), 0, 10);
        
        return [
            'tweets' => $tweets,
            'users' => $users,
            'events' => $events,
            'lists' => $lists
        ];
    }
    
    public function suggest() 
    {
        if (!isset($_SESSION['user_id'])) {
            echo json_encode([]);
            return;
        }
        
        $query = $_GET['q'] ?? '';
        
        if (strlen($query) < 2) {
            echo json_encode([]);
            return;
        }
        
        Database::init();
        
        // Get user suggestions
        $userSuggestions = R::getAll("
            SELECT username, fullname, avatar
            FROM users 
            WHERE username LIKE ? OR fullname LIKE ?
            ORDER BY 
                CASE 
                    WHEN username LIKE ? THEN 1
                    ELSE 2
                END
            LIMIT 5
        ", ["%$query%", "%$query%", "$query%"]);
        
        // Get hashtag suggestions (from tweet content)
        $hashtagSuggestions = R::getAll("
            SELECT DISTINCT 
                SUBSTRING_INDEX(SUBSTRING_INDEX(content, '#', -1), ' ', 1) as hashtag,
                COUNT(*) as count
            FROM tweets 
            WHERE content LIKE ?
            GROUP BY hashtag
            HAVING hashtag != ''
            ORDER BY count DESC
            LIMIT 5
        ", ["%#$query%"]);
        
        echo json_encode([
            'users' => $userSuggestions,
            'hashtags' => $hashtagSuggestions
        ]);
    }
    
    public function trends() 
    {
        if (!isset($_SESSION['user_id'])) {
            echo json_encode([]);
            return;
        }
        
        Database::init();
        
        // Get trending hashtags from last 24 hours
        $trendingHashtags = R::getAll("
            SELECT 
                SUBSTRING_INDEX(SUBSTRING_INDEX(content, '#', -1), ' ', 1) as hashtag,
                COUNT(*) as tweet_count
            FROM tweets 
            WHERE content LIKE '%#%' AND created_at >= DATE_SUB(NOW(), INTERVAL 24 HOUR)
            GROUP BY hashtag
            HAVING hashtag != '' AND hashtag NOT LIKE '% %'
            ORDER BY tweet_count DESC
            LIMIT 10
        ");
        
        // Get trending users (most followed in last week)
        $trendingUsers = R::getAll("
            SELECT u.username, u.fullname, u.avatar, COUNT(f.id) as new_followers
            FROM users u
            LEFT JOIN follows f ON u.id = f.following_id 
            WHERE f.created_at >= DATE_SUB(NOW(), INTERVAL 7 DAY)
            GROUP BY u.id
            ORDER BY new_followers DESC
            LIMIT 5
        ");
        
        echo json_encode([
            'hashtags' => $trendingHashtags,
            'users' => $trendingUsers
        ]);
    }
}
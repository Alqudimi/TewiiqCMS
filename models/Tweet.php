<?php

require_once __DIR__ . '/../database/Database.php';

use RedBeanPHP\R;

class Tweet 
{
    public static function create($data) 
    {
        Database::init();
        
        $tweet = R::dispense('tweets');
        $tweet->user_id = $data['user_id'];
        $tweet->content = $data['content'];
        $tweet->image_url = $data['image_url'] ?? null;
        $tweet->likes_count = 0;
        $tweet->retweets_count = 0;
        $tweet->replies_count = 0;
        $tweet->created_at = date('Y-m-d H:i:s');
        $tweet->updated_at = date('Y-m-d H:i:s');
        
        return R::store($tweet);
    }
    
    public static function findById($id) 
    {
        Database::init();
        return R::load('tweets', $id);
    }
    
    public static function getAll($limit = 20, $offset = 0) 
    {
        Database::init();
        return R::findAll('tweets', 'ORDER BY created_at DESC LIMIT ? OFFSET ?', [$limit, $offset]);
    }
    
    public static function getByUserId($userId, $limit = 20, $offset = 0) 
    {
        Database::init();
        return R::find('tweets', 'user_id = ? ORDER BY created_at DESC LIMIT ? OFFSET ?', [$userId, $limit, $offset]);
    }
    
    public static function getWithUserData($limit = 20, $offset = 0) 
    {
        Database::init();
        
        $sql = "
            SELECT t.*, u.username, u.fullname, u.avatar, u.is_verified
            FROM tweets t 
            JOIN users u ON t.user_id = u.id 
            ORDER BY t.created_at DESC 
            LIMIT ? OFFSET ?
        ";
        
        return R::getAll($sql, [$limit, $offset]);
    }
    
    public static function getUserTweetsWithData($userId, $limit = 20, $offset = 0) 
    {
        Database::init();
        
        $sql = "
            SELECT t.*, u.username, u.fullname, u.avatar, u.is_verified
            FROM tweets t 
            JOIN users u ON t.user_id = u.id 
            WHERE t.user_id = ?
            ORDER BY t.created_at DESC 
            LIMIT ? OFFSET ?
        ";
        
        return R::getAll($sql, [$userId, $limit, $offset]);
    }
    
    public static function delete($id, $userId) 
    {
        Database::init();
        
        $tweet = R::load('tweets', $id);
        
        if ($tweet->user_id == $userId) {
            R::trash($tweet);
            return true;
        }
        
        return false;
    }
    
    public static function like($tweetId, $userId) 
    {
        Database::init();
        
        $existingLike = R::findOne('likes', 'tweet_id = ? AND user_id = ?', [$tweetId, $userId]);
        
        if ($existingLike) {
            // Unlike
            R::trash($existingLike);
            
            // Decrease likes count
            $tweet = R::load('tweets', $tweetId);
            if ($tweet->id) {
                $tweet->likes_count = max(0, $tweet->likes_count - 1);
                R::store($tweet);
            }
            
            return false; // Unliked
        } else {
            // Like
            $like = R::dispense('likes');
            $like->tweet_id = $tweetId;
            $like->user_id = $userId;
            $like->created_at = date('Y-m-d H:i:s');
            R::store($like);
            
            // Increase likes count
            $tweet = R::load('tweets', $tweetId);
            if ($tweet->id) {
                $tweet->likes_count = $tweet->likes_count + 1;
                R::store($tweet);
            }
            
            return true; // Liked
        }
    }
    
    public static function isLikedByUser($tweetId, $userId) 
    {
        Database::init();
        return R::count('likes', 'tweet_id = ? AND user_id = ?', [$tweetId, $userId]) > 0;
    }
    
    public static function getLikesCount($tweetId) 
    {
        Database::init();
        return R::count('likes', 'tweet_id = ?', [$tweetId]);
    }
}
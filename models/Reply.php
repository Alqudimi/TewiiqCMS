<?php

require_once __DIR__ . '/../database/Database.php';

use RedBeanPHP\R;

class Reply 
{
    public static function create($data) 
    {
        Database::init();
        
        $reply = R::dispense('replies');
        $reply->tweet_id = $data['tweet_id'];
        $reply->user_id = $data['user_id'];
        $reply->content = $data['content'];
        $reply->image_url = $data['image_url'] ?? null;
        $reply->likes_count = 0;
        $reply->replies_count = 0;
        $reply->created_at = date('Y-m-d H:i:s');
        $reply->updated_at = date('Y-m-d H:i:s');
        
        $replyId = R::store($reply);
        
        // Update replies count in original tweet
        $tweet = R::load('tweets', $data['tweet_id']);
        if ($tweet->id) {
            $tweet->replies_count = $tweet->replies_count + 1;
            $tweet->updated_at = date('Y-m-d H:i:s');
            R::store($tweet);
        }
        
        return $replyId;
    }
    
    public static function getByTweetId($tweetId, $limit = 20, $offset = 0) 
    {
        Database::init();
        
        $sql = "
            SELECT r.*, u.username, u.fullname, u.avatar, u.is_verified
            FROM replies r 
            JOIN users u ON r.user_id = u.id 
            WHERE r.tweet_id = ?
            ORDER BY r.created_at ASC 
            LIMIT ? OFFSET ?
        ";
        
        return R::getAll($sql, [$tweetId, $limit, $offset]);
    }
    
    public static function getCount($tweetId) 
    {
        Database::init();
        return R::count('replies', 'tweet_id = ?', [$tweetId]);
    }
    
    public static function like($replyId, $userId) 
    {
        Database::init();
        
        $existingLike = R::findOne('replylikes', 'reply_id = ? AND user_id = ?', [$replyId, $userId]);
        
        if ($existingLike) {
            // Unlike
            R::trash($existingLike);
            
            $reply = R::load('replies', $replyId);
            if ($reply->id) {
                $reply->likes_count = max(0, $reply->likes_count - 1);
                R::store($reply);
            }
            
            return false;
        } else {
            // Like
            $like = R::dispense('replylikes');
            $like->reply_id = $replyId;
            $like->user_id = $userId;
            $like->created_at = date('Y-m-d H:i:s');
            R::store($like);
            
            $reply = R::load('replies', $replyId);
            if ($reply->id) {
                $reply->likes_count = $reply->likes_count + 1;
                R::store($reply);
            }
            
            return true;
        }
    }
    
    public static function isLikedByUser($replyId, $userId) 
    {
        Database::init();
        return R::count('replylikes', 'reply_id = ? AND user_id = ?', [$replyId, $userId]) > 0;
    }
    
    public static function delete($id, $userId) 
    {
        Database::init();
        
        $reply = R::load('replies', $id);
        
        if ($reply->id && $reply->user_id == $userId) {
            // Update tweet replies count
            $tweet = R::load('tweets', $reply->tweet_id);
            if ($tweet->id) {
                $tweet->replies_count = max(0, $tweet->replies_count - 1);
                R::store($tweet);
            }
            
            // Delete reply likes first
            R::exec('DELETE FROM replylikes WHERE reply_id = ?', [$id]);
            R::trash($reply);
            return true;
        }
        
        return false;
    }
}
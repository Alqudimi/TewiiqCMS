<?php

require_once __DIR__ . '/../database/Database.php';

use RedBeanPHP\R;

class Reel 
{
    public static function create($data) 
    {
        Database::init();
        
        $reel = R::dispense('reels');
        $reel->user_id = $data['user_id'];
        $reel->title = $data['title'] ?? '';
        $reel->description = $data['description'] ?? '';
        $reel->video_url = $data['video_url'];
        $reel->thumbnail_url = $data['thumbnail_url'] ?? '';
        $reel->duration = $data['duration'] ?? 0;
        $reel->views_count = 0;
        $reel->likes_count = 0;
        $reel->comments_count = 0;
        $reel->hashtags = $data['hashtags'] ?? '';
        $reel->music_title = $data['music_title'] ?? 'Original Audio';
        $reel->music_artist = $data['music_artist'] ?? '';
        $reel->is_public = $data['is_public'] ?? true;
        $reel->created_at = date('Y-m-d H:i:s');
        $reel->updated_at = date('Y-m-d H:i:s');
        
        return R::store($reel);
    }
    
    public static function getAll($limit = 20, $offset = 0) 
    {
        Database::init();
        
        $reels = R::find('reels', 'is_public = 1 ORDER BY created_at DESC LIMIT ? OFFSET ?', [$limit, $offset]);
        
        $result = [];
        foreach ($reels as $reel) {
            $user = R::load('users', $reel->user_id);
            $result[] = [
                'reel' => $reel,
                'user' => $user,
                'is_liked' => false // Will be updated based on current user
            ];
        }
        
        return $result;
    }
    
    public static function getByUser($userId, $limit = 20) 
    {
        Database::init();
        
        return R::find('reels', 'user_id = ? ORDER BY created_at DESC LIMIT ?', [$userId, $limit]);
    }
    
    public static function findById($id) 
    {
        Database::init();
        return R::load('reels', $id);
    }
    
    public static function like($reelId, $userId) 
    {
        Database::init();
        
        // Check if already liked
        $existingLike = R::findOne('reel_likes', 'reel_id = ? AND user_id = ?', [$reelId, $userId]);
        
        if ($existingLike) {
            return false;
        }
        
        $like = R::dispense('reel_likes');
        $like->reel_id = $reelId;
        $like->user_id = $userId;
        $like->created_at = date('Y-m-d H:i:s');
        
        R::store($like);
        
        // Update likes count
        $reel = R::load('reels', $reelId);
        if ($reel->id) {
            $reel->likes_count++;
            R::store($reel);
        }
        
        return true;
    }
    
    public static function unlike($reelId, $userId) 
    {
        Database::init();
        
        $like = R::findOne('reel_likes', 'reel_id = ? AND user_id = ?', [$reelId, $userId]);
        
        if ($like) {
            R::trash($like);
            
            // Update likes count
            $reel = R::load('reels', $reelId);
            if ($reel->id && $reel->likes_count > 0) {
                $reel->likes_count--;
                R::store($reel);
            }
            
            return true;
        }
        
        return false;
    }
    
    public static function addView($reelId, $userId, $viewDuration = 0) 
    {
        Database::init();
        
        // Check if user already viewed this reel in the last hour
        $existingView = R::findOne('reel_views', 
            'reel_id = ? AND user_id = ? AND created_at > ?', 
            [$reelId, $userId, date('Y-m-d H:i:s', strtotime('-1 hour'))]
        );
        
        if ($existingView) {
            return false;
        }
        
        $view = R::dispense('reel_views');
        $view->reel_id = $reelId;
        $view->user_id = $userId;
        $view->view_duration = $viewDuration;
        $view->created_at = date('Y-m-d H:i:s');
        
        R::store($view);
        
        // Update views count
        $reel = R::load('reels', $reelId);
        if ($reel->id) {
            $reel->views_count++;
            R::store($reel);
        }
        
        return true;
    }
    
    public static function addComment($reelId, $userId, $content) 
    {
        Database::init();
        
        $comment = R::dispense('reel_comments');
        $comment->reel_id = $reelId;
        $comment->user_id = $userId;
        $comment->content = $content;
        $comment->likes_count = 0;
        $comment->created_at = date('Y-m-d H:i:s');
        
        $commentId = R::store($comment);
        
        // Update comments count
        $reel = R::load('reels', $reelId);
        if ($reel->id) {
            $reel->comments_count++;
            R::store($reel);
        }
        
        return R::load('reel_comments', $commentId);
    }
    
    public static function getComments($reelId, $limit = 20) 
    {
        Database::init();
        
        $comments = R::find('reel_comments', 'reel_id = ? ORDER BY created_at DESC LIMIT ?', [$reelId, $limit]);
        
        $result = [];
        foreach ($comments as $comment) {
            $user = R::load('users', $comment->user_id);
            $result[] = [
                'comment' => $comment,
                'user' => $user
            ];
        }
        
        return $result;
    }
    
    public static function isLiked($reelId, $userId) 
    {
        Database::init();
        return R::count('reel_likes', 'reel_id = ? AND user_id = ?', [$reelId, $userId]) > 0;
    }
}
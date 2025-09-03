<?php

require_once __DIR__ . '/../database/Database.php';

use RedBeanPHP\R;

class User 
{
    public static function create($data) 
    {
        Database::init();
        
        $user = R::dispense('users');
        $user->username = $data['username'];
        $user->email = $data['email'];
        $user->password = password_hash($data['password'], PASSWORD_DEFAULT);
        $user->fullname = $data['fullname'] ?? '';
        $user->bio = $data['bio'] ?? '';
        $user->avatar = $data['avatar'] ?? null;
        $user->cover_image = $data['cover_image'] ?? null;
        $user->location = $data['location'] ?? null;
        $user->website = $data['website'] ?? null;
        $user->is_verified = false;
        $user->is_active = true;
        $user->created_at = date('Y-m-d H:i:s');
        $user->updated_at = date('Y-m-d H:i:s');
        
        return R::store($user);
    }
    
    public static function findByEmail($email) 
    {
        Database::init();
        return R::findOne('users', 'email = ?', [$email]);
    }
    
    public static function findByUsername($username) 
    {
        Database::init();
        return R::findOne('users', 'username = ?', [$username]);
    }
    
    public static function findById($id) 
    {
        Database::init();
        return R::load('users', $id);
    }
    
    public static function authenticate($identifier, $password) 
    {
        Database::init();
        
        // Try to find by email or username
        $user = R::findOne('users', 'email = ? OR username = ?', [$identifier, $identifier]);
        
        if ($user && password_verify($password, $user->password)) {
            return $user;
        }
        
        return false;
    }
    
    public static function update($id, $data) 
    {
        Database::init();
        
        $user = R::load('users', $id);
        
        if (!$user->id) {
            return false;
        }
        
        foreach ($data as $key => $value) {
            if ($key !== 'id' && $key !== 'password') {
                $user->$key = $value;
            }
        }
        
        if (isset($data['password']) && !empty($data['password'])) {
            $user->password = password_hash($data['password'], PASSWORD_DEFAULT);
        }
        
        $user->updated_at = date('Y-m-d H:i:s');
        
        return R::store($user);
    }
    
    public static function getFollowersCount($userId) 
    {
        Database::init();
        return R::count('follows', 'following_id = ?', [$userId]);
    }
    
    public static function getFollowingCount($userId) 
    {
        Database::init();
        return R::count('follows', 'follower_id = ?', [$userId]);
    }
    
    public static function getTweetsCount($userId) 
    {
        Database::init();
        return R::count('tweets', 'user_id = ?', [$userId]);
    }
    
    public static function isFollowing($followerId, $followingId) 
    {
        Database::init();
        return R::count('follows', 'follower_id = ? AND following_id = ?', [$followerId, $followingId]) > 0;
    }
    
    public static function follow($followerId, $followingId) 
    {
        Database::init();
        
        if ($followerId == $followingId) {
            return false;
        }
        
        if (self::isFollowing($followerId, $followingId)) {
            return false;
        }
        
        $follow = R::dispense('follows');
        $follow->follower_id = $followerId;
        $follow->following_id = $followingId;
        $follow->created_at = date('Y-m-d H:i:s');
        
        return R::store($follow);
    }
    
    public static function unfollow($followerId, $followingId) 
    {
        Database::init();
        
        $follow = R::findOne('follows', 'follower_id = ? AND following_id = ?', [$followerId, $followingId]);
        
        if ($follow) {
            R::trash($follow);
            return true;
        }
        
        return false;
    }
}
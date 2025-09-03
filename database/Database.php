<?php

require_once __DIR__ . '/../vendor/autoload.php';

use RedBeanPHP\R;

class Database 
{
    private static $initialized = false;
    
    public static function init() 
    {
        if (self::$initialized) {
            return;
        }
        
        try {
            // Use SQLite for simplicity
            $dbPath = __DIR__ . '/tewiiq.db';
            R::setup('sqlite:' . $dbPath);
            
            // Test connection
            R::testConnection();
            
            self::$initialized = true;
            self::createTables();
            
        } catch (Exception $e) {
            error_log("Database connection failed: " . $e->getMessage());
            throw new Exception("Could not connect to database: " . $e->getMessage());
        }
    }
    
    public static function createTables()
    {
        try {
            // Create users table
            $user = R::dispense('users');
            $user->username = 'test';
            $user->email = 'test@example.com';
            $user->password = 'test';
            $user->fullname = 'Test User';
            $user->bio = 'Test bio';
            $user->avatar = null;
            $user->cover_image = null;
            $user->location = null;
            $user->website = null;
            $user->is_verified = false;
            $user->is_active = true;
            $user->created_at = date('Y-m-d H:i:s');
            $user->updated_at = date('Y-m-d H:i:s');
            R::store($user);
            R::trash($user);
            
            // Create tweets table
            $tweet = R::dispense('tweets');
            $tweet->user_id = 1;
            $tweet->content = 'Test tweet';
            $tweet->image_url = null;
            $tweet->likes_count = 0;
            $tweet->retweets_count = 0;
            $tweet->replies_count = 0;
            $tweet->created_at = date('Y-m-d H:i:s');
            $tweet->updated_at = date('Y-m-d H:i:s');
            R::store($tweet);
            R::trash($tweet);
            
            // Create follows table
            $follow = R::dispense('follows');
            $follow->follower_id = 1;
            $follow->following_id = 2;
            $follow->created_at = date('Y-m-d H:i:s');
            R::store($follow);
            R::trash($follow);
            
            // Create likes table
            $like = R::dispense('likes');
            $like->user_id = 1;
            $like->tweet_id = 1;
            $like->created_at = date('Y-m-d H:i:s');
            R::store($like);
            R::trash($like);
            
            // Create sessions table
            $session = R::dispense('sessions');
            $session->user_id = 1;
            $session->session_token = 'test_token';
            $session->expires_at = date('Y-m-d H:i:s', strtotime('+1 day'));
            $session->created_at = date('Y-m-d H:i:s');
            R::store($session);
            R::trash($session);
            
        } catch (Exception $e) {
            error_log("Error creating tables: " . $e->getMessage());
        }
    }
    
    public static function close()
    {
        R::close();
        self::$initialized = false;
    }
}
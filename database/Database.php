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
            
            // Create replies table
            $reply = R::dispense('replies');
            $reply->tweet_id = 1;
            $reply->user_id = 1;
            $reply->content = 'Test reply';
            $reply->image_url = null;
            $reply->likes_count = 0;
            $reply->replies_count = 0;
            $reply->created_at = date('Y-m-d H:i:s');
            $reply->updated_at = date('Y-m-d H:i:s');
            R::store($reply);
            R::trash($reply);
            
            // Create reply_likes table
            $replyLike = R::dispense('replylikes');
            $replyLike->reply_id = 1;
            $replyLike->user_id = 1;
            $replyLike->created_at = date('Y-m-d H:i:s');
            R::store($replyLike);
            R::trash($replyLike);
            
            // Create tweet_lists table
            $list = R::dispense('tweet_lists');
            $list->user_id = 1;
            $list->name = 'Test List';
            $list->description = 'Test list description';
            $list->is_private = false;
            $list->cover_image = null;
            $list->members_count = 0;
            $list->created_at = date('Y-m-d H:i:s');
            $list->updated_at = date('Y-m-d H:i:s');
            R::store($list);
            R::trash($list);
            
            // Create list_members table
            $listMember = R::dispense('list_members');
            $listMember->list_id = 1;
            $listMember->user_id = 1;
            $listMember->created_at = date('Y-m-d H:i:s');
            R::store($listMember);
            R::trash($listMember);
            
            // Create events table
            $event = R::dispense('events');
            $event->user_id = 1;
            $event->title = 'Test Event';
            $event->description = 'Test event description';
            $event->event_type = 'general';
            $event->start_time = date('Y-m-d H:i:s', strtotime('+1 hour'));
            $event->end_time = date('Y-m-d H:i:s', strtotime('+2 hours'));
            $event->is_live = false;
            $event->image_url = null;
            $event->participants_count = 0;
            $event->location = null;
            $event->hashtags = '';
            $event->created_at = date('Y-m-d H:i:s');
            $event->updated_at = date('Y-m-d H:i:s');
            R::store($event);
            R::trash($event);
            
            // Create event_participants table
            $participant = R::dispense('event_participants');
            $participant->event_id = 1;
            $participant->user_id = 1;
            $participant->joined_at = date('Y-m-d H:i:s');
            R::store($participant);
            R::trash($participant);
            
            // Create user_settings table
            $settings = R::dispense('user_settings');
            $settings->user_id = 1;
            $settings->profile_visibility = 'public';
            $settings->tweet_privacy = 'public';
            $settings->message_privacy = 'everyone';
            $settings->tagging_permission = 'everyone';
            $settings->location_sharing = false;
            $settings->photo_tagging = true;
            $settings->search_by_email = true;
            $settings->search_by_phone = true;
            $settings->email_notifications = true;
            $settings->push_notifications = true;
            $settings->sms_notifications = false;
            $settings->like_notifications = true;
            $settings->reply_notifications = true;
            $settings->follow_notifications = true;
            $settings->mention_notifications = true;
            $settings->retweet_notifications = true;
            $settings->message_notifications = true;
            $settings->theme = 'light';
            $settings->font_size = 'medium';
            $settings->language = 'ar';
            $settings->timezone = 'Asia/Riyadh';
            $settings->autoplay_videos = true;
            $settings->data_saver = false;
            $settings->high_quality_images = true;
            $settings->sensitive_content = false;
            $settings->two_factor_auth = false;
            $settings->login_verification = true;
            $settings->password_reset_email = true;
            $settings->created_at = date('Y-m-d H:i:s');
            $settings->updated_at = date('Y-m-d H:i:s');
            R::store($settings);
            R::trash($settings);
            
            // Create conversations table
            $conversation = R::dispense('conversations');
            $conversation->participant_one = 1;
            $conversation->participant_two = 2;
            $conversation->created_at = date('Y-m-d H:i:s');
            $conversation->updated_at = date('Y-m-d H:i:s');
            R::store($conversation);
            R::trash($conversation);
            
            // Create messages table
            $message = R::dispense('messages');
            $message->conversation_id = 1;
            $message->sender_id = 1;
            $message->content = 'Test message';
            $message->message_type = 'text';
            $message->is_read = false;
            $message->created_at = date('Y-m-d H:i:s');
            R::store($message);
            R::trash($message);
            
            // Create reels table
            $reel = R::dispense('reels');
            $reel->user_id = 1;
            $reel->title = 'Test Reel';
            $reel->description = 'Test reel description';
            $reel->video_url = '/uploads/test.mp4';
            $reel->thumbnail_url = '/uploads/test_thumb.jpg';
            $reel->duration = 30;
            $reel->views_count = 0;
            $reel->likes_count = 0;
            $reel->comments_count = 0;
            $reel->hashtags = '#test #reel';
            $reel->music_title = 'Original Audio';
            $reel->music_artist = 'User Name';
            $reel->is_public = true;
            $reel->created_at = date('Y-m-d H:i:s');
            $reel->updated_at = date('Y-m-d H:i:s');
            R::store($reel);
            R::trash($reel);
            
            // Create reel_likes table
            $reelLike = R::dispense('reel_likes');
            $reelLike->reel_id = 1;
            $reelLike->user_id = 1;
            $reelLike->created_at = date('Y-m-d H:i:s');
            R::store($reelLike);
            R::trash($reelLike);
            
            // Create reel_comments table
            $reelComment = R::dispense('reel_comments');
            $reelComment->reel_id = 1;
            $reelComment->user_id = 1;
            $reelComment->content = 'Test comment';
            $reelComment->likes_count = 0;
            $reelComment->created_at = date('Y-m-d H:i:s');
            R::store($reelComment);
            R::trash($reelComment);
            
            // Create reel_views table
            $reelView = R::dispense('reel_views');
            $reelView->reel_id = 1;
            $reelView->user_id = 1;
            $reelView->view_duration = 15;
            $reelView->created_at = date('Y-m-d H:i:s');
            R::store($reelView);
            R::trash($reelView);
            
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
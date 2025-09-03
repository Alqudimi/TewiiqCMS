<?php

require_once __DIR__ . '/../database/Database.php';

use RedBeanPHP\R;

class UserSettings 
{
    public static function getSettings($userId) 
    {
        Database::init();
        
        $settings = R::findOne('user_settings', 'user_id = ?', [$userId]);
        
        if (!$settings) {
            // Create default settings
            $settings = self::createDefaultSettings($userId);
        }
        
        return $settings;
    }
    
    public static function createDefaultSettings($userId) 
    {
        Database::init();
        
        $settings = R::dispense('user_settings');
        $settings->user_id = $userId;
        
        // Privacy Settings
        $settings->profile_visibility = 'public'; // public, private, followers
        $settings->tweet_privacy = 'public';
        $settings->message_privacy = 'everyone'; // everyone, followers, none
        $settings->tagging_permission = 'everyone';
        $settings->location_sharing = false;
        $settings->photo_tagging = true;
        $settings->search_by_email = true;
        $settings->search_by_phone = true;
        
        // Notification Settings
        $settings->email_notifications = true;
        $settings->push_notifications = true;
        $settings->sms_notifications = false;
        $settings->like_notifications = true;
        $settings->reply_notifications = true;
        $settings->follow_notifications = true;
        $settings->mention_notifications = true;
        $settings->retweet_notifications = true;
        $settings->message_notifications = true;
        
        // Appearance Settings
        $settings->theme = 'light'; // light, dark, auto
        $settings->font_size = 'medium'; // small, medium, large
        $settings->language = 'ar';
        $settings->timezone = 'Asia/Riyadh';
        
        // Content Settings
        $settings->autoplay_videos = true;
        $settings->data_saver = false;
        $settings->high_quality_images = true;
        $settings->sensitive_content = false;
        
        // Security Settings
        $settings->two_factor_auth = false;
        $settings->login_verification = true;
        $settings->password_reset_email = true;
        
        $settings->created_at = date('Y-m-d H:i:s');
        $settings->updated_at = date('Y-m-d H:i:s');
        
        R::store($settings);
        
        return $settings;
    }
    
    public static function updateSettings($userId, $data) 
    {
        Database::init();
        
        $settings = self::getSettings($userId);
        
        $allowedFields = [
            'profile_visibility', 'tweet_privacy', 'message_privacy', 'tagging_permission',
            'location_sharing', 'photo_tagging', 'search_by_email', 'search_by_phone',
            'email_notifications', 'push_notifications', 'sms_notifications',
            'like_notifications', 'reply_notifications', 'follow_notifications',
            'mention_notifications', 'retweet_notifications', 'message_notifications',
            'theme', 'font_size', 'language', 'timezone',
            'autoplay_videos', 'data_saver', 'high_quality_images', 'sensitive_content',
            'two_factor_auth', 'login_verification', 'password_reset_email'
        ];
        
        foreach ($data as $key => $value) {
            if (in_array($key, $allowedFields)) {
                $settings->$key = $value;
            }
        }
        
        $settings->updated_at = date('Y-m-d H:i:s');
        
        return R::store($settings);
    }
    
    public static function getPrivacySettings($userId) 
    {
        $settings = self::getSettings($userId);
        
        return [
            'profile_visibility' => $settings->profile_visibility,
            'tweet_privacy' => $settings->tweet_privacy,
            'message_privacy' => $settings->message_privacy,
            'tagging_permission' => $settings->tagging_permission,
            'location_sharing' => $settings->location_sharing,
            'photo_tagging' => $settings->photo_tagging,
            'search_by_email' => $settings->search_by_email,
            'search_by_phone' => $settings->search_by_phone,
        ];
    }
    
    public static function getNotificationSettings($userId) 
    {
        $settings = self::getSettings($userId);
        
        return [
            'email_notifications' => $settings->email_notifications,
            'push_notifications' => $settings->push_notifications,
            'sms_notifications' => $settings->sms_notifications,
            'like_notifications' => $settings->like_notifications,
            'reply_notifications' => $settings->reply_notifications,
            'follow_notifications' => $settings->follow_notifications,
            'mention_notifications' => $settings->mention_notifications,
            'retweet_notifications' => $settings->retweet_notifications,
            'message_notifications' => $settings->message_notifications,
        ];
    }
    
    public static function getAppearanceSettings($userId) 
    {
        $settings = self::getSettings($userId);
        
        return [
            'theme' => $settings->theme,
            'font_size' => $settings->font_size,
            'language' => $settings->language,
            'timezone' => $settings->timezone,
        ];
    }
}
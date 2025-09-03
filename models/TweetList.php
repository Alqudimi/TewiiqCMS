<?php

require_once __DIR__ . '/../database/Database.php';

use RedBeanPHP\R;

class TweetList 
{
    public static function create($data) 
    {
        Database::init();
        
        $list = R::dispense('tweet_lists');
        $list->user_id = $data['user_id'];
        $list->name = $data['name'];
        $list->description = $data['description'] ?? '';
        $list->is_private = $data['is_private'] ?? false;
        $list->cover_image = $data['cover_image'] ?? null;
        $list->members_count = 0;
        $list->created_at = date('Y-m-d H:i:s');
        $list->updated_at = date('Y-m-d H:i:s');
        
        return R::store($list);
    }
    
    public static function findById($id) 
    {
        Database::init();
        return R::load('tweet_lists', $id);
    }
    
    public static function getByUserId($userId) 
    {
        Database::init();
        return R::find('tweet_lists', 'user_id = ? ORDER BY created_at DESC', [$userId]);
    }
    
    public static function getPublicLists($limit = 20, $offset = 0) 
    {
        Database::init();
        
        $sql = "
            SELECT l.*, u.username, u.fullname, u.avatar
            FROM tweet_lists l 
            JOIN users u ON l.user_id = u.id 
            WHERE l.is_private = 0
            ORDER BY l.created_at DESC 
            LIMIT ? OFFSET ?
        ";
        
        return R::getAll($sql, [$limit, $offset]);
    }
    
    public static function addMember($listId, $userId) 
    {
        Database::init();
        
        $existing = R::findOne('list_members', 'list_id = ? AND user_id = ?', [$listId, $userId]);
        if ($existing) {
            return false;
        }
        
        $member = R::dispense('list_members');
        $member->list_id = $listId;
        $member->user_id = $userId;
        $member->created_at = date('Y-m-d H:i:s');
        R::store($member);
        
        // Update members count
        $list = R::load('tweet_lists', $listId);
        if ($list->id) {
            $list->members_count = $list->members_count + 1;
            $list->updated_at = date('Y-m-d H:i:s');
            R::store($list);
        }
        
        return true;
    }
    
    public static function removeMember($listId, $userId) 
    {
        Database::init();
        
        $member = R::findOne('list_members', 'list_id = ? AND user_id = ?', [$listId, $userId]);
        if ($member) {
            R::trash($member);
            
            // Update members count
            $list = R::load('tweet_lists', $listId);
            if ($list->id) {
                $list->members_count = max(0, $list->members_count - 1);
                $list->updated_at = date('Y-m-d H:i:s');
                R::store($list);
            }
            
            return true;
        }
        
        return false;
    }
    
    public static function getMembers($listId) 
    {
        Database::init();
        
        $sql = "
            SELECT u.*, lm.created_at as joined_at
            FROM list_members lm 
            JOIN users u ON lm.user_id = u.id 
            WHERE lm.list_id = ?
            ORDER BY lm.created_at DESC
        ";
        
        return R::getAll($sql, [$listId]);
    }
    
    public static function isMember($listId, $userId) 
    {
        Database::init();
        return R::count('list_members', 'list_id = ? AND user_id = ?', [$listId, $userId]) > 0;
    }
    
    public static function update($id, $data, $userId) 
    {
        Database::init();
        
        $list = R::load('tweet_lists', $id);
        
        if (!$list->id || $list->user_id != $userId) {
            return false;
        }
        
        foreach ($data as $key => $value) {
            if (in_array($key, ['name', 'description', 'is_private', 'cover_image'])) {
                $list->$key = $value;
            }
        }
        
        $list->updated_at = date('Y-m-d H:i:s');
        
        return R::store($list);
    }
    
    public static function delete($id, $userId) 
    {
        Database::init();
        
        $list = R::load('tweet_lists', $id);
        
        if ($list->id && $list->user_id == $userId) {
            // Delete all list members first
            R::exec('DELETE FROM list_members WHERE list_id = ?', [$id]);
            R::trash($list);
            return true;
        }
        
        return false;
    }
}
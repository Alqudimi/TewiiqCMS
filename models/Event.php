<?php

require_once __DIR__ . '/../database/Database.php';

use RedBeanPHP\R;

class Event 
{
    public static function create($data) 
    {
        Database::init();
        
        $event = R::dispense('events');
        $event->user_id = $data['user_id'];
        $event->title = $data['title'];
        $event->description = $data['description'] ?? '';
        $event->event_type = $data['event_type'] ?? 'general'; // live, sports, news, general
        $event->start_time = $data['start_time'];
        $event->end_time = $data['end_time'] ?? null;
        $event->is_live = $data['is_live'] ?? false;
        $event->image_url = $data['image_url'] ?? null;
        $event->participants_count = 0;
        $event->location = $data['location'] ?? null;
        $event->hashtags = $data['hashtags'] ?? '';
        $event->created_at = date('Y-m-d H:i:s');
        $event->updated_at = date('Y-m-d H:i:s');
        
        return R::store($event);
    }
    
    public static function findById($id) 
    {
        Database::init();
        return R::load('events', $id);
    }
    
    public static function getLiveEvents() 
    {
        Database::init();
        
        $sql = "
            SELECT e.*, u.username, u.fullname, u.avatar
            FROM events e 
            JOIN users u ON e.user_id = u.id 
            WHERE e.is_live = 1 AND (e.end_time IS NULL OR e.end_time > NOW())
            ORDER BY e.start_time DESC
        ";
        
        return R::getAll($sql);
    }
    
    public static function getUpcomingEvents($limit = 20, $offset = 0) 
    {
        Database::init();
        
        $sql = "
            SELECT e.*, u.username, u.fullname, u.avatar
            FROM events e 
            JOIN users u ON e.user_id = u.id 
            WHERE e.start_time > NOW()
            ORDER BY e.start_time ASC 
            LIMIT ? OFFSET ?
        ";
        
        return R::getAll($sql, [$limit, $offset]);
    }
    
    public static function getEventsByType($type, $limit = 20, $offset = 0) 
    {
        Database::init();
        
        $sql = "
            SELECT e.*, u.username, u.fullname, u.avatar
            FROM events e 
            JOIN users u ON e.user_id = u.id 
            WHERE e.event_type = ?
            ORDER BY e.start_time DESC 
            LIMIT ? OFFSET ?
        ";
        
        return R::getAll($sql, [$type, $limit, $offset]);
    }
    
    public static function joinEvent($eventId, $userId) 
    {
        Database::init();
        
        $existing = R::findOne('event_participants', 'event_id = ? AND user_id = ?', [$eventId, $userId]);
        if ($existing) {
            return false;
        }
        
        $participant = R::dispense('event_participants');
        $participant->event_id = $eventId;
        $participant->user_id = $userId;
        $participant->joined_at = date('Y-m-d H:i:s');
        R::store($participant);
        
        // Update participants count
        $event = R::load('events', $eventId);
        if ($event->id) {
            $event->participants_count = $event->participants_count + 1;
            $event->updated_at = date('Y-m-d H:i:s');
            R::store($event);
        }
        
        return true;
    }
    
    public static function leaveEvent($eventId, $userId) 
    {
        Database::init();
        
        $participant = R::findOne('event_participants', 'event_id = ? AND user_id = ?', [$eventId, $userId]);
        if ($participant) {
            R::trash($participant);
            
            // Update participants count
            $event = R::load('events', $eventId);
            if ($event->id) {
                $event->participants_count = max(0, $event->participants_count - 1);
                $event->updated_at = date('Y-m-d H:i:s');
                R::store($event);
            }
            
            return true;
        }
        
        return false;
    }
    
    public static function isParticipant($eventId, $userId) 
    {
        Database::init();
        return R::count('event_participants', 'event_id = ? AND user_id = ?', [$eventId, $userId]) > 0;
    }
    
    public static function getParticipants($eventId, $limit = 50) 
    {
        Database::init();
        
        $sql = "
            SELECT u.*, ep.joined_at
            FROM event_participants ep 
            JOIN users u ON ep.user_id = u.id 
            WHERE ep.event_id = ?
            ORDER BY ep.joined_at DESC
            LIMIT ?
        ";
        
        return R::getAll($sql, [$eventId, $limit]);
    }
    
    public static function updateLiveStatus($eventId, $isLive) 
    {
        Database::init();
        
        $event = R::load('events', $eventId);
        if ($event->id) {
            $event->is_live = $isLive;
            $event->updated_at = date('Y-m-d H:i:s');
            R::store($event);
            return true;
        }
        
        return false;
    }
    
    public static function search($query, $type = null, $limit = 20, $offset = 0) 
    {
        Database::init();
        
        $sql = "
            SELECT e.*, u.username, u.fullname, u.avatar
            FROM events e 
            JOIN users u ON e.user_id = u.id 
            WHERE (e.title LIKE ? OR e.description LIKE ? OR e.hashtags LIKE ?)
        ";
        
        $params = ["%$query%", "%$query%", "%$query%"];
        
        if ($type) {
            $sql .= " AND e.event_type = ?";
            $params[] = $type;
        }
        
        $sql .= " ORDER BY e.start_time DESC LIMIT ? OFFSET ?";
        $params[] = $limit;
        $params[] = $offset;
        
        return R::getAll($sql, $params);
    }
}
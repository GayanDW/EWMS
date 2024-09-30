<?php

namespace App\Models;

use CodeIgniter\Model;

class NotificationModel extends Model {
    protected $table = 'user_notifications';
    protected $primaryKey = 'notification_id';
    protected $allowedFields = ['UserId','UserType', 'item_id', 'message', 'is_read', 'created_at'];

    // Add a new notification
    public function addNotification($userId, $itemId, $message) {
        $data = [
            'UserId' => $userId,
            'item_id' => $itemId,
            'message' => $message
        ];
        return $this->insert($data);
    }

    // Retrieve notifications for a specific user
    public function getNotificationsForUser($userId) {
        return $this->where('UserId', $userId)->orderBy('created_at', 'DESC')->findAll();
    }

    // Retrieve unread notifications for a specific user
    public function getUnreadNotificationsForUser($userId) {
        return $this->where('UserId', $userId)->where('is_read', 0)->orderBy('created_at', 'DESC')->findAll();
    }

    // Mark a notification as read
    public function markAsRead($notificationId) {
        return $this->update($notificationId, ['is_read' => 1]);
    }
}

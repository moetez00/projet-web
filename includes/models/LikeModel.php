<?php
/*
 * includes/models/LikeModel.php
 * ------------------------------
 * OOP model for the `like` join table (student likes event).
 * Connects to: database/schema.sql → like
 *
 * Methods:
 *   like($studentId, $eventId)
 *   unlike($studentId, $eventId)
 *   hasLiked($studentId, $eventId)
 *   getLikedEvents($studentId)
 */

class LikeModel {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function like($studentId, $eventId) {
        $stmt = $this->conn->prepare("INSERT IGNORE INTO `like` (student_id, event_id) VALUES (?, ?)");
        $stmt->bind_param("ii", $studentId, $eventId);
        $stmt->execute();
    }

    public function unlike($studentId, $eventId) {
        $stmt = $this->conn->prepare("DELETE FROM `like` WHERE student_id = ? AND event_id = ?");
        $stmt->bind_param("ii", $studentId, $eventId);
        $stmt->execute();
    }

    public function hasLiked($studentId, $eventId) {
        $stmt = $this->conn->prepare("SELECT 1 FROM `like` WHERE student_id = ? AND event_id = ?");
        $stmt->bind_param("ii", $studentId, $eventId);
        $stmt->execute();
        return $stmt->get_result()->num_rows > 0;
    }

    public function getLikedEvents($studentId) {
        $stmt = $this->conn->prepare("
            SELECT e.* FROM `like` l
            JOIN event e ON l.event_id = e.id
            WHERE l.student_id = ?
            AND e.event_date >= NOW()
            ORDER BY e.event_date ASC
        ");
        $stmt->bind_param("i", $studentId);
        $stmt->execute();
        return $stmt->get_result();
    }
}
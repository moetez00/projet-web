<?php
/*
 * includes/models/EventModel.php
 * --------------------------------
 * OOP model for the `event` table.
 * Connects to: database/schema.sql → event JOIN club
 *
 * Methods:
 *   create($clubId, $title, $description, $eventDate, $location, $image)
 *   findById($id)
 *   getByClub($clubId)
 *   getRecent($limit)
 *   getLikeCount($eventId)
 */
class EventModel {
    private $db;

    public function __construct($connection) {
        $this->db = $connection;
    }

    public function create($clubId, $title, $description, $eventDate, $location, $image) {
        $stmt = $this->db->prepare('INSERT INTO event (club_id, title, description, event_date, location, image) VALUES (?, ?, ?, ?, ?, ?)');
        $stmt->bind_param("isssss", $clubId, $title, $description, $eventDate, $location, $image);
        return $stmt->execute();
    }

    public function findById($id) {
        $stmt = $this->db->prepare('SELECT * FROM event WHERE id = ?');
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function getByClub($clubId) {
        $stmt = $this->db->prepare('SELECT * FROM event WHERE club_id = ? ORDER BY event_date DESC');
        $stmt->bind_param("i", $clubId);
        $stmt->execute();
        return $stmt->get_result();
    }

    public function getRecent($limit) {
        $stmt = $this->db->prepare('SELECT * FROM event ORDER BY event_date DESC LIMIT ?');
        $stmt->bind_param("i", $limit);
        $stmt->execute();
        return $stmt->get_result();
    }

    public function getLikeCount($eventId) {
        // Placeholder for like count logic
        return 0;
    }
}
<?php
class ClubModel {
    private $db;

    public function __construct($connection) {
        $this->db = $connection;
    }
    public function createClub($newUserID, $CLUBNAME){
        $stmt = $this->db->prepare('INSERT INTO club (user_id, name) VALUES (?, ?)');
        $stmt->bind_param("i", $newUserID, $CLUBNAME); 
        return $stmt->execute();
    }

    public function findById($id) {
        $sql = "SELECT c.*, u.username, u.profile_img, u.email 
                FROM club c 
                JOIN user u ON c.user_id = u.id 
                WHERE u.id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function getEvents($club_id) {
        $sql = "SELECT * FROM event WHERE club_id = ? ORDER BY event_date DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $club_id);
        $stmt->execute();
        return $stmt->get_result();
    }
}

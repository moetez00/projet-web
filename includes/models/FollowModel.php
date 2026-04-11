<?php
/*
 * includes/models/FollowModel.php
 * ---------------------------------
 * OOP model for the `follow` join table (student follows club).
 * Connects to: database/schema.sql → follow
 *
 * Methods:
 *   follow($studentId, $clubId)
 *   unfollow($studentId, $clubId)
 *   isFollowing($studentId, $clubId)
 *   getFollowedClubs($studentId)
 */?>
<?php
class FollowModel {
    private $db;

    public function __construct($connection) {
        $this->db = $connection;
    }

    /*public function getFollowedClubs($studentId) {
        $stmt = $this->db->prepare(
            'SELECT c.*, u.username, u.profile_img
             FROM follow f
             JOIN club c ON f.club_id = c.id
             JOIN user u ON c.user_id = u.id
             WHERE f.student_id = ?'
        );
        $stmt->bind_param("i", $studentId);
        $stmt->execute();
        return $stmt->get_result();
    }*/
    public function follow($studentId, $clubId) {
        $stmt = $this->db->prepare(
            'INSERT INTO follow (student_id, club_id) VALUES (?, ?)'
        );
        $stmt->bind_param("ii", $studentId, $clubId);
        $stmt->execute();
    }

}
?>
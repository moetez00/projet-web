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
 */
class FollowModel{
    private $db; 
    public function __construct($db){
        $this->db=$db;
    } 
    public function follow($student_id,$club_id){
    $query="insert into follow(student_id,club_id) values(?,?)";
    $stmt=$this->db->prepare($query);
    $stmt->bind_param("ii",$student_id,$club_id);
    return $stmt->execute();
   }
   public function unfollow($student_id,$club_id){
    $stmt=$this->db->prepare("delete from follow where student_id=? and club_id=?");
    $stmt->bind_param("ii",$student_id,$club_id);
    return $stmt->execute();
   }
   public function isFollowing($student_id,$club_id){
    $stmt=$this->db->prepare("select * from follow where student_id=? and club_id=?");
    $stmt->bind_param("ii",$student_id,$club_id);
    $stmt->execute();
    if ($stmt->get_result()->num_rows > 0) {
        return true;
    }
    else{
        return false;
    }
   }
public function getFollowedClubs($student_id) {
    $sql = "SELECT c.* FROM club c 
            JOIN follow f ON c.user_id = f.club_id 
            WHERE f.student_id = ?";
            
    $stmt = $this->db->prepare($sql);
    $stmt->bind_param("i", $student_id);
    $stmt->execute();
    return $stmt->get_result();
}
   public function getFollowingStudents($club_id) {
    $sql = "SELECT s.* FROM student s 
            JOIN `follow` f ON s.user_id = f.student_id 
            WHERE f.club_id = ?";
            
    $stmt = $this->db->prepare($sql);
    $stmt->bind_param("i", $club_id);
    
    $stmt->execute();
    $result = $stmt->get_result();
    
    return $result; 
}
}
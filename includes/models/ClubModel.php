<?php
class ClubModel
{
    private $db;

    public function __construct($connection)
    {
        $this->db = $connection;
    }
    public function createClub($newUserID, $CLUBNAME)
    {
        $stmt = $this->db->prepare('INSERT INTO club (user_id, name) VALUES (?, ?)');
        $stmt->bind_param("is", $newUserID, $CLUBNAME);
        return $stmt->execute();
    }
    /*public function createClub($newUserID, $CLUBNAME){
        $stmt = $this->db->prepare('INSERT INTO club (user_id, name) VALUES (?, ?)');
        $stmt->bind_param("is", $newUserID, $CLUBNAME); 
        return $stmt->execute();
    } */

    public function findById($id)
    {
        $sql = "SELECT c.*, u.username, u.profile_img, u.email 
                FROM club c 
                JOIN user u ON c.user_id = u.id 
                WHERE u.id = ?";

        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();

        return $stmt->get_result()->fetch_assoc();
    }

    public function getEvents($club_id)
    {
        $sql = "SELECT * FROM event WHERE club_id = ? ORDER BY event_date DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $club_id);
        $stmt->execute();
        return $stmt->get_result();
    }
    public function addEvent($club_id, $title, $description, $event_date, $place, $image) {
        $sql = "INSERT INTO event (club_id, title, description, event_date, place, image) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $this->db->prepare($sql); 
        $stmt->bind_param("isssss", $club_id, $title, $description, $event_date, $place, $image); // Utilise $image
        return $stmt->execute(); 
}
    public function editClub($clubId, $newName, $newDescription, $category, $coverImg, $newProfileImg)
    {
        if ($coverImg != null && $newProfileImg == null) {
            $sql = "update club set name=?, description=?, category=?, cover_img=? where user_id=?";
            $stmt = $this->db->prepare($sql);
            $stmt->bind_param("ssssi", $newName, $newDescription, $category, $coverImg, $clubId);
            return $stmt->execute();
        }
        if ($newProfileImg != null && $coverImg == null) {
            $sql = "update club set name=?, description=?, category=? where user_id=?; ";
            $stmt = $this->db->prepare($sql);
            $stmt->bind_param("sssi", $newName, $newDescription, $category, $clubId);
            $sql2 = "update user set profile_img=? where id=?";
            $stmt2 = $this->db->prepare($sql2);
            $stmt2->bind_param("si", $newProfileImg, $clubId);

            return $stmt->execute()&& $stmt2->execute();
        } else if ($newProfileImg != null && $coverImg != null) {
            $sql = "update club set name=?, description=?, category=?, cover_img=? where user_id=?";
            $stmt = $this->db->prepare($sql);
            $stmt->bind_param("ssssi", $newName, $newDescription, $category, $coverImg, $clubId);
            $sql2 = "update user set profile_img=? where id=?";
            $stmt2 = $this->db->prepare($sql2);
            $stmt2->bind_param("si", $newProfileImg, $clubId);
            
            return $stmt->execute() && $stmt2->execute();
        } else {
            $sql = "update club set name=?, description=?, category=? where user_id=?";
            $stmt = $this->db->prepare($sql);
            $stmt->bind_param("sssi", $newName, $newDescription, $category, $clubId);
            return $stmt->execute();
        }
    }
}

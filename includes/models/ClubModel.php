<?php

class ClubModel {
    private $db;

    public function __construct($connection) {
        $this->db = $connection;
    }

    public function createClub($newUserID, $CLUBNAME){
        $stmt = $this->db->prepare('INSERT INTO club (user_id, name) VALUES (?, ?)');
        $stmt->bind_param("is", $newUserID, $CLUBNAME); 
        return $stmt->execute();
    }




}

<?php

class StudentModel {
    private $db;

    public function __construct($connection) {
        $this->db = $connection;
    }

    public function createStudent($newUserID, $STUDENTNAME){
        $stmt = $this->db->prepare('INSERT INTO student (user_id, fullName) VALUES (?, ?)');
        $stmt->bind_param("is", $newUserID, $STUDENTNAME); 
        return $stmt->execute();
    }


}

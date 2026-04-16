<?php

class StudentModel {
    private $db;

    public function __construct($connection) {
        $this->db = $connection;
    }

    public function findById($student_id) {
        // Ajout de u.profile_img car il est dans la table user selon ton SQL
        $stmt = $this->db->prepare("SELECT s.*, u.email, u.profile_img FROM student s JOIN user u ON s.user_id = u.id WHERE s.user_id = ?");
        $stmt->bind_param("i", $student_id);
        $stmt->execute(); // On exécute d'abord
        $result = $stmt->get_result(); // On récupère le résultat après
        return $result->fetch_assoc();
    }

    public function createStudent($newUserID, $STUDENTNAME) {
        $stmt = $this->db->prepare('INSERT INTO student (user_id, fullName) VALUES (?, ?)');
        $stmt->bind_param("is", $newUserID, $STUDENTNAME); 
        return $stmt->execute();
    }

    public function editProfile($student_id, $newProfileImage, $newName, $newMajor, $newBirthday) {
        if ($newProfileImage == null) {
            $sql = "UPDATE student SET fullname=?, major=?, birthday=? WHERE user_id=?";
            $stmt = $this->db->prepare($sql);
            // 3 strings (name, major, birthday) et 1 integer (id) -> "sssi"
            $stmt->bind_param("sssi", $newName, $newMajor, $newBirthday, $student_id);
            return $stmt->execute();
        } else {
            // Update table student
            $stmt1 = $this->db->prepare("UPDATE student SET fullname=?, major=?, birthday=? WHERE user_id=?");
            $stmt1->bind_param("sssi", $newName, $newMajor, $newBirthday, $student_id);
            
            // Update table user (car l'image est là-bas dans ton SQL)
            $stmt2 = $this->db->prepare("UPDATE user SET profile_img=? WHERE id=?");
            $stmt2->bind_param("si", $newProfileImage, $student_id);
            
            // Exécution avec les $ manquants et vérification des deux
            return $stmt1->execute() && $stmt2->execute();
        }
    }
}
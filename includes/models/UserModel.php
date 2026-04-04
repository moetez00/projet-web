<?php
/*
 * includes/models/UserModel.php
 * ------------------------------
 * OOP model for the `user` table (base account shared by students and clubs).
 * Handles authentication logic: email lookup and password verification.
 * Connects to: database/schema.sql → user
 *
 * Methods:
 *   findByEmail($email)
 *   create($email, $password, $role)
 *   verifyPassword($plain, $hash)
 *   updateAvatar($id, $path)
 */

class UserModel {
    private $db;

    public function __construct($connection) {
        $this->db = $connection;
    }

    public function findByEmailANDpassword($email,$password) {
        $stmt = $this->db->prepare('SELECT * FROM user WHERE email = ? and password = ?');
        
        $stmt->bind_param("ss", $email, $password);
        $stmt->execute();
        return $stmt->get_result();
    }


}
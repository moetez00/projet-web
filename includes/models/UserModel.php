<?php

class UserModel {
    private $db;

    public function __construct($connection) {
        $this->db = $connection;
    }

    /*finds user by a combo of email and password , nest7a99ouha fel login*/
    public function findByEmailANDpassword($email,$password) {
        $stmt = $this->db->prepare('SELECT * FROM user WHERE email = ? and password = ?');
        $stmt->bind_param("ss", $email, $password);
        $stmt->execute();
        return $stmt->get_result();
    }
    /* creates a user by a combo of parameters , nest7a99ouha fel registration*/
    public function createUser($STUDENTUSERNAME, $STUDENTEMAIL, $STUDENTPASSWORD,$role){

        $stmt = $this->db->prepare('INSERT INTO user (username, email, password,role) VALUES (?, ?, ?,?)');
        $stmt->bind_param("ssss", $STUDENTUSERNAME, $STUDENTEMAIL, $STUDENTPASSWORD,$role);
        return $stmt->execute();
    }

    public function findByUsername($username) {
        $stmt = $this->db->prepare('SELECT * FROM user WHERE username = ? ');
        $stmt->bind_param("s", $username);
        $stmt->execute();
        return $stmt->get_result();
    }
    public function findByEmail($email) {
        $stmt = $this->db->prepare('SELECT * FROM user WHERE email = ? ');
        $stmt->bind_param("s", $email);
        $stmt->execute();
        return $stmt->get_result();
    }

}
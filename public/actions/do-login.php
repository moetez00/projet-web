<?php
    session_start();

    require  '../../includes/db.php';
    require '../../includes/autoloader.php';
    

    $email = $_POST['email'];
    $password = md5($_POST['password']);
    /*if (!isset($connection) || $connection === null) {
        die("Error: The connection variable is missing. Check includes/db.php");
    }*/
    $user = new UserModel($connection);

    $result = $user->findByEmailANDpassword($email,$password);

    if ($result->num_rows === 0) {
        $_SESSION['login_error'] = 'Email or Password is incorrect';

        header('Location: ../login.php');
    }
    else if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
        if ($user['role'] !== 'club_NotConfirmed') {
            $_SESSION['user'] = $user;
            header('location:../index.php');
        }
        else {
            $_SESSION['login_error'] = 'Your account is not yet confirmed.';
            header('Location: ../login.php');
        }
    }

?>
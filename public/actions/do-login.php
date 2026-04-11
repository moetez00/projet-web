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
        if ($user['role'] == 'club_NotConfirmed') {
             $_SESSION['login_error'] = 'Your account is not yet confirmed.';
            header('Location: ../login.php');
        }
        else if($user['role'] === 'student'){
            $_SESSION['user'] = $user;//returned not just the username but all the info about the user so if we access the role it should be $_SESSION['user']['role']
            header('location:../index.php');
        }
        else if($user['role'] === 'club_Confirmed'){
            $_SESSION['user'] = $user;//returned not just the username but all the info about the user so if we access the role it should be $_SESSION['user']['role']
            header('location:../club.php');
        }
        else {
            //kenou admin narach chisir haha
        }
    }

?>
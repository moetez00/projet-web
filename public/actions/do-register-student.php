<?php

    session_start();

    require  '../../includes/db.php';
    require '../../includes/autoloader.php';

    $user = new UserModel($connection);

    $STUDENTNAME=$_POST['fullname'];
    $STUDENTEMAIL=$_POST['email'];
    $STUDENTPASSWORD=md5($_POST['password']);
    $STUDENTREPEATEDPASSWORD=md5($_POST['repeat-password']);
    $STUDENTUSERNAME = $_POST['username'];
    $role = 'student';

    if(strcmp($STUDENTPASSWORD, $STUDENTREPEATEDPASSWORD) == 0) {
        if($user->findByEmail($STUDENTEMAIL)->num_rows === 0){
            if($user->findByUsername($STUDENTUSERNAME)->num_rows === 0){
                if($user->createUser($STUDENTUSERNAME, $STUDENTEMAIL, $STUDENTPASSWORD,$role)) {

                    $newUserID = $connection->insert_id;
                    $student = new StudentModel($connection);
                    
                    if($student->createStudent($newUserID, $STUDENTNAME)) {
                        header('location:../login.php');
                    } else {
                        echo "Error creating STUDENT entry: " . $connection->error;
                    }
                }
            }
            else{
                $_SESSION['username_error'] = 'This username is already used.';
                header('Location: ../register-student.php');
            }
            
        
        } 
        else{
            $_SESSION['email_error'] = 'This email is linked to another account.';
            header('Location: ../register-student.php');
        }
    }
    else{
        $_SESSION['password_error'] = 'Passwords not matching.';
        header('Location: ../register-student.php');
    }
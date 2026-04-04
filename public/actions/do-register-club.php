 <?php

    session_start();

    require  '../../includes/db.php';
    require '../../includes/autoloader.php';

    $user = new UserModel($connection);


    $CLUBNAME=$_POST['clubname'];
    $CLUBEMAIL=$_POST['email'];
    $CLUBPASSWORD=md5($_POST['password']);
    $CLUBREPEATEDPASSWORD=md5($_POST['repeat-password']);
    $CLUBUSERNAME = strtolower(str_replace(' ', '', $CLUBNAME));
    $role = 'club_NotConfirmed';


    if(strcmp($CLUBPASSWORD, $CLUBREPEATEDPASSWORD) == 0) {
        if($user->findByEmail($CLUBEMAIL)->num_rows === 0){
            if($user->findByUsername($CLUBUSERNAME)->num_rows === 0){
                if($user->createUser($CLUBUSERNAME, $CLUBEMAIL, $CLUBPASSWORD,$role)) {

                    $newUserID = $connection->insert_id;
                    $Club = new ClubModel($connection);
                    
                    if($Club->createClub($newUserID, $CLUBNAME)) {
                        header('location:../login.php');
                    } else {
                        echo "Error creating CLUB entry: " . $connection->error;
                    }
                }
            }
            else{
                $_SESSION['username_error'] = 'This club is already registered.';
                header('Location: ../register-club.php');
            }
            
        
        } 
        else{
            $_SESSION['email_error'] = 'This email is linked to another account.';
            header('Location: ../register-club.php');
        }
    }
    else{
        $_SESSION['password_error'] = 'Passwords not matching.';
        header('Location: ../register-club.php');
    }
    
?>
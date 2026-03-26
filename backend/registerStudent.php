<?php

require  './connection.php';

$STUDENTNAME=$_POST['fullname'];
$STUDENTEMAIL=$_POST['email'];
$STUDENTPASSWORD=md5($_POST['password']);
$STUDENTREPEATEDPASSWORD=md5($_POST['repeat-password']);
$STUDENTUSERNAME = $_POST['username'];

if(strcmp($STUDENTPASSWORD, $STUDENTREPEATEDPASSWORD) == 0) {

    $stmt1 = $connection->prepare('INSERT INTO USER (username, email, password, registerDate) VALUES (?, ?, ?, ?)');
    $date = date('Y-m-d');
    

    $stmt1->bind_param("ssss", $STUDENTUSERNAME, $STUDENTEMAIL, $STUDENTPASSWORD, $date);
    
    if($stmt1->execute()) {

        $newUserID = $connection->insert_id; 


        $stmt2 = $connection->prepare('INSERT INTO STUDENT (id, fullName) VALUES (?, ?)');
        $stmt2->bind_param("is", $newUserID, $STUDENTNAME); 
        
        if($stmt2->execute()) {
            header('location:../frontend/login/index.html');
        } else {
            echo "Error creating STUDENT entry: " . $connection->error;
        }
    } else {
        echo "Error creating user: " . $connection->error;
    }
}

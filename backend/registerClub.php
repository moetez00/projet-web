<?php

require  './connection.php';

$CLUBNAME=$_POST['clubname'];
$CLUBEMAIL=$_POST['email'];
$CLUBPASSWORD=md5($_POST['password']);
$CLUBREPEATEDPASSWORD=md5($_POST['repeat-password']);
$CLUBUSERNAME = strtolower(str_replace(' ', '', $CLUBNAME));

if(strcmp($CLUBPASSWORD, $CLUBREPEATEDPASSWORD) == 0) {


    $stmt1 = $connection->prepare('INSERT INTO USER (username, email, password, registerDate) VALUES (?, ?, ?, ?)');
    $date = date('Y-m-d');

    $stmt1->bind_param("ssss", $CLUBUSERNAME, $CLUBEMAIL, $CLUBPASSWORD, $date);
    
    if($stmt1->execute()) {

        $newUserID = $connection->insert_id; 

        $stmt2 = $connection->prepare('INSERT INTO CLUB (id, clubName) VALUES (?, ?)');
        $stmt2->bind_param("is", $newUserID, $CLUBNAME); 
        
        if($stmt2->execute()) {
            header('location:../frontend/login/index.html');
        } else {
            echo "Error creating club entry: " . $connection->error;
        }
    } else {
        echo "Error creating user: " . $connection->error;
    }
}

$connection->close();

?>
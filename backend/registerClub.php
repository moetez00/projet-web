<?php

require  './connection.php';

$CLUBNAME=$_POST['clubname'];
$CLUBEMAIL=$_POST['email'];
$CLUBPASSWORD=md5($_POST['password']);
$CLUBREPEATEDPASSWORD=md5($_POST['repeat-password']);
$CLUBUSERNAME = strtolower(str_replace(' ', '', $CLUBNAME));

if(strcmp($CLUBPASSWORD, $CLUBREPEATEDPASSWORD) == 0) {

    // 1. Insert into USER table
    $stmt1 = $connection->prepare('INSERT INTO USER (username, email, password, registerDate) VALUES (?, ?, ?, ?)');
    $date = date('Y-m-d');
    
    // "ssss" means 4 strings
    $stmt1->bind_param("ssss", $CLUBUSERNAME, $CLUBEMAIL, $CLUBPASSWORD, $date);
    
    if($stmt1->execute()) {
        // 2. GET THE NEW USER ID (Crucial step!)
        $newUserID = $connection->insert_id; 

        // 3. Insert into CLUB table using that ID
        $stmt2 = $connection->prepare('INSERT INTO CLUB (id, clubName) VALUES (?, ?)');
        $stmt2->bind_param("is", $newUserID, $CLUBNAME); // "is" = integer, string
        
        if($stmt2->execute()) {
            echo "Success! Club registered with User ID: " . $newUserID;
        } else {
            echo "Error creating club entry: " . $connection->error;
        }
    } else {
        echo "Error creating user: " . $connection->error;
    }
}

$connection->close();

?>
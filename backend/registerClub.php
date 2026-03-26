<?php

require  './connection.php';

$CLUBNAME=$_POST['clubname'];
$CLUBEMAIL=$_POST['email'];
$CLUBPASSWORD=md5($_POST['password']);
$CLUBREPEATEDPASSWORD=md5($_POST['repeat-password']);
$CLUBUSERNAME = strtolower(str_replace(' ', '', $CLUBNAME));

if(strcmp($CLUBPASSWORD,$CLUBREPEATEDPASSWORD)==0){

    $stmt1 = $connection->prepare('INSERT INTO USER (username,email,password,registerDate) VALUES (?,?,?,?) ');
    $result=$stmt1->execute(array($CLUBUSERNAME,$CLUBEMAIL,$CLUBPASSWORD,date('Y-m-d')));
    $logged=(mysqli_num_rows($result)==1) ? true : false;
    echo $logged;
    $stmt2 = $connection->prepare('INSERT INTO CLUB (id,clubName) VALUES (?,?)');

}

$connection->close();

?>
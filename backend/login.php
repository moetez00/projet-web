<?php
require  './connection.php';
$usernameORemail = $_POST['usernameORemail'];
$password = md5($_POST['password']);

$stmt = $connection->prepare('SELECT * FROM USER WHERE (email = ? OR username = ?) AND password = ?');
$stmt->bind_param("sss", $usernameORemail, $usernameORemail, $password);

$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo 'Email or Password is incorrect';
}
else if ($result->num_rows === 1) {
    header('location:../frontend/feed/index.html');
}

?>


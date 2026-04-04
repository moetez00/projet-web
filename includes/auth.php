<?php
/*
 * includes/auth.php
 * -----------------
 * Session management helpers.
 * Provides: isLoggedIn(), requireLogin(), getCurrentUser(), getRole().
 * Starts the session; pages include this file to enforce authentication.
 * Used by: all public/*.php pages and all actions/*.php
 */

/*nediwelha fi awwel koll page bech nthabtou sar log in walla*/
function checkAuth(){
    if (!isset($_SESSION)) {
        session_start();
    }
    
    require_once 'autoloader.php';
    if (!isLoggedIn()) {
        requireLogin();
    }
    
}
/*tverifi logged in walla ,AKA famma session 9dima walla */
function isLoggedIn(){
    $user = $_SESSION['user'];
    if (!isset($user)){ return false;}
    else {return true;}
}

/*thezzek ta3mel log in kenek makch logged in*/
function requireLogin(){
    if (!isLoggedIn()){
        header('location:../public/login.php');
        }
}
function getRole(){
    return $_SESSION['user']['role'];
}
?>


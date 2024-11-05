<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
} 
if (isset($_SESSION['user_id'])) {
    $_SESSION = array();
    session_destroy();
    header("Location: index.php");
    exit();
} 
?>

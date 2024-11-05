<?php
$host = 'localhost'; 
$username = 'kareem'; 
$password = 'kareem';
$dbname = 'blog_app'; 


$conn = new mysqli($host, $username, $password, $dbname );

if ($conn->connect_error) {
    die("The Connection failed: " . $conn->connect_error);
}
?>

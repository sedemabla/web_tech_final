<?php
$servername = 'localhost'; 
$username = 'sedem.agudetse';
$password = 'Thebrownbag04,!!';
$dbname = 'webtech_fall2024_sedem_agudetse';

// Create a connection
$conn = mysqli_connect($servername,$username,$password,$dbname) or die("Couldn't connect to database");

// Check connection with detailed error
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} else {
    $connection = $conn;
}

$connection->set_charset("utf8");
?>

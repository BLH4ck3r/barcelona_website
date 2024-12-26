<?php
$host = 'localhost';
$db = 'barcelona_website';
$user = 'd1ckh4ck3r';
$password = '12345678';
$conn = new mysqli($host, $user, $password, $db);

if ($conn->connect_error) {
    die('Error de conexión: ' . $conn->connect_error);
}
?>

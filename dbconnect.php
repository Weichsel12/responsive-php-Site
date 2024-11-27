<?php
$servername = "localhost";
$username = "root";
$password = "391S=O9/mJm+";
$dbname = "db_immo";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
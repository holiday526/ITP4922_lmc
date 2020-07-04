<?php

$db_hostname = "192.168.1.100";
$db_username = "root";
$db_password = "2fi@Solutions";
$db_database = "autocardb";
$conn = new mysqli($db_hostname, $db_username, $db_password, $db_database);

if ($conn->connect_errno) {
    die("Could not connect MySQL: " . $conn->connect_error);
}
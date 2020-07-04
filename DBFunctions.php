<?php

function getDbConn() {
    $db_hostname = "192.168.1.100";
    $db_username = "root";
    $db_password = "2fi@Solutions";
    $db_database = "autocardb";
    $conn = new mysqli($db_hostname, $db_username, $db_password, $db_database);
    if ($conn->connect_errno) {
        return die("Could not connect MySQL: " . $conn->connect_error);
    }
    return $conn;
}

function get($query) {
    $conn = getDbConn();
    $collection = [];
    $result = $conn->query($query);
    while ($row = $result->fetch_assoc()) {
        array_push($collection, $row);
    }
    mysqli_close($conn);
    return $collection;
}

function dd($collection) {
    echo "<pre>";
    var_dump($collection);
    echo "</pre>";
}

/** admins */
function getAllAdmins() {
    $query = "SELECT * FROM `admins`";
    return get($query);
}

/** appointments */
// for admins
function getAppointments($user_id = "") {
    $query = 'SELECT * FROM `appointments`';
    if ($user_id != "") {
        $query = $query." WHERE appointmentUserId = '$user_id'";
    }
    return get($query);
}

/** cars */
function getCars($user_id = "") {
    $query = 'SELECT * FROM `cars`';
    if ($user_id != "") {
        $query = $query." WHERE ownerId = '$user_id'";
    }
    return get($query);
}

/** car_brands */
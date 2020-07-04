<?php

require 'dbconn.php';

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
    while ($row = $result->fetch_array(MYSQLI_NUM)) {
        array_push($collection, $row);
    }
    mysqli_close($conn);
    return $collection;
}

/** admins */
function getAllAdmins() {
    $query = "SELECT * FROM `admins`";
    return get($query);
}

/** appointments */
// for admins
function getAllAppointments($user_id = "A000002") {

    $query = "SELECT * FROM `appointments`";
    if ($user_id) {
        $query." WHERE appointmentUserId = \'$user_id\'";
    }
    echo $query;
    return get($query);
}

/** cars */

/** car_brands */
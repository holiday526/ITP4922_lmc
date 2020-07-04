<?php

require 'dbconn.php';

/** admins */
function getAllAdmins() {
    global $conn;
    $collection = [];
    $query = "SELECT * FROM admins";
    $result = $conn->query($query);
    while ($row = $result->fetch_array(MYSQLI_NUM)) {
        array_push($collection, $row);
    }
    mysqli_close($conn);
    return $collection;
}

/** appointments */

/** cars */

/** car_brands */
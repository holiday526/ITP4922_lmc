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

function where($query, $where_array) {
    $first = true;
    foreach ($where_array as $key => $value) {
        if ($first) {
            $query = $query." WHERE $key = '$value'";
            $first = false;
        } else {
            $query = $query." AND $key = '$value'";
        }
    }
    return $query;
}

// $orderby_array = ['columnName' => 'ASC|DESC']
function orderBy($query, $orderby_array) {
    $first = true;
    foreach ($orderby_array as $key => $value) {
        if ($first) {
            $query = $query." ORDER BY $key $value";
            $first = false;
        } else {
            $query = $query." , $key $value";
        }
    }
    return $query;
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


/** customers */
function getCustomers($user_details = []) {
    $query = 'SELECT * FROM `customers`';
    if (!empty($user_details)) {
        $query = where($query, $user_details);
    }
    echo $query;
    return get($query);
}

/** orders */
function getOrders($user_details = []) {
    $query = 'SELECT * FROM `orders`';
    if (!empty($user_details)) {
        $query = where($query, $user_details);
    }
    return get($query);
}

function queryBuilder($table, $select_array = ['*'], $where_array = [], $orderby_array = []) {
    $query = "SELECT * FROM $table";
    if (!empty($details)) {
        $query = where($query, $details);
    }
    if (!empty($orderby_array)) {
        $query = orderBy($query, $orderby_array);
    }
    // TODO: this query
}

function test() {
    $query = "SELECT * FROM `admins` ";
    $id = 'id';
    $arr = ['id'=>'A000001'];
//    $query = $query." WHERE $id = ? ";
    $stmt = getDbConn()->prepare($query);
    $params_types = "";
    foreach ($arr as $key => $value) {
        switch (gettype($value)) {
            case "string": $params_types = $params_types."s"; break;
            case "integer": $params_types = $params_types."i"; break;
            case "double": $params_types = $params_types."d"; break;
            default: $params_types = $params_types."s"; break;
        }
    }
//    $stmt->bind_param($params_types, $arr['id']);
//    $stmt->execute();
    if (!$stmt->execute()) {
        echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
    }
    $result = $stmt->get_result();
    echo var_dump($result);
    while ($row = $result->fetch_assoc()) {
        echo var_dump($row);
    }
    $stmt->close();
}

function test2() {
    $dbh = new PDO(
        'mysql:host=192.168.1.100;dbname=autocardb;charset=utf8mb4',
        'root',
        '2fi@Solutions'
    );
    $id = 'id';
    $sth = $dbh->prepare("SELECT * FROM `admins` WHERE $id = ?");
    $sth->execute(['A000002']);
    return $sth->fetchAll();
}

function getPdo() {
    $dbh = new PDO(
        'mysql:host=192.168.1.100;dbname=autocardb;charset=utf8mb4',
        'root',
        '2fi@Solutions'
    );
    return $dbh;
}

function queryBuilderPrepare($table, $select_array, $where_array = [], $orderby_array) {
    $selector = "";
    if ($select_array[0] == '*') {
        $selector = "*";
    }
    $query = "SELECT ";
}

function prepareWhere($query, $where_array ) {

}

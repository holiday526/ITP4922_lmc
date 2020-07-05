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

function queryBuilderPrepare($table, $select_array, $where_array = [], $orderby_array = []) {

    $selector = "";
    if ($select_array[0] == '*') {
        $selector = "*";
    } else {
        $first = true;
        foreach ($select_array as $value) {
            if ($first) {
                $selector = $value;
                $first = false;
            } else {
                $selector = $selector.", $value";
            }
        }
    }

    $query = "SELECT $selector FROM $table";

    $bind_array = [];
    if (!empty($where_array)) {
        $first = true;
        foreach ($where_array as $key => $value) {
            if ($first) {
                $query = $query." WHERE $key = ?";
                array_push($bind_array, $value);
                $first = false;
            } else {
                $query = $query." AND $key = ?";
                array_push($bind_array, $value);
            }
        }
    }

    $sth = getPdo()->prepare($query);
    if (!empty($bind_array)) {
        $sth->execute($bind_array);
    } else {
        $sth->execute();
    }

    return $sth->fetchAll();
}

function prepareWhere($query, $where_array) {

}

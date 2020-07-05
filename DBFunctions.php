<?php

function dd($collection) {
    echo "<pre>";
    var_dump($collection);
    echo "</pre>";
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

    if (!empty($orderby_array)) {
        $first = true;
        foreach ($orderby_array as $key => $value) {
            if ($first) {
                $query = $query." ORDER BY ? ?";
                array_push($bind_array, $key);
                array_push($bind_array, $value);
                $first = false;
            } else {
                $query = $query." AND ? ?";
                array_push($bind_array, $key);
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
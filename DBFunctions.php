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

function queryBuilderPrepare($table, $select_array, $where_array = [], $orderby_array = [], $inner_join_array = [], $limit = -1) {

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

    $bind_array = [];

    $query = "SELECT $selector FROM $table";
    if (!empty($inner_join_array)) {
        foreach ($inner_join_array as $array) {
            $query = $query." INNER JOIN $array[0] ON $array[1] = $array[2] ";
        }
    }

    if (!empty($where_array)) {
        $first = true;
        foreach ($where_array as $key => $value) {
            $temp_in_str = "";
            $in_first = true;
            if (is_array($value)) {
                $temp_in_str = "(";
                foreach ($value as $v) {
                    if ($in_first) {
                        $temp_in_str = $temp_in_str."?";
                        $in_first = false;
                    } else {
                        $temp_in_str = $temp_in_str.",?";
                    }
                }
                $temp_in_str = $temp_in_str.")";
            }
            if ($first) {
                if (is_array($value)) {
                    $query = $query." WHERE $key IN $temp_in_str";
                    foreach ($value as $v) {
                        array_push($bind_array, $v);
                    }
                } else {
                    $query = $query." WHERE $key = ?";
                    array_push($bind_array, $value);
                }
                $first = false;
            } else {
                if (is_array($value)) {
                    $query = $query." AND $key IN $temp_in_str";
                    foreach ($value as $v) {
                        array_push($bind_array, $v);
                    }
                } else {
                    $query = $query." AND $key = ?";
                    array_push($bind_array, $value);
                }
            }
        }
    }

    if (!empty($orderby_array)) {
        $first = true;
        foreach ($orderby_array as $key => $value) {
            if ($first) {
                $query = $query." ORDER BY $key $value";
                $first = false;
            } else {
                $query = $query." AND $key $value";
            }
        }
    }

    if (!($limit <= 0)) {
        $query .= " LIMIT $limit ";
    }

//    return ["query"=>$query, "array"=>$bind_array];

    $sth = getPdo()->prepare($query);

    if (!empty($bind_array)) {
        $sth->execute($bind_array);
    } else {
        $sth->execute();
    }

    return $sth->fetchAll();
}

function insertPrepare($table, $column_array = [], $value_array = []) {

    $query = "INSERT INTO $table ";

    $bind_array = [];

    if (isset($column_array)) {
        $first = true;
        $query .= "(";
        foreach ($column_array as $column) {
            if ($first) {
                $query .= "$column";
//                array_push($bind_array, $column);
                $first = false;
            } else {
                $query .= ",$column";
//                array_push($bind_array, $column);
            }
        }
        $query .= ")";
    }

    $query .= " VALUES ";

    if (isset($value_array)) {
        $first = true;

        $query .= "(";
        foreach ($value_array as $column) {
            if ($first) {
                $query .= "?";
                array_push($bind_array, $column);
                $first = false;
            } else {
                $query .= ", ?";
                array_push($bind_array, $column);
            }
        }
        $query .= ")";
    }

//    return ['query'=>$query, 'array'=>$bind_array];

    $sth = getPdo()->prepare($query);

    return !empty($bind_array) ? $sth->execute($bind_array) : $sth->execute(); // return true or false
}
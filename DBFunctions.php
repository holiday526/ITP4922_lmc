<?php

function dd($collection) {
    echo "<pre>";
    var_dump($collection);
    echo "</pre>";
}

function getPdo() {
    $dbh = new PDO(
        'mysql:host=127.0.0.1;dbname=autocarsales;charset=utf8mb4',
        'root',
        'password'
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

function updatePrepare($table, $assoc_array, $where_assoc_array) {

    $update_query = "UPDATE $table SET ";

    $first = true;

    $bind_array = [];
    foreach ($assoc_array as $key => $value) {
        if ($first) {
            $update_query .= "$key=?";
            array_push($bind_array, $value);
            $first = false;
        } else {
            $update_query .= ",$key=?";
            array_push($bind_array, $value);
        }
    }

//    $id = $assoc_array['id'];

    $first = true;
    foreach ($where_assoc_array as $key => $value) {
        if ($first) {
            $update_query .= " WHERE $key = ?";
            array_push($bind_array, $value);
            $first = false;
        } else {
            $update_query .= " AND $key = ?";
        }
    }

//    return ['query'=>$update_query, 'array'=>$bind_array];

    $stmt = getPdo()->prepare($update_query);
    return $stmt->execute($bind_array);

}

function deletePrepare($table, $where_array) {

    $query = "DELETE FROM $table ";

    $bind_array = [];
    if (isset($where_array)) {
        $first = true;
        foreach ($where_array as $key => $value) {
            if ($first) {
                $query .= " WHERE $key = ?";
                array_push($bind_array, $value);
                $first = false;
            } else {
                $query .= " AND $key = ?";
                array_push($bind_array, $value);
            }
        }
    }

    $stmt = getPdo()->prepare($query);
    if (!empty($bind_array)) {
        return $stmt->execute($bind_array);
    } else {
        return $stmt->execute();
    }

}

function searchPrepare($search_str) {
    $query = "SELECT * FROM cars
          WHERE name LIKE ? 
          OR description LIKE ?
          OR brandName LIKE ?
          OR pros LIKE ?
          OR cons LIKE ?
          OR specifications LIKE ?
          OR transmission LIKE ? ";

    $array = [];

    for ($i = 0; $i < 7; $i++) {
        array_push($array, "%".$_POST['search']."%");
    }

    $result = getPdo()->prepare($query);
    $result->execute($array);
//    return ['query'=>$query, 'array'=>$array];
    return $result->fetchAll();

}
<?php

if(!isset($_GET['carId'])){
    echo "you mother fucker, you are not allow to access this page without any things to compare";
//    $url = $_SERVER['HTTP_REFERER'];
//    header("Refresh: 5; URL=\"" . $url . "\"");
}
$compareId = $_GET['carId'];
dd(queryBuilderPrepare('car', ['*'], ['id' => $compareId[0]]));


<?php
session_start();
include 'DBFunctions.php/';

var_dump($_POST);

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    if (isset($_POST['action'])){
        die("i m drunk");
        var_dump((insertPrepare('appointments',
            ['carId', 'appointmentUserId'],
            [$_POST['carId'], $_SESSION['customer']['id']]
        ));
    }
}
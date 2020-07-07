<?php
session_start();
require_once '../DBFunctions.php';

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    if (isset($_POST['action'])){
//        die("i m drunk");
        dd(insertPrepare('appointments',
            ['carId', 'appointmentUserId'],
            [$_POST['carId'], $_SESSION['customer']['id']]
        ));
    }
}
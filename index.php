<!doctype html>
<html lang="en">
<?php require_once 'layout/head.php'; ?>
<body>
<?php
require_once 'CommonFunctions.php';
require_once 'layout/navbar.php';
?>
<?php require_once 'layout/header.php'; ?>
<?php
if (isset($_GET['route'])){
    $route = $_GET['route'];
    switch ($route) {
        case 'login': $page = 'login'; break;
        case 'cart': $page = 'cart'; break;
    }
} else {
    $page = 'home';
}

require_once "./page/$page.php";

echo "<pre>";
var_dump(getAllAdmins());
echo "</pre>";

?>
<?php require_once 'layout/footer.php'; ?>
<?php require_once 'layout/footer-script.php'; ?>
</body>
</html>

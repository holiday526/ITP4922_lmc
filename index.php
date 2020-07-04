<!doctype html>
<html lang="en">
<head>
    <?php require_once 'layout/head.php'; ?>
</head>
<body>
<?php
require_once 'CommonFunctions.php';
require_once 'layout/navbar.php';
?>

<!-- content -->
<?php
if (isset($_GET['route'])){
    $route = $_GET['route'];
    switch ($route) {
        case 'login': $page = 'login'; break;
        case 'cart': $page = 'cart'; break;
        case 'content': $page = 'content'; break;
        default: $page = "404";
    }
} else {
    $page = 'home';
}

require_once "./page/$page.php";

echo "<pre>";
$records = getAllAdmins();
var_dump($records);
echo "</pre>";

?>
<!-- end of content -->

<?php require_once 'layout/footer.php'; ?>
<?php require_once 'layout/footer-script.php'; ?>
</body>
</html>

<!doctype html>
<html lang="en">
<head>
    <?php require_once 'layout/head.php' ?>
</head>
<body class="d-flex flex-column min-vh-100">
<?php
require_once 'DBFunctions.php';
require_once 'layout/navbar.php';
?>

<!-- content -->
<?php
if (isset($_GET['route'])){
    $route = $_GET['route'];
    switch ($route) {
        case 'login': $page = 'login'; break;
        case 'register': $page = 'register'; break;
        case 'cart': $page = 'cart'; break;
        case 'content': $page = 'content'; break;
        case 'compare': $page = 'compare'; break;
        default: $page = "404";
    }
} else {
    $page = 'home';
}
if ($page === "404") {
    echo "<div style='background: #6c757d'>";
    require_once "./page/$page.php";
    echo "</div>";
}
require_once "./page/$page.php";


?>
<!-- end of content -->

<?php require_once 'layout/footer.php'; ?>
<?php require_once 'layout/footer-script.php'; ?>
</body>
</html>

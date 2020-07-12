<?php
session_start();

require_once '../DBFunctions.php';

$auth = (isset($_SESSION['customer']) || isset($_SESSION['admin']));

if ($auth) {
    // auth ed
    $deleted = deletePrepare('cars', ['id'=>$_POST['carId'], 'ownerId'=>$_POST['ownerId']]);
    if (isset($_SESSION['admin']) && $_POST['catalogAction'] == "Delete") {
        $deleted = deletePrepare('cars', ['id'=>$_POST['carId']]);
?>
    <script>
        alert("Car ad (id: <?= $_POST['carId'] ?>) has been deleted.");
        window.location.replace(window.location.origin + '/?route=allCatalog');
    </script>
<?php
    }
?>
    <script>
        alert("Your car ad (id: <?= $_POST['carId'] ?>) has been deleted.");
        window.location.replace(window.location.origin + '/?route=sell&type=show');
    </script>
<?php
} else {
?>
    <script>
        window.location.replace(window.location.origin + '/?route=login')
    </script>
<?php
}
?>
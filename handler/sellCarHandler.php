<?php
session_start();
require_once "../DBFunctions.php";
if ((isset($_SESSION['customer']) || isset($_SESSION['admin']))) {
    require_once "./imageUploadHandler.php";
    $record_success = insertPrepare('cars',
        ['name', 'description', 'photoLocation', 'retailPrice', 'productCost', 'oldCar', 'ownerId', 'sold', 'brandName', 'pros', 'cons', 'specifications', 'fuel_typesId'],
        [$_POST['name'], $_POST['description'], $target_file, $_POST['retailPrice'], $_POST['productCost'], $_POST['oldCar'], $_POST['ownerId'], $_POST['sold'], $_POST['brandName'], $_POST['pros'], $_POST['cons'], $_POST['specifications'], $_POST['fuel_typesId']]
    );
    if ($record_success) {
?>
    <script>
        alert('Sell car record is created');
        window.location.replace(window.location.origin + '/?route=sell&type=show');
    </script>
<?php
    } else {
?>
    <script>
        alert('Sell car record cannot be created');
        window.location.replace(window.location.origin + '/?route=sell');
    </script>
<?php
    }
} else {
?>
    <script>
        // login is required
        window.location.replace(window.location.origin + '/?route=login');
    </script>
<?php
}
?>

<?php
session_start();

require_once '../DBFunctions.php';

$car = queryBuilderPrepare('cars', ['*'], ['id'=>$_POST['id']])[0];

$auth = (isset($_SESSION['customer']) || isset($_SESSION['admin']));

if ($auth && ($car['ownerId'] == $_SESSION['customer']['id'] || $car['ownerId'] === $_SESSION['admin']['id'])) {
    updatePrepare("cars", $_POST);
?>
    <script>
        alert('Cars <?= $_POST["id"] ?> is updated');
        window.location.replace(window.location.origin + '/?route=sell&type=show');
    </script>
<?php
} else {
?>
    <script>
        window.location.replace(window.location.origin + '/?route=login');
    </script>
<?php
}
?>
<?php
session_start();

$auth = (isset($_SESSION['customer']) || isset($_SESSION['admin']));

//$auth = true;

require_once "../DBFunctions.php";

// $_POST accept carId, bid price, userId -> lastBidUserId

if ($auth) {
    $user = isset($_SESSION['customer']) ? $_SESSION['customer'] : $_SESSION['admin'];
    $retailPrice = queryBuilderPrepare('cars', ['retailPrice'], ['id'=>$_POST['carId'], 'bid'=>1, 'sold'=>0])[0]['retailPrice'];
    $bidPrice = (float)$_POST['bidPrice'] >= 100? $_POST['bidPrice'] : 100;
    if (!empty($retailPrice)) {
        updatePrepare('cars', ['lastBidUserId'=>$user['id'], 'retailPrice'=>(float)$retailPrice+$bidPrice], ['id'=>$_POST['carId']]);
?>
        <script>
            alert('bid ordered');
            window.location.replace(window.location.origin + "/?route=bid&carId=<?= $_POST['carId'] ?>")
        </script>
<?php
    } else {
?>
        <script>
            alert('You are not allow to bid this car, you can only order this car');
            window.location.replace(window.location.origin + '/?route=catalog');
        </script>
<?php
    }
} else {
?>
    <script>
        alert('Login first');
        window.location.replace(window.location.origin + '/?route=login');
    </script>
<?php
}
?>

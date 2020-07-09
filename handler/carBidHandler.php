<?php
session_start();

$auth = (isset($_SESSION['customer']) || isset($_SESSION['admin']));

//$auth = true;

require_once "../DBFunctions.php";

// $_POST accept carId, bid price, userId -> lastBidUserId

if ($auth) {
    $user = isset($_SESSION['customer']) ? $_SESSION['customer'] : $_SESSION['admin'];
    $retailPrice = queryBuilderPrepare('cars', ['retailPrice'], ['id'=>$_POST['carId'], 'bid'=>1])[0]['retailPrice'];
    dd($_POST);
    dd($retailPrice);
    if (!empty($retailPrice)) {
        updatePrepare('cars', ['id'=>$_POST['carId'], 'lastBidUserId'=>$_POST['userId'], 'retailPrice'=>(float)$retailPrice+(float)$_POST['bidPrice']]);
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

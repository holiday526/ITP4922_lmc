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
        $order = queryBuilderPrepare('orders', ['id','carId'], ['carId'=>$_POST['carId']])[0];
        if (!empty($order)) {
            $updated = updatePrepare('orders', ['customerId'=>$user['id']], ['id'=>$order['id']]);
?>
            <script>
                alert("Bid order updated: Latest Customer is <?= $user['id'] ?>");
            </script>
<?php
        } else {
            $inserted = insertPrepare('orders', ['carId', 'customerId'], [$_POST['carId'], $user['id']]);
?>
            <script>
                alert("Bid order created: Latest Customer is <?= $user['id'] ?>");
            </script>
<?php
        }
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

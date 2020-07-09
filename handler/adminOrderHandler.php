<?php
session_start();

require_once '../DBFunctions.php';

$auth = isset($_SESSION['admin']);

if ($auth) {
    dd($_POST);
    if ($_POST['orderAction'] === "Delete") {
        $deleted = deletePrepare('orders', ['id'=>$_POST['orderId']]);
        if ($deleted) {
?>
        <script>
            alert('Order ID: <?= $_POST['orderId'] ?> deleted')
            window.location.replace(window.location.origin + '/?route=allOrder');
        </script>
<?php
        } else {
?>
        <script>
            alert('Order ID: <?= $_POST['orderId'] ?> delete fail')
            window.location.replace(window.location.origin + '/?route=allOrder');
        </script>
<?php
        }
    } else if ($_POST['orderAction'] === "Mark as sold") {
        $updated = updatePrepare('orders', ['processed'=>1], ['id'=>$_POST['orderId']]);
        if ($updated) {
            $deleted_other_orders = deletePrepare('orders', ['carId'=>$_POST, 'processed'=>0]);
            $mark_as_sold_car = updatePrepare('cars', ['sold'=>1], ['id'=>$_POST['carId']]);
?>
            <script>
                alert("Order ID: <?= $_POST['orderId'] ?> is processed");
                window.location.replace(window.location.origin + '/?route=allOrder');
            </script>
<?php
        }
    }
?>

<?php
} else {
?>
    <script>
        window.location.replace(window.location.origin + '/?route=');
    </script>
<?php
}
?>

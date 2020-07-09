<?php
session_start();
require_once "../DBFunctions.php";

if (empty($_POST['action']) || $_SERVER['REQUEST_METHOD'] != 'POST') { ?>
    <script>
        alert('Bad request!');
        window.location.replace(window.location.origin + '/?route=home');
    </script>
    <?php die('Bad request'); ?>
<?php } ?>

<?php $auth = (isset($_SESSION['customer']) || isset($_SESSION['admin'])); ?>
<?php $user = isset($_SESSION['customer']) ? $_SESSION['customer'] : $_SESSION['admin']; ?>

<?php if (!$auth) { ?>
    <script>
        alert('Order car require login!');
        window.location.replace(window.location.origin + '/?route=login');
    </script>
    <?php die('require login'); ?>
<?php } ?>


<?php
if ($_POST['action'] == 'store') { ?>

    <?php if (empty($_POST['carId'])) { ?>
        <script>
            alert('No car selected!');
            window.location.replace(window.location.origin + '/?route=catalog');
        </script>
        <?php die('no carId'); ?>
    <?php } ?>

    <?php $car = queryBuilderPrepare('cars', ['cars.id'], ['id' => $_POST['carId']]); ?>

    <?php if (!$car) { ?>
        <script>
            alert('no such car existed');
            window.location.replace(window.location.origin + '/?route=catalog');
        </script>
        <?php die('Car id not exist'); ?>

    <?php } ?>

    <?php if ($car['sold'] == '1') { ?>
        <script>
            alert('The car already sold!');
            window.location.replace(window.location.origin + '/?route=catalog');
        </script>
        <?php die('already sold'); ?>
    <?php } ?>

    <?php if ($car['ownerId'] == $user['id']) { ?>
        <script>
            alert('You can not order your own car!');
            window.location.replace(window.location.origin + '/?route=catalog');
        </script>
        <?php die('ordering own car'); ?>
    <?php } ?>

    <?php
    $result = insertPrepare('orders',
        ['carId', 'customerId', 'orderNotes'],
        [$_POST['carId'], $user['id'], $_POST['orderNotes']]
    );

    if ($result) { ?>
        <script>
            alert('Congratulations, Order placed!');
            window.location.replace(window.location.origin + '/?route=catalog');
        </script>
        <?php die('order success'); ?>
    <?php } else { ?>
        <script>
            alert('Sorry, this car is not available!');
            window.location.replace(window.location.origin + '/?route=catalog');
        </script>
        <?php die('order failed'); ?>
    <?php } ?>
<?php } elseif ($_POST['action'] == 'delete') { ?>

    <?php checkOrder();?>

    <?php $result = deletePrepare('orders', ['orders.id' => $_POST['orderId']]) ?>

    <?php if (!$result) { ?>
        <script>
            alert('Order cannot be cancel!');
            window.location.replace(window.location.origin + '/?route=orderIndex');
        </script>
        <?php die('delete error'); ?>
    <?php } else { ?>
        <script>
            alert('Cancel success!');
            window.location.replace(window.location.origin + '/?route=orderIndex');
        </script>
        <?php die('success'); ?>
    <?php } ?>

<?php } elseif ($_POST['action'] == 'update') { ?>

    <?php checkOrder();?>

    <?php $result = updatePrepare('orders', ['orders.orderNotes'=>$_POST['orderNotes']], ['orders.id'=>$_POST['orderId']])?>

    <?php if (!$result) {?>
        <script>
            alert('Update cannot be done!');
            window.location.replace(window.location.origin + '/?route=orderIndex');
        </script>
        <?php die('delete error'); ?>
    <?php } else { ?>
        <script>
            alert('Update success!');
            window.location.replace(window.location.origin + '/?route=orderIndex');
        </script>
        <?php die('success'); ?>
    <?php } ?>

<?php } else { ?>
    <script>
        alert('Action invalid!');
        window.location.replace(window.location.origin + '/?route=orderIndex');
    </script>
    <?php die('Invalid action'); ?>
<?php } ?>



<?php function checkOrder()
{
    if (empty($_POST['orderId'])) { ?>
        <script>
            alert('No order selected!');
            window.location.replace(window.location.origin + '/?route=orderIndex');
        </script>
        <?php die('no orderId in post'); ?>
    <?php } ?>

    <?php $order = queryBuilderPrepare('orders', ['orders.id as orderId'], ['orders.id' => $_POST['orderId']])[0] ?>

    <?php if (!$order) { ?>
    <script>
        alert('Order not found!');
        window.location.replace(window.location.origin + '/?route=orderIndex');
    </script>
    <?php die('no order found'); ?>
<?php }

} ?>
<?php
session_start();
require_once "../DBFunctions.php";

if (empty('route') || empty('carId') || $_SERVER['REQUEST_METHOD'] != 'POST') { ?>
    <script>
        alert('Bad request!');
        window.location.replace(window.location.origin + '/?route=home');
    </script>
    <?php die('Bad request'); ?>
<?php } ?>

<?php $auth = (isset($_SESSION['customer']) || isset($_SESSION['admin'])); ?>

<?php if (!$auth) {?>
    <script>
        alert('Order car require login!');
        window.location.replace(window.location.origin + '/?route=login');
    </script>
    <?php die('require login'); ?>
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

<?php if ($car['ownerId'] == $_SESSION['customer']['id']) { ?>
    <script>
        alert('You can not order your own car!');
        window.location.replace(window.location.origin + '/?route=catalog');
    </script>
    <?php die('ordering own car'); ?>
<?php } ?>

<?php
$user = isset($_SESSION['customer']) ? $_SESSION['customer'] : $_SESSION['admin'];
$sold = updatePrepare('cars', ['id'=>$_GET['carId'], 'sold'=>1]);
$result = insertPrepare('orders',
    ['carId', 'customerId', 'orderNotes'],
    [$_POST['carId'], $user['id'], $_POST['orderNotes']]
);

if ($result && $sold) {?>
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
<?php }
?>
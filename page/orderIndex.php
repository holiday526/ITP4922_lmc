<?php
session_start();

$auth = (isset($_SESSION['customer']) || isset($_SESSION['admin']));
$user = isset($_SESSION['customer']) ? $_SESSION['customer'] : $_SESSION['admin'];

if (!$auth) { ?>
    <script>
        alert('Require login!');
        window.location.replace(window.location.origin + '/?route=login');
    </script>
    <?php die('require login'); ?>
<?php } ?>

<?php if ($_GET['route'] != 'orderIndex') { ?>
    <script>
        alert('Wrong request!');
        window.location.replace(window.location.origin + '/?route=catalog');
    </script>
    <?php die('Wrong request'); ?>
<?php } ?>

<?php $orderRecords = queryBuilderPrepare('orders',
    ['cars.id as carId', 'orders.id as orderId', 'photoLocation', 'cars.name as carName', 'cars.ownerId', 'orders.created_at as orderCreatedAt', 'orders.processed as processed'],
    ['customerId' => $user['id']],
    [],
    [['cars', 'orders.carId', 'cars.id']]
);

for ($i = 0; $i < count($orderRecords); $i++ ) {
    $owner = queryBuilderPrepare('customers',
        ['customers.name as ownerName'],
        ['customers.id' => $orderRecords[$i]['ownerId']]
    )[0];
    $orderRecords[$i]['ownerName'] = $owner['ownerName'];
} ?>

<?php if (!$orderRecords) { ?>
    <script>
        alert('You haven\'t order any cars yet!');
        window.location.replace(window.location.origin + '/?route=catalog');
    </script>
    <?php die('Empty order record'); ?>
<?php } ?>

<div class="container">

    <h3 class="pt-2">All order record</h3>
    <?php foreach ($orderRecords as $orderRecord) { ?>
        <div class="row py-2">
            <div class="col-md-4">
                <a href="#">
                    <img class="img-fluid rounded mb-3 mb-md-0" src="<?= $orderRecord['photoLocation'] ?>" alt="">
                    <?php if ($orderRecord['processed']) { ?>
                    <div class="card-img-overlay text-success h2 d-flex justify-content-center align-items-end">
                        <p>Order processed</p></div>
                    <?php } ?>
                </a>
            </div>
            <div class="col-md-8">
                <h4 class="h3"><?= $orderRecord['carName'] ?> <span class="h5">(Owner ID: <?= $orderRecord['ownerId'] ?>)</span></h4>
                <p>Owner Name: <?=$orderRecord['ownerName']?> </p>
                <p>Order ID: <?= $orderRecord['orderId'] ?> </p>
                <p>Order at: <?= $orderRecord['orderCreatedAt'] ?> </p>
                <form action="../handler/orderHandler.php" method="post">
                    <input type="hidden" name="orderId" value="<?= $orderRecord['orderId'] ?>">
                    <input type="hidden" name="action" value="delete">
                    <?php if ($orderRecord['processed']) { ?>
                        <input type="submit" value="Cancel Order" class="btn btn-danger disabled">
                    <?php } else { ?>
                        <input type="submit" value="Cancel Order" class="btn btn-danger">
                    <?php } ?>
                    <span class="glyphicon glyphicon-chevron-right"></span>
                </form>
                <?php if ($orderRecord['processed']) { ?>
                    <a href="/?route=orderEdit&orderId=<?= $orderRecord['orderId'] ?>" class="btn btn-warning disabled">Update Order</a>
                <?php } else { ?>
                    <a href="/?route=orderEdit&orderId=<?= $orderRecord['orderId'] ?>" class="btn btn-warning">Update Order</a>
                <?php } ?>
            </div>
        </div>
        <hr>
    <?php } ?>
</div>
<?php
session_start();

$auth = (isset($_SESSION['customer']) || isset($_SESSION['admin']));
$user = isset($_SESSION['customer']) ? $_SESSION['customer'] : $_SESSION['admin'];

if (!$auth) { ?>
    <script>
        alert('Ordering car require login!');
        window.location.replace(window.location.origin + '/?route=login');
    </script>
    <?php die('require login'); ?>
<?php } ?>

<?php if ($_GET['route'] != 'orderEdit' || empty($_GET['orderId'])) { ?>
    <script>
        alert('Wrong request!');
        window.location.replace(window.location.origin + '/?route=catalog');
    </script>
    <?php die('Wrong request'); ?>
<?php } ?>

<?php
$order = queryBuilderPrepare('orders',
    ['*'],
    ['orders.id' => $_GET['orderId']],
    [],
//    [['customers', 'cars.ownerId', 'customers.id']]
)[0];

if (!$order) { ?>
    <script>
        alert('Order not existed!');
        window.location.replace(window.location.origin + '/?route=catalog');
    </script>
    <?php die('Order not existed'); ?>
<?php } ?>

<?php if ($order['customerId'] != $user['id']) { ?>
    <script>
        alert('You can not edit other\'s order!');
        window.location.replace(window.location.origin + '/?route=catalog');
    </script>
    <?php die('ordering other\'s order'); ?>
<?php } ?>

<?php
$car = queryBuilderPrepare('cars',
    ['cars.id as carId', 'cars.sold', 'ownerId', 'cars.name as carName', 'photoLocation', 'cars.description as carDescription', 'odometer', 'transmission', 'fuel_typesId', 'retailPrice', 'customers.name as ownerName'],
    ['cars.id' => $order['carId']],
    [],
    [['customers', 'cars.ownerId', 'customers.id']])[0];
$fuel_type = queryBuilderPrepare('fuel_types', ['name'], ["id" => $car['fuel_typesId']])[0]['name'];

if (!$car) { ?>
    <script>
        alert('Car not existed!');
        window.location.replace(window.location.origin + '/?route=catalog');
    </script>
    <?php die('Car not existed'); ?>
<?php } ?>

<div class="container">
    <!-- Page Heading/Breadcrumbs -->
    <h1 class="mt-4 mb-3"><?= $car['carName'] ?>
        <small></small>
    </h1>

    <!-- Content Row -->
    <div class="row">
        <!-- Map Column -->
        <div class="col-lg-8 mb-4">
            <img src="<?= $car['photoLocation'] ?>" class="car-img" alt="">
        </div>
        <!-- Contact Details Column -->
        <div class="col-lg-4 mb-4">
            <h3>Order Details</h3>

            <h5>Order Item:</h5>
            <p><?= $car['carName'] ?><br><?= $car['carDescription'] ?></p>

            <h5>Transmission:</h5>
            <p><?= $car['transmission'] ?></p>

            <h5>Odometer:</h5>
            <p><?=$car['odometer']?>Km</p>

            <h5>Fuel Types:</h5>
            <p><?=$fuel_type?></p>

            <h5>Current Price:</h5>
            <p>$<?=$car['retailPrice']?></p>

        </div>
    </div>
    <!-- /.row -->

    <!-- Contact Form -->
    <!-- In order to set the email address and subject line for the contact form go to the bin/contact_me.php file. -->
    <div class="row">
        <div class="col-lg-8 mb-4">
            <h3>Order Form</h3>
            <form action="../handler/orderHandler.php" name="orderForm" id="orderForm" method="post">
                <div class="control-group form-group">
                    <div class="controls">
                        <label for="name">Full Name:</label>
                        <input type="text" class="form-control" id="name" required
                               data-validation-required-message="Please enter your name." value="<?=$user['name']?>" disabled>
                        <p class="help-block"></p>
                    </div>
                </div>
                <div class="control-group form-group">
                    <div class="controls">
                        <label for="phone">Phone Number:</label>
                        <input type="tel" class="form-control" id="phone" required
                               data-validation-required-message="Please enter your phone number." value="<?=$user['contactPhones']?>" disabled>
                    </div>
                </div>
                <div class="control-group form-group">
                    <div class="controls">
                        <label for="email">Email Address:</label>
                        <input type="email" class="form-control" id="email" required
                               data-validation-required-message="Please enter your email address." value="<?=$user['email']?>" disabled>
                    </div>
                </div>
                <div class="control-group form-group">
                    <div class="controls">
                        <label for="orderNotes">Order Notes:</label>
                        <textarea rows="10" cols="100" class="form-control" id="orderNotes" name="orderNotes"
                                  data-validation-required-message="Please enter your message" maxlength="999"
                                  style="resize:none"><?=$order['orderNotes']?></textarea>
                    </div>
                </div>
                <input type="hidden" name="orderId" value="<?=$_GET['orderId']?>">
                <input type="hidden" name="action" value="update">
                <button type="submit" class="btn btn-primary">Update Order</button>
            </form>
        </div>

    </div>
    <!-- /.row -->

</div>
<!-- /.container -->
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

<?php if ($_GET['route'] != 'order' || empty($_GET['carId'])) { ?>
    <script>
        alert('Wrong request!');
        window.location.replace(window.location.origin + '/?route=catalog');
    </script>
    <?php die('Wrong request'); ?>
<?php } ?>

<?php
$car = queryBuilderPrepare('cars',
    ['cars.id as carId', 'cars.sold', 'ownerId', 'cars.name as carName', 'photoLocation', 'cars.description as carDescription', 'odometer', 'transmission', 'fuel_typesId', 'retailPrice', 'customers.name as ownerName'],
    ['cars.id' => $_GET['carId']],
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
            <form action="../handler/orderHandler.php" name="sentMessage" id="contactForm" method="post">
                <div class="control-group form-group">
                    <div class="controls">
                        <label>Full Name:</label>
                        <input type="text" class="form-control" id="name" required
                               data-validation-required-message="Please enter your name." value="<?=$user['name']?>" disabled>
                        <p class="help-block"></p>
                    </div>
                </div>
                <div class="control-group form-group">
                    <div class="controls">
                        <label>Phone Number:</label>
                        <input type="tel" class="form-control" id="phone" required
                               data-validation-required-message="Please enter your phone number." value="<?=$user['contactPhones']?>" disabled>
                    </div>
                </div>
                <div class="control-group form-group">
                    <div class="controls">
                        <label>Email Address:</label>
                        <input type="email" class="form-control" id="email" required
                               data-validation-required-message="Please enter your email address." value="<?=$user['email']?>" disabled>
                    </div>
                </div>
                <div class="control-group form-group">
                    <div class="controls">
                        <label>Order Notes:</label>
                        <textarea rows="10" cols="100" class="form-control" id="message" name="orderNotes"
                                  data-validation-required-message="Please enter your message" maxlength="999"
                                  style="resize:none"></textarea>
                    </div>
                </div>
                <input type="hidden" name="carId" value="<?=$_GET['carId']?>">
                <button type="submit" class="btn btn-primary" id="sendMessageButton">Confirm Order</button>
            </form>
        </div>

    </div>
    <!-- /.row -->

</div>
<!-- /.container -->
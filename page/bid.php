<?php
session_start();

$auth = (isset($_SESSION['customer']) || isset($_SESSION['admin']));

if ($auth) {
    $user = isset($_SESSION['customer']) ? $_SESSION['customer'] : $_SESSION['admin'];
    $car = queryBuilderPrepare('cars', ['*'], ['id'=>$_GET['carId']])[0];
    $fuel_type = queryBuilderPrepare('fuel_types', ['*'], ['id'=>$car['fuel_typesId']])[0]['name'];
//    dd($car);
    // check is bid or not
    if ($car['bid'] == 1) {
        // is bid
?>
        <div class="container">
            <!-- Page Heading/Breadcrumbs -->
            <h1 class="mt-4 mb-3"><?= $car['name'] ?>
<!--                <small>Bid</small>-->
            </h1>

            <!-- Content Row -->
            <div class="row">
                <!-- Map Column -->
                <div class="col-lg-8 mb-4">
                    <img src="<?= $car['photoLocation'] ?>" class="car-img" alt="">
                </div>
                <!-- Contact Details Column -->
                <div class="col-lg-4 mb-4">
                    <h3>Car Bid:</h3>

                    <h5>Latest Bidder</h5>

                    <p class="h2 text-info py-2"><?=$car['lastBidUserId']?></p>

                    <h5>Current Price:</h5>
                    <p class="h2 text-success py-2">$<?=$car['retailPrice']?></p>

                    <label for="bidPriceInput">Add Bid (minimum: 100 per bid)</label>
                    <form action="../handler/carBidHandler.php" method="post">
                        <div class="input-group mb-3">
                            <input type="hidden" value="<?= $_GET['carId'] ?>" name="carId">
                            <input type="number" name="bidPrice" class="form-control" aria-describedby="basic-addon2" id="bidPriceInput"  min="100" required>
                            <div class="input-group-append">
                                <input type="submit" class="btn btn-outline-info" value="Bid!">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
<?php
    } else {
        // is not bid
?>
        <script>
            alert('This car is not for bid');
            window.location.replace(window.location.origin + "/?route=catalog");
        </script>
<?php
    }
} else {
    // no login
?>
    <script>
        alert('Login first');
        window.location.replace(window.location.origin + "/?route=login");
    </script>
<?php
}
?>

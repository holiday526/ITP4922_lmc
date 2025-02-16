<?php
session_start();
//dd($_SESSION['customer']['id']);
?>

<?php $auth = (isset($_SESSION['customer']) || isset($_SESSION['admin'])); ?>
<?php $user = isset($_SESSION['customer']) ? $_SESSION['customer'] : $_SESSION['admin']; ?>


<?php
if (isset($_GET['addcompare'])) {
    if (count(array_filter($_SESSION['compareList'])) < 4) {
        if (!in_array($_GET['addcompare'], $_SESSION['compareList'])) {
            $_SESSION['compareList'][] = $_GET['addcompare'];
        }
    } else { ?>
        <script>
            alert('You can only compare 2-4 car!');
            window.location.replace(window.location.origin + '/?route=catalog');
        </script>
        <?php die('compareList full'); ?>
    <?php } ?>
<?php } elseif (isset($_GET['delcompare'])) {
    if (in_array($_GET['delcompare'], $_SESSION['compareList'])) {
        if (($key = array_search($_GET['delcompare'], $_SESSION['compareList'])) !== false) {
            unset($_SESSION['compareList'][$key]);
        }
    }
    header('Location: ' . $_SERVER['HTTP_REFERER'] . '#car' . $_GET['delcompare']);
}

if (isset($_GET['carId'])) {
//    Show the queried car (single car)
    $car = queryBuilderPrepare('cars',
        ['cars.name as carName', 'cars.id as carId', 'cars.ownerId', 'photoLocation', 'description', 'brandName', 'odometer', 'transmission', 'make', 'year_manufactured', 'pros', 'cons', 'specifications', 'color', 'retailPrice', 'bid'],
        ['cars.id' => $_GET['carId']],
        []
    )[0];
    $relatedCar = queryBuilderPrepare('cars', ['cars.id as carId, photoLocation', 'cars.name'], ['ownerId' => $car['ownerId'], 'sold' => 0]);
    ?>
    <!-- Page Content -->
    <div class="container">

        <!-- Page Heading/Breadcrumbs -->
        <h1 class="mt-4 mb-3"><?= $car['carName'] ?>
            <small></small>
        </h1>

        <!--        <ol class="breadcrumb">-->
        <!--            <li class="breadcrumb-item">-->
        <!--                <a href="index.html">Home</a>-->
        <!--            </li>-->
        <!--            <li class="breadcrumb-item active">Portfolio Item</li>-->
        <!--        </ol>-->

        <!-- Portfolio Item Row -->
        <div class="row">

            <div class="col-md-8">
                <img class="img-fluid p-3" width="750" height="500" src="<?= $car['photoLocation'] ?>" alt="">
            </div>

            <div class="col-md-4">
                <h3 class="my-3">Car Description</h3>
                <p><?= $car['description'] ?></p>
                <h3 class="my-3">Car Details</h3>
                <ul>
                    <li>Brand: <?=$car['brandName']?></li>
                    <li>Odometer: <?=$car['odometer']?>Km</li>
                    <li>Transmission: <?=$car['transmission']?></li>
                    <li>Make at: <?=$car['make']?></li>
                    <li>Year Manufactured: <?=$car['year_manufactured']?></li>
                    <li>Color: <?=$car['color']?></li>
                </ul>
                <h3 class="my-3">Price </h3>
                <p><?php if ($car['bid']) { echo 'Current';} else { echo 'Fixed';}?>Price: $ <?= $car['retailPrice'] ?></p>
            </div>

        </div>
        <!-- /.row -->

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">About this car</div>
                    <div class="card-body mt-auto">
                        <div class="row">
                            <div class="col-6">
                                <h5 class="card-title">Pros</h5>
                                <div>
                                    <?php foreach (explode("\n", $car['pros']) as $pros) { ?>
                                        <p class="card-text text-success"><?= $pros ?></p>
                                    <?php } ?>
                                </div>
                            </div>
                            <div class="col-6">
                                <h5 class="card-title">Cons</h5>
                                <div>
                                    <?php foreach (explode("\n", $car['cons']) as $cons) { ?>
                                        <p class="card-text text-danger"><?= $cons ?></p>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-body mt-auto">
                        <h5 class="card-title">Specifications</h5>
                        <?php foreach (explode("\n", $car['specifications']) as $spec) { ?>
                            <?php $item = explode(':', $spec) ?>
                            <h6 class="card-text"><?= $item[0] ?></h6>
                            <p class="card-text text-info"><?= $item[1] ?></p>

                        <?php } ?>
                        <div class=""></div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.row -->

        <!-- Related Projects Row -->
        <h3 class="my-4">This car owner also selling</h3>

        <div class="row">
            <?php foreach ($relatedCar as $car) {
                $carUrl = "/?route=catalog&carId=" . $car['carId']; ?>
                <div class="col-md-3 col-sm-6 mb-4">
                    <div class="card">

                        <div class="card-body">
                            <a href="<?= $carUrl ?>">
                                <img class="img-fluid" src="<?= $car['photoLocation'] ?>" alt="">
                            </a>
                        </div>

                        <div class="card-footer">
                            <?= $car['name'] ?>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
        <!-- /.row -->

    </div>
    <!-- /.container -->


    <?php
} else {
//    Show all car available in database (Full catalog)
    $catalogString = '';
    if (isset($_GET['type'])) {
        switch ($_GET['type']) {
            case 'new':
                $catalogString = 'New';
                $catType = '0';
                break;
            case '2nd':
                $catalogString = '2<sup>nd</sup> Hand Cars';
                $catType = '1';
                break;
        }
        $cars = queryBuilderPrepare(
            'cars',
            ['*'],
            ['oldCar' => $catType, 'sold'=>0],
            []
        );
//        $cars = queryBuilderPrepare(
//                'cars',
//            ['cars.name as carName', 'customers.name as customerName', 'cars.id as carId', 'customers.id as customerId', 'cars.*'],
//            ['oldCar' => $catType]
//        );
    } else {
        $catalogString = 'All';
//        $cars = queryBuilderPrepare('cars',
//            ['cars.name as carName', 'customers.name as customerName', 'cars.id as carId', 'customers.id as customerId', 'cars.*'],
//            [],
//            [],
//            [['customers', 'cars.ownerId', 'customers.id']]);
        $cars = queryBuilderPrepare('cars',
            ['*'],
            ['sold'=>0],
            []
        );
//        dd($cars);
    }
    $ownerNames = [];
    $customers = queryBuilderPrepare('customers', ['id', 'name']);
    $admins = queryBuilderPrepare('admins', ['id', 'username']);

    foreach ($customers as $customer) {
//        array_push($ownerNames, [$customer[0]=>$customer[1]]);
        $ownerNames[(string)$customer[0]] = $customer[1];
    }
    foreach ($admins as $admin) {
//        array_push($ownerNames, [$admin[0]=>$admin[1]]);
        $ownerNames[$admin[0]] = $admin[1];
    }
    ?>

    <!-- Page Content -->
    <div class="container">

        <!-- Page Heading/Breadcrumbs -->
        <h1 class="mt-4 mb-3">Catalog
            <small><?= $catalogString ?></small>
        </h1>

        <?php foreach ($cars as $car) {
            $order = queryBuilderPrepare('orders', ['*'], ['orders.carId'=>$car['carId'], 'orders.customerId'=>$user['id']])[0];
            if ($car['ownerId'] == $user['id'] || $car['sold'] || $order['processed']) {
                continue;
            }
            $carUrl = "/?route=catalog&carId=" . $car['id'];
            $customerUrl = "/?route=profile&id=" . $car['customerId']; ?>
            <!-- Blog Post -->
            <div id="car<?= $car['id'] ?>" class="card mb-4">
                <div class="card-body">
                    <div class="row">
                        <div class="col-6">
                            <a href="<?= $carUrl ?>">
                                <img class="img-fluid rounded car-img" src="<?= $car['photoLocation'] ?>" style="max-height: 300px" alt="">
                            </a>
                        </div>
                        <div class="col-6 align-content-center my-auto">
                            <h2 class="card-title"><?= $car['name'] ?> <br><small>Current price: $<?= $car['retailPrice'] ?></small></h2>
                            <p class="card-text"><?= $car['description'] ?></p>
                            <p class="card-text"></p>
                            <div class="row py-1 justify-content-around">
                                <a href="<?= $carUrl ?>" class="btn btn-primary col-5">Read More &rarr;</a>
                                <?php if (in_array($car['id'], $_SESSION['compareList'])) { ?>
                                    <a class="btn btn-danger px-2 col-5"
                                       href="/?route=catalog&delcompare=<?= $car['id'] ?>">Remove compare</a>
                                <?php } else { ?>
                                    <a class="btn btn-success px-2 col-5"
                                       href="/?route=catalog&addcompare=<?= $car['id'] ?>">Add to compare</a>
                                <?php } ?>
                            </div>
                            <div class="row py-1 justify-content-around">
                                <a href="/?route=makeAppointment&carId=<?= $car['id'] ?>"
                                   class="btn btn-info px-2 col-5">Make appointment</a>
                                <?php if ($car['bid'] == false && !$order) { ?>
                                    <a href="/?route=orderCreate&carId=<?= $car['id'] ?>"
                                       class="btn btn-success px-2 col-5">Order Now!</a>
                                <?php } elseif ($car['bid'] == true && !$order) { ?>
                                    <a href="/?route=bid&carId=<?= $car['id'] ?>" class="btn btn-warning px-2 col-5">Bid
                                        Now!</a>
                                <?php } elseif ($order) {?>
                                    <a href="/?route=orderIndex" class="btn btn-secondary px-2 col-5">Order pending...</a>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer text-muted">
                    <?php $ownerId = $car['ownerId']; ?>
                    Uploaded on <?= $car['created_at'] ?> by <a
                            href="<?= $customerUrl ?>" style="text-decoration: none"><?= $ownerNames[$ownerId] ?></a>
                </div>
            </div>
        <?php } ?>
    </div>
    <!-- /.container -->
<?php } ?>





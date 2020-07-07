<?php
session_start();

if (isset($_GET['addcompare'])) {
    if (count(array_filter($_SESSION['compareList'])) < 4) {
        if (!in_array($_GET['addcompare'], $_SESSION['compareList'])) {
            $_SESSION['compareList'][] = $_GET['addcompare'];
            dd($_SESSION);
        }
    }
    header('Location: ' . $_SERVER['HTTP_REFERER'] . '#car' . $_GET['addcompare']);
} elseif (isset($_GET['delcompare'])) {
    if (in_array($_GET['delcompare'], $_SESSION['compareList'])) {
        if (($key = array_search($_GET['delcompare'], $_SESSION['compareList'])) !== false) {
            unset($_SESSION['compareList'][$key]);
        }
        dd($_SESSION);
    }
    header('Location: ' . $_SERVER['HTTP_REFERER'] . '#car' . $_GET['delcompare']);
}

if (isset($_GET['carId'])) {
//    Show the queried car (single car)
    $car = queryBuilderPrepare('cars',
        ['*'],
//        ['cars.name as carName', 'customers.name as customerName', 'cars.id as carId'],
        ['cars.id' => $_GET['carId']],
//        ['cars.id' => 1],
        [],
        [['customers', 'cars.ownerId', 'customers.id']]
    )[0];
//    dd($car);

    $relatedCar = queryBuilderPrepare('cars', ['cars.id as carId, photoLocation', 'cars.name'], ['ownerId' => $car['ownerId']]);
//    dd($relatedCar);
    ?>
    <!-- Page Content -->
    <div class="container">

        <!-- Page Heading/Breadcrumbs -->
        <h1 class="mt-4 mb-3"><?= $car['name'] ?>
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
                    <li>Lorem Ipsum</li>
                    <li>Dolor Sit Amet</li>
                    <li>Consectetur</li>
                    <li>Adipiscing Elit</li>
                </ul>
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
        <h3 class="my-4">Related Car</h3>

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
            ['cars.name as carName', 'customers.name as customerName', 'cars.id as carId', 'customers.id as customerId', 'cars.*'],
            ['oldCar' => $catType],
            [],
            [['customers', 'cars.ownerId', 'customers.id']]
        );
    } else {
        $catalogString = 'All';
        $cars = queryBuilderPrepare('cars',
            ['cars.name as carName', 'customers.name as customerName', 'cars.id as carId', 'customers.id as customerId', 'cars.*'],
            [],
            [],
            [['customers', 'cars.ownerId', 'customers.id']]);
    }
//    dd($cars);
    ?>

    <!-- Page Content -->
    <div class="container">

        <!-- Page Heading/Breadcrumbs -->
        <h1 class="mt-4 mb-3">Catalog
            <small><?= $catalogString ?></small>

        </h1>

        <!--    <ol class="breadcrumb">-->
        <!--        <li class="breadcrumb-item">-->
        <!--            <a href="index.html">Home</a>-->
        <!--        </li>-->
        <!--        <li class="breadcrumb-item active">Blog Home 2</li>-->
        <!--    </ol>-->

        <?php foreach ($cars as $car) { ?>
            <?php $carUrl = "/?route=catalog&carId=" . $car['carId'] ?>
            <?php $customerUrl = "/?route=profile&id=" . $car['customerId'] ?>
            <!-- Blog Post -->
            <div id="car<?= $car['carId'] ?>" class="card mb-4">
                <div class="card-body">
                    <div class="row">
                        <div class="col-6">
                            <a href="<?= $carUrl ?>">
                                <img class="img-fluid rounded" src="<?= $car['photoLocation'] ?>" alt="">
                            </a>
                        </div>
                        <div class="col-6">
                            <h2 class="card-title"><?= $car['carName'] ?></h2>
                            <p class="card-text"><?= $car['description'] ?></p>
                            <div class="d-flex flex-row py-1">
                                <a href="<?= $carUrl ?>" class="btn btn-primary d-flex">Read More &rarr;</a>
                                <?php if (in_array($car['carId'], $_SESSION['compareList'])) { ?>
                                    <a class="btn btn-success d-flex px-2" href="/?route=catalog&delcompare=<?= $car['carId'] ?>">Remove from compare</a>
                                <?php } else { ?>
                                    <a class="btn btn-success d-flex px-2" href="/?route=catalog&addcompare=<?= $car['carId'] ?>">Add to compare</a>
                                <?php } ?>
                            </div>
                            <div class="d-flex flex-row pt-1">
                                <a href="<?= $carUrl ?>" class="btn btn-primary d-flex px-2">Make appointment</a>
                                <a href="<?= $carUrl ?>" class="btn btn-primary d-flex px-2">Order Now!</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer text-muted">
                    Uploaded on <?= $car['created_at'] ?> by <a
                            href="<?= $customerUrl ?>"><?= $car['customerName'] ?></a>
                </div>
            </div>
        <?php } ?>
    </div>
    <!-- /.container -->
<?php } ?>
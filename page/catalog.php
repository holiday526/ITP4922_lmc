<?php
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
            ['oldCar'=>$catType],
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
//dd($cars);
?>

<!-- Page Content -->
<div class="container">

    <!-- Page Heading/Breadcrumbs -->
    <h1 class="mt-4 mb-3">Catalog
        <small><?= $catalogString?></small>

    </h1>

    <!--    <ol class="breadcrumb">-->
    <!--        <li class="breadcrumb-item">-->
    <!--            <a href="index.html">Home</a>-->
    <!--        </li>-->
    <!--        <li class="breadcrumb-item active">Blog Home 2</li>-->
    <!--    </ol>-->

    <?php foreach ($cars as $car) { ?>
        <?php $carUrl = "/?route=catalog&carId=" . $car['carId'] ?>
        <?php $customerUrl = "/?route=profile&id=" . $car['customerId']?>
        <!-- Blog Post -->
        <div class="card mb-4">
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-6">
                        <a href="<?=$carUrl?>">
                            <img class="img-fluid rounded" src="<?= $car['photoLocation'] ?>" alt="">
                        </a>
                    </div>
                    <div class="col-lg-6">
                        <h2 class="card-title"><?= $car['carName'] ?></h2>
                        <p class="card-text"><?= $car['description'] ?></p>
                        <a href="<?= $carUrl ?>" class="btn btn-primary">Read More &rarr;</a>
                    </div>
                </div>
            </div>
            <div class="card-footer text-muted">
                Uploaded on <?= $car['created_at'] ?> by <a href="<?=$customerUrl?>"><?= $car['customerName']?></a>
            </div>
        </div>
    <?php } ?>

    <!-- Pagination -->
<!--    <ul class="pagination justify-content-center mb-4">-->
<!--        <li class="page-item">-->
<!--            <a class="page-link" href="#">&larr; Older</a>-->
<!--        </li>-->
<!--        <li class="page-item disabled">-->
<!--            <a class="page-link" href="#">Newer &rarr;</a>-->
<!--        </li>-->
<!--    </ul>-->

</div>
<!-- /.container -->
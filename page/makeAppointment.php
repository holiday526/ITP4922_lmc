<?php
echo "\$_GET";
//dd($_GET);
if (!isset($_SESSION['customer'])){
    $_SESSION['ERROR'] = "Making appointments require login!";
    header("location: /?route=login");
}
if (isset($_GET['carId'], $_GET['customerId'])){
    $temp = queryBuilderPrepare('cars',
        ['*'],
        ['cars.id'=>$_GET['carId']],
//        ['carId'=>$_GET['carId'], 'customerId'=>$_GET['customerId']],
        [],
        [['customers', 'cars.ownerId', 'customers.id']]
    );
    dd($temp);
}

?>
<div class="container">
    <div class="row">
        <div class="col -1-12">
            <div class="card">
                <div class="card-body">
                    <h3 class="card-title">Title</h3>
                    <p class="card-text">Text</p>
                </div>
            </div>
        </div>
        <div class="col-xs-1-12">
            <div class="card">
                <div class="card-body">
                    <h3 class="card-title">Title</h3>
                    <p class="card-text">Text</p>
                </div>
            </div>
        </div>
    </div>
</div>
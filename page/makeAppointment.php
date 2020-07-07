<?php
session_start();

if (!isset($_SESSION['customer']['id'])) {
    $_SESSION['ERROR'] = "Making appointments require login!";
    header("location: /?route=login");
}
if (isset($_GET['carId'])) {
    $car = queryBuilderPrepare('cars',
        ['cars.name as carName', 'customers.name as customerName', 'cars.description', 'cars.photoLocation', 'cars.id as carId'],
        ['cars.id' => $_GET['carId']],
//        ['carId'=>$_GET['carId'], 'customerId'=>$_GET['customerId']],
        [],
        [['customers', 'cars.ownerId', 'customers.id']]
    )[0];
    dd($car);
}

?>
<div class="container">
    <div class="card">
        <div class="card-header">
            <h2>Appointment Form</h2>
        </div>
        <div class="row">
            <div class="col-6">
                <div class="card-body">
                    <img class="card-img" src="<?=$car['photoLocation']?>" alt="" style="height: 320px; width: 500px;">
                    <div class="card-body">
                        <h3 class="font-weight-bold "><?= $car['carName'] ?></h3>
                        <p><?= $car['description'] ?></p>
                    </div>
                </div>
            </div>
            <div class="col-6">
                <div class="card-body">
                    <h3 class="my-3">Project Description</h3>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam viverra euismod odio, gravida
                        pellentesque urna varius vitae. Sed dui lorem, adipiscing in adipiscing et, interdum nec metus.
                        Mauris ultricies, justo eu convallis placerat, felis enim.</p>
                    <h3 class="my-3">Project Details</h3>
                    <ul>
                        <li>Lorem Ipsum</li>
                        <li>Dolor Sit Amet</li>
                        <li>Consectetur</li>
                        <li>Adipiscing Elit</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <form action="../handler/appointmentHandler.php?action=make&carId=<?=$car['carId']?>" method="post">
                <button class="btn btn-danger">Confirm book appointment</button>
            </form>
        </div>
        <!-- /.row -->

    </div>
</div>
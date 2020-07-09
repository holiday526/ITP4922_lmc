<?php
session_start();

if ($_GET['route'] !== 'makeAppointment' || empty($_GET['carId']) || $_SERVER['REQUEST_METHOD'] != 'GET') { ?>
    <script>
        alert('Bad request!');
        window.location.replace(window.location.origin + '/?route=home');
    </script>
    <?php die('Bad request!'); ?>
<?php } ?>

<?php $auth = (isset($_SESSION['customer']) || isset($_SESSION['admin'])); ?>
<?php $user = isset($_SESSION['customer']) ? $_SESSION['customer'] : $_SESSION['admin']; ?>

<?php if (!$auth) { ?>
    <script>
        alert('Making appointments require login!');
        window.location.replace(window.location.origin + '/?route=login');
    </script>
<?php } ?>

<?php if ($car['ownerId'] == $user['id']) { ?>
    <script>
        alert('You can not make appointment to your own car!');
        window.location.replace(window.location.origin + '/?route=catalog');
    </script>
    <?php die('appointment own car'); ?>
<?php } ?>

<?php $car = queryBuilderPrepare('cars',
    ['cars.name as carName', 'customers.name as customerName', 'cars.description', 'cars.photoLocation', 'cars.id as carId', 'customers.name as ownerName'],
    ['cars.id' => $_GET['carId']],
//        ['carId'=>$_GET['carId'], 'customerId'=>$_GET['customerId']],
    [],
    [['customers', 'cars.ownerId', 'customers.id']]
)[0];?>

<?php if (!$car) { ?>
    <script>
        alert('no such car existed');
        window.location.replace(window.location.origin + '/?route=catalog');
    </script>
    <?php die('Car id not exist'); ?>
<?php } ?>

<div class="container">
    <div class="card">
        <form action="../handler/appointmentHandler.php" method="post">
            <div class="card-header">
                <h2>Appointment Form</h2>
            </div>
            <div class="row">
                <div class="col-6">
                    <div class="card-body">
                        <img class="card-img car-img" src="<?= $car['photoLocation'] ?>" alt="">
                        <div class="card-body">
                            <h3 class="font-weight-bold "><?= $car['carName'] ?></h3>
                            <p><?= $car['description'] ?></p>
                        </div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="card-body">
                        <h4>Appointment detail</h4>
                        <div class="form-group">
                            <label for="ownerName">Owner Name: </label>
                            <input type="text" class="form-control" name="ownerName" id="ownerName"
                                   value="<?= $car['ownerName'] ?>" disabled>
                        </div>
                        <div class="form-group">
                            <label for="appointmentDateTime">Meeting Data and Time:</label>
                            <input type="datetime-local" class="form-control" name="appointmentDateTime"
                                   id="appointmentDateTime" required>
                        </div>
                        <div class="form-group">
                            <label for="appointmentNotes">Note to owner</label>
                            <textarea class="form-control" name="appointmentNotes" id="appointmentNotes" cols="30"
                                      rows="8"></textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <input type="hidden" name="action" value="make">
                <input type="hidden" name="carId" value="<?= $car['carId'] ?>">
                <div class="form-group">
                    <button class="btn btn-danger form-control">Confirm book appointment</button>

                </div>
            </div>
        </form>
    </div>
</div>
<?php
session_start();

if (!isset($_SESSION['customer']['id'])) { ?>
    <script>
        alert('Making appointments require login!');
        window.location.replace(window.location.origin + '/?route=login');
    </script>
<?php }
if (isset($_GET['carId'])) {
    $car = queryBuilderPrepare('cars',
        ['cars.name as carName', 'customers.name as customerName', 'cars.description', 'cars.photoLocation', 'cars.id as carId', 'customers.name as ownerName'],
        ['cars.id' => $_GET['carId']],
//        ['carId'=>$_GET['carId'], 'customerId'=>$_GET['customerId']],
        [],
        [['customers', 'cars.ownerId', 'customers.id']]
    )[0];
}

?>
<div class="container">
    <div class="card">
        <form action="../handler/appointmentHandler.php" method="post">
            <div class="card-header">
                <h2>Appointment Form</h2>
            </div>
            <div class="row">
                <div class="col-6">
                    <div class="card-body">
                        <img class="card-img" src="<?= $car['photoLocation'] ?>" alt=""
                             style="height: 320px; width: 500px;">
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
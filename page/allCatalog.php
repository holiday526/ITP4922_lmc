<?php
session_start();

$auth = isset($_SESSION['admin']);

if ($auth) {
    $cars = queryBuilderPrepare('cars', ['*']);
?>
    <div class="container">
        <h3 class="py-2">Manage Car Catalogs</h3>
        <table class="table table-hover">
            <thead>
            <tr>
                <th scope="col">Car ID</th>
                <th scope="col">Car Name</th>
                <th scope="col">Old Car?</th>
                <th scope="col">Owner ID</th>
                <th scope="col">Sold?</th>
                <th scope="col">Brand Name</th>
                <th scope="col">Created at</th>
                <th scope="col">delete</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($cars as $car) { ?>
                <tr>
                    <td><?= $car['id'] ?></td>
                    <td><?= $car['name'] ?></td>
                    <td><?= $car['oldCar'] ? "2nd hand" : "New"?></td>
                    <td><?= $car['ownerId'] ?></td>
                    <td><?= $car['sold'] ? "sold" : "-" ?></td>
                    <td><?= $car['brandName'] ?></td>
                    <td><?= $car['created_at'] ?></td>
                    <td>
                        <form action="../handler/deleteCarAdHandler.php" method="post">
                            <?php if($car['sold']) { ?>
                            <input type="submit" class="btn btn-danger disabled" value="Delete" name="catalogAction" disabled>
                            <?php } else { ?>
                            <input type="hidden" value="<?= $car['id'] ?>" name="carId">
                            <input type="submit" class="btn btn-danger" value="Delete" name="catalogAction">
                            <?php } ?>
                        </form>
                    </td>
                    <td>
                        <?php if($car['sold']) { ?>
                            <a class="btn btn-warning disabled" disabled>Update</a>
                        <?php } else { ?>
                            <a class="btn btn-warning" href="/?route=adminUpdate&carId=<?= $car['id'] ?>">Update</a>
                        <?php } ?>
                    </td>
                </tr>

            <?php } ?>
            </tbody>
        </table>
    </div>
<?php
} else {
?>
    <script>
        window.location.replace(window.location.origin + '/?route=');
    </script>
<?php
}
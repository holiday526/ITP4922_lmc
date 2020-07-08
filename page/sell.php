<?php
session_start();

$auth = (isset($_SESSION['customer']) || isset($_SESSION['admin']));

if ($auth) {
    if (!isset($_GET['type'])) {
?>
<!-- sell a car page -->
<div class="container">
    <h4 class="pt-2">Sell a car</h4>
    <form action="../handler/sellCarHandler.php" method="post" enctype="multipart/form-data">
        <div class="form-group">
            <label for="carNameInput">Car Name</label>
            <input type="text" name="name" class="form-control" id="carNameInput" placeholder="Enter Car Name" required>
        </div>
        <div class="form-group">
            <label for="descriptionInput">Car Description</label>
            <input type="text" name="description" class="form-control" id="descriptionInput" placeholder="Enter Description" required>
        </div>
        <div class="form-group">
            <label for="carPhotoFile">Car Image (Only one image)</label>
            <input type="file" class="form-control-file" id="carPhotoFile" name="carPhoto">
        </div>
        <div class="flex-row">
            <label class="form-check-label">Selling Method</label>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="bid" id="fixedprice" value="0" checked>
                <label class="form-check-label" for="fixedprice">
                    Fixed Price
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="bid" id="Bidding" value="1">
                <label class="form-check-label" for="Bidding">
                    Bidding
                </label>
            </div>
        </div>
        <div class="form-group">
            <label for="retailPriceInput">Start bid</label>
            <input type="number" name="retailPrice" class="form-control" id="retailPriceInput"  min="0" required>
        </div>
        <div class="form-group">
            <label for="productCostInput">Product Cost</label>
            <input type="number" name="productCost" class="form-control" id="productCostInput"  min="0" required>
        </div>
        <input type="hidden" name="oldCar" value="1">
        <?php if ($_SESSION['customer']) { ?>
        <input type="hidden" name="ownerId" value="<?= $_SESSION['customer']['id'] ?>">
        <?php } else if ($_SESSION['admin']) { ?>
        <input type="hidden" name="ownerId" value="<?= $_SESSION['admin']['id'] ?>">
        <?php } ?>
        <input type="hidden" name="sold" value="0">
        <div class="form-group">
            <label for="brandNameInput">Brand Name</label>
            <input type="text" name="brandName" class="form-control" id="brandNameInput"  min="0" required>
        </div>
        <div class="form-group">
            <label for="prosTextArea">Pros</label>
            <textarea class="form-control" id="prosTextArea" name="pros" rows="3" required></textarea>
        </div>
        <div class="form-group">
            <label for="consTextArea">Cons</label>
            <textarea class="form-control" id="consTextArea" name="cons" rows="3" required></textarea>
        </div>
        <div class="form-group">
            <label for="specificationsTextArea">Specifications</label>
            <textarea class="form-control" id="specificationsTextArea" name="specifications" rows="3" required></textarea>
        </div>
        <div class="form-group">
            <label for="fuelTypeSelect">Fuel Types</label>
            <?php $fuel_types = queryBuilderPrepare('fuel_types', ['*']) ?>
            <select class="form-control" id="fuelTypeSelect" name="fuel_typesId">
                <?php foreach ($fuel_types as $record) { ?>
                    <option value="<?= $record['id'] ?>"><?=$record['name']?></option>
                <?php } ?>
            </select>
        </div>
        <div class="form-group form-row">
            <div class="col-6 mx-auto">
                <input type="submit" value="Sell a car" class="btn btn-primary btn-block">
            </div>
        </div>
    </form>
</div>
<?php
    } else if (isset($_GET['type']) && $_GET['type'] === "show") {
        // show all sells
?>
        <div class="container">
            <?php
            if ($_SESSION['customer']) {
                $selling_cars = queryBuilderPrepare(
                        'cars',
                    '*',
                    ['ownerId'=>$_SESSION['customer']['id']],
                    ['created_at'=>'desc']
                );
            } else if ($_SESSION['admin']) {
                $selling_cars = queryBuilderPrepare(
                    'cars',
                    '*',
                    ['ownerId'=>$_SESSION['admin']['id']],
                    ['created_at'=>'desc']
                );
            }
//            dd($selling_cars); ?>
            <h1 class="mt-4 mb-3">Your selling cars
                <small>count: <?= count($selling_cars) ?></small>
            </h1>
            <?php
            $first = true;
            foreach ($selling_cars as $selling_car) {
//                dd($selling_car);
                if ($first) {
            ?>
                    <div class="row my-2">
                        <div class="col-md-7">
                            <div class="card">
                                <img class="card-img rounded mb-3 mb-md-0" src="<?= $selling_car['photoLocation'] ?>" alt="">
                                <?php if ($selling_car['sold']) { ?>
                                <div class="card-img-overlay text-black-50 d-flex justify-content-center align-items-end"><p>Sold</p></div>
                                <?php } ?>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <h3><?= $selling_car['name'] ?></h3>
                            <p>Description: <?= $selling_car['description'] ?></p>
                            <p>Product Cost: $<?= $selling_car['productCost'] ?></p>
                            <p>Current Price: $<?= $selling_car['retailPrice'] ?></p>
                            <a class="btn btn-primary" href="/?route=update&carId=<?= $selling_car['id'] ?>">Update selling cars
                                <span class="glyphicon glyphicon-chevron-right"></span>
                            </a>
                            <button id="delete_id" class="btn btn-danger gg" onclick="setDelete(<?= $selling_car['id'] ?>)">Delete</button>
                        </div>
                    </div>
            <?php
                    $first = false;
                } else {
            ?>
                    <hr>
                    <div class="row my-2">
                        <div class="col-md-7">
                            <div class="card">
                                <img class="card-img rounded mb-3 mb-md-0" src="<?= $selling_car['photoLocation'] ?>" alt="">
                                <?php if ($selling_car['sold']) { ?>
                                    <div class="card-img-overlay text-black-50 d-flex justify-content-center align-items-end"><p>Sold</p></div>
                                <?php } ?>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <h3><?= $selling_car['name'] ?></h3>
                            <p><?= $selling_car['description'] ?></p>
                            <p>Product Cost: $<?= $selling_car['productCost'] ?></p>
                            <p>Current Price: $<?= $selling_car['retailPrice'] ?></p>
                            <a class="btn btn-primary" href="/?route=update&carId=<?= $selling_car['id'] ?>">Update selling cars
                                <span class="glyphicon glyphicon-chevron-right"></span>
                            </a>
                            <button id="delete_id" class="btn btn-danger gg" onclick="setDelete(<?= $selling_car['id'] ?>)">Delete</button>
                        </div>
                    </div>
            <?php
                }
            }
            ?>
            <div id="delete-confirm" class="modal"  data-backdrop="static" data-keyboard="false">
                <div class="vertical-alignment-helper">
                    <div class="modal-dialog vertical-align-center">
                        <div class="modal-content">
                            <div class="modal-header">

                                <h4 class="modal-title  text-center"> Attention</h4>
                            </div>
                            <div class="modal-body">
                                <p class="text-center">Are you sure you want to delete this car ad?</p>
                                <form action="../handler/deleteCarAdHandler.php" method="post">
                                    <input type="hidden" id="car_delete_id" name="carId">
                                    <?php if($_SESSION['admin']) { ?>
                                    <input type="hidden" name="ownerId" value="<?= $_SESSION['admin']['id'] ?>">
                                    <?php } elseif ($_SESSION['customer']) { ?>
                                    <input type="hidden" name="ownerId" value="<?= $_SESSION['customer']['id'] ?>">
                                    <?php } ?>
                                    <div class="text-center" >
                                        <button type="submit" class=" btn btn-success"> Okay</button>
                                        <button type="button" class=" btn btn-danger" data-dismiss="modal" >Cancel</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script>
            let gg_buttons = document.getElementsByClassName('gg');
            for (let i = 0; i < gg_buttons.length; i++) {
                gg_buttons[i].addEventListener('click', function(){
                    $('#delete-confirm').modal('show');
                    document.getElementById('car_delete_id').value = getDelete();
                });
            }
            let deleteId;

            function setDelete(id) {
                this.deleteId = id
            }

            function getDelete() {
                return this.deleteId
            }
        </script>
<?php
?>

<?php
    } else if (isset($_GET['type']) && $_GET['type'] === "appointment") {
//        show all appointments
?>
        <div class="container">
            <h4 class="my-2">All appointments</h4>
        </div>
<?php
    } else {
?>
    <script>
        window.location.replace(window.location.origin+'/?route=sell');
    </script>
<?php
    }
} else {
?>
    <script>
        window.location.replace(window.location.origin + '/?route=login');
    </script>
<?php
}
?>
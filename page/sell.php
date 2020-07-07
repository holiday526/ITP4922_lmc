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
        <div class="form-group">
            <label for="retailPriceInput">Retail Price</label>
            <input type="number" name="retailPrice" class="form-control" id="retailPriceInput"  min="0" required>
        </div>
        <div class="form-group">
            <label for="productCostInput">Retail Price</label>
            <input type="number" name="productCost" class="form-control" id="productCostInput"  min="0" required>
        </div>
        <input type="hidden" name="oldCar" value="1">
        <input type="hidden" name="ownerId" value="<?= $_SESSION['customer']['id'] ?>">
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
            <select class="form-control" id="fuelTypeSelect">
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
            <?php $selling_cars = queryBuilderPrepare(
                    'cars',
                '*',
                ['ownerId'=>$_SESSION['customer']['id']],
                ['created_at'=>'desc']
            );
//            dd($selling_cars); ?>
            <h1 class="mt-4 mb-3">Your selling cars
                <small>count: <?= count($selling_cars) ?></small>
            </h1>
            <?php
            $first = true;
            foreach ($selling_cars as $selling_car) {
                if ($first) {
            ?>
                    <div class="row my-2">
                        <div class="col-md-7">
                            <a href="#">
                                <img class="img-fluid rounded mb-3 mb-md-0" src="http://placehold.it/700x300" alt="">
                            </a>
                        </div>
                        <div class="col-md-5">
                            <h3>Project One</h3>
                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Laudantium veniam exercitationem expedita laborum at voluptate. Labore, voluptates totam at aut nemo deserunt rem magni pariatur quos perspiciatis atque eveniet unde.</p>
                            <a class="btn btn-primary" href="#">View Project
                                <span class="glyphicon glyphicon-chevron-right"></span>
                            </a>
                        </div>
                    </div>
            <?php
                    $first = false;
                } else {
            ?>
                    <hr>
                    <div class="row my-2">
                        <div class="col-md-7">
                            <a href="#">
                                <img class="img-fluid rounded mb-3 mb-md-0" src="http://placehold.it/700x300" alt="">
                            </a>
                        </div>
                        <div class="col-md-5">
                            <h3>Project One</h3>
                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Laudantium veniam exercitationem expedita laborum at voluptate. Labore, voluptates totam at aut nemo deserunt rem magni pariatur quos perspiciatis atque eveniet unde.</p>
                            <a class="btn btn-primary" href="#">View Project
                                <span class="glyphicon glyphicon-chevron-right"></span>
                            </a>
                        </div>
                    </div>
            <?php
                }
            }
            ?>
        </div>
<?php
?>

<?php
    } else if (isset($_GET['type']) && $_GET['type'] === "appointment") {
//        show all appointments
?>

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
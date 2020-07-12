<?php
session_start();

$auth = isset($_SESSION['admin']);

if ($auth) {
    $car = queryBuilderPrepare('cars', ['*'], ['id'=>$_GET['carId']])[0];
?>
    <div class="container">
        <h3 class="mt-2">View and update your ad</h3><span class="text-info h4">Car status: <?= $car['sold'] ? "sold" : "Not sold" ?></span>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="card">
                        <img src="<?= $car['photoLocation'] ?>" class="card-img rounded mb-3 mb-md-0" alt="">
                        <?php if ($car['sold']) { ?>
                            <div class="card-img-overlay text-black-50 d-flex justify-content-center align-items-end"><p>Sold</p></div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
        <form action="../handler/adminUpdateSellAdHandler.php" method="post">
            <div class="form-group">
                <label for="carId">Car Id</label>
                <input type="text" class="form-control" id="carId" value="<?= $car['id'] ?>" disabled required>
                <input type="hidden" name="id" value="<?= $car['id'] ?>">
            </div>
            <div class="form-group">
                <label for="carNameInput">Car Name</label>
                <input type="text" name="name" class="form-control" id="carNameInput" placeholder="Enter Car Name" value="<?= $car['name'] ?>" required>
            </div>
            <div class="form-group">
                <label for="descriptionInput">Car Description</label>
                <input type="text" name="description" class="form-control" id="descriptionInput" placeholder="Enter Description" value="<?= $car['description'] ?>" required>
            </div>
            <div class="form-group">
                <label for="retailPriceInput">Current Price</label>
                <input type="number" name="retailPrice" class="form-control" id="retailPriceInput" value="<?= $car['retailPrice'] ?>" disabled>
            </div>
            <div class="form-group">
                <label for="productCostInput">Product Cost</label>
                <input type="number" name="productCost" class="form-control" id="productCostInput" value="<?= $car['productCost'] ?>" disabled>
            </div>
            <div class="form-group">
                <label for="brandNameInput">Brand Name</label>
                <input type="text" name="brandName" class="form-control" id="brandNameInput" value="<?= $car['brandName'] ?>" min="0" required>
            </div>
            <div class="form-group">
                <label for="prosTextArea">Pros</label>
                <textarea class="form-control" id="prosTextArea" name="pros" rows="3" required><?= $car['pros'] ?></textarea>
            </div>
            <div class="form-group">
                <label for="consTextArea">Cons</label>
                <textarea class="form-control" id="consTextArea" name="cons" rows="3" required><?= $car['cons'] ?></textarea>
            </div>
            <div class="form-group">
                <label for="specificationsTextArea">Specifications</label>
                <textarea class="form-control" id="specificationsTextArea" name="specifications" rows="3" required><?= $car['specifications'] ?></textarea>
            </div>
            <div class="form-group">
                <label for="fuelTypeSelect">Fuel Types</label>
                <?php $fuel_types = queryBuilderPrepare('fuel_types', ['*']) ?>
                <?php $car['fuel_typesId'] = empty($car['fuel_typesId']) ? 1 : $car['fuel_typesId'] ?>
                <?php $selected_fuel_types = queryBuilderPrepare('fuel_types', ['*'], ['id'=>$car['fuel_typesId']])[0] ?>
                <select class="form-control" id="fuelTypeSelect" name="fuel_typesId">
                    <option value="<?= $car['fuel_typesId'] ?>" selected><?= $selected_fuel_types['name'] ?></option>
                    <?php foreach ($fuel_types as $record) { ?>
                        <option value="<?= $record['id'] ?>"><?=$record['name']?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="form-group form-row">
                <div class="col-6 mx-auto">
                    <input type="submit" value="Update car ad" class="btn btn-success btn-block">
                </div>
            </div>
        </form>
    </div>
<?php
} else {
?>
    <script>
        window.location.replace(window.location.origin + '/?route=');
    </script>
<?php
}


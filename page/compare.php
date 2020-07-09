<?php
session_start();

if (!empty($_SESSION['compareList'])) {
    if (count(array_filter($_SESSION['compareList'])) >= 2) {
        $carComparing = queryBuilderPrepare('cars', ['*'], ['id' => $_SESSION['compareList']]);
    } else { ?>
        <script>
            alert('You need to select at least two car to compare');
            window.location.replace(window.location.origin + '/?route=catalog');
        </script>
    <?php }
} else { ?>
    <script>
        alert('You compare list is empty, you can click the add to compare button to compare car model.');
        window.location.replace(window.location.origin + '/?route=catalog');
    </script>
<?php } ?>

<div class="container pt-2">
    <h2>compare result</h2>
    <div class="row">
        <div class="col-12">
            <div class="card-group">
                <?php foreach ($carComparing as $car) { ?>
                    <div class="card text-left">
                        <img class="card-img-top mx-auto d-block py-2"
                             style="max-width: 100%; max-height: 100%;object-fit: scale-down"
                             src="<?= $car['photoLocation'] ?>"
                             height="200px" alt="Card image cap">
                        <div class="card-body d-flex flex-column align-items-stretch mt-auto">
                            <h3 class="card-title"><?= $car['name'] ?></h3>
                            <p class="card-text"><?= $car["description"] ?></p>
                        </div>

                        <div class="card-body mt-auto">
                            <h5 class="card-title">Pros</h5>
                            <div>
                                <?php foreach (explode("\n", $car['pros']) as $pros) { ?>
                                    <p class="card-text text-success"><?= $pros ?></p>
                                <?php } ?>
                            </div>
                        </div>

                        <div class="card-body align-items-stretch mt-auto">
                            <h5 class="card-title">Cons</h5>
                            <div>
                                <?php foreach (explode("\n", $car['cons']) as $cons) { ?>
                                    <p class="card-text text-danger"><?= $cons ?></p>
                                <?php } ?>
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

                        <div class="card-footer d-flex flex-row">
                            <?php if (in_array($car['id'], $_SESSION['compareList'])) { ?>
                                <a href="/?route=catalog&carId=<?= $car['id'] ?>"
                                   class="btn btn-info d-flex flex-column px-3">Detail</a>
                                <a href="/?route=orderCreate&carId=<?= $car['id'] ?>"
                                   class="btn btn-success d-flex flex-column px-3">Order
                                    Now!</a>
                                <a class="btn btn-danger d-flex flex-column px-3"
                                   href="/?route=catalog&delcompare=<?= $car['id'] ?>">Remove
                                    from compare</a>
                            <?php } ?>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
</div>

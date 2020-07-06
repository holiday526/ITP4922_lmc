<?php
$carComparing = queryBuilderPrepare('cars', ['*'], ['id' => [1, 2, 3]]);
//echo "<pre>";
//var_dump($carComparing);
//echo "</pre>";
?>

<div class="container pt-2">
    <h2>compare result</h2>
    <div class="row">
        <div class="col-12">
            <div class="card-group">
                <?php foreach ($carComparing as $car) { ?>
                <div class="card text-left">
                    <img class="card-img-top mx-auto d-block py-2"
                         style="max-width: 100%; max-height: 100%;object-fit: scale-down"
                         src="<?= $car['photoLocation']?>"
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
                </div>
                <?php } ?>
            </div>
        </div>
    </div>
</div>

<?php
session_start();

require_once 'DBFunctions.php';

$auth = (isset($_SESSION['customer']) || isset($_SESSION['admin']));
$user = null;
if ($auth) {
    $user = isset($_SESSION['customer']) ? $_SESSION['customer'] : $_SESSION['admin'];
}
?>
<div class="container">
    <h1 class="mt-4 mb-3">Search result</h1>
    <?php
    $cars = searchPrepare($_POST['search']);
//    dd($cars);
    foreach ($cars as $car) {
        if ((!empty($user) && $user['id'] === $car['ownerId']) || $car['sold']) {
            continue;
        } else {
            ?>
            <div class="card mb-4">
                <div class="card-body">
                    <div class="row">
                        <div class="col-6">
                            <a href="/?route=catalog&carId=<?= $car['id'] ?>">
                                <img class="img-fluid rounded" src="<?= $car['photoLocation'] ?>" alt="">
                            </a>
                        </div>
                        <div class="col-6">
                            <h2 class="card-title"><?= $car['name'] ?></h2>
                            <p class="card-text"><?= $car['description'] ?></p>
                            <div class="row py-1 justify-content-around">
                                <a href="/?route=catalog&carId=<?= $car['id'] ?>" class="btn btn-primary col-5">Read More &rarr;</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer text-muted">
                    Uploaded on <?= $car['created_at'] ?>
                </div>
            </div>
            <?php
        }
    }
    ?>
</div>

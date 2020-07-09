<?php
session_start();

$auth = isset($_SESSION['admin']);

if ($auth) {
    $orders = queryBuilderPrepare('orders', ['*']);
    ?>
    <div class="container">
        <h4 class="py-2">All orders</h4>
        <table class="table table-hover">
            <thead>
            <tr>
                <th scope="col">Order ID</th>
                <th scope="col">Car ID</th>
                <th scope="col">Customer ID</th>
                <th scope="col">Create at</th>
                <th scope="col">Processed</th>
                <th scope="col">Delete</th>
                <th scope="col">Sold</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($orders as $order) {
                ?>
                <tr>
                    <td><?= $order['id'] ?></td>
                    <td><?= $order['carId'] ?></td>
                    <td><?= $order['customerId'] ?></td>
                    <td><?= $order['created_at'] ?></td>
                    <td><?= empty($order['processed']) ? "No" : "Yes" ?></td>
                    <td>
                        <form action="../handler/adminOrderHandler.php" method="post">
                            <?php if (empty($order['processed'])) { ?>
                                <input type="hidden" value="<?= $order['carId'] ?>" name="carId">
                                <input type="hidden" value="<?= $order['id'] ?>" name="orderId">
                                <input type="submit" class="btn btn-danger" value="Delete" name="orderAction">
                            <?php } else { ?>
                                <button class="btn btn-danger disabled" disabled>Delete</button>
                            <?php } ?>
                        </form>
                    </td>
                    <td>
                        <form action="../handler/adminOrderHandler.php" method="post">
                            <?php if (empty($order['processed'])) { ?>
                                <input type="hidden" value="<?= $order['carId'] ?>" name="carId">
                                <input type="hidden" value="<?= $order['id'] ?>" name="orderId">
                                <input type="submit" class="btn btn-success" value="Mark as sold" name="orderAction">
                            <?php } else { ?>
                                <button class="btn btn-success disabled" disabled>Mark as sold</button>
                            <?php } ?>
                        </form>
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

?>


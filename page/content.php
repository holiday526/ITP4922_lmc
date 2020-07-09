<div class="container">

<?php
dd(queryBuilderPrepare('cars',
    ['cars.name as carName', 'cars.id as carId', 'customers.id as customerId'],
    ['cars.id'=>$_GET['carId']],
    [],
    [['customers', 'cars.ownerId', 'customers.id']]
));
?>

</div>
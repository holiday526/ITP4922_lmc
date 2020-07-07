<div class="container">

<?php
dd(queryBuilderPrepare('cars', ['*'], ['customers.id'=>'C000001'], [], [['customers', 'customers.id', 'cars.ownerId']]));
?>

</div>
<div class="container">

<?php
dd(queryBuilderPrepare('cars',
    ['cars.id', 'cars.sold', 'cars.ownerId', 'cars.name as carName', 'cars.photoLocation', 'cars.description as carDescription', 'cars.odometer', 'cars.transmission', 'cars.fuel_typesId', 'cars.retailPrice'],
    ['cars.id' => 4]
));
?>

</div>
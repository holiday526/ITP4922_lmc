<?php

require_once 'DBFunctions.php';

?>
<div class="container">
    <h3>Search result:</h3>
    <?php
    dd($_POST);
    dd(searchPrepare($_POST['search']));
    ?>
</div>

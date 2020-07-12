<?php
session_start();

require_once '../DBFunctions.php';

$auth = isset($_SESSION['admin']);

//dd($_POST);

if ($auth) {
    $updated = updatePrepare("cars", $_POST, ['id'=>$_POST['id']]);
?>
    <script>
        alert("Car id: <?= $_POST['id'] ?> is updated");
        window.location.replace(window.location.origin + '/?route=allCatalog');
    </script>
<?php
} else {
?>
    <script>
        window.location.replace(window.location.origin + '/?route=');
    </script>
<?php
}
?>

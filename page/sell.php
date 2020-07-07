<?php
session_start();

$auth = isset($_SESSION['customer']);

if ($auth) {
?>

<?php
}
?>
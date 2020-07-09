<?php
session_start();
require_once "../DBFunctions.php";
?>

<?php if (empty($_POST['carId']) || $_POST['action'] !== 'make' || $_SERVER['REQUEST_METHOD'] != 'POST') { ?>
    <script>
        alert('Bad request!');
        window.location.replace(window.location.origin + '/?route=home');
    </script>
    <?php die('Bad request'); ?>
<?php } ?>

<?php if (!isset($_POST['carId'], $_POST['appointmentDateTime'], $_POST['appointmentNotes'])) { ?>
    <script>
        alert('Appointment form incorrect!');
        window.location.replace(window.location.origin + '/?route=login');
    </script>
    <?php die('form validation failed'); ?>
<?php } ?>

<?php $auth = (isset($_SESSION['customer']) || isset($_SESSION['admin'])); ?>
<?php $user = isset($_SESSION['customer']) ? $_SESSION['customer'] : $_SESSION['admin']; ?>

<?php if (!$auth) { ?>
    <script>
        alert('Making appointments require login!');
        window.location.replace(window.location.origin + '/?route=login');
    </script>
    <?php die('require login'); ?>
<?php } ?>

<?php $car = queryBuilderPrepare('cars', ['id'], ['id' => $_POST['carId']]); ?>
<?php if (!$car) { ?>
    <script>
        alert('no such car existed');
        window.location.replace(window.location.origin + '/?route=catalog');
    </script>
    <?php die('car id not existed'); ?>
<?php } ?>

<?php $result = createAppointment($_POST['carId'], datetime_localToTimestamp($_POST['appointmentDateTime']), $_POST['appointmentNotes']); ?>
<?php if (!$result) { ?>
    <script>
        alert('Appointment request fail!');
        window.location.replace(window.location.origin + '/?route=catalog');
    </script>
<?php } else { ?>
    <script>
        alert('Appointment made!');
        window.location.replace(window.location.origin + '/?route=catalog');
    </script>
<?php } ?>

<?php
function createAppointment($carId, $appointmentDateTime, $appointNotes)
{
    global $user;
    return insertPrepare('appointments',
        ['carId', 'appointmentUserId', 'appointmentDateTime', 'appointmentNotes'],
        [$_POST['carId'], $user['id'], datetime_localToTimestamp($appointmentDateTime), $appointNotes]
    );
}

function datetime_localToTimestamp($datetime)
{
    return gmdate('Y-m-d H:i:s', strtotime($datetime));
}
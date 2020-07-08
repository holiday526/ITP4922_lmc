<?php
session_start();
require_once "../DBFunctions.php";

if (!isset($_SESSION['customer']['id'])) { ?>
    <script>
        alert('Making appointments require login!');
        window.location.replace(window.location.origin + '/?route=login');
    </script>
<?php }

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    if (isset($_POST['action']) && $_POST['action'] === 'make') {
        if (isset($_POST['carId'], $_POST['appointmentDateTime'], $_POST['appointmentNotes'])) {
            if (queryBuilderPrepare('cars', ['id'], ['id' => $_POST['carId']]) != null) {
                createAppointment($_POST['carId'], datetime_localToTimestamp($_POST['appointmentDateTime']), $_POST['appointmentNotes']); ?>
                <script>
                    alert('Appointment made!');
                    window.location.replace(window.location.origin + '/?route=catalog');
                </script>
            <?php } else { ?>
                <script>
                    alert('no such car existed');
                    window.location.replace(window.location.origin + '/?route=catalog');
                </script>
            <?php }
        }
    }
}

function createAppointment($carId, $appointmentDateTime, $appointNotes)
{
    insertPrepare('appointments',
        ['carId', 'appointmentUserId', 'appointmentDateTime', 'appointmentNotes'],
        [$_POST['carId'], $_SESSION['customer']['id'], datetime_localToTimestamp($appointmentDateTime), $appointNotes]
    );
}

function datetime_localToTimestamp($datetime)
{
    return gmdate('Y-m-d H:i:s', strtotime($datetime));
}
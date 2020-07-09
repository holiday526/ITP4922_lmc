<?php
session_start();

$auth = (isset($_SESSION['customer']) || isset($_SESSION['admin']));

require_once "../DBFunctions.php";

$appointment = queryBuilderPrepare('appointments', ['*'], ['id'=>$_POST['appointmentId']])[0];

if ($auth) {
    $user = isset($_SESSION['customer']) ? $_SESSION['customer'] : $_SESSION['admin'];
    if ($user['id'] === $appointment['appointmentUserId']) {
        // auth success, do delete
        $deleted = deletePrepare('appointments', ['id'=>$_POST['appointmentId']]);
?>
        <script>
            alert('Delete appointment success');
            window.location.replace(window.location.origin + '/?route=sell&type=appointment');
        </script>
<?php
    } else {
        // not that login ed user, do redirect
?>
        <script>
            alert('You are not allowed to do so');
            window.location.replace(window.location.origin + '/?route=catalog');
        </script>
<?php
    }
} else {
    // need to login
?>
    <script>
        window.location.replace(window.location.origin + '/?route=login');
    </script>
<?php
}
?>

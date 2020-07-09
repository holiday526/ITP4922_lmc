<?php
session_start();

require_once '../DBFunctions.php';

$auth = isset($_SESSION['customer']);

if ($auth) {
    $customer = queryBuilderPrepare('customers', ['password'], ['id'=>$_SESSION['customer']['id']])[0];
    if ($customer['password'] === md5($_POST['originPassword'])) {
        if (md5($_POST['password']) !== md5($_POST['c_password'])) {
?>
            <script>
                alert('Your confirm password is not consistent will your new password');
                window.location.replace(window.location.origin + '/?route=changePassword');
            </script>
<?php
        }
        updatePrepare('customers', ['password'=>md5($_POST['password'])], ['id'=>$_SESSION['customer']['id']]);
?>
        <script>
            alert('Your password is updated! Please login again');
            window.location.replace(window.location.origin + '/logout.php');
        </script>
<?php
    } else {
?>
    <script>
        alert('Your original password is not correct, please try again!');
        window.location.replace(window.location.origin + '/?route=changePassword');
    </script>
<?php
    }
} else {
?>
    <script>
        window.location.replace(window.location.origin + '/?route=');
    </script>
<?php
}

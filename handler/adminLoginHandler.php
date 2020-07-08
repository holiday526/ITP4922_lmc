<?php
session_start();
?>
<?php
require_once "../DBFunctions.php";

$admin = queryBuilderPrepare('admins', ['*'], ['username'=>$_POST['username']])[0];

if (empty($admin)) {
    // no username
?>
    <script>
        alert('Login failed');
        window.location.replace(window.location.origin + '/');
    </script>
<?php
} else if ($admin['password'] !== md5($_POST['password'])) {
    // password invalid
?>
    <script>
        alert('Login failed');
        window.location.replace(window.location.origin + '/');
    </script>
<?php
} else if ($admin['password'] === md5($_POST['password'])) {
    $admin = queryBuilderPrepare('admins', ['id', 'username'], ['username'=>$_POST['username']])[0];
    $_SESSION['admin'] = $admin;
?>
    <script>
        alert('Admin login success');
        window.location.replace(window.location.origin + '/');
    </script>
<?php
} else {
?>
    <script>
        window.location.replace(window.location.origin + '/');
    </script>
<?php
}
?>
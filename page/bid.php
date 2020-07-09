<?php
session_start();

$auth = (isset($_SESSION['customer']) || isset($_SESSION['admin']));

if ($auth) {
    $user = isset($_SESSION['customer']) ? $_SESSION['customer'] : $_SESSION['admin'];
//    $car =
} else {
    // no login
?>
    <script>
        alert('Login first');
        window.location.replace(window.location.origin + "/?route=login");
    </script>
<?php
}
?>

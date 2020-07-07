<?php
session_start();
?>
<?php
require_once "../DBFunctions.php";


$temp_user = queryBuilderPrepare('customers',
    ['uid','password'],
    [ 'uid'=> $_POST['uid'] ]
);

if (!empty($temp_user)) {
    // password error
    if ($temp_user[0]['password'] !== md5($_POST['password'])) {
        $_SESSION['ERROR'] = ["LOGIN" => "Password invalid"];
    } else {
        $_SESSION['customer'] =
            queryBuilderPrepare(
                'customers',
                ['id', 'email', 'uid', 'name', 'corporateCustomer', 'address', 'contactPhones', 'registrationDate', 'updated_at'],
                ['uid'=>$_POST['uid']]
            )[0];
        unset($_SESSION['ERROR']['LOGIN']);
    }
} else {
    $_SESSION['ERROR'] = ["LOGIN" => "No User Name"];
}

if (empty($_SESSION['ERROR']["LOGIN"])) {
?>
    <script>
        // login success
        alert("<?= $_SESSION['customer']['name'] ?>, Welcome to Auto Car Sales Ltd");
        window.location.replace(window.location.origin + '/');
    </script>
<?php
} else {
?>
    <script>
        // login error
        window.location.replace(window.location.origin + '/?route=login');
    </script>
<?php
}

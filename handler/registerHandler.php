<?php

session_start();

require_once "../DBFunctions.php";

$customer_email = queryBuilderPrepare('customers', ['*'], ['email'=>$_POST['email']]);
$customer_username = queryBuilderPrepare('customers', ['*'], ['uid'=>$_POST['uid']]);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!empty($customer_email)) {
        $error_msg = "This email is already registered";
        $_SESSION['ERROR_REGISTER'] = ["EMAIL"=>$error_msg];
    }
    if (!empty($customer_username)) {
        $error_msg = "This username is already used";
        $_SESSION['ERROR_REGISTER'] = ["EMAIL" => $error_msg];
    }
    if (!empty($_SESSION['ERROR_REGISTER'])) {

    }

    $largest_id = queryBuilderPrepare('customers', ['id'], [], ['id'=>'DESC']);
    if (!empty($largest_id)) {

    }

    insertPrepare('customer', []);
}


//insertPrepare(
//        'customers',
//    [],
//    [$_POST['email'], $_POST['password'], $_POST['corporateCustomer'], $_POST['contactPhones']]
//)

?>

<script>
    alert('Welcome to Auto Car Sales Ltd!');
    alert('<?= $_POST["password"] ?>');
    window.location.replace(window.location.origin + '/');
</script>

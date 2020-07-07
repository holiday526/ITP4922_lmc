<?php
session_start();
?>
<?php
require_once "../DBFunctions.php";

$customer_email = queryBuilderPrepare('customers', ['*'], ['email'=>$_POST['email']]);
$customer_username = queryBuilderPrepare('customers', ['*'], ['uid'=>$_POST['uid']]);
dd($customer_email);
dd($customer_username);

echo $_SERVER["REQUEST_METHOD"];

?>
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // have duplicate email
    if (!empty($customer_email)) {
        $error_msg = "This email is already registered";
        $_SESSION['ERROR_REGISTER'] = ["EMAIL"=>$error_msg];
    }
    // have duplicate username
    if (!empty($customer_username)) {
        $error_msg = "This username is already used";
        $_SESSION['ERROR_REGISTER'] = ["EMAIL" => $error_msg];

    }
?>
<?php
    // have errors
    if (!empty($_SESSION['ERROR_REGISTER'])) {
?>
    <script>
        window.location.replace(window.location.origin + '/?route=register');
    </script>
<?php
    }

    // no errors then do insert
    $largest_id = queryBuilderPrepare('customers', ['id'], [], ['id'=>'DESC']);
    if (!empty($largest_id)) {

    }

}

?>

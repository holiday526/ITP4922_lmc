<?php
session_start();
?>
<?php
require_once "../DBFunctions.php";

$customer_email = queryBuilderPrepare('customers', ['*'], ['email'=>$_POST['email']]);
$customer_username = queryBuilderPrepare('customers', ['*'], ['uid'=>$_POST['uid']]);

?>
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // have duplicate email
    if (!empty($customer_email)) {
        $error_msg = "This email is already registered";
        $_SESSION['ERROR_REGISTER'] = ["EMAIL"=>$error_msg];
    } else {
        unset($_SESSION['ERROR_REGISTER']['EMAIL']);
    }
    // have duplicate username
    if (!empty($customer_username)) {
        $error_msg = "This username is already used";
        $_SESSION['ERROR_REGISTER'] = ["USERNAME" => $error_msg];
    } else {
        unset($_SESSION['ERROR_REGISTER']['USERNAME']);
    }

    if ($_POST['password'] !== $_POST['c_password']) {
        $_SESSION['ERROR_REGISTER'] = ["PASSWORD" => "Password invalid"];
    } else {
        unset($_SESSION['ERROR_REGISTER']['PASSWORD']);
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
    $largest_id = queryBuilderPrepare('customers', ['id'], [], ['id'=>'desc'],[], 1);
    if (empty($largest_id)) {
        $id = 'C000001';
    } else {
        $id = str_replace("C", "", $largest_id[0]['id']);
        $id = sprintf("%06d", (int)$id + 1);
        $id = "C".$id;
    }
    $corporate_customer = 0;
    if ($_POST['corporateCustomer'] != null) {
        $corporate_customer = 1;
    }
    $phone = "";
    if (is_array($_POST['contactPhones'])) {
        $temp_str = "";
        $first = true;
        foreach ($_POST['contactPhones'] as $phone) {
            if ($first) {
                $temp_str .= $phone;
                $first = false;
            } else {
                $temp_str .= $phone;
            }
        }
        $phone = $temp_str;
    } else {
        $phone = $_POST['contactPhones'];
    }

    insertPrepare('customers',
        ['id','email','uid','password','name','corporateCustomer','address','contactPhones'],
        [$id, $_POST['email'], $_POST['uid'], md5($_POST['password']), $_POST['customerName'], $corporate_customer, $_POST['address'], $phone]
    );
?>
    <script>
        alert('Welcome to Auto Car Sales Ltd.');
        window.location.replace(window.location.origin + '/?route=login');
    </script>
<?php
}

?>

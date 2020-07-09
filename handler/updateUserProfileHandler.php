<?php
session_start();

require_once "../DBFunctions.php";

$auth = isset($_SESSION['customer']);
if ($auth) {
    $user = $_SESSION['customer'];
    $temp_keys = [];
    $temp_values = [];
    foreach ($_POST as $key => $value) {
        if ($key === "contactPhones") {
            $temp_phones = "";
            for ($i = 0; $i < count($value); $i++) {
                if ($i == 0) {
                    $temp_phones .= $value[$i];
                } else {
                    $temp_phones .= ",".$value[$i];
                }
            }
            array_push($temp_values, $temp_phones);
        } else {
            array_push($temp_values, $value);
        }
        array_push($temp_keys, $key);
    }
    $temp_update_assoc_arr = [];
    for ($i = 0; $i < count($temp_keys); $i++) {
        $temp_update_assoc_arr[$temp_keys[$i]] = $temp_values[$i];
    }
    $updated = updatePrepare('customers', $temp_update_assoc_arr, ['id'=>$_SESSION['customer']['id']]);
//    dd($updated);
    if ($updated) {
?>
        <script>
            alert('Customer profile update success');
            window.location.replace(window.location.origin + '/?route=userProfile');
        </script>
<?php
    } else {
?>
        <script>
            alert('Customer profile update failed');
            window.location.replace(window.location.origin + '/?route=userProfile');
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

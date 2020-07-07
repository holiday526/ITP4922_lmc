<?php

echo $_POST['email'];

dd(queryBuilderPrepare('customers', ['*'], ['email'=>$_POST['email']]));

//insertPrepare(
//        'customers',
//    [],
//    [$_POST['email'], $_POST['password'], $_POST['corporateCustomer'], $_POST['contactPhones']]
//)

?>

<script>
    alert("<?= $_POST["contactPhones"][0] ?>");
    alert("<?= $_POST["contactPhones"][1] ?>");
    alert('Welcome to Auto Car Sales Ltd!');
    window.location.replace(window.location.origin + '/');
</script>

<?php
session_start();
?>


<?php $auth = (isset($_SESSION['customer']) || isset($_SESSION['admin'])); ?>
<?php $user = isset($_SESSION['customer']) ? $_SESSION['customer'] : $_SESSION['admin']; ?>
<?php $customer = queryBuilderPrepare('customers', ['*'], ['id'=>$_SESSION['customer']['id']])[0];
//dd($customer);
?>

<?php if (!$auth) {?>
    <script>
        alert('Login Required!');
        window.location.replace(window.location.origin + '/?route=login');
    </script>
    <?php die('require login'); ?>
<?php } ?>

<div class="container mt-4">
    <h4><?= isset($_SESSION['customer']) ? 'Customer Profile' : 'Admin Profile' ?></h4>
    <form action="../handler/updateUserProfileHandler.php" method="post">
        <div class="form-group">
            <label for="emailInput">Email address</label>
            <input type="email" name="email" class="form-control" id="emailInput" value="<?= $customer['email'] ?>"
                   placeholder="Enter email" disabled>
        </div>
        <div class="form-group">
            <label for="userIdInput">User ID</label>
            <input type="text" name="uid" class="form-control" id="userIdInput" value="<?= $customer['uid'] ?>"
                   placeholder="Enter User ID for login"
                   pattern="^[a-zA-Z][a-zA-Z0-9-_\.]{5,15}$" disabled>
            <small id="passwordHelp" class="form-text text-muted">User ID Length must be 6 - 16 characters.</small>
        </div>
        <div class="form-group">
            <label for="customerNameInput">Customer Name</label>
            <input type="text" name="name" class="form-control" id="customerNameInput"
                   value="<?= $customer['name'] ?>" placeholder="Enter your name">
        </div>
        <div class="form-group">
            <label for="passwordInput">Password</label>
            <input type="password" name="password" class="form-control" id="passwordInput" value="****************"
                   placeholder="Enter password"
                   aria-describedby="passwordHelp" disabled>
            <small id="passwordHelp" class="form-text text-muted">Password Length must be 8 - 20 characters.</small>
        </div>
        <div class="form-group">
            <label for="passwordInputConfirm">Confirm Password</label>
            <input type="password" name="c_password" class="form-control" id="passwordInputConfirm"
                   value="****************" placeholder="Repeat password" aria-describedby="passwordConfirmHelp"
                   disabled>
            <small id="passwordConfirmHelp" class="form-text text-muted">Password Length must be 8 - 20
                characters.</small>
        </div>
        <div class="form-group form-check">
            <input type="checkbox" class="form-check-input" id="corporateCustomerCheckbox" name="corporateCustomer">
            <label class="form-check-label" for="corporateCustomerCheckbox">Corporate Customer?</label>
        </div>
        <div class="form-group">
            <label for="addressTextArea">Address</label>
            <textarea class="form-control" id="addressTextArea" name="address" rows="3"
                      ><?= $customer['address'] ?></textarea>
        </div>
        <div class="form-group">
            <label for="contactPhones">Contact Phones</label>
            <div class="input-group mb-2">
                <?php foreach (explode(',', $customer['contactPhones']) as $phone) { ?>
                    <input type="text" class="form-control" value="<?=$phone?>" placeholder="Phone No." name="contactPhones[]"
                           id="contactPhones">
                <?php } ?>
                <div class="input-group-append">
                    <button class="btn btn-secondary" type="button" onclick="createNewContactPhoneInput()">+</button>
                </div>
            </div>
            <div id="newPhoneContactInput"></div>
        </div>
        <div class="form-group form-row">
            <div class="col-4 mx-auto">
                <input type="submit" class="btn btn-success btn-md btn-block" value="Update profile">
            </div>
            <div class="col-4 mx-auto">
                <a href="?route=logout" class="btn btn-primary btn-md btn-block">Logout Current</a>
            </div>
        </div>
    </form>
</div>

<script>
    function createNewContactPhoneInput() {
        let txtNewInputBox = document.createElement('div');
        txtNewInputBox.innerHTML = "<div class='py-2'><input type='text' id='newInputBox' class='form-control' placeholder='Phone No.' name='contactPhones[]' required></div>";
        document.getElementById("newPhoneContactInput").appendChild(txtNewInputBox);
    }
</script>

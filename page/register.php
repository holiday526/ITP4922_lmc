<?php
session_start();
?>

<?php
if (!empty($_SESSION['ERROR_REGISTER'])) {
?>
    <script>
        $(document).ready(function(){
            $("#registerModal").modal('show');
        });
    </script>
    <div class="modal fade" id="registerModal" tabindex="-1" role="dialog" aria-labelledby="registerModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="registerModalLabel">Modal title</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p class="text-danger">Register Failed</p>
                    <?php foreach ($_SESSION['ERROR_REGISTER'] as $error_key => $error_value) { ?>
                    <p><?= $error_value ?></p>
                    <?php } ?>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
<?php
}

if (isset($_SESSION['customer']) || isset($_SESSION['admin'])) {
?>
    <script>
        // Authed, redirect back to home page
        window.location.replace(window.location.origin + '/');
    </script>
<?php } ?>

<div class="container mt-4">
    <h4>Customer Register</h4>
    <form action="../handler/registerHandler.php" method="POST">
        <div class="form-group">
            <label for="emailInput">Email address</label>
            <input type="email" name="email" class="form-control" id="emailInput" placeholder="Enter email" required>
        </div>
        <div class="form-group">
            <label for="userIdInput">User ID</label>
            <input type="text" name="uid" class="form-control" id="userIdInput" placeholder="Enter User ID for login"
                   pattern="^[a-zA-Z][a-zA-Z0-9-_\.]{5,15}$" required>
            <small id="passwordHelp" class="form-text text-muted">User ID Length must be 6 - 16 characters.</small>
        </div>
        <div class="form-group">
            <label for="customerNameInput">Customer Name</label>
            <input type="text" name="customerName" class="form-control" id="customerNameInput" placeholder="Enter your name" required>
        </div>
        <div class="form-group">
            <label for="passwordInput">Password</label>
            <input type="password" name="password" class="form-control" id="passwordInput" placeholder="Enter password"
                   aria-describedby="passwordHelp" required>
            <small id="passwordHelp" class="form-text text-muted">Password Length must be 8 - 20 characters.</small>
        </div>
        <div class="form-group">
            <label for="passwordInputConfirm">Confirm Password</label>
            <input type="password" name="c_password" class="form-control" id="passwordInputConfirm"
                   placeholder="Repeat password" aria-describedby="passwordConfirmHelp" required>
            <small id="passwordConfirmHelp" class="form-text text-muted">Password Length must be 8 - 20
                characters.</small>
        </div>
        <div class="form-group form-check">
            <input type="checkbox" class="form-check-input" id="corporateCustomerCheckbox" name="corporateCustomer">
            <label class="form-check-label" for="corporateCustomerCheckbox">Corporate Customer?</label>
        </div>
        <div class="form-group">
            <label for="addressTextArea">Address</label>
            <textarea class="form-control" id="addressTextArea" name="address" rows="3" required></textarea>
        </div>
        <div class="form-group">
            <label for="contactPhones">Contact Phones</label>
            <div class="input-group mb-2">
                <input type="text" class="form-control" placeholder="Phone No." name="contactPhones[]"
                       id="contactPhones" required>
                <div class="input-group-append">
                    <button class="btn btn-secondary" type="button" onclick="createNewContactPhoneInput()">+</button>
                </div>
            </div>
            <div id="newPhoneContactInput"></div>
        </div>
        <div class="form-group form-row">
            <div class="col-4 mx-auto">
                <input type="submit" class="btn btn-success btn-block">
            </div>
            <div class="col-4 mx-auto">
                <a href="?route=login" class="btn btn-primary btn-md btn-block">Login existing</a>
            </div>
        </div>
    </form>
</div>

<script>
    let emailObj = document.getElementById('emailInput');
    let passwordObj = document.getElementById('passwordInput');
    let cPasswordObj = document.getElementById('passwordInputConfirm');
    let passwordHelpMessage = document.getElementById('passwordHelp');
    let cPasswordHelpMessage = document.getElementById('passwordConfirmHelp');
    let address = document.getElementById('addressTextArea');
    let contactPhones = document.getElementById('contactPhones');

    passwordObj.addEventListener("input", function (event) {
        if (checkPassword(passwordObj.value)) {
            passwordObj.classList.remove('is-invalid');
            passwordHelpMessage.classList.remove('text-danger');
            passwordHelpMessage.classList.add('text-muted');
        } else {
            passwordObj.classList.add('is-invalid');
            passwordHelpMessage.classList.remove('text-muted');
            passwordHelpMessage.classList.add('text-danger');
        }
    });

    cPasswordObj.addEventListener("input", function (event) {
        if (passwordObj.value === cPasswordObj.value) {
            cPasswordObj.classList.remove('is-invalid');
            cPasswordHelpMessage.classList.remove('text-danger');
            cPasswordHelpMessage.classList.add('text-muted');
        } else {
            cPasswordObj.classList.add('is-invalid');
            cPasswordHelpMessage.classList.remove('text-muted');
            cPasswordHelpMessage.classList.add('text-danger');
        }
    });

    function checkPassword(inputPw) {
        let pwRegex = /^[A-Za-z0-9]\w{7,20}$/;
        if (inputPw.match(pwRegex)) {
            return true;
        } else {
            return false;
        }
    }

    function hashPassword(obj) {

        if (passwordObj.value !== "" && cPasswordObj.value !== "" && address.value !== "" && emailObj.value !== "" && contactPhones.value !== "") {
            let hashObj = new jsSHA("SHA-512", "TEXT", {numRounds: 1});
            hashObj.update(passwordObj.value);
            let hash = hashObj.getHash("HEX");
            passwordObj.value = hash;

            let hashObj2 = new jsSHA("SHA-512", "TEXT", {numRounds: 1});
            hashObj2.update(passwordObj.value);
            let hash2 = hashObj2.getHash("HEX");
            cPasswordObj.value = hash2;
        }

    }

    function createNewContactPhoneInput() {
        let txtNewInputBox = document.createElement('div');
        txtNewInputBox.innerHTML = "<div class='py-2'><input type='text' id='newInputBox' class='form-control' placeholder='Phone No.' name='contactPhones[]' required></div>";
        document.getElementById("newPhoneContactInput").appendChild(txtNewInputBox);
    }
</script>

<?php
session_start();

$auth = isset($_SESSION['customer']);

if ($auth) {
    ?>
    <div class="container">
        <h2 class="py-4">Change Password</h2>
        <form action="../handler/changePasswordHandler.php" method="post">
            <div class="form-group">
                <label for="originalPasswordInput">Original Password</label>
                <input type="password" name="originPassword" class="form-control" id="originalPasswordInput"
                       placeholder="Enter origin password"
                       aria-describedby="originPasswordHelp" required>
            </div>
            <div class="form-group">
                <label for="passwordInput">New Password</label>
                <input type="password" name="password" class="form-control" id="passwordInput"
                       placeholder="Enter new password"
                       aria-describedby="passwordHelp" min="8" max="20" required>
                <small id="passwordHelp" class="form-text text-muted">Password Length must be 8 - 20 characters.</small>
            </div>
            <div class="form-group">
                <label for="passwordInputConfirm">Confirm Password</label>
                <input type="password" name="c_password" class="form-control" id="passwordInputConfirm"
                       placeholder="Repeat new password" aria-describedby="passwordConfirmHelp" min="8" max="20" required>
                <small id="passwordConfirmHelp" class="form-text text-muted">Password Length must be 8 - 20
                    characters.</small>
            </div>
            <div class="form-group form-row">
                <div class="col-4 mx-auto">
                    <input type="submit" class="btn btn-success btn-md btn-block" value="Update password">
                </div>
            </div>
        </form>
    </div>
    <?php
} else {
    ?>
    <script>
        window.location.replace(window.location.origin + '/?route=');
    </script>
    <?php
}


<div class="container mt-4">
    <h4>Customer Register</h4>
    <form action="" method="post">
        <div class="form-group">
            <label for="emailInput">Email address</label>
            <input type="email" name="email" class="form-control" id="emailInput" placeholder="Enter email">
        </div>
        <div class="form-group">
            <label for="userIdInput">User ID</label>
            <input type="text" name="uid" class="form-control" id="userIdInput" placeholder="Enter User ID for login"
                   pattern="^[a-zA-Z][a-zA-Z0-9-_\.]{6,16}$">
            <small id="passwordHelp" class="form-text text-muted">User ID Length must be 6 - 16 characters.</small>
        </div>
        <div class="form-group">
            <label for="passwordInput">Password</label>
            <input type="password" name="password" class="form-control" id="passwordInput" placeholder="Enter password"
                   aria-describedby="passwordHelp" pattern="^[a-zA-Z][a-zA-Z0-9-_\.]{8,20}$">
            <small id="passwordHelp" class="form-text text-muted">Password Length must be 8 - 20 characters.</small>
        </div>
        <div class="form-group">
            <label for="passwordInputConfirm">Confirm Password</label>
            <input type="password" name="c_password" class="form-control" id="passwordInputConfirm"
                   placeholder="Enter password" aria-describedby="passwordConfirmHelp"
                   pattern="^[a-zA-Z][a-zA-Z0-9-_\.]{8,20}$">
            <small id="passwordConfirmHelp" class="form-text text-muted">Password Length must be 8 - 20
                characters.</small>
        </div>
        <div class="form-group form-check">
            <input type="checkbox" class="form-check-input" id="corporateCustomerCheckbox" name="corporateCustomer">
            <label class="form-check-label" for="corporateCustomerCheckbox">Corporate Customer?</label>
        </div>
        <div class="form-group">
            <label for="addressTextArea">Address</label>
            <textarea class="form-control" id="addressTextArea" name="address" rows="3"></textarea>
        </div>
        <div class="form-group">
            <label for="contactPhones">Contact Phones</label>
            <input type="email" name="contactPhones[]" class="form-control" id="contactPhones" placeholder="Phone No.">
        </div>

        <div class="form-group form-row">
            <div class="col-4 mx-auto">
                <button type="submit" class="btn btn-success btn-md btn-block">Submit</button>
            </div>
            <div class="col-4 mx-auto"><a href="?route=login" class="btn btn-primary btn-md btn-block">Login
                    existing</a></div>
        </div>
    </form>
</div>

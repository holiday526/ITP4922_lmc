<div class="container mt-4">
    <h4>Customer Register</h4>
    <form action="" method="post">
        <div class="form-group">
            <label for="emailInput">Email address</label>
            <input type="email" name="email" class="form-control" id="emailInput" aria-describedby="emailHelp" placeholder="Enter email">
        </div>
        <div class="form-group">
            <label for="inputPassword">Password</label>
            <input type="password" id="inputPassword" class="form-control mx-sm-3" aria-describedby="passwordHelpInline">
            <small id="passwordHelpInline" class="text-muted">
                Must be 8-20 characters long.
            </small>
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
            <div class="col-4 mx-auto"><button type="submit" class="btn btn-success btn-md btn-block">Submit</button></div>
            <div class="col-4 mx-auto"><a href="?route=login" class="btn btn-primary btn-md btn-block">Login existing</a></div>
        </div>
        
    </form>
</div>

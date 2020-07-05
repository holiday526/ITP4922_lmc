<div class="container">
    <h2>Member Information</h2>
    <form action="/updateUserInfo.php" method="post">
        <div class="form-group">
            <label for="email">Registered Email</label>
            <input type="email" class="form-control disabled" value="<?=$email?>" disabled>
            <small class="form-text text-muted">This registered email can not be change</small>
        </div>
        <div class="form-row">
            <div class="form-group col-6">
                <label for="name">Name</label>
                <input type="text" class="form-control disabled" value="<?=$name?>" disabled>
            </div>
        <div class="form-row">
            <div class="form-group col-6">
                <label for="phone">Phone</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <div class="input-group-text">+852</div>
                    </div>
                    <input type="tel" id="phone" pattern="[0-9]{8}" maxlength="8" title="8 digit Hong Kong number"
                           class="form-control" name="phone" placeholder="<?=$contactphones?>">
                </div>
            </div>
            <div class="form-group col-6">
                <label for="rdate">Registration Date</label>
                <input type="date" id="rdate" class="form-control" name="rdate" placeholder="<?=$rdate?>" value="<?=$rdate?>">
            </div>
        </div>
        <div class="form-group">
            <label for="address">Address</label>
            <div class="input-group">
                <div class="input-group-prepend">
                    <div class="input-group-text">Hong Kong</div>
                </div>
                <textarea id="address" class="form-control" name="address" placeholder="<?=$address?>"></textarea>
            </div>
        </div>
        <div class="form-group">
            <label for="cocustomer">Corporate Customer</label>
            <input type="text" class="form-control disabled" value="<?=$cocustomer?>" disabled>
        </div>
        <input class="btn btn-primary" type="submit" value="Update my information">
    </form>
</div>
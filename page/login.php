<div class="container">
    <div class="d-flex justify-content-center">
        <div class="col-md-8 mt-5">
            <div class="card">
                <div class="card-header">Customer Login</div>

                <div class="card-body">
                    <form method="POST" action="">
                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">Email Address</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control" name="email" value="" required autofocus>

                                <?php if (false) { ?>
                                <span class="invalid-feedback" role="alert">
                                    <strong>Message</strong>
                                </span>
                                <?php } ?>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">Password</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control" name="password" required>

                                <?php if (false) { ?>
                                <span class="invalid-feedback" role="alert">
                                    <strong>Message</strong>
                                </span>
                                <?php } ?>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    Login
                                </button>
                                <a href="?route=register" class="btn btn-info ml-5">Register</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

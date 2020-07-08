<?php
session_start();

$error = isset($_SESSION['ERROR']['ADMIN']);

$auth = (isset($_SESSION['customer']) || isset($_SESSION['admin']));

if ($auth) {
?>
    <script>
        // login ed
        window.location.replace(window.location.origin + "/");
    </script>
<?php
} else if ($error) {
?>
    <script>
        $(document).ready(function(){
            $("#loginModal").modal('show');
        });
    </script>
    <div class="modal fade" id="adminLoginModal" tabindex="-1" role="dialog" aria-labelledby="adminLoginModal" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="adminLoginModal">Modal title</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p class="text-danger">Login Failed</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
<?php
} else {
?>
    <div class="container">
        <div class="d-flex justify-content-center">
            <div class="col-md-8 mt-5">
                <div class="card">
                    <div class="card-header">Admin Login</div>

                    <div class="card-body">
                        <form method="POST" action="../handler/adminLoginHandler.php">
                            <div class="form-group row">
                                <label for="uid" class="col-md-4 col-form-label text-md-right">Admin Username</label>

                                <div class="col-md-6">
                                    <input id="username" type="text" class="form-control" name="username" value="" required autofocus>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="password" class="col-md-4 col-form-label text-md-right">Password</label>

                                <div class="col-md-6">
                                    <input id="password" type="password" class="form-control" name="password" min="8" required>
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-8 offset-md-4">
                                    <input type="submit" value="Login" class="btn btn-success">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php
}
?>
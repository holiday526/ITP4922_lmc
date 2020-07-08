<?php
session_start();
?>
<?php
if (!empty($_SESSION['ERROR']['LOGIN'])) {
?>
    <script>
        $(document).ready(function(){
            $("#loginModal").modal('show');
        });
    </script>
    <div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="loginModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="loginModalLabel">Warning</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p class="text-danger">Login Failed</p>
                    <p><?= $_SESSION['ERROR']['LOGIN'] ?></p>
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
<?php
}
?>
<div class="container">
    <div class="d-flex justify-content-center">
        <div class="col-md-8 mt-5">
            <div class="card">
                <div class="card-header">Customer Login</div>

                <div class="card-body">
                    <form method="POST" action="../handler/loginHandler.php">
                        <div class="form-group row">
                            <label for="uid" class="col-md-4 col-form-label text-md-right">User ID</label>

                            <div class="col-md-6">
                                <input id="uid" type="text" class="form-control" name="uid" value="" required autofocus>
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
                                <input type="submit" class="btn btn-primary">
                                <a href="?route=register" class="btn btn-info ml-5">Register</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

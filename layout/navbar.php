<nav class="navbar fixed-top navbar-expand-lg navbar-dark bg-dark fixed-top">
    <div class="container">
        <a class="navbar-brand" href="/">Auto Car Sales Ltd</a>
        <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav ml-auto">
                <!-- Normal users -->
                <li class="nav-item">
                    <a class="nav-link" href="#">About Us</a>
                </li>
                <li class="nav-item">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Search">
                        <div class="input-group-append">
                            <button class="btn btn-secondary" type="button">
                                <i class="fa fa-search"></i>
                            </button>
                        </div>
                    </div>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownCarProduct" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Products
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownCarProduct">
                        <a class="dropdown-item" href="?route=content">All</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="#">New Cars</a>
                        <a class="dropdown-item" href="#">2<sup>nd</sup> Hand Cars</a>
                    </div>
                </li>
                <!-- End of normal users -->
                <!-- For auth users -->
                <?php if(false) { ?>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownUser" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <?php
                            if (isset($_SESSION['is_admin']) && $_SESSION['is_admin']) {
                                echo 'Hi,'.$_SESSION['admin_username'];
                            } else {
                                echo 'Hi,'.$_SESSION['customer_username'];
                            }
                        ?>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownUser">
                        <a class="dropdown-item" href="#">Profile</a>
                        <a class="dropdown-item" href="#">Logout</a>
                    </div>
                </li>
                <?php } else { ?>
                <li class="nav-item">
                    <a class="nav-link" href="/?route=login">Sign In</a>
                </li>
                <?php } ?>
                <!-- End of for auth users -->
            </ul>
        </div>
    </div>
</nav>
<nav class="navbar fixed-top navbar-expand-lg navbar-dark bg-dark fixed-top">
    <div class="container">
        <a class="navbar-brand" href="/ITP4922_lmc">Auto Car Sales Ltd</a>
        <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav ml-auto">
                <!-- Normal users -->
                <li class="nav-item">
                    <a class="nav-link" href="#">About Us</a>
                </li>
                <form class="form-inline">
                    <input class="form-control mr-sm-2" type="search" placeholder="Search something" aria-label="Search">
                    <button class="btn btn-outline-light my-2 my-sm-0" type="submit">Search</button>
                </form>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownCarProduct" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Products
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownCarProduct">
                        <a class="dropdown-item" href="#">All</a>
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
                    <a class="nav-link" href="#">Sign In</a>
                </li>
                <?php } ?>
                <!-- End of for auth users -->
            </ul>
        </div>
    </div>
</nav>
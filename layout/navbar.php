<?php session_start(); ?>
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
                    <a class="nav-link" href="/?route=about">About Us</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/?route=compare">Compare model</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownCarProduct" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Products
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownCarProduct">
                        <a class="dropdown-item" href="?route=catalog">All</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="?route=catalog&type=new">New Cars</a>
                        <a class="dropdown-item" href="?route=catalog&type=2nd">2<sup>nd</sup> Hand Cars</a>
                    </div>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownCarProduct" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Search
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownCarProduct" style="background: transparent; border: none">
                        <form action="/?route=search" method="post">
                            <div class="input-group mb-3">
                                <input type="text" name="search" class="nav-item form-control" placeholder="Search">
                                <div class="input-group-append">
                                    <button class="btn btn-success" type="submit">go</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </li>
                <!-- End of normal users -->
                <!-- For auth users -->
                <?php if(isset($_SESSION['customer']) || isset($_SESSION['admin'])) { ?>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownYourCar" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Your car
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownYourCar">
                        <a class="dropdown-item" href="?route=sell&type=create">Sell a car</a>
                        <a class="dropdown-item" href="?route=orderIndex">Order record</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="?route=sell&type=show">My selling car</a>
                        <a class="dropdown-item" href="?route=sell&type=appointment">My appointment</a>
                    </div>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownUser" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <?php
                            if (isset($_SESSION['admin']) && $_SESSION['admin']) {
                                echo 'Hi, '.$_SESSION['admin']['username'];
                            } else if (isset($_SESSION['customer']) && $_SESSION['customer']) {
                                echo 'Hi, '.$_SESSION['customer']["name"];
                            }
                        ?>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownUser">
                        <?php
                        if (isset($_SESSION['admin']) && $_SESSION['admin']) {
                        ?>
                        <a class="dropdown-item" href="/?route=allOrder">Members all orders</a>
                        <div class="dropdown-divider"></div>
                        <?php
                        }
                        ?>
                        <a class="dropdown-item" href="?route=userProfile">Profile</a>
                        <a class="dropdown-item" href="../logout.php">Logout</a>
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
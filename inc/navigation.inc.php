
            <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
                <div class="container-fluid">
                    
                        <a class="navbar-brand" href="index.php?site=home">
                            <img class = "navbar_logo" src="<?php echo $file == "index.php" ?  "./" :  "../" ?>res/icons/logo.png" alt="logo">
                        </a>
                    
                    <a class="navbar-brand" href="index.php?site=home">RIFT</a>
                        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse" id="navbarSupportedContent">
                            <ul class="navbar-nav me-auto mb-2 mb-lg-0">

                                <?php
                                if($_SESSION['logged'])
                                {
                                    //print stuff for a logged user?>
                                    <li class="nav-item">
                                    <a class="nav-link<?php echo $file == "profile.php"? " active": "";?> aria-current="page" href="/sites/profile.php">Profile</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link<?php echo $navigator == "notifications" ? " active": "";?>" href="<?php echo $file == "index.php" ?  "./" :  "../" ?>index.php?site=notifications">Notifications</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link<?php echo $navigator == "messages" ? " active": "";?>" href="<?php echo $file == "index.php" ?  "./" :  "../" ?>index.php?site=messages">Messages</a>
                                </li>
                                <?php
                                     // admin print
                                    if($_SESSION['user']['is_admin'])
                                    {
                                        //printing list element for admin panel?>
                                    <li class="nav-item">
                                        <a class="nav-link<?php echo $navigator == "admin" ? " active": "";?>" href=" <?php echo $file == "index.php" ?  "./" :  "../"; ?> index.php?site=admin">Admin</a>
                                </li>
                                    <?php
                                    }
                                    // Logout Button print?>
                                    <li class="nav-item">
                                <a class="nav-link" href="<?php echo $file == "index.php" ?  "./" :  "../" ?>index.php?site=logout">Logout</a>
                            </li>

                                <?php
                                } else
                                {
                                    //User is not logged in - print register and login button?>

                                    <li class="nav-item">
                                <a class="nav-link<?php echo $navigator == "login" ? " active": "";?>" href="<?php echo $file == "index.php" ?  "./" :  "../" ?>index.php?site=login">Login</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link<?php echo $navigator == "register" ? " active": "";?>" href="<?php echo $file == "index.php" ?  "./" :  "../" ?>index.php?site=register">Sign Up</a>
                            </li>
                            <?php
                                }
                            
                                //print remaining items?>
                                <li class="nav-item">
                                    <a class="nav-link<?php echo $navigator == "impressum" ? " active": "";?>" href="<?php echo $file == "index.php" ?  "./" :  "../" ?>index.php?site=impressum">Impressum</a>
                                </li>
                            </ul>
                            <form class="d-flex" action="index.php" method="GET">
                                <input class="form-control me-2" type="search" name="searchValue" placeholder="Search user" aria-label="Search">
                                <button class="btn btn-outline-success" id="searchSubmit" name="searchSubmit" type="submit">Search</button>
                            </form>
                        </div>
                </div>
            </nav>


            
            <?php

            if (isset($_GET['searchValue'])){
                $_SESSION['searchVal'] = $_GET['searchValue'];
                include 'sites/searchResult.php';
            }
            ?>

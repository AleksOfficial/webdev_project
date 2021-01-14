
            <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
                <div class="container-fluid">
                    
                        <a class="navbar-brand" href="index.php?menu=home">
                            <img src="./res/icons/rift_logo128x.png" alt="" width="30" height="24">
                        </a>
                    
                    <a class="navbar-brand" href="index.php?menu=home">RIFT</a>
                        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse" id="navbarSupportedContent">
                            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                                <li class="nav-item">
                                    <a class="nav-link active" aria-current="page" href="index.php?menu=profile">Profile</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#">Notifications</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#">Messages</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#">Admin</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#">Log In</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#">Log Out</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#">Impressum</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Disabled</a>
                                </li>
                            </ul>
                            <form class="d-flex">
                                <input class="form-control me-2" type="search" placeholder="Search user" aria-label="Search">
                                <button class="btn btn-outline-success" type="submit">Search</button>
                            </form>
                        </div>
                </div>
            </nav>



            <?php   

        if (isset($_GET['menu']))
        {
            $home = TRUE;
            switch ($_GET['menu']) {
                case 'profile':
                    include 'sites/profile.php';
                    break;
                case 'notifications':
                    include 'sites/notifications.php';
                        break;
                case 'messages':
                    include 'sites/messages.php';
                    break;
                case 'adminset':
                    include 'sites/administration.php';
                    break;
                case 'impressum':
                    include 'inc/impressum.inc.php';
                    break;
                case 'login':
                    include 'sites/login.php';
                    break;
                case 'logout':
                    include 'sites/kontaktform.php';
                    break;
               /* default:
                    include 'sites/default.php';
                    $home =False;
                    break;*/
            
            }
        }
               
        



        //navbar-expand-lg
        ?>    
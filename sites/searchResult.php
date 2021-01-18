
<?php

//include 'inc/class-autoload.inc.php';


if (!isset($_GET['searchSubmit'])) {
    $_SESSION['searchUser'] = search_user($_GET['searchSumbit']);
    $_SESSEION['searchAmmount'] = count($_SESSION['searchUser'], 0);

}


foreach ($_SESSION['searchUser'] as $test) {
    echo "this is a test: " . $test;
}





?>



<div class="container">
    <div>
        <h3>
            showing results for "try"... <?php  echo "showing results for \"" . $_GET['searchSubmit'] . "\"...";   ?>
        </h3>
    </div>
   

    <div class="row">


            <?php

                $rows = $_SESSION['searchAmmount'] / 3;
                $rowsRest = $_SESSION['searchAmmount'] % 3;
                $userCount = 0;
                for($y = 0 ; $y < 3 ; $y++) {
?>                  <div class="col-md-4 searchResultContainer">                            <?php

                    if ($rowsRest > 0) {
                        for($i = 0 ; $i < $rows+1 ; $i++) {
                            
                            
                            $userCount++;
                        }
                    } else {
                        for($i = 0 ; $i < $rows ; $i++) {
                            
                            
                            $userCount++;
                        }
                    }
                    $rowsRest--;

?>                  </div>                                                                  <?php
                }   
                


            ?>


 <!--       <div class="col-md-4 searchResultContainer">






            <div class="card searchResultCard" style="width: 100%;">
                <img src="res/pics/narutotest.jpeg" class="card-img-top" alt="good shit">
                <div class="card-body">
                    <h5 class="card-title">trylikeabun</h5>
                    <p class="card-text">Naruto best anime ever no doubt everyone can shut the fuck up.</p>
                    <a href="#" class="btn btn-primary">Visit profile</a>
                    

                </div>
            </div>
        </div>
        <div class="col-md-4 searchResultContainer">
            <div class="card searchResultCard" style="width: 100%;">
                <img src="res/pics/narutotest.jpeg" class="card-img-top" alt="good shit">
                <div class="card-body">
                    <h5 class="card-title">trylikeabun</h5>
                    <p class="card-text">Naruto best anime ever no doubt everyone can shut the fuck up.</p>
                    <a href="#" class="btn btn-primary">Visit profile</a>
                    

                </div>
            </div>
        </div>
        <div class="col-md-4 searchResultContainer">
            <div class="card searchResultCard" style="width: 100%;">
                <img src="res/pics/narutotest.jpeg" class="card-img-top" alt="good shit">
                <div class="card-body">
                    <h5 class="card-title">trylikeabun</h5>
                    <p class="card-text">Naruto best anime ever no doubt everyone can shut the fuck up.</p>
                    <a href="#" class="btn btn-primary">Visit profile</a>
                    

                </div>
            </div>
        </div> -->
    </div>

</div>
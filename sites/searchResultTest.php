

<?php

//include 'inc/class-autoload.inc.php';

$searchUserClass = new Db_user();

$searchUser = $searchUserClass->search_user($_SESSION['searchVal']);
$searchAmount = $searchUserClass->count_array($searchUser);

//echo "test" . $searchUser[1][1]; why bro
var_dump($searchUser);
$cycle = 0;
?>

<div>

<?php
foreach($searchUser as $user)
{
    
}
?>
</div>
<?php
if ($searchUser[0]['username'] != NULL) {
    
    $_SESSION['searchAmount'] = count($searchUser['username'], 0);
    echo "testamount=" . $_SESSION['searchAmount'];
    
?>  <div class="container">     
        <h3>
            <?php  echo "showing results for \"" . $_GET['searchValue'] . "\"";   ?>
        </h3>
    </div>                                                              <?php


} else /*if ($searchUser['username'] != NULL)*/ {            ?>
    <div class="container">     
        <h3>
            <?php  echo "there are no results for \"" . $_GET['searchValue'] . "\"";   ?>
        </h3>
    </div>                                              <?php
}


foreach ($searchUser as $test) {
    echo "this is a test: " . $test;
}

//echo "testest " . $_SESSION['searchUser'];




?>



<div class="container">
    <div>
        <h3>
            <?php  echo "showing results for \"" . $_GET['searchValue'] . "\"";   ?>
        </h3>
    </div>
   

    <div class="row">


            <?php

                $rows = $_SESSION['searchAmount'] / 3;
                $rowsRest = $_SESSION['searchAmount'] % 3;
                $userCount = 0;
                for($y = 0 ; $y < 3 ; $y++) {
?>                  <div class="col-md-4 searchResultContainer">                                        <?php

                    if ($rowsRest > 0) {
                        for($i = 0 ; $i < $rows+1 ; $i++) {
?>                          <div class="card searchResultCard" style="width: 100%;">         
                                <img src="res/pics/narutotest.jpeg" class="card-img-top" alt="good shit">   
                                <div class="card-body">
                                    <h5 class="card-title">trylikeabun</h5>                 
                                    <p class="card-text">Naruto best anime ever no doubt everyone can shut the fuck up.</p>
                                    <a href="#" class="btn btn-primary">Visit profile</a>
                                </div>
                            </div>                                                                      <?php
                            
                            $userCount++;
                        }
                    } else {
                        for($i = 0 ; $i < $rows ; $i++) {
?>                          <div class="card searchResultCard" style="width: 100%;">         
                                <img src="res/pics/narutotest.jpeg" class="card-img-top" alt="good shit">   
                                <div class="card-body">
                                    <h5 class="card-title">trylikeabun</h5>                 
                                    <p class="card-text">Naruto best anime ever no doubt everyone can shut the fuck up.</p>
                                    <a href="#" class="btn btn-primary">Visit profile</a>
                                </div>
                            </div>                                                                      <?php
                            
                            $userCount++;
                        }
                    }
                    $rowsRest--;

?>                  </div>                                                                               <?php
                }   
                
            ?>
    </div>
</div>


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
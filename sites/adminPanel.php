<?php
$adminUserClass = new Db_user();
$adminUser = $searchUserClass->get_all_users();
$adminAmount = $searchUserClass->count_array($adminUser);
?>


<div class="container">
    <div>
        <h2>
            Welcome Admin!
        </h2>
    </div>
    <div>

    </div>
</div>

<?php

$cycle = 0;




if ($searchAmount > 0) {
    
    
?>  <div class="container">     
        <h3>
            <?php  echo "showing results for \"" . $_GET['searchValue'] . "\"";   ?>
        </h3>
    </div>                                                              <?php


} else if ($searchAmount == 0) {            ?>
    <div class="container">     
        <h3>
            <?php  echo "there are no results for \"" . $_GET['searchValue'] . "\"";   ?>
        </h3>
    </div>                                              <?php
}

?>


    <div class="row">


            <?php

                $rows = $searchAmount / 3;
                $rowsRest = $searchAmount % 3;
                $userCount = 0;
                if ($searchAmount == 2) {
                    for ($i = 0 ; $i < 2 ; $i++) {
    ?>                  <div class="col-md-4 searchResultContainer">                                            <?php

                            $searchUserClass->print_result_card($searchUser[$userCount]['person_id']);
                            $userCount++;
                    
    ?>                  </div>                                                                                  <?php
                    }
                    ?> <div class="col-md-4 searchResultContainer"></div> <?php
                } else if ($searchAmount == 1) {
                   
?>                  <div class="col-md-4 searchResultContainer">                                            <?php
                    
                        $searchUserClass->print_result_card($searchUser[$userCount]['person_id']);
                        $userCount++;
                                        
?>                  </div>                                                                                  <?php
                                        
                    ?> <div class="col-md-4 searchResultContainer"></div> <?php
                    ?> <div class="col-md-4 searchResultContainer"></div> <?php
                } else if ($searchAmount == 0) {
                    ?>  bruh  <?php
                } else if ($searchAmount >= 3) {



                    for($y = 0 ; $y < 3 ; $y++) {
    ?>                  <div class="col-md-4 searchResultContainer">                                        <?php
                        // if statement falls weniger als 3 hasen

                       
                    
                        if ($rowsRest > 0) {
                            for($i = 0 ; $i < $rows+1 ; $i++) {
                                $searchUserClass->print_result_card($searchUser[$userCount]['person_id']);
                                
                                $userCount++;
                            }
                        } else {
                            for($i = 0 ; $i < $rows ; $i++) {
                                $searchUserClass->print_result_card($searchUser[$userCount]['person_id']);
                                
                                $userCount++;
                            }
                        }
                        $rowsRest--;

    ?>                  </div>                                                                               <?php
                    }   
                }
                
            ?>
    </div>
</div>



    </div>

</div>
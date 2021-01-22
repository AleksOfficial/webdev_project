<?php
$adminUserClass = new Db_user();
$adminUser = $adminUserClass->get_all_users();
$adminAmount = $adminUserClass->count_array($adminUser);
?>

<?php //activate/deactivate user
    if (isset($_GET['action'])) {
        $action_and_id = explode("-", $_GET['action']);
        //echo 'action and id ma man';
        //var_dump($action_and_id);
        if ($action_and_id[0] == 'activate') {
        
            $adminUserClass->change_status(1, $action_and_id[1]);

        } else {
            $adminUserClass->change_status(2, $action_and_id[1]);
        }

    }
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

?>


    <div class="row">


            <?php

                $rows = $adminAmount / 3;
                $rowsRest = $adminAmount % 3;
                $userCount = 0;
                if ($adminAmount == 2) {
                    for ($i = 0 ; $i < 2 ; $i++) {
    ?>                  <div class="col-md-4 searchResultContainer">                                            <?php

                            $adminUserClass->print_admin_card($adminUser[$userCount]['person_id']);
                            $userCount++;
                    
    ?>                  </div>                                                                                  <?php
                    }
                    ?> <div class="col-md-4 searchResultContainer"></div> <?php
                } else if ($adminAmount == 1) {
                   
?>                  <div class="col-md-4 searchResultContainer">                                            <?php
                    
                        $adminUserClass->print_admin_card($adminUser[$userCount]['person_id']);
                        $userCount++;
                                        
?>                  </div>                                                                                  <?php
                                        
                    ?> <div class="col-md-4 searchResultContainer"></div> <?php
                    ?> <div class="col-md-4 searchResultContainer"></div> <?php
                } else if ($adminAmount == 0) {
                    ?>  bruh  <?php
                } else if ($adminAmount >= 3) {



                    for($y = 0 ; $y < 3 ; $y++) {
    ?>                  <div class="col-md-4 searchResultContainer">                                        <?php
                        // if statement falls weniger als 3 hasen

                       
                    
                        if ($rowsRest > 0) {
                            for($i = 0 ; $i < $rows ; $i++) {
                                $adminUserClass->print_admin_card($adminUser[$userCount]['person_id']);
                                
                                $userCount++;
                            }
                        } else {
                            for($i = 0 ; $i < $rows-1 ; $i++) {
                                $adminUserClass->print_admin_card($adminUser[$userCount]['person_id']);
                                
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
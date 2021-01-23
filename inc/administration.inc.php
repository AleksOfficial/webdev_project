<?php
$adminUserClass = new Db_user();
$adminUser = $adminUserClass->get_not_admin_users();
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
            $adminUserClass->change_status(0, $action_and_id[1]);
        }

    }
?>








<div class="container-fluid">
    <div>
        <h3>
            Welcome Admin!
        </h3>
    </div>
    <div class="row">
      <div class='col-2'>

      </div>
      <div class="col">
        <div class="row">
          <div class="col d-flex flex-wrap ">
            <?php
            if (!empty($adminUser)) {


              foreach ($adminUser as $user) {
                $user_id = $user['person_id'];
                $adminUserClass->print_admin_card($user_id, $dots);
              }
            } ?>
          </div>
          <div class="row">
            <div class="col-3">

            </div>
            <div class="col-6">
              
            </div>
            <div class="col-3">

            </div>
          </div>
        </div>
      </div>
      <div class="col-2">

      </div>

    </div>
  </div>
<?php
if($_SESSION['logged'])
{
  $db_user = new db_user();
  $all_friend_ids = $db_user->get_friends($_SESSION['user']['person_id']);
  //var_dump($all_friend_ids);
  

}
?>
  
<div class="container-fluid">
    <div class="row">
      <div class='col-2'>

      </div>
      <div class="col">
        <div class="row">
          <div class="col d-flex flex-wrap ">
            <?php
            if (!empty($all_friend_ids)) {


              foreach ($all_friend_ids as $user) {
                
                $db_user->print_friend_card($user, $dots);
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
 <?php
    $db_notifications = new Db_notifications();
    $db_user = new Db_user();
    $db_create = new Db_create_stuff();

    $notificationsArray = $db_notifications->get_all_notifications($_SESSION['user']['person_id']);
    //var_dump($notificationsArray);


    $db_create->change_all_viewed($_SESSION['user']['person_id']);


    if (isset($_GET['accept'])) {
      $db_create->accept_friend($_GET['accept'],$_SESSION['user']['person_id']);
    } else if (isset($_GET['reject'])) {
      $db_create->remove_friend($_GET['accept'],$_SESSION['user']['person_id']);
    }
?>
<div class='container'>
  <div class='row'>
    <div class='col'>
      <h3>Notifications</h3>
    </div>
  </div>
  <div class="row">
    <div class="col-1">

    </div>
    <div class="col">
      
      <?php //print notifications
        foreach($notificationsArray as $notification) {
          $from_id = $notification['from_id'];
          if ($notification['notification_id'] == 2) {
            $status = $db_create->check_viewed($from_id,$notification['to_id']);
          }

          if ($notification['notification_id'] == 1) {
            $db_user->print_commented_notification($from_id,$dots);
          
          } else if ($notification['notification_id'] == 2) {
            $db_user->print_friendrequest_notification($from_id,$dots,$status);
          } else if ($notification['notification_id'] == 3) {
            $db_user->print_liked_notification($from_id,$dots);
          } else if ($notification['notification_id'] == 4) {
            $db_user->print_disliked_notification($from_id,$dots);
          } else if ($notification['notification_id'] == 5) {
            $db_user->print_pooped_notification($from_id,$dots);
          }

        }
      ?>
    </div>
    <div class="col-1">

    </div>
  </div>
 

</div>
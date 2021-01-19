<?php
if($_SESSION['logged'])
{
  $db_user = new db_user();
  $all_friend_ids = $db_user->get_friends($_SESSION['user']['person_id']);
  foreach($all_friend_ids as $friend_id)
  {
    $db_user->print_result_card($friend_id);
    
  }
  
}
  

?>
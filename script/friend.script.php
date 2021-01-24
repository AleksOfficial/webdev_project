<?php
if($_SESSION['logged'])
{
  if(isset($_GET['friend_request']))
  {
    if($_GET['friend_request']==$_SESSION['user']['person_id'] && $_GET['user'] != $_GET['friend_request'])
  {
    $from_id = $_GET['friend_request'];
    $to_id = $_GET['user'];
    $db_create_stuff = new Db_create_stuff();
    $db_create_stuff->add_friend($from_id,$to_id);
    $db_notifications = new Db_notifications();
    $db_notifications->add_notification_user($from_id,$to_id,2);
  }
  }
  else if (isset($_GET['friend_accept']))
  {
    if($_GET['friend_accept']==$_SESSION['user']['person_id'] && $_GET['user'] != $_GET['friend_request'])
    {
      $from_id = $_SESSION['user']['person_id'];
      $to_id = $_GET['user'];
      $db_create_stuff = new Db_create_stuff();
      $db_create_stuff->accept_friend($from_id,$to_id);

        
    }
  }
  else if(isset($_GET['unfriend']))
  {
    if($_GET['unfriend']==$_SESSION['user']['person_id'] && $_GET['user'] != $_GET['unfriend'])
    {
      $from_id = $_SESSION['user']['person_id'];
      $to_id = $_GET['user'];
      $db_create_stuff = new Db_create_stuff();
      $db_create_stuff->remove_friend($from_id,$to_id);
  }
  
}
}
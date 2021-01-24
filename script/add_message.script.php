<?php
//check if ppl are friends & if user is logged
if($_SESSION['logged'])
{
  $user_id = $_SESSION['user']['person_id'];
  $recipient_id = $_GET['chat'];
  $db_user = new Db_user();
  if($db_user->check_friends($user_id,$recipient_id)>0)
  {
    if(!empty($_POST['content']))
      $content = stripslashes(htmlspecialchars($_POST['content']));
      $db_messages->insert_message($user_id,$recipient_id,$content);

  }

}
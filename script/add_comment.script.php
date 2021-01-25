<?php
  if($_SESSION['logged'])
  {
    $db_create_stuff = new Db_create_stuff();
    $comment = array();
    $valid_comment=true;
    if(isset($_POST['comment_text']))
    {
      if(empty($_POST['comment_text']))
        $valid_comment=false;
      else
        array_push($comment,stripslashes(htmlspecialchars($_POST['comment_text'])));
    }
    else
    {
      $valid_comment=false;
    }
    if(isset($_POST['post_id']))
    {
      if(empty($_POST['post_id']))
        $valid_comment=false;
      else
        array_push($comment,stripslashes(htmlspecialchars($_POST['post_id'])));

    }
    else
    {
      $valid_comment=false;
    }
    array_push($comment,$_SESSION['user']['person_id']);
      


    if($valid_comment)
    {
      $db_create_stuff->create_comment($comment);
      $db_notification = new Db_notifications();
      $db_post = new Db_posts();
      $post = $db_post->get_post_from_id($_POST['post_id']);
      if($post['person_id']!=$_SESSION['user']['person_id'])
      {
        $db_notification->add_notification_user($_SESSION['user']['person_id'],$post['person_id'],1);
      }
      

    }
      
    else
      $db_create_stuff->error("Error: one of the pararmeters is corrupted. repost your comment!");
  }
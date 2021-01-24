<?php
$deleted = false;
if($_SESSION['logged'])
  {
    $db_post = new Db_posts();
    $post = $db_post->convert_to_posts([$post_id]);
    if($post)
    {
      $condition1 = $db_post->own_post_check($post[0],$_SESSION['user']['person_id']);
    }
    else{
      $condition1 = false;
    }
    
    if($condition1 || $_SESSION['user']['is_admin'])
    {
      $x = $db_post->delete_post($post_id);
      $deleted = true;

    }
    
  }
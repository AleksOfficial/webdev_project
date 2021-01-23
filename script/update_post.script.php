<?php
if($_SESSION['logged'])
{
  $post_id = $_GET['post'];
  $user_id = $_SESSION['user']['person_id'];
  $db_post = new Db_posts();
  $db_create_stuff = new Db_create_stuff();
  $post = $db_post->get_post_from_id($post_id);
  
  
    if($db_post->own_post_check($post,$user_id) || $_SESSION['user']['is_admin'])
    {
      if(isset($_GET['content_post']) && isset($_GET['privacy_status_post']))
      {
        if(!empty($_GET['content_post']) && !empty($_GET['privacy_status_post']))
        {
          $content = stripslashes(htmlspecialchars($_GET['content_post']));
          $post['post_text'] = $content;
          $post['privacy_status'] = $_GET['privacy_status_post'];
          $db_post->remove_tags_from_id($post_id);
          $tags = $db_create_stuff->get_hashtags($content,0);
          $db_create_stuff->add_tags($tags,$post_id);
          $db_create_stuff->update_post($post);
        }
      }
      
    }

  
}
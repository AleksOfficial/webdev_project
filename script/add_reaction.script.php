<?php
if(isset($_GET['reaction']) && !empty($post_id))
{
  if(!empty($_GET['reaction']) && $_SESSION['logged'])
  {
    $reaction_id= $_GET['reaction'];
    $user_id = $_SESSION['user']['person_id'];
    $db_create_stuff = new Db_create_stuff();
    $db_create_stuff->add_reaction($reaction_id,$post_id,$user_id);
    $db_notification = new Db_notifications();
    $db_post = new Db_posts();
    $post = $db_post->get_post_from_id($post_id);
    if($post['person_id']!=$_SESSION['user']['person_id'])
    {
      $db_notification->add_notification_user($_SESSION['user']['person_id'],$post['person_id'],2+$reaction_id);
    }
    
    
    //^Notlösung, es funktioniert auch wenn man weitere Reaktionen zur DB hinzufügt, man muss jedoch auch in der type_notification das ebenfalls erwähnen.
    //um das zu lösen bräuchte man einen Foreign Key von type_notification->reaction_type mit auf die IDs um sie zu joinen und dann dementsprechend hinzuzufügen.
    //So wirds aber für das Projekt auch funktionieren
     

  }
}

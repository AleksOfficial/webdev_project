<?php
if(isset($_GET['reaction']) && !empty($post_id))
{
  if(!empty($_GET['reaction']) && $_SESSION['logged'])
  {
    $reaction_id= $_GET['reaction'];
    $user_id = $_SESSION['user']['person_id'];
    $db_create_stuff = new Db_create_stuff();
    $db_create_stuff->add_reaction($reaction_id,$post_id,$user_id);

  }
}

<?php
class db_messages extends Db_con
{
  function get_messages_list($user_array)
  { 
    $con = $this->connect();
    $query = "SELECT * FROM messages where to_id=? OR from_id = ? ORDER BY msg_id DESC";
    $stmt = $con->prepare($query);
    $id = $user_array['person_id'];
    $stmt->execute([$id, $id]);
    $print_order = array();
    $recipients = array();
    while ($row = $stmt->fetch()) {
      $new_entry = $row;
      $recipient_id = $this->get_not_user($row, $id);
      $new_entry['recipient_id'] = $recipient_id;

      $index = array_search($recipient_id, $recipients);
      if (!empty($recipients)) {
        if ($recipients[0] == $recipient_id || $index > 0) {

        } else {
          array_push($print_order, $new_entry);
          array_push($recipients, $recipient_id);
        }
      } else {
        array_push($print_order, $new_entry);
        array_push($recipients, $recipient_id);
      }
    }
    return $print_order;
  }
  function get_unread_msg ($user_id,$recipient_id)
  {
    $con = $this->connect();
    $query = "SELECT COUNT(*) FROM messages WHERE (from_id = ? AND to_id =?) AND viewed = 0";
    $stmt = $con->prepare($query);
    $stmt->execute([$recipient_id,$user_id]);
    return $stmt->fetch()['COUNT(*)'];
  }
  

  function print_list_element($user_id, $message)
  {
    $db_user = new db_user();
    $user = $db_user->get_user_by_id($message['recipient_id']);
    $recipient_id = $message['recipient_id'];
    $img_path = $user['thumbnail_path'];
    $username = $user['username'];
    $content = $message['content'];
    $timestamp = $this->get_timestring($message['created_on']);
    $unread = $this->get_unread_msg($user_id,$recipient_id);
    echo "
      <a href='index.php?site=show_chat&chat=$recipient_id'>
      <div class='row list_element'>
      <div class ='col thumbnail_list'><img class='messengerthumbnail' src='$img_path'></div>
      <div class ='col username_list'>$username</div>
      <div class ='col timestamp_list'><p class='msg_content'>$content</p><i class='timestamp'>$timestamp</i></div>
      <div class ='col unread_msg_list'><span class='unread_msg_counter'>$unread</span></div>
      </div>
      </a>";
  }
  function get_chat($user,$recipient_id)
  {

    $con = $this->connect();
    $id = $user['person_id'];
    $query = "SELECT * FROM messages WHERE (from_id = ? AND to_id = ?) OR (to_id = ? AND from_id = ?)";
    $stmt = $con->prepare($query);
    $stmt->execute([$id,$recipient_id,$id,$recipient_id]);
    return $stmt->fetchAll();
    
  }
  function update_viewed($user_id,$recipient_id)
  {
    $con = $this->connect();
    $query = "UPDATE messages SET viewed =1 WHERE from_id = ? AND to_id =?";
    $stmt = $con->prepare($query);
    $stmt->execute([$recipient_id,$user_id]);
  }
  function print_message($message,$user_id)
  {
    $r_id = $message['from_id'];
    $content = $message['content'];
    $timestring = $this->get_timestring($message['created_on']);
    if($r_id == $user_id)
    {
      echo "<div class='row'>
      <div class ='message-orange col-sm-7 offset-sm-5 '>
    <div class='message-content'>
        $content
    </div>
    <div class='message-timestamp-right'>$timestring</div>
  </div>
  </div>";
    }
    else{
      echo "<div class='row'>
      <div class ='message-blue col-sm-7 '>
      <div class='message-content'>
      $content
      </div>
      <div class='message-timestamp-left'>$timestring</div>
    </div>
    </div>";
    }
  }
  function insert_message($from_id,$recipient_id,$content)
  {
    $con = $this->connect();
    $query = "INSERT INTO messages(from_id,to_id,content,viewed,created_on) VALUES(?,?,?,0,CURRENT_TIME)";
    $stmt = $con->prepare($query);
    $stmt->execute([$from_id,$recipient_id,$content]);
  }
  
  /*
  LMAO NONE OF THIS SHIT WORKS ! NOOOO I AM NOT MAD AT MYSELF OR PHP
  function get_messages_list($user_array)
  {
    $con = $this->connect();
    //ALL Messages involved with the User 
    $query = "SELECT * FROM messages WHERE to_id = ? OR from_id= ?";
    $stmt = $con->prepare($query);
    $stmt->execute([$user_array['person_id'], $user_array['person_id']]);
    $msg_array = array();
    $person_id = $user_array['person_id'];
    //var_dump($stmt->fetchAll());
    while ($row = $stmt->fetch()) {
      //var_dump($row);
      $from_id = $row['from_id'];
      $to_id = $row['to_id'];
      //user received msg
      if ($person_id == $to_id) {
        if (isset($msg_array["$from_id"])) {
          if ($msg_array["$from_id"]['msg_id'] < $row['msg_id']) {
            $new_message = array();
            $new_message = array_merge($new_message,$row);
            //update unviewed msgs
            if (!$row['viewed']) {
              if (isset($msg_array["$from_id"]["unread_msg_total"])) {
                $msg_array["$from_id"]["unread_msg_total"]++;
              } else {
                $msg_array["$from_id"]["unread_msg_total"] = 1;
              }
              $new_message["unread_msg_total"] = $msg_array["$from_id"]["unread_msg_total"];
              $msg_array["$from_id"] = $new_message;
            }
          }
        } else {
          //msg doesn't exist in array yet - create new entry
          $msg_array["$from_id"] = $row;
          if (!$row['viewed']) {
            $msg_array["$from_id"]["unread_msg_total"] =1;
          }
          else{
          $msg_array["$from_id"]["unread_msg_total"] =0;
          }
        }
      }
      //user sent msg
      else {
        if (isset($msg_array["$to_id"])) {
          if ($msg_array["$to_id"]["msg_id"] < $row["msg_id"]) {
            $msg_array["$to_id"] = $row;
            $msg_array["$to_id"]["unread_msg_total"]=0;
          }
        }
        else
        {
          $msg_array["$to_id"]=$row;
          $msg_array["$to_id"]["unread_msg_total"]=0;
        }
      }
    }
    return $msg_array;
  }
  function sort_message_list_desc($message_list)
  {
    $sorted_list = array();
    $var = 0;
    $not_inserted = true;
    foreach($message_list as $message)
    {
      if(empty($sorted_list))
      {
        $sorted_list[$var] = $message;
        $var++;
      }
      else
      {
        for($x = 0; $x<$var; $x++)
        {
          if($sorted_list[$x]["msg_id"]<$message["msg_id"])
          {
            var_dump($sorted_list);
            $after_elements = array_slice($sorted_list,$x);
            $prev_elements = array_diff($sorted_list,$after_elements);
            var_dump($prev_elements);
            $prev_elements[$x] = $message;
            $sorted_list = array_merge($prev_elements,array_slice($sorted_list,$x));
            $not_inserted = false;
            $var++;
            break;
          }
        }
        if($not_inserted)
        {
          $sorted_list[$var] = $message;
          $var++;
        }
      }
    }
    return $sorted_list;
  }
  function determine_user_msg_list($sorted_list, $logged_user)
  {
    //can be only in from or to field. and it can't be the same one as the logged user
    $user_list = array();
    foreach($sorted_list as $message)
    {
      if($message['from_id']===$logged_user['person_id'])
        array_push($user_list,$message['to_id']);
      else
        array_push($user_list,$message['from_id']);
    }
    return $user_list;
  }
  */
}

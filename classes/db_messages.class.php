<?php
class db_messages extends Db_con
{
  function get_messages_list($user_array)
  {
    $con = $this->connect();
    $query = "SELECT * FROM messages where to_id=? OR from_id = ? ORDER BY msg_id DESC";
    $stmt = $con->prepare($query);
    $id = $user_array['person_id'];
    $stmt->execute([$id,$id]);
    $print_order = array();
    $recipients = array();
    while($row = $stmt->fetch())
    {
      $new_entry = $row;
      $recipient_id = $this->get_recipient_id($row,$id);
      $new_entry['recipient_id'] = $recipient_id;
      if(!$new_entry['viewed'])
      $new_entry['unread_msg'] = 1;
      else
      $new_entry['unread_msg']=0;
      $index = array_search($recipient_id,$recipients);
      if(!empty($recipients))
      {
        if($recipients[0]==$recipient_id || $index>0)
        {
          if(!$row['viewed'])
          {
            $print_order[$index]['unread_msg']++;
          }
        }
        else{
          array_push($print_order,$new_entry);
          array_push($recipients,$recipient_id);
        }
      }
      else
      {
        array_push($print_order,$new_entry);
        array_push($recipients,$recipient_id);
      }
    }
    return $print_order;
    }
  function get_recipient_id($message,$id)
  {
    if($message['from_id']==$id)
      return $message['to_id'];
    else
      return $message['from_id'];
  }

  function get_timestring($timestamp)
  { 
    //Cool this works :) maybe we can shift it to the con_class so every function has this capability. This way you can use it for posts as well.
    $date_msg = new DateTime($timestamp);
    $now = date('D d M Y H:i:s');
    $date_now = new DateTime($now);
    $diff = $date_now->diff($date_msg);
    var_dump($diff);
    /*
    $timestamp=strtotime($timestamp);
    $now = time();
    $diff = $now-$timestamp;
    $diff=getdate($diff);
    //var_dump(getdate($timestamp));
    var_dump($now);
    var_dump($diff);
    */
  }

  function print_list_element($userid,$message)
  {
    $db_user = new db_user();
    $user = $db_user->get_user_by_id($userid);
    $img_path = $db_user->get_profile_thumbnail_path($userid);
    $username = $user['username'];
    $content = $message['content'];
    $timestamp = $this->get_timestring($message['created_on']);
    //echo out 
    /*<html>
      <td><img class='messengerthumbnail' src='$img_path'></td>
      <td><p class="username">$username</p></td>
      <td><p class="msg_content">$content</p><i class="timestamp">$timestamp      
    </html>*/
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

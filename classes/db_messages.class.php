<?php
class db_messages extends Db_con{
  
  function get_messages_list($user_array)
  {
    $con = $this->connect();
    //ALL Messages involved with the User 
    $query = "SELECT * FROM messages WHERE to_id = ? OR from_id= ?";
    $stmt = $con->prepare($query);
    $stmt->execute([$user_array['person_id'],$user_array['person_id']]);
    $msg_array = array();
    $person_id = $user_array['person_id'];
    while($row = $stmt->fetch())
    {
      
      $from_id =$row['from_id'];
      $to_id = $row['to_id'];
      //user received msg
      if($person_id == $to_id)
      {
        if(isset($msg_array["$from_id"]))
        {
          $prev_message = $msg_array["$from_id"];
          if($prev_message['msg_id']<$row['msg_id'])
          {
            $msg_array["$from_id"] = $row;
            if(!$row['viewed'])
            {
              if(isset($msg_array["$from_id"]["unread_msg_total"]))
              {
                $msg_array["$from_id"]["unread_msg_total"]++;
              }
              else{
                $msg_array["$from_id"]["unread_msg_total"]=1;
              }
            }
          }
        }
      else{
          $msg_array["$from_id"]=$row;
      }
    }
    //user sent msg
    else{
      if(isset($msg_array["$to_id"]))
      {
        if($msg_array["$to_id"]["msg_id"]<$row["msg_id"])
        {
          $msg_array["$to_id"] = $row;
        }
      }
    }
  }
  return $msg_array;
}
}

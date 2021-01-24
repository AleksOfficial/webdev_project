<?php
class Db_notifications extends Db_con{
  function get_all_notifications($user_id)
  {
    $con = $this->connect();
    $query = "SELECT * FROM all_notifications WHERE to_id = ?";
    $stmt = $con->prepare($query);
    $stmt->execute([$user_id]);
    return $stmt->fetchAll();
  }
  function add_notification_user ($from_user,$to_user,$notification_type)
  {
    $con = $this->connect();
    $query = "INSERT INTO all_notifications(notification_time,viewed,from_id,to_id,notification_id) VALUES(CURRENT_TIMESTAMP,0,?,?,?)";
    $stmt = $con->prepare($query);
    $x = $stmt->execute([$from_user,$to_user,$notification_type]);
    if($x)
    {
      return true;
    }
    else
    {
      $this->error($stmt->errorInfo()[2]);
      return false;
    }
  }
  function welcome_message($user_id)
  {
    $con = $this->connect();
    $query = "INSERT INTO messages(from_id,to_id,content,viewed,created_on) VALUES(1,?,\"Welcome to Rift! This is the messaging area where you can chat with your friends. You can't chat with foreigners like me though... but deep down, I feel a friendly connection :)\",0,CURRENT_TIMESTAMP)";
    $stmt = $con->prepare($query);
    $x = $stmt->execute([$user_id]);
    if($x)
    {
      return true;
    }
    else
    {
      $this->error("Error: Welcome Message couldn't be created - ".$stmt->errorInfo()[2]);
      return false;
    }
  }


}
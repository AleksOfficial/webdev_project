<?php
class db_notifications extends Db_con{
  function get_all_notifications($user_id)
  {
    $con = $this->connect();
    $query = "SELECT * FROM all_notifications WHERE to_id = ?";
    $stmt = $con->prepare($query);
    $stmt->execute([$user_id]);
    return $stmt->fetchAll();
  }
  //at the end.


}
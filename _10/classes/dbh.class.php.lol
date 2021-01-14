<?php
class dbh
{
  private $user = "hello_world";
  private $pwd ="123";
  private $db_name = "webtech_9";
  private $db_host = "localhost";


  protected function connect()
  {
    $pdo = new PDO('mysql:host = '. $this->db_host.'; dbname = '.$this->db_name, $this->user,$this->pwd);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_CLASS);
    return $pdo;
  }

  function getUserList()
  {
    return;
  }
  function getUser($username)
  {
    return;
  }
  function registerUser($userobject)
  {
    return;
  }
  function updateUser($userobject)
  {
    return;
  }
  function deleteUser($UserID)
  {
    return;
  }
  function loginUser($username,$password)
  {
    return;
  }


}
<?php
class Db_con
{
  private $host = "localhost";
  private $user = "hello_world";
  private $pwd = "123";
  private $dbName = "webdev_project";

  protected function connect()
  {
    $dsn = 'mysql:host=' . $this->host . ';dbname=' . $this->dbName;
    $pdo = new PDO($dsn, $this->user, $this->pwd);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    return $pdo;
  }

  public function error($error_msg, $array = NULL)
  {
    if ($array == NULL) {
      echo '<div class="alert alert-danger" role="alert">
      ' . $error_msg . '</div>';
    } else {
      $string = $error_msg . "<ul>\n";
      foreach ($array as $x) {
        $string = $string . "\n<li>$x</li>\n";
      }
      $string = $string . "</ul>";
      echo '<div class="alert alert-danger" role="alert">
      ' . $string . '</div>';
    }
  }
  public function success($success_msg)
  {
    echo '<div class="alert alert-success" role="alert">
    ' . $success_msg . '</div>';
  }
  function get_timestring($timestamp)
  {
    //Cool this works :) maybe we can shift it to the con_class so every function has this capability. This way you can use it for posts as well.
    $date_msg = new DateTime($timestamp);
    $now = date('D d M Y H:i:s');
    $date_now = new DateTime($now);
    $diff = $date_now->diff($date_msg);

    if ($diff->y) {
      return $date_msg->format('D, d M Y H:i');
    }
    if ($diff->m) {
      return $date_msg->format('D, d M Y H:i');
    }
    if ($diff->d) {
      if ($diff->d < 10)
        return $diff->d . " day" . ($diff->y > 1 ? "s" : "") . " ago. - " . $date_msg->format('D, d M Y H:i');
      else
        return $date_msg->format('D, d M Y H:i:s');
    }
    if ($diff->h) {
      return $diff->h . " hour" . ($diff->h > 1 ? "s" : "") . " ago - " . $date_msg->format('H:i');
    }
    if ($diff->i) {
      return $diff->i . " minute" . ($diff->i > 1 ? "s" : "") . " ago. - " . $date_msg->format('H:i');
    }
    if ($diff->s) {
      if ($diff->s < 30) {
        return "under 30 seconds ago. - " . $date_msg->format('H:i');
      } else {
        return "under a minute ago. - " . $date_msg->format('H:i');
      }
    }
    return "Now";
}
function get_not_user($from_to_array, $user_id)
{ 
  if($from_to_array['from_id'] == $user_id)
    return $from_to_array['to_id'];
  else
    return $from_to_array['from_id'];
}
}

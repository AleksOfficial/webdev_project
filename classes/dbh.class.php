<?php
class Dbh
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
}

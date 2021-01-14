<?php
  include "inc/class-autoload.inc.php";
  session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
  <link rel = "stylesheet" href="./res/css/style.css">
  <title>Document</title>
</head>
<body>
<?php
      $db = new db();

  if(isset($_POST['register']))
  {
    $user = new User($_POST);
    $db->registerUser($user);
  }

  if (isset($_POST['reset-password-submit'])) 
  {
    include "/inc/reset-password.script.php";
  }

  if(isset($_POST['password_reset']))
  {
    include "./inc/reset-password.inc.php";
  }

  if(isset($_POST['login_button']))
    if($db->loginUser($_POST['username'],$_POST['password']))
    {
      $_SESSION['logged'] = true;
      $_SESSION['username'] = $_POST['username'];
      echo "SUCCESS!";
    }

  if(isset($_SESSION['logged']) && $_SESSION['logged'])
  {
    include "inc/show_details.inc.php";
  }

  else if(isset($_GET['register']))
  {
    include "inc/registerForm.inc.php";
  }
  else 
  {
    include "inc/login.inc.php";
  }
  
  
?>
</body>
</html>

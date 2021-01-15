<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
  <link rel = "stylesheet" href="./res/css/base.css">
  <?php
    //css
    session_start();
    $file = basename(__FILE__);
    if(isset($_GET['register']))
      echo '<link rel = "stylesheet" href="./res/css/registerform.css">';
    else
      echo '<link rel = "stylesheet" href="./res/css/login.css">';
      ?>
  <title>Document</title>
</head>
<body>
  <?php
    //var_dump($_POST);
    include "inc/class-autoload.inc.php";
    if(isset($_GET['register']))
    {
      include "inc/registerForm.inc.php";
    }
    else
      include "inc/login.inc.php";
    $db = new Db_user();

    if(isset($_POST['register']))
    {
      if($db->register_user($_POST))
      {
        //here should be a login thing. 
        echo"hi";
      }

    }
    if(isset($_POST['login']))
    {
      $db->loginUser($_POST['username'],$_POST['password']);
    }
    

?>

  
</body>
</html>
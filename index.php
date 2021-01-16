<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
  <link rel="stylesheet" href="./res/css/base.css">
  <?php
  //Initial setup
    session_start();
    $file = basename(__FILE__);
    include "inc/class-autoload.inc.php";
    
    if (isset($_GET['site'])) {
      $navigator = $_GET['site'];
    } else {
      $navigator = "home";
    }
    if (!isset($_SESSION['user'])) {
      $_SESSION['logged'] = false;
    }
  
  //Login User & Register
  $db = new Db_user();
  if(isset($_POST['login']) ||isset($_POST['register']))
  {
    include "script/login_register.script.php";
  }

  //css
  switch ($navigator) {
    case 'notifications':
      // does notifications have a css?
      break;
    case 'messages':
      // does messages have a css?
      break;
    case 'admin':
      // does admin have a css?
      break;
    case 'impressum':
      // does impressum have a css?
      break;
    case 'login':
      echo '<link rel = "stylesheet" href="./res/css/login.css">';
      break;

    case 'register':
      echo '<link rel = "stylesheet" href="./res/css/registerform.css">';
      break;
    default:
      header("sites/lost.php");
      break;
  }
  ?>
  <title>🌍 RIFT - <?php echo ucwords($navigator)?></title>
</head>

<body>
  <?php
  //Navbar
  include 'inc/navigation.inc.php';
  //Main Elements 
  switch ($navigator) {
    case 'notifications':
      include 'inc/notifications.inc.php';
      break;
    case 'messages':
      include 'inc/messages.inc.php';
      break;
    case 'adminset':
      include 'inc/administration.inc.php';
      break;
    case 'impressum':
      include 'inc/impressum.inc.php';
      break;
    case 'login':
      include 'inc/login.inc.php';
      break;
    case 'logout':
      session_destroy();
      header("Location: index.php");
      break;
    case 'register':
      include 'inc/registerform.inc.php';
      break;
    case 'home':
      echo"welcome user!";
      break;
    default:
      header("Location: sites/lost.php");
      break;
  }
  ?>
</body>

</html>
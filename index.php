<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
  <link rel="stylesheet" type="text/css" href="jquery.fancybox.min.css">
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
    if($file == "index.php")
    {
      $dots=".";
    }
    else
    {
      $dots="..";
    }
  //Login User & Register
  $db = new Db_user();
  if(isset($_POST['login']) ||isset($_POST['register']))
  {
    include "script/login_register.script.php";
  }
  if(isset($_POST['submit_post']))
  {
    include "script/add_post.script.php";
  }
  if(isset($_POST['update_profile']))
  {
    include "script/update_profile.script.php";
  }


  //css
  switch ($navigator) {
    case 'notifications':
      // does notifications have a css?
      echo '<link rel = "stylesheet" href="./res/css/notifications.css">';
      break;
    case 'messages':
      echo '<link rel = "stylesheet" href="res/css/messages.css">';
      break;
    case 'show_chat':
      echo '<link rel = "stylesheet" href="res/css/messages.css">';
      //echo '<meta http-equiv="refresh" content="30">'; might be added later.
      break;
    case 'admin':
      // does admin have a css?
      echo '<link rel = "stylesheet" href="./res/css/admin.css">';
      break;
    case 'impressum':
      echo '<link rel = "stylesheet" href="./res/css/impressum.css">';
      break;
    case 'help':
      echo '<link rel = "stylesheet" href="./res/css/impressum.css">';
    case 'login':
      echo '<link rel = "stylesheet" href="./res/css/login.css">';
      break;
    case 'register':
      echo '<link rel = "stylesheet" href="./res/css/registerform.css">';
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
    case 'admin':
      include 'inc/administration.inc.php';
      break;
    case 'impressum':
      include 'inc/impressum.inc.php';
      break;
    case 'help':
      include 'inc/help.inc.php';
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
    case 'search':
      header("Location: sites/searchUserTest.php");
      break;
    case 'home':
      include 'inc/home.inc.php';
      break;
    case 'show_chat':
      include 'inc/show_chat.inc.php';
      break;
    case 'start_chat':
      include 'inc/start_chat.inc.php';
      break;
    default:
      header("Location: sites/lost.php");
      break;
  }
  
  ?>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js" integrity="sha384-q2kxQ16AaE6UbzuKqyBE9/u/KzioAlnx2maXQHiDX9d4/zp8Ok3f+M7DPm+Ib6IU" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.min.js" integrity="sha384-pQQkAEnwaBkjpqZ8RU1fF1AKtTcHJwFl3pblpTlHXybJjHpMYo79HY3hIi4NKxyj" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="jquery.fancybox.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.js" integrity="sha512-uURl+ZXMBrF4AwGaWmEetzrd+J5/8NRkWAvJx5sbPSSuOb0bZLqf+tOzniObO00BjHa/dD7gub9oCGMLPQHtQA==" crossorigin="anonymous"></script>
</body>

</html>
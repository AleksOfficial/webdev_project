<?php
session_start();
$file = basename(__FILE__);
$navigator = "profile";
$dots = "..";
include "../inc/class-autoload.inc.php";
include "../inc/navigation.inc.php";

if ($_SESSION['logged']) {
  //only logged users can view profiles
?>
  <!DOCTYPE html>
  <html lang="en">

  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
    <link rel="stylesheet" href="../res/css/base.css">
    <link rel="stylesheet" href="../res/css/profile.css">
    <title>🌍 RIFT - <?php echo ucwords($navigator) ?></title>
  </head>

  <body>
  <?php
  //Friend stuff 
  if(isset($_GET['friend_request']) || isset($_GET['friend_accept']) || isset($_GET['unfriend']))
  {
    include "../script/friend.script.php";
  }

  //Initialize stuff
  $db_user = new Db_user();
  //$db_post = new db_post()
  if (isset($_GET['user'])) {
    $user = $db_user->get_user_by_id($_GET['user']);
    $user_id = $user['person_id'];
    $filename = $user['image_name'];
    $file_path = "../" . $user['file_path'];
    $username = $user['username'];
    $first_name = $user['first_name'];
    $last_name = $user['last_name'];
  } else {
      
      $user_id = $_SESSION['user']['person_id'];
      $filename = $_SESSION['user']['image_name'];
      $file_path = "../" . $_SESSION['user']['file_path'];
      $username = $_SESSION['user']['username'];
      $first_name = $_SESSION['user']['first_name'];
      $last_name = $_SESSION['user']['last_name'];
    }
  $sender = $_SESSION['user']['person_id'];
  $user = $db_user->get_user_by_id($user_id);
  $friend_count = $db_user->count_friends($user_id);
  $friends_string = "";
  $all_friends = $db_user->get_friends($user_id);
  $var = 0;
  



  $db_user = new Db_user();

  if ($_SESSION['logged']) {
    $friends = $db_user->check_friends($_SESSION['user']['person_id'], $user_id);
    $own_profile = ($_SESSION['user']['person_id'] == $_GET['user']);
  } else {
    $friends = 0;
    $own_profile = 0;
  }




  //for loop for the last 3 friends added to his friend list
  foreach ($all_friends as $friend) {
    if ($var == 6) { //break after getting 6
      break;
    }

    $friend_id = $friend;
    $friend = $db_user->get_user_by_id($friend);
    $thumbnail_friend = $friend['thumbnail_path'];
    $filename_friend = $friend['image_name'];
    $username_friend = $friend['username'];
    $friends_string = $friends_string . "<div class='col'>
          <div class='row'><div class='col' style='height:80px;'><img class='profile_pic small_profile_pic' src='../$thumbnail_friend' alt='$filename_friend'>
          </div>
          </div>
          <div class ='row'>
          <div class='col'><a href='./profile.php?user=$friend_id'>$username_friend
          </a>
          </div>
          </div>
          </div>";
    $var++;
  }

  echo "<div class='container main'>
    <div class='row'>
      <div class='col-lg-3'>
        <div class='main_left sidebar'>
          <div class='card text-white bg-dark mb-3 user_profile'>
              <img class='card-img-top profile_pic' src='$file_path' alt='$filename'>
            
            <div class='card-title username'>
            <h3>$username's profile</h3>
          </div>
          <div class='card-text names'>
            <span>$first_name $last_name</span>
          </div> <div class='card-text buttons'>";
  if (!$own_profile) {
    if ($friends == 1) {
      echo "<div class='col'>
              <a href='../index.php?site=show_chat&chat=$user_id' class='btn message_button msg_button '><img src='../res/icons/mail.png'></a></li>
          </div>";
    } else if ($friends == 0) {
      echo "<div class='col'>
              <a href='#' class='btn message_button fr_button isDisabled'><img src='../res/icons/friendrequest.png'></a></li>
          </div>";
    } else {
      echo "<div class='col'>
              <a href='profile.php?user=$user_id&friend_request=$sender' class='btn message_button fr_button'><img src='../res/icons/friendrequest.png'></a></li>
          </div>";
    }
  }
  echo "
            </div>
            <div class='friend_count'>
              <span>Friends ($friend_count):</span>
            </div>
            <div class='row'>
            $friends_string
            </div>
          </div>
        </div>
  </div>
      <div class='col-lg-6'>
        <div class='post'>
          <h3>$username's posts</h3>
        </div>";

  //Print out all posts of user
  include "../inc/feed.inc.php";



  echo "
      </div>
      <div class='col-lg-3'>
        <div class='row>";
  if ($_SESSION['logged']) {
    if ($own_profile || $_SESSION['user']['is_admin']) {
      echo "<div class='col-12'>
            <div class='edit_button'><a href='edit_profile.php?user=$user_id' class='btn btn-warning unfriend_button' style='width:100%'><i><img src='../res/icons/edit.png' alt='unfriend'>Edit Profile</i></a></div>
          </div>";
    }
    if ($friends == 1) {
      echo " <div class='col-12'>
            <div class='unfriend_button'><a href='profile.php?user=$user_id&unfriend=$sender' class='btn btn-danger unfriend_button'style='width:100%'><i><img src='../res/icons/unfriend.png' alt='unfriend'>Unfriend</i></a></div>
          </div>";
    }
  }
  echo "
         
      </div>
    </div>
  </div>
  </div>

</body>

</html>";
} else {
  header("Location: ../index.php?error=1");
}

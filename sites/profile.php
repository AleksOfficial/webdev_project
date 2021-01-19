<?php
session_start();
$file = basename(__FILE__);
$navigator = "profile";
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
    <link rel="styelsheet" href="../res/css/profile.css">
    <title>🌍 RIFT - <?php echo ucwords($navigator) ?></title>
  </head>

  <body>
    <?php
    $db_user = new Db_user();
    //$db_post = new db_post();
    $user_id = $_SESSION['user']['person_id'];
    $filename = $_SESSION['user']['image_name'];
    $file_path = "../".$_SESSION['user']['file_path'];
    $username = $_SESSION['user']['username'];
    $first_name = $_SESSION['user']['first_name'];
    $last_name = $_SESSION['user']['last_name'];
    $user = $db_user->get_user_by_id($user_id);
    $friend_count = $db_user->count_friends($user_id);
    $friends_string = "";
    
    //for loop for the last 3 friends added to his friend list
    if ($friend_count > 3) {
      for ($x = 0; $x < 3; $x++) {
        //add the 3 things
      }
    } else {
      for ($x = 0; $x < $friend_count; $x++) {
        //add the 3 things
      }
    }

    echo "<div class='container'>
    <div class='row'>
      <div class='col-lg-3'>
        <div class='main-left-sidebar'>
          <div class='user_profile'>
            <div class='user_pro_img'>
              <img src='$file_path' alt='$filename'>
            </div>
            <div class='buttons'>
              <ul>
                <li> <a href='profile.php?user=$user_id&friend_request=1' class='btn my_button friend_button'><img src='../res/icons/.png'></a></li>
                <li> <a href='../index.php?site=show_chat&chat=$user_id' class='btn my_button message_button'><img src='../res/icons/mail.png'></a></li>
                <li> <a href='profile.php?user=$user_id&friend_request=1' class='btn message_button'><img src='../res/icons/friendrequest.png'></a></li>
              </ul>
            </div>
            <div class='friend_count'>
              <span>Friends ($friend_count)</span>
              
            </div>
            $friends_string
          </div>
        </div>
      </div>
      <div class='col-lg-6'>
        <div class='user_info'>
          <h3>$username</h3>
          <div class='first_second_names'>
            <span>$first_name $last_name</span>
          </div>
        </div>
        <div class='post_section'>";
        //Print out all posts of user
        
        
        
      echo "</div>
      </div>
      <div class='col-lg-3'>
        <div class='edit_button'><a href='profile.php?user=$user_id&unfriend=1' class='btn my_button unfriend_button'><i><img src='../res/icons/edit.png' alt='unfriend'></i></a></div>
        <div class='unfriend_button'><a href='profile.php?user=$user_id&unfriend=1' class='btn my_button unfriend_button'><i><img src='../res/icons/unfriend.png' alt='unfriend'></i>Unfriend</a></div>
      </div>
    </div>
  </div>
  </div>

</body>

</html>";
    ?>

    ?>
  <?php
} else {
  header("Location: ../index.php?error=1");
}

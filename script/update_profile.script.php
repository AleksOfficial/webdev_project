<?php
if($_SESSION['logged'])
{
  $user = $_SESSION['user'];
  $user_id = $_SESSION['user']['person_id'];
  $new_firstname = stripslashes(htmlspecialchars($_POST['first_name']));
  $new_lastname = stripslashes(htmlspecialchars($_POST['last_name']));
  $new_emailname = stripslashes(htmlspecialchars($_POST['email']));
  $new_username = stripslashes(htmlspecialchars($_POST['username']));
  $new_gender = $_POST['gender'];
  $update_user_id = $_POST['user_id'];
  
  $userarray = array($new_firstname,$new_lastname,$new_username,$new_emailname,$new_gender);
  $db_user = new Db_user();
  $db_create_stuff = new Db_create_stuff();
  if (isset($_FILES['image'])) {
    if(!empty($_FILES['image']['type']))
    {
    $file = $_FILES['image'];

    $file_name = $_FILES['image']['name'];
    $file_tmp_name = $_FILES['image']['tmp_name'];
    $file_size = $_FILES['image']['size'];
    $file_error = $_FILES['image']['error'];
    $file_type = $_FILES['image']['type'];

    $file_name_exploded = explode(".", $file_name);
    $file_actual_extension = strtolower(end($file_name_exploded));
    $allowed = array("jpg","jpeg", "png", "gif");
    if (in_array($file_actual_extension, $allowed)) {
      if ($file_error == 0) {
        if ($file_size < 10000000) {
          $file_name_new = uniqid('', true) . "." . $file_actual_extension;
          $file_destination = "uploads\\pic\\" . $file_name_new;
          move_uploaded_file($file_tmp_name, $file_destination);
          $image_processor = new ImageProcessor();
          $thumbnail_path= $image_processor->createThumbnail($file_destination);
        } else {
          $db_create_stuff->error( "Your file is too big!");
        }
      } else {
        $db_create_stuff->error( "There was an error uploading your file!");
      }
    } else {
      $db_create_stuff->error( "You cannot upload filesof this type!");
    }
  
    $image = array();
    array_push($image,$file_name,$file_destination,$thumbnail_path);
    $image_id= $db_create_stuff->create_image($image);
    array_push($userarray,$image_id);
  }
}
  
  if($user_id == $update_user_id || $_SESSION['user']['is_admin'])
  {
    $db_user->update_user($userarray,$update_user_id);
    if($user_id == $update_user_id)
    {

      if(isset($userarray[5]))
      {
        $_SESSION['user']['thumbnail_path'] = $thumbnail_path;
        $_SESSION['user']['image_name'] = $file_name;
        $_SESSION['user']['file_path'] = $file_destination;
      }
      $_SESSION['user']['first_name'] = $new_firstname;
      $_SESSION['user']['last_name'] = $new_lastname;
      $_SESSION['user']['username'] = $new_username;
    }
    //header("refresh:0;url=$dots/index.php");
    echo '<meta http-equiv="refresh" content="0;url=index.php">';
}
  else
  {
    $this->error("Error: Permission denied - you are not the user or an admin.");
  }

  
}
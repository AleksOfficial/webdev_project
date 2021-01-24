<?php

if ($_SESSION['logged']) {
    $db_post = new Db_posts();
    $db_create_stuff = new Db_create_stuff();
  if (isset($_POST['submit_post'])) {
    if(empty($_POST['content_post']) && !isset($_FILES['file']))
    {
      //no post and file is empty
      header("Location: index.php?error=2");
    }
    $new_post = array();
    array_push($new_post,$_SESSION['user']['person_id'],stripslashes(htmlspecialchars($_POST['privacy_status_post'])),stripslashes(htmlspecialchars($_POST['content_post'])));


    
    
    
    if (isset($_FILES['image'])) {
      if(!empty($_FILES['image']['type']))
      {
      $file = $_FILES['image'];

      $file_name = stripslashes(htmlspecialchars($_FILES['image']['name']));
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
            echo "Your file is too big!";
          }
        } else {
          echo "There was an error uploading your file!";
        }
      } else {
        echo "You cannot upload filesof this type!";
      }
      $image = array();
      array_push($image,$file_name,$file_destination,$thumbnail_path);
      $id = $db_create_stuff->create_image($image);
      array_push($new_post,$id);
    }
  }
    $post_id = $db_create_stuff->create_post($new_post);
    $tags=$db_create_stuff->get_hashtags($new_post[2],0);
    $db_create_stuff->add_tags($tags,$post_id);
    //var_dump($post_id);
  }
header("Location: index.php");
}
else
{//User is not logged in
  header("Location: index.php?error=1");
}

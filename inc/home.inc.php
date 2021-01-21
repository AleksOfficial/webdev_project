<?php
if($_SESSION['logged'])
{
  $file_path = $_SESSION['user']['thumbnail_path'];
  $filename = $_SESSION['user']['image_name'];
  $first_name = $_SESSION['user']['first_name'];
  $last_name = $_SESSION['user']['last_name'];
  $username = $_SESSION['user']['username'];
}
else{
  $file_path = './res/icons/default_smaller.png';
  $filename = 'default.png';
  $first_name = "";
  $last_name = "";
  $username = "Guest";
}

echo "<div class='container main'>
  <div class='row'>
    <div class='col-lg-3'>
      <div class='main_left'>
        <div class='card text-white bg-dark mb-3 user_profile'>
          <img class='card-img-top profile_pic' src='$file_path' alt='$filename'>
        
        <div class='card-title username'>
          <h3>Welcome $username!</h3>
        </div>
        <div class='card-text names'>
          <span>$first_name $last_name</span>
        </div>


      </div>
      </div>
    </div>
<div class='col-lg-6'>";
  if($_SESSION['logged'])
  {
    echo"<div class='post_bar'>
    <div class='row'> 
    <form action='index.php' enctype='multipart/form-data' method='POST'>
    <div class='col-3'>
    <h5>Submit a post</h5>
    </div>
    <div class='col-9'>
    <select class='form-select' name='privacy_status_post' aria-label='Default select example'>
      <option selected value='1'>Public</option>
      <option value='2'>Friends</option>
      <option value='3'>Private</option>
    </select>
    </div>
    </div> 
    
    <div class='row'>
    
    <div class='input-group'>
    
        <div class='input-group-prepend'>
          <a class='btn send_btn send_btn_left'><i><input type='file' class='file_upload' name='image'><img class='button_icon_left'  src='res/icons/camera.png' alt='upload your image'></i></a>
      </div>
        <textarea class='form-control' name='content_post' maxlength='500' placeholder='What are you thinking about today?'></textarea>
        <button class='btn send_btn' type='submit' name='submit_post'><img src='./res/icons/send-mail.png'></button>
    </form>
    </div>
    </div>
    ";
  
  }
  
  




  //Print out all posts of user
  include "./inc/feed.inc.php";



echo "
</div>
<div class='col-lg-3'>
</div>
</div>";
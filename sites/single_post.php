<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
  <link rel="stylesheet" href="../res/css/base.css">
  <title>🌍 RIFT - Search Result</title>
  <?php
  //Initial setup
  session_start();
  $file = basename(__FILE__);
  $dots = "..";
  $navigator = "home";
  $post_id = "";
  
  include "../inc/class-autoload.inc.php";
  include '../inc/navigation.inc.php';
  //Single Post
  if(!empty($_POST))
  {
    $post_id = $_POST['post_id'];
  }
  if(isset($_GET['post']))
  {
    if(!empty($_GET['post']))
    $post_id = $_GET['post'];
  }
  if(isset($_GET['reaction']))
  {
    include "../script/add_reaction.script.php";
  }

  if(isset($_GET['delete']))
  {
    include "$dots/script/delete_post.script.php";
    //header("Location: $dots/script/delete_post.script.php");
  }
  if(isset($_POST['comment_submit']))
  {
    include "../script/add_comment.script.php";
  }
  if(isset($_GET['update_post']))
  {
    include "../script/update_post.script.php";
  }
  ?>
</head>

<body>
  <div class="container main">
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
  }echo"
      <div class='row'>
    <div class='col-lg-3'>
      <div class='main_left'>
        <div class='card text-white bg-dark mb-3 user_profile'>
          <img class='card-img-top profile_pic' src='../$file_path' alt='$filename'>
        
        <div class='card-title username'>
          <h3>Welcome $username!</h3>
        </div>
        <div class='card-text names'>
          <span>$first_name $last_name</span>
        </div>


      </div>
      </div>
    </div>";?>
      <div class="col-lg-6">
      <h3>Single Post View</h3>
        <div class="row">
            <div class="col">
              <?php
              if(isset($deleted))
              {
                if($deleted)
                {
                  echo "<div style='text-align:center'>
                  <h1 class='nothing_here_yet headline'>ᕦ( ͡° ͜ʖ ͡°)ᕤ</h1>
                  <p class='nothing_here_yet text'>deleted like a shredder! </p></div>";
   
                }
              }
              else if(isset($_GET['edit']))
              {
                include "../inc/edit_post.inc.php";
              }
              else{
                include "../inc/feed.inc.php";
              }

              
              ?>
            </div>
            </div>
            <div class="col-3">

            
          </div>
        </div>
      </div>
      <div class="col-2">

      </div>

    </div>
  </div>
</body>

</html>
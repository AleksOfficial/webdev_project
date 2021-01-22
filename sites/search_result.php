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
  include "../inc/class-autoload.inc.php";
  include '../inc/navigation.inc.php';
  //Suchfunktion
  if (isset($_GET['search_submit'])) {
    if(isset($_GET['search_value']) && !empty($_GET['search_value']))
    {
      $db_user = new Db_user();
      $db_post = new Db_posts();
      $db_create = new Db_create_stuff();
      $searchval = $_GET['search_value'];
      $all_tags = $db_post->get_hashtags($searchval,0);
      $tag_search = false;

      foreach($all_tags as $tag)
      {
        $tag_search = true;
        $searchval=str_replace("#".$tag,"",$searchval,);
        $searchval=trim($searchval);
      }
      if(!$tag_search)
      {
        $search_result_users = $db_user->search_user($searchval);
      }
      
      $all_tags = $db_create->tags_to_ids($all_tags);
      
    }
  }



  ?>
</head>

<body>
  <div class="container-fluid">
    <div class="row">
    <div class='col-2'>

  </div>
      <div class="col">
        <div class="row">
          <div class="col d-flex flex-wrap ">
          <?php
          if(!empty($search_result_users)){

          
      foreach($search_result_users as $user)
      {
        $file_path = $user['thumbnail_path'];
        $file_name = $user['image_name'];
        $username = $user['username'];
        $first_name = $user['first_name'];
        $last_name = $user['last_name'];
        $user_id = $user['person_id'];
       
      echo"
      
      <div class='card text-white bg-dark m-2 search_result_card'>
          <img class='card-img-top profile_pic' src='$dots/$file_path' alt='$file_name'>
        <div class='card-body'>
        <div class='card-title username'>
        <h3>$username's profile</h3>
      </div>
      <div class='card-text names'>
        <span>$first_name $last_name</span>
      </div>
          <div class='card-text buttons'>
          <div class='col'>
             <a href='../index.php?site=show_chat&chat=$user_id' class='btn message_button msg_button '><img src='../res/icons/mail.png'></a></li>
          </div>
          <div class='col'>
             <a href='profile.php?user=$user_id&friend_request=1' class='btn message_button fr_button'><img src='../res/icons/friendrequest.png'></a></li>
          </div>
        </div>
      </div>
    </div>
    ";
      }}?>
          </div>
          <div class="row">
            <div class="col">
              <?php
                include "../inc/feed.inc.php";
              ?>
            </div>
          </div>
        </div>
      </div>
      <div class="col-2">

      </div>

    </div>
  </div>
</body>

</html>
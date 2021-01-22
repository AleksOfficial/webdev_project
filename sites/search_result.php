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
        $user_id = $user['person_id'];
        $db_user->print_result_card($user_id);
      }}?>
          </div>
          <div class="row">
          <div class="col-3">
          
          </div>
            <div class="col-6">
              <?php
              
                include "../inc/feed.inc.php";
              ?>
            </div>
            <div class="col-3">
          
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
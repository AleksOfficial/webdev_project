<div class='post_section'>
  <?php
  $db_post = new Db_posts();
  if ($file == "index.php") {
    if ($_SESSION['logged']) {
      //registered user

      //admin user
      $posts_person = $db_post->get_all_posts($_SESSION['user']['person_id']);
    } else {
      //public user
      $posts_person = $db_post->get_posts_public();
    }
  } else {
    //Profile Page
    if ($_SESSION['logged']) {
      $db_user = new Db_user();
      if ($_SESSION['user']['person_id'] == $_GET['user']) {
        //own page
        $posts_person = $db_post->get_own_posts($_SESSION['user']['person_id']);
      } else if ($db_user->check_friends($_SESSION['user']['person_id'], $_GET['user'])) {
        //friend's page
        $posts_person = $db_post->get_posts_from_id_friend($_GET['user']);
      } else {
        //foreigners page
        $posts_person = $db_post->get_posts_from_id_user($_GET['user']);
      }
    } else {
      //not logged on - foreigners page
      $posts_person = $db_post->get_posts_from_id_user($_GET['user']);
    }
  }
  //printing available posts
  if (!empty($posts_person)) {
    foreach ($posts_person as $post) {
      $db_post->print_post($post);
    }
  }
  ?>
</div>
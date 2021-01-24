<div class='post_section'>
  <?php
  $db_post = new Db_posts();


  if ($file == "index.php") {
    if ($_SESSION['logged']) {
      //admin user
      if ($_SESSION['user']['is_admin']) {
        $posts_person = $db_post->get_all_posts($_SESSION['user']['person_id']);
      }
      //registered user
      else {
        $db_user = new Db_user();
        $friends_ids = $db_user->get_friends($_SESSION['user']['person_id']);
        $post_ids = $db_post->get_post_ids_from_own_and_friends($_SESSION['user']['person_id'], $friends_ids);
        $posts_person = $db_post->convert_to_posts($post_ids);
      }
    } else {
      //public user
      $posts_person = $db_post->get_posts_public();
    }
  } else if ($file == "profile.php") {
    //Profile Page
    if ($_SESSION['logged']) {
      $db_user = new Db_user();
      if ($_SESSION['user']['person_id'] == $_GET['user']) {
        //own page
        $posts_person = $db_post->get_own_posts($_SESSION['user']['person_id']);
      } else if ($db_user->check_friends($_SESSION['user']['person_id'], $_GET['user'])>0) {
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
  } else if ($file == "search_result.php") {
    if ($_SESSION['logged']) {
      //Admin User
      if ($_SESSION['user']['is_admin'])
        $post_ids = $db_post->get_search_results($searchval, 3, $all_tags);
      //Registered User
      else
        $post_ids = $db_post->get_search_results($searchval, 2, $all_tags, $_SESSION['user']['person_id']);
    } else {
      //Foreigners Page
      $post_ids = $db_post->get_search_results($searchval, 1, $all_tags);
    }
    $posts_person = $db_post->convert_to_posts($post_ids);
  } else if ($file == "single_post.php") {
    if (isset($post_id) && !isset($_GET['delete']) && !empty($post_id))
      $posts_person = $db_post->convert_to_posts([$post_id]);

  }
  

  //printing available posts
  if (!empty($posts_person) ) {
    foreach ($posts_person as $post) {
      if ($_SESSION['logged']) {
        if($file=="single_post.php" )
        {
          $db_post->print_post($post,$file,$_SESSION['user']['person_id'],1);
          break;
        }
        $db_post->print_post($post, $file, $_SESSION['user']['person_id']);
      } else {
        $db_post->print_post($post, $file);
      }
    }
  } else {
    if ($file == "search_result.php") {
      echo "<div style='text-align:center'>
      <h1 class='nothing_here_yet headline'>ლಠ_ಠლ</h1>
      <p class='nothing_here_yet text'>Couldn't find anything</p></div>";
    } else if($file =="single_post.php")
    {
      echo "<div style='text-align:center'>
      <h1 class='nothing_here_yet headline'>ʕ•ᴥ•ʔ</h1>
      <p class='nothing_here_yet text'>I lost the post.. sorry.</p></div>";
    }
     
    else {
      echo "<div style='text-align:center'>
      <h1 class='nothing_here_yet headline'>¯\_(ツ)_/¯</h1>
      <p class='nothing_here_yet text'>There is nothing here yet!</p></div>";
    }
  }
  ?>
</div>
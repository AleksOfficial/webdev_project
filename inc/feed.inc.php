<div class='post_section'>
  <?php
  $db_post = new Db_posts();

  
  if ($file == "index.php") {
    if ($_SESSION['logged']) {
      //admin user
      if($_SESSION['user']['is_admin'])
      {
        $posts_person = $db_post->get_all_posts($_SESSION['user']['person_id']);
      }
      //registered user
      else
      {
        $db_user = new Db_user();
        $friends_ids = $db_user->get_friends($_SESSION['user']['person_id']);
        $post_ids = $db_post->get_post_ids_from_own_and_friends($_SESSION['user']['person_id'],$friends_ids);
        $posts_person = $db_post->convert_to_posts($post_ids);
      }
      
      
    } else {
      //public user
      $posts_person = $db_post->get_posts_public();
    }
  } else if($file == "profile.php") {
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
/*
  } else if ($file == "searchResultTest.php") {
    
    if ($_SESSION['logged']) {
      //admin user
      if($_SESSION['user']['is_admin'])
      {
        $posts_person = $db_post->get_all_posts($_SESSION['user']['person_id']);
      }
      //registered user
      else
      {
        $db_user = new Db_user();
        $friends_ids = $db_user->get_friends($_SESSION['user']['person_id']);
        $post_ids = $db_post->get_post_ids_from_own_and_friends($_SESSION['user']['person_id'],$friends_ids);
        $posts_person = $db_post->convert_to_posts($post_ids);
      }
      
      
    } else {
      //public user
      $posts_person = $db_post->get_posts_public();
      

    }
    $posts_person_save = $posts_person;
    $posts_person = $db_post->search_post($_SESSION['searchVal'],$posts_person_save);
    var_dump($posts_person);*/
  
  //printing available posts
  if (!empty($posts_person)) {
    foreach ($posts_person as $post) {
      if($_SESSION['logged'])
      {
        $db_post->print_post($post,$file,$_SESSION['user']['person_id']);
      }
      else{
        $db_post->print_post($post,$file);
      }
      
    }
  }
  else
  {
    if($file!="search_result.php")
    {
      echo "<div style='text-align:center'>
      <h1 class='nothing_here_yet headline'>¯\_(ツ)_/¯</h1>
      <p class='nothing_here_yet text'>There is nothing here yet!</p></div>";  
    }
    else
    echo "<div style='text-align:center'>
          <h1 class='nothing_here_yet headline'>ლಠ_ಠლ</h1>
          <p class='nothing_here_yet text'>Couldn't find anything</p></div>";
  }
  ?>
</div>
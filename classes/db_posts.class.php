<?php
class Db_posts extends Db_con
{

  function get_own_posts($user_id)
  {
    $con = $this->connect();
    $query = "SELECT * FROM post LEFT JOIN person ON person.person_id = post.person_id LEFT JOIN images ON post.image_id = images.image_id WHERE post.person_id = ? ORDER BY post.post_id DESC";
    $stmt = $con->prepare($query);
    $x = $stmt->execute([$user_id]);

    $results = $stmt->fetchAll();
    return $results;
  }
  function get_posts_from_id_friend($user_id)
  {
    $con = $this->connect();
    $query = "SELECT * FROM post LEFT JOIN person ON person.person_id = post.person_id LEFT JOIN images ON post.image_id = images.image_id WHERE post.person_id = ? AND (privacy_status=1 OR privacy_status = 2) ORDER BY post.post_id DESC";
    $stmt = $con->prepare($query);
    $x = $stmt->execute([$user_id]);

    $results = $stmt->fetchAll();
    return $results;
  }
  function get_post_ids_from_own_and_friends($user_id)
  {
    $con = $this->connect();
    $query = "SELECT post.post_id, post.person_id, post.privacy_status FROM post LEFT JOIN person ON person.person_id = post.person_id WHERE post.person_id = ? OR post.privacy_status = 1 OR post.privacy_status = 2";
    //$addition_query = " OR (post.person_id = ? AND (privacy_status=1 OR privacy_status = 2)) ";
    //Original plan was to extend the query string by the above line This won't work with huge a lot of friends. max char amount for a query is 65k chars

    //as described above, this won't work. perhaps it's better to just get all posts and check who's a friend and who isn't. 
    /*for($x = 0;$x < $times_to_add;$x++)
    {
      $query = $query. $addition_query;
    }
    var_dump($query);
    $stmt = $con->prepare($query);
    $input_array=array_merge([$user_id],$friends_array);
    $x = $stmt->execute($input_array);*/

    //var_dump($x);
    $stmt = $con->prepare($query);
    $x = $stmt->execute([$user_id]);
    //var_dump($x);
    $all_posts = array();
    $results = $stmt->fetchAll();
    $db_user = new Db_user();
    if (!empty($results)) {
      foreach ($results as $post_id) {

        if ($db_user->check_friends($user_id, $post_id['person_id']) || $user_id == $post_id['person_id'] || $post_id['privacy_status']==1)
          array_push($all_posts, $post_id['post_id']);
      }
      rsort($all_posts);
    }
    return $all_posts;
  }

  function convert_to_posts($array_ids)
  {
    $con = $this->connect();
    $query = "SELECT * FROM post LEFT JOIN person ON person.person_id = post.person_id LEFT JOIN images ON post.image_id = images.image_id WHERE post.post_id = ?";
    $stmt = $con->prepare($query);
    $posts = array();
    foreach ($array_ids as $id) {
      $stmt->execute([$id]);
      $post = $stmt->fetch();
      array_push($posts, $post);
    }
    return $posts;
  }

  function get_posts_from_id_user($user_id)
  {
    $con = $this->connect();
    $query = "SELECT * FROM post LEFT JOIN person ON person.person_id = post.person_id LEFT JOIN images ON post.image_id = images.image_id WHERE post.person_id = ? AND post.privacy_status = 1";
    $stmt = $con->prepare($query);
    $x = $stmt->execute([$user_id]);
    //var_dump($x);
    $results = $stmt->fetchAll();
    return $results;
  }
  function get_post_from_id($post_id)
  {
    $con = $this->connect();
    $query = "SELECT * FROM post LEFT JOIN person ON person.person_id = post.person_id LEFT JOIN images ON post.image_id = images.image_id WHERE post.post_id = ?";
    $stmt = $con->prepare($query);
    $x = $stmt->execute([$post_id]);
    if($x)
    {
      return $stmt->fetch();
    }
    else
    {
      $this->error($stmt->errorInfo());
      return false;
    }

  }
  

  function get_post_with_image($post_id)
  {
    $con = $this->connect();
    $query = "SELECT * FROM post LEFT JOIN images ON post.image_id = images.image_id WHERE post_id = ?";
    $stmt = $con->prepare($query);
    $stmt->execute([$post_id]);
    $x = $result = $stmt->fetch();
    if($x)
    {
      return $result;
    }
    else
    {
      $this->error($stmt->errorInfo());
    }
    
  }


  function get_tags_from_id($post_id)
  {
    $con = $this->connect();
    $query = "SELECT * FROM all_tags WHERE post_id = ?";
    $stmt = $con->prepare($query);
    $stmt->execute([$post_id]);
    return $stmt->fetchAll();
  }

  function get_posts_public()
  {
    $con = $this->connect();
    $query = "SELECT * FROM post LEFT JOIN person ON person.person_id = post.person_id LEFT JOIN images ON post.image_id = images.image_id WHERE privacy_status = 1 ORDER BY post_id DESC";
    $stmt = $con->prepare($query);
    $x = $stmt->execute();

    return $stmt->fetchAll();
  }
  function get_all_posts()
  {
    $con = $this->connect();
    $query = "SELECT * FROM post LEFT JOIN person ON person.person_id = post.person_id LEFT JOIN images ON post.image_id = images.image_id ORDER BY post_id DESC";
    $stmt = $con->prepare($query);
    $stmt->execute();

    return $stmt->fetchAll();
  }

  function get_reactions_from_id($post_id)
  {
    $con = $this->connect();
    $query = "SELECT COUNT(*) AS amount ,all_reactions.reaction_id  FROM all_reactions LEFT JOIN reaction_type ON all_reactions.reaction_id = reaction_type.reaction_id WHERE post_id = ? GROUP BY all_reactions.reaction_id ORDER BY amount DESC";
    $stmt = $con->prepare($query);
    $x = $stmt->execute([$post_id]);
    if (!$x) {
      $this->error($stmt->errorInfo()[2]);
      return NULL;
    }
    return $stmt->fetchAll();
  }
  function get_reaction_details($reaction_id)
  {
    $con = $this->connect();
    $query = "SELECT * FROM reaction_type WHERE reaction_id = ?";
    $stmt = $con->prepare($query);
    $x = $stmt->execute([$reaction_id]);
    if ($x) {
      return $stmt->fetch();
    } else {
      $this->error($stmt->errorInfo()[2]);
    }
  }
  function get_status_img_string($privacy_status, $dots)
  {
    //return "<li>hello_world!</li>";
    //return the right image
    switch ($privacy_status) {
      case 1:
        return "<li><a class='btn btn-info status-public small_'><img class ='status small_button' src='$dots/res/icons/public.png'></a></li>";
        break;
      case 2:
        return "<li><a class='btn btn-info status-friends small_'><img class ='status small_button' src='$dots/res/icons/friends.png'></a></li>";
        break;
      case 3:
        return "<li><a class='btn btn-info status-private small_'><img class ='status small_button' src='$dots/res/icons/private.png'></a></li>";
        break;
    }
  }

  function get_comments($post_id, $amount = 0)
  {

    $con = $this->connect();
    $query = "SELECT * FROM comments JOIN person ON comments.person_id = person.person_id JOIN images ON person.profile_pic = images.image_id WHERE post_id = ? ORDER BY comment_id DESC ";
    if ($amount != 0) {
      $query = $query . "LIMIT $amount";
    }
    $stmt = $con->prepare($query);
    $stmt->execute([$post_id]);
    $results = $stmt->fetchAll();
    return $results;
  }
  function own_post_check($post_with_person, $logged_id)
  {
    if ($logged_id == NULL) {
      return false;
    }
    if(!isset($post_with_person['person_id']))
    {
      return false;
    }
    $user_id = $post_with_person['person_id'];
    if ($logged_id == $user_id)
      return true;
    else
      return false;
  }

  function get_profilethumb_path($user_id)
  {
    $con = $this->connect();
    $query = "SELECT * FROM person LEFT JOIN images ON person.profile_pic = images.image_id WHERE person.person_id = ?";
    $stmt = $con->prepare($query);
    $stmt->execute([$user_id]);
    $result = $stmt->fetch();
    return $result['thumbnail_path'];
  }

  function count_comments_post($post_id)
  {
    $con = $this->connect();
    $query = "SELECT COUNT(*) AS amount FROM comments WHERE post_id = ?";
    $stmt = $con->prepare($query);
    $x = $stmt->execute([$post_id]);
    if ($x)
      return $stmt->fetch()['amount'];
    else
      $this->error($stmt->errorInfo()[2]);
  }

  function get_possible_reactions()
  {
    $con = $this->connect();
    $query = "SELECT * FROM reaction_type";
    $stmt = $con->prepare($query);
    $x = $stmt->execute();
    $reactions = $stmt->fetchAll();
    if (!$x) {
      $this->error($stmt->errorInfo()[2]);
      return false;
    }
    $result = array();
    $var = 1;
    foreach ($reactions as $_) {
      array_push($result, $var);
      $var++;
    }
    return $result;
  }
  function already_liked($user_id,$reaction_id,$post_id)
  {
    $con = $this->connect();
    $query = "SELECT * FROM all_reactions WHERE reaction_id = ? AND post_id = ? AND person_id = ?";
    $stmt = $con->prepare($query);
    $x = $stmt->execute([$reaction_id, $post_id ,$user_id]);
    if($x)
    {
      $result = $stmt->fetchAll();
      if(empty($result))
        return false;
      else
      return true;
    }
    else
      $this->error($stmt->errorInfo()[2]);
    return false;
    
  }
  function delete_post($post_id)
  {
    $con = $this->connect();
    $query = "DELETE FROM post WHERE post_id = ?";
    $stmt = $con->prepare($query);
    $x=$stmt->execute([$post_id]);
    if(!$x)
    {
      $this->error($stmt->errorInfo()[2]);
      return false;
    }
    else
    {
      return true;
    }
  }
  function remove_tags_from_id($post_id)
  {
    $con = $this->connect();
    $query = "DELETE FROM all_tags WHERE post_id = ?";
    $stmt = $con->prepare($query);
    $stmt->execute([$post_id]);

  }

  

  function get_search_results($string, $status, $all_tags = NULL, $user_id = 0)
  {
    $con = $this->connect();
      //Admin
      if ($status == 3)
      {
        if ($all_tags == NULL)
        {
          $query = "SELECT post.post_id FROM post LEFT JOIN comments ON post.post_id = comments.post_id LEFT JOIN images ON images.image_id = post.image_id WHERE post.post_text LIKE ? OR comments.comment_text LIKE ? OR images.image_name LIKE ?";
          $stmt = $con->prepare($query);
          $x = $stmt->execute(["%" . $string . "%", "%" . $string . "%", "%" . $string . "%"]);
          $all_result = array();
          if (!$x)
          {
            $this->error($stmt->errorInfo()[2]);
          } 
          else 
          {
            $result = $stmt->fetchAll();
          }
          foreach ($result as $element) 
          {
            array_push($all_result, $element['post_id']);
          }

          $all_result = array_unique($all_result, SORT_REGULAR);
          rsort($all_result);
          return $all_result;
        }
        else
        {
          $query = "SELECT * FROM post LEFT JOIN comments ON post.post_id = comments.post_id LEFT JOIN images ON images.image_id = post.image_id INNER JOIN all_tags ON all_tags.post_id = post.post_id WHERE post.post_text LIKE ? OR comments.comment_text LIKE ? OR images.image_name LIKE ?";
          $stmt = $con->prepare($query);
          $x = $stmt->execute(["%" . $string . "%", "%" . $string . "%", "%" . $string . "%"]);
          $all_result = array();
          if (!$x) {
            $this->error($stmt->errorInfo()[2]);

          }
          else
          {
            $result = $stmt->fetchAll();
          }
          foreach ($result as $element)
          {
            if (in_array($element['tag_id'], $all_tags))
            {
              array_push($all_result, $element['post_id']);
            }
          }

          $all_result = array_unique($all_result, SORT_REGULAR);
          rsort($all_result);
          return $all_result;
        }
      }
      //Registrierter User
      else if ($status == 2)
      {
        if ($all_tags == NULL)
        {
          //Query for own posts
          $query = "SELECT * FROM post LEFT JOIN comments ON post.post_id = comments.post_id LEFT JOIN images ON images.image_id = post.image_id WHERE (post.post_text LIKE ? OR comments.comment_text LIKE ? OR images.image_name LIKE ?) AND post.person_id = ?";
          $stmt = $con->prepare($query);
          $x = $stmt->execute(["%" . $string . "%", "%" . $string . "%", "%" . $string . "%", $user_id]);
          $all_result = array();
          if (!$x) {
            $this->error($stmt->errorInfo()[2]);
          } else {
            $result = $stmt->fetchAll();
          }
          foreach ($result as $element)
          {
            if (in_array($element['tag_id'], $all_tags))
            {
              array_push($all_result, $element['post_id']);
            }
          }
          //Query Friends
          $query = "SELECT * FROM post LEFT JOIN comments ON post.post_id = comments.post_id LEFT JOIN images ON images.image_id = post.image_id WHERE (post.post_text LIKE ? OR comments.comment_text LIKE ? OR images.image_name LIKE ?) AND (post.privacy_status = 2 OR post.privacy_status = 1) AND post.person_id <> ? ";
          $stmt = $con->prepare($query);
          $x = $stmt->execute(["%" . $string . "%", "%" . $string . "%", "%" . $string . "%", $user_id]);
          $all_result = array();
          $db_user = new Db_user();
          if (!$x)
          {
            $this->error($stmt->errorInfo()[2]);
          }
          else
          {
            $result = $stmt->fetchAll();
          }
          foreach ($result as $element)
          {
            if ($db_user->check_friends($user_id, $element['person_id']) || $element['privacy_status']==1)
            {
                array_push($all_result, $element['post_id']);
            }
          }
          $all_result = array_unique($all_result);
          rsort($all_result);
          return $all_result;
        }
       else
       {
        //Query for own posts
        $query = "SELECT * FROM post LEFT JOIN comments ON post.post_id = comments.post_id LEFT JOIN images ON images.image_id = post.image_id INNER JOIN all_tags ON all_tags.post_id = post.post_id WHERE (post.post_text LIKE ? OR comments.comment_text LIKE ? OR images.image_name LIKE ?) AND post.person_id = ?";
        $stmt = $con->prepare($query);
        $x = $stmt->execute(["%" . $string . "%", "%" . $string . "%", "%" . $string . "%", $user_id]);
        $all_result = array();
        if (!$x)
        {
          $this->error($stmt->errorInfo()[2]);
        } else
        {
          $result = $stmt->fetchAll();
        }
        foreach ($result as $element)
        {
          if (in_array($element['tag_id'], $all_tags))
          {
            array_push($all_result, $element['post_id']);
          }
        }
        //Query Friends
        $query = "SELECT * FROM post LEFT JOIN comments ON post.post_id = comments.post_id LEFT JOIN images ON images.image_id = post.image_id INNER JOIN all_tags ON all_tags.post_id = post.post_id WHERE (post.post_text LIKE ? OR comments.comment_text LIKE ? OR images.image_name LIKE ?) AND post.privacy_status = 2 AND post.person_id <> ? ";
        $stmt = $con->prepare($query);
        $x = $stmt->execute(["%" . $string . "%", "%" . $string . "%", "%" . $string . "%", $user_id]);
        $all_result = array();
        $db_user = new Db_user();
        if (!$x)
        {
          $this->error($stmt->errorInfo()[2]);
        } else
        {
          $result = $stmt->fetchAll();
        }
        foreach ($result as $element) {
          if ($db_user->check_friends($user_id, $element['person_id']) ||$element['privacy_status'] == 1) {
            if (in_array($element['tag_id'], $all_tags)) {
              array_push($all_result, $element['post_id']);
            }
          }
        }
        $all_result = array_unique($all_result);
        rsort($all_result);
        return $all_result;
      }
    }
    
    //Foreign User
    else {
      if ($all_tags == NULL) {
        $query = "SELECT post.post_id FROM post LEFT JOIN comments ON post.post_id = comments.post_id LEFT JOIN images ON post.image_id = images.image_id WHERE (post.post_text LIKE ? OR comments.comment_text LIKE ? OR images.image_name LIKE ?) AND post.privacy_status = 1";
        $stmt = $con->prepare($query);
        $x = $stmt->execute(["%" . $string . "%", "%" . $string . "%", "%" . $string . "%"]);
        $all_result = array();
        if (!$x) {
          $this->error($stmt->errorInfo()[2]);
        } else {
          $result = $stmt->fetchAll();
        }
        foreach ($result as $element) {
          array_push($all_result, $element['post_id']);
        }
        $all_result = array_unique($all_result, SORT_REGULAR);
        rsort($all_result);
        return $all_result;
      } else {
        $query = "SELECT * FROM post LEFT JOIN comments ON post.post_id = comments.post_id LEFT JOIN images ON post.image_id = images.image_id INNER JOIN all_tags ON post.post_id = all_tags.post_id WHERE (post.post_text LIKE ? OR comments.comment_text LIKE ? OR images.image_name LIKE ?) AND post.privacy_status = 1";
        $stmt = $con->prepare($query);
        $x = $stmt->execute(["%" . $string . "%", "%" . $string . "%", "%" . $string . "%"]);
        $all_result = array();
        if (!$x) {
          $this->error($stmt->errorInfo()[2]);
        } else {
          $result = $stmt->fetchAll();
        }
        foreach ($result as $element) {
          if (in_array($element['tag_id'], $all_tags))
            array_push($all_result, $element['post_id']);
        }
        $all_result = array_unique($all_result, SORT_REGULAR);
        rsort($all_result);
        return $all_result;
      }
    }
  }


  function print_post($post_with_person, $file, $logged_id = NULL,$var = 0)
  {
    $post_id = $post_with_person['post_id'];
    $username = $post_with_person['username'];
    $timestring = $this->get_timestring($post_with_person['created_on']);
    $db_user = new Db_user();
    $edit_button = "";
    $delete_button = "";
    $url = $_SERVER['REQUEST_URI'];

    $profile_pic_thumbnail = $this->get_profilethumb_path($post_with_person['person_id']);
    $filename = $post_with_person['image_name'];
    $user_id = $post_with_person['person_id'];
    if ($file == "index.php")
      $dots = ".";
    else
      $dots = "..";
    $content = $post_with_person['post_text'];
    $tags = $this->get_hashtags($content, 0);
    foreach ($tags as $tag) {
      $content = $this->convert_text_to_hashtag($content, $tag, $dots);
    }

    $status_image = $this->get_status_img_string($post_with_person['privacy_status'], $dots); //should echo out an img tag and an a tag around it so you can change it if necessary. changes possible only in single_post view. as a dropdown perhaps idk..
    
    if ($this->own_post_check($post_with_person, $logged_id)) {
      $edit_button = "<li><a class='btn btn-warning small_'href='$dots/sites/single_post.php?post=$post_id&edit=$post_id'><img class='small_button edit_button' src ='$dots/res/icons/edit.png' alt='edit'></a></li>";
      $delete_button = "<li><a class='btn btn-danger small_' href='$dots/sites/single_post.php?post=$post_id&delete=$post_id'><img class='small_button delete_button' src ='$dots/res/icons/delete.png' alt='delete'></a></li>";
    }
    if($logged_id)
    {
      $user = $db_user->get_user_by_id($logged_id);
      if($user['is_admin'])
      {
        $edit_button = "<li><a class='btn btn-warning small_'href='$dots/sites/single_post.php?post=$post_id&edit=$post_id'><img class='small_button edit_button' src ='$dots/res/icons/edit.png' alt='edit'></a></li>";
        $delete_button = "<li><a class='btn btn-danger small_' href='$dots/sites/single_post.php?post=$post_id&delete=$post_id'><img class='small_button delete_button' src ='$dots/res/icons/delete.png' alt='delete'></a></li>";
      }
    }
      
    $singlepost = $dots . "/sites/single_post.php?post=$post_id";


    echo "       
    <div class='post'>
      <div class='card bg-dark text-white mb-3 post_topbar'>
        <div class='row user_image'>
          <div class='col-md-2 pic_container'>  
            <img src='$dots/$profile_pic_thumbnail' class='profile_pic small_profile_pic' alt='$filename'>
          </div>
          <div class='col-md-6 user_name'>
            <div class='card-body'>
              <div class='card-text'>
                <a class='username_post' href='$dots/sites/profile.php?user=$user_id'><h5 class='username'>$username</h5></a>
              </div>
              <div class='card-text'>
                <small><i>$timestring</i></small>
              </div>
            </div>
          </div>
          <div class='col-md-4 status_image'>
            <ul>
              $status_image
              $edit_button
              $delete_button    
            </ul>
          </div>
        </div>
      
      <div class='row main_input'>
        <div class='post_text'>
        <p>$content</p> <a href='$singlepost'>View full post</a></div>";
    if ($post_with_person['image_id'] != NULL) {
      $post_image = $this->get_post_with_image($post_id);
      if($file == "single_post.php")
      {
        $image_path = $post_image['file_path'];
        $styling = "style='width:100%'";
      }
      else
      {
        $image_path = $post_image['thumbnail_path'];
        $styling="";
      }
        

      $image_name = $post_image['image_name'];
      echo "
          <div class='post_image'>
            <a href='$singlepost'><img class='rounded mx-auto d-block' src='$dots/$image_path' alt='$image_name'$styling></a>
          </div>";
    }
    echo "
      </div>
      <div class='row reaction_section'>
        <div class='col-7'>
          <div class='row'>
        ";
    $reactions = $this->get_possible_reactions();
    $amount_reactions = $this->get_reactions_from_id($post_id);

    foreach ($amount_reactions as $reaction) { //Here comes a function which prints out the possible reactions. right now there are only 2 or so. could add more actually. is added


      $reaction_id = $reaction['reaction_id'];
      $amount = $reaction['amount'];
      $reaction = $this->get_reaction_details($reaction_id);
      $reactions[$reaction_id - 1] = 0;
      $emoji_path = $reaction['emoji_path'];
      if($this->already_liked($user_id,$reaction_id,$post_id) || $logged_id == NULL)
        $disabled = " isDisabled";
      else
        $disabled = "";
      

      echo "<div class='col'>
            <a class='btn btn-warning$disabled' href='$dots/sites/single_post.php?post=$post_id&reaction=$reaction_id'><img class='smaller_profile_icon'src='$dots/$emoji_path'> </a><span class='text-white' style='margin-left:5px;'>($amount)
            </div>";
    }
    foreach ($reactions as $reaction) {
      if ($reaction > 0) {
        $reaction = $this->get_reaction_details($reaction);
        $reaction_id = $reaction['reaction_id'];
        $emoji_path = $reaction['emoji_path'];
        $disabled = "";
        if(!$logged_id)
        {
          $disabled = " isDisabled";
        }
        echo "<div class='col'>
            <a class='btn btn-warning$disabled' href='$dots/sites/single_post.php?post=$post_id&reaction=$reaction_id'><img class='smaller_profile_icon'src='$dots/$emoji_path'></a></div>";
      }
    }

    echo "
        </div>
        </div>
        </div>
        <div class='row comment-section'>";

    //count the comments
    $count_comments = $this->count_comments_post($post_id);
    if (($count_comments-3) > 0 && $var!=1) {
      $count_comments -= 3;
      echo "<a href='$singlepost' class='view_more_comments'>view more comments ($count_comments)</a>";
      $count_comments += 3;
    }
    if ($var!=0) {
      $var = $count_comments;
      $last_comments = $this->get_comments($post_id);
    }
    else if ($file != "single_post.php") {
      $var = 3;
      $last_comments = $this->get_comments($post_id, $var);
    }
    


    if (!empty($last_comments)) {


      echo "<ul>";
      for ($x = 0; $x < $var; $x++) {
        $element = $var - $x-1;
        if (isset($last_comments[$element])) {
          $comment = $last_comments[$element];
          $comment_thumbnail = $comment['thumbnail_path'];
          $comment_filename = $comment['image_name'];
          $comment_timestring = $this->get_timestring($comment['created_on']);
          $comment_username = $comment['username'];
          $comment_content = $comment['comment_text'];

          echo "
                <div class='card bg-dark text-white comment'>
                <div class='row user_image'>
                <div class='col-md-2 pic_container'> 
                  <img src='$dots/$comment_thumbnail' class='smaller_profile_pic' alt = '$comment_filename'>
                  </div>
                  <div class='col-md-10 user_name'>
                  <div class='card-body'>
                  <p class='comment_name'>$comment_username</p>
                  <small class='text-muted'><span>$comment_timestring</span></small>
                  <p class='comment_content'>$comment_content</p>
                  </div>
                </div>
              </div>
            </div>";
        }
      }
      echo "</ul>";
    }

   



    if ($_SESSION['logged']) {
      $comment_thumbnail =$user['thumbnail_path'];
      $comment_filename = $user['image_name'];

      echo "
      <div class='row comment_on_things'>
      <div class='card bg-dark text-white comment'>
          <div class='row user_image'>
            <div class='col-2 pic_container'>
              <img class='profile_pic smaller_profile_pic' src='$dots/$comment_thumbnail' alt='$comment_filename'>
            </div>
          <div class='col-10 user_name'>
                <form action='$dots/sites/single_post.php' method='POST'>
                <div class='input-group'>  
                <textarea class='form-control' placeholder='Post a comment' name='comment_text'></textarea>
                  <input type='hidden' name='post_id' value='$post_id'>
                  <button type='submit' class='btn  btn-warning send_btn' name='comment_submit'><img src='$dots/res/icons/send.png' ></button></div>
                </form>
          </div>
          </div>
    </div>
    </div>
          ";
    }
    echo "          
      </div>
    </div>
    </div>";
  }
}

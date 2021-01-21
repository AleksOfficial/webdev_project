<?php
class Db_posts extends Db_con{

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
    $query = "SELECT post.post_id, post.person_id FROM post LEFT JOIN person ON person.person_id = post.person_id WHERE post.person_id = ? OR post.privacy_status = 1 OR post.privacy_status = 2";
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
    if(!empty($results))
    {
      foreach($results as $post_id)
      {
        
        if($db_user->check_friends($user_id,$post_id['person_id']) || $user_id == $post_id['person_id'])
          array_push($all_posts,$post_id['post_id']);
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
    foreach($array_ids as $id)
    {
      $stmt->execute([$id]);
      $post = $stmt->fetch();
      array_push($posts,$post);
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

  function get_post_with_image($post_id)
  {
    $con = $this->connect();
    $query = "SELECT * FROM post LEFT JOIN images ON post.image_id = images.image_id WHERE post_id = ?";
    $stmt = $con->prepare($query);
    $stmt->execute([$post_id]);
    $result = $stmt->fetch();
    return $result;

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
    if(!$x)
    {
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
    $x=$stmt->execute([$reaction_id]);
    if($x)
    {
      return $stmt->fetch();
    }
    else
    {
      $this->error($stmt->errorInfo()[2]);
    }
  }
  function get_status_img_string($privacy_status,$dots)
  {
    //return "<li>hello_world!</li>";
    //return the right image
    switch($privacy_status)
    {
      case 1:
        return "<li><a class='btn btn-info status-public small_'><img class ='status small_button' src='$dots/res/icons/public.png'></a></li>";
        break;
      case 2:
        return "<li><a class='btn btn-info status-friends small_'><img class ='status small_button' src='$dots/res/icons/friends.png'></a></li>";
        break;
      case 3:
        return "<li><a class='btn btn-info status-private small_'><img class ='status button' src='$dots/res/icons/private.png'></a></li>";
        break;
    }
  }

  function get_3_comments($post_id)
  {
    $con = $this->connect();
    $query = "SELECT * FROM comments JOIN person ON comments.person_id = person.person_id JOIN images ON person.profile_pic = images.image_id WHERE post_id = ? ORDER BY comment_id DESC LIMIT 3";
    $stmt = $con->prepare($query);
    $stmt->execute([$post_id]);
    $results = $stmt->fetchAll();
    return $results;
  }
  function own_post_check ($post_with_person,$logged_id)
  {
    if($logged_id==NULL)
    {
      return false;
    }
    $user_id=$post_with_person['person_id'];
    if($logged_id == $user_id)
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
  function print_tag($tag,$dots)
  {
    $text = $tag['tag_text'];
    echo "
    <li><a href=$dots/sites/searchResult.php?tag=$text>$text</a></li>";
  }
  function count_comments_post($post_id)
  {
    $con = $this->connect();
    $query = "SELECT COUNT(*) AS amount FROM comments WHERE post_id = ?";
    $stmt =$con->prepare($query);
    $x=$stmt->execute([$post_id]);
    if($x)
      return $stmt->fetch()['amount'];
    else
      $this->error($stmt->errorInfo()[2]);

  }
  
  function get_possible_reactions()
  {
    $con = $this->connect();
    $query = "SELECT * FROM reaction_type";
    $stmt =$con->prepare($query);
    $x = $stmt->execute();
    $reactions = $stmt->fetchAll();
    if(!$x)
    {
      $this->error($stmt->errorInfo()[2]);
      return false;
    } 
    $result = array();
    $var = 1;
    foreach($reactions as $_)
    {
      array_push($result,$var);
      $var++;
    }
    return $result;
    
  }

  function print_post($post_with_person,$file,$logged_id=NULL)
  {
    //1var_dump($post_with_person);
    $post_id = $post_with_person['post_id'];
    $username = $post_with_person['username'];
    $timestring = $this->get_timestring($post_with_person['created_on']);
    $content = $post_with_person['post_text'];
    $edit_button = "";
    $delete_button = "";
    $all_tags = $this->get_tags_from_id($post_with_person['post_id']);
    $url = $_SERVER['REQUEST_URI'];
    $var = 0;
    $profile_pic_thumbnail = $this->get_profilethumb_path($post_with_person['person_id']);
    $filename = $post_with_person['image_name'];
    $user_id = $post_with_person['person_id'];
    if($file == "index.php")
      $dots = ".";
    else
      $dots = "..";
    $status_image = $this->get_status_img_string($post_with_person['privacy_status'],$dots); //should echo out an img tag and an a tag around it so you can change it if necessary. changes possible only in single_post view. as a dropdown perhaps idk..
    if($this->own_post_check($post_with_person,$logged_id))
    {
      $edit_button = "<li><a class='btn btn-warning small_'href='$dots/sites/single_post.php?edit=$post_id'><img class='small_button edit_button' src ='$dots/res/icons/edit.png' alt='edit'></a></li>";
      $delete_button = "<li><a class='btn btn-danger small_' href='$dots/sites/single_post.php?delete=$post_id'><img class='small_button delete_button' src ='$dots/res/icons/delete.png' alt='delete'></a></li>";
    }
    
    $singlepost = $dots."/sites/single_post.php?post=$post_id";


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
        if($post_with_person['image_id']!=NULL)
        {
          $post_image = $this->get_post_with_image($post_id);
          $image_path = $post_image['thumbnail_path'];
          $image_name = $post_image['image_name'];
          echo"
          <div class='post_image'>
            <a href='$singlepost'><img class='rounded mx-auto d-block' src='$dots/$image_path' alt='$image_name'></a>
          </div>";
        }
          echo"
      </div>
      <div class='row reaction_section'>
        <div class='col-6'>
          <div class='row'>
        ";/*
        $all_reactions = $this->get_possible_reactions();
        $amount_reactions = $this->get_reactions_from_id($post_with_person['post_id']);*/
        $reactions = $this->get_possible_reactions();
        $amount_reactions = $this->get_reactions_from_id($post_id);

        foreach($amount_reactions as $reaction)
        {//Here comes a function which prints out the possible reactions. right now there are only 2 or so. could add more actually. is added
          
            
            $reaction_id = $reaction['reaction_id'];
            $amount = $reaction['amount'];
            $reaction = $this->get_reaction_details($reaction_id);
            $reactions[$reaction_id-1]=0;
            $emoji_path = $reaction['emoji_path'];
            echo "<div class='col'>
            <a class='btn btn-warning' href='$url'><img class='smaller_profile_icon'src='$dots/$emoji_path'> </a><span class='text-white' style='margin-left:5px;'>($amount)
            </div>";
            
            
            //<img src='images/liked-img.png' alt='likes'>
            //<span>amount of specific reaction</span>
            //</li>
        }
        foreach($reactions as $reaction)
        {
          if($reaction>0)
          {
            $reaction = $this->get_reaction_details($reaction);
            $emoji_path = $reaction['emoji_path'];
            echo "<div class='col'>
            <a class='btn btn-warning' href='$url'><img class='smaller_profile_icon'src='$dots/$emoji_path'></a></div>";
          }

        }
         
        echo "
        </div>
        </div>
        </div>
        <div class='row comment-section'>";
          if($file !="single_post.php")
          $last_comments= $this->get_3_comments($post_id);
          $count_comments=$this->count_comments_post($post_id);
          $count_comments-=3;
          if(!empty($last_comments))
          {
            if($count_comments>0)
            {
              echo "<a href='$singlepost' class='view_more_comments'>view more comments ($count_comments)</a>";
            }
            
            echo "<ul>";
            for($x = 0; $x<3;$x++)
            {
              $element = 2-$x;
              if(isset($last_comments[$element]))
              {
                $comment = $last_comments[$element];
                $comment_thumbnail = $comment['thumbnail_path'];
                $comment_filename = $comment['image_name'];
                $comment_timestring = $this->get_timestring($comment['created_on']);
                $comment_username = $comment['username'];
                $comment_content = $comment['comment_text'];

                echo "
                <div class='card bg-dark text-white mb-3 comment'>
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
          /*
          <li>
          function to echo last 2 or 3 comments
          <div class='comment'>
          <img>
          <p class='comment_name>

          </div>

          </li>*/
        $site = $_SERVER['PHP_SELF'];
        //$site = $site."?user=$user_id";

        if($_SESSION['logged'])
        {
          echo"
          <div class='comment_img'>
          <img class='smaller_profile_pic' src='$dots/$profile_pic_thumbnail' alt='$filename'>
        </div>
          <div class='comment_box'>
            <form action='$site' method='POST'>
              <input type='text' placeholder='Post a comment' name='comment_text'>
              <input type='hidden' name='post_id' value='$post_id'>
              <button type='submit' name='comment_submit'>Send</button>
            </form>
          </div>
          ";
 
        }
        echo"          
      </div>
    </div>
    </div>";

  }
  function search_post($search, $postArray){
    /*tmt = $con->prepare($query);
    $stmt->execute(["%".$search."%"]);
    $result = $stmt->fetchAll();    
    //$result = array_unique($result);
    //asort($result);
    //var_dump($result);
    return $result; */
    $cycle = 0;
    $result = array();
    foreach($postArray as $post) {
      if(in_array($search, $post[$cycle]['post_text']) == true) {
        array_push($result, $post[$cycle]);
      }
      $cycle++;
    }
    return $result;
  }
}
<?php
class Db_posts extends Db_con{
  function get_own_posts($user_id)
  {
    $con = $this->connect();
    $query = "SELECT * FROM post JOIN person ON post.person_id=person.person_id JOIN images ON person.profile_pic = images.image_id WHERE person.person_id = ?";
    $stmt = $con->prepare($query);
    $x = $stmt->execute([$user_id]);
    $results = $stmt->fetchAll();
    return $results;
  }

  function get_posts_from_id_friend($user_id)
  {
    $con = $this->connect();
    $query = "SELECT * FROM post JOIN person ON person.person_id = post.person_id JOIN images ON person.profile_pic = images.image_id  WHERE post.person_id = ? AND (privacy_status=1 OR privacy_status = 2)";
    $stmt = $con->prepare($query);
    $x = $stmt->execute([$user_id]);
    var_dump($x);
    $results = $stmt->fetchAll();
    return $results;
  }
  function get_post_ids_from_own_and_friends($user_id)
  {
    $con = $this->connect();
    $query = "SELECT post.post_id, post.person_id FROM post JOIN person ON person.person_id = post.person_id JOIN images ON person.profile_pic = images.image_id  WHERE post.person_id = ? OR post.privacy_status = 1 OR post.privacy_status = 2";
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

  function get_posts_from_id_user($user_id)
  {
    $con = $this->connect();
    $query = "SELECT * FROM post JOIN person ON person.person_id = post.person_id JOIN images ON person.profile_pic = images.image_id  WHERE post.person_id = ?";
    $stmt = $con->prepare($query);
    $x = $stmt->execute([$user_id]);
    var_dump($x);
    $results = $stmt->fetchAll();
    return $results;
  }

  function convert_to_posts($array_ids)
  {
    $con = $this->connect();
    $query = "SELECT * FROM post JOIN person ON person.person_id = post.person_id JOIN images on person.profile_pic = images.image_id WHERE post.post_id = ?";
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
    $query = "SELECT * FROM post JOIN person ON person.person_id = post.person_id JOIN images ON person.profile_pic = images.image_id WHERE privacy_status = 1 ORDER BY post_id DESC";
    $stmt = $con->prepare($query);
    $x = $stmt->execute();
    
    return $stmt->fetchAll();
  }
  function get_all_posts()
  {
    $con = $this->connect();
    $query = "SELECT * FROM post JOIN person ON person.person_id = post.person_id JOIN images ON person.profile_pic = images.image_id ORDER BY post_id DESC";
    $stmt = $con->prepare($query);
    $stmt->execute();
    
    return $stmt->fetchAll();
  }
  function print_post($post_with_person)
  {
    var_dump($post_with_person);
    ?>
    
    <div class="post-bar">
      <div class="post_topbar">
        <div class="usy-dt">
          <img src="$thumbnail_path" alt="$filename">
          <div class="usy-name">
            <a href="profile.php?user=$user_id"><p class="username">$username</p>
            <span>$timestring</span>
          </div>
        </div>
        <div class="ed-opts">
          <a href="#" title="" class="ed-opts-open"><i class="la la-ellipsis-v"></i></a>
          <div class="post_options">
            <a href="$file?delete=$post_id" title=""><img src="$dots/res/icons/delete.png"></a>
            $status_image;
            
          </div>
        </div>
      </div>
      <div class="main_input">
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam luctus hendrerit metus, ut ullamcorper quam
          finibus at. Etiam id magna sit amet </p> collapse if too many chars. <a href="$singlepost">View full post </a>
        <ul class="tags">
          function to echo tags with as li a img elements as 
          <li><a href="#" title="">example</a></li>
        </ul>
      </div>
      <div class="job-status-bar">
        <ul class="like-com">
          <li>
            <a href="#"><img src="$dots/res/icons/Like_smaller.png"></a>
            <img src="images/liked-img.png" alt="likes">
            <span>$amount_likes</span>
          </li>
          <li>
            <a href="#"><img src="$dots/res/icons/dislike_smaller.png"></a>
            <img src="images/liked-img.png" alt="likes">
            <span>$amount_likes</span>
          </li>
          <li><a href="$singlepost" class="com">view more comments</a></li>
          function to echo last 2 or 3 comments
        </ul>
      </div>
    </div>
    <?php


  }

}
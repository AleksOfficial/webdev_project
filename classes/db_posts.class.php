<?php
class Db_posts extends Db_con{
  function get_own_posts($user_id)
  {
    $con = $this->connect();
    $query = "SELECT * FROM post WHERE person_id = ?";
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

  function get_posts_from_id_user($user_id)
  {
    $con = $this->connect();
    $query = "SELECT * FROM post JOIN person ON person.person_id = post.person_id JOIN images ON person.profile_pic = images.image_id  WHERE post.person_id = ? AND privacy_status=1";
    $stmt = $con->prepare($query);
    $x = $stmt->execute([$user_id]);
    var_dump($x);
    $results = $stmt->fetchAll();
    return $results;
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
    $x = $stmt->execute();
    
    return $stmt->fetchAll();
  }
  function print_post($post_with_person)
  {
    var_dump($post_with_person);


  }

}
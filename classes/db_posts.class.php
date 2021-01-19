<?php
class Db_post extends Db_con{
  function get_posts_from_id($user_id)
  {
    $con = $this->connect();
    $query = "SELECT * FROM posts WHERE from_id = ?";
    $stmt = $con->prepare($query);
    $stmt->execute([$user_id]);
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

  function print_post($post)
  {
    echo "hello_world!";
  }

  function print_tag($tag)
  {
    echo "Hello_world!";
  }
}
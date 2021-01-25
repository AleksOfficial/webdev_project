<?php
class Db_create_stuff extends Db_con
{
  function create_post($post)
  {
    var_dump($post);
    $con = $this->connect();
    $query_img = "INSERT INTO post(person_id,created_on,privacy_status,post_text,image_id) VALUES(?,CURRENT_TIMESTAMP,?,?,?)";
    $query_normal = "INSERT INTO post(person_id,created_on,privacy_status,image_id,post_text) VALUES(?,CURRENT_TIMESTAMP,?,NULL,?)";
    if(isset($post[3]))
    {
      $stmt=$con->prepare($query_img);
    }
    else{
      $stmt=$con->prepare($query_normal);
    }
    $x = $stmt->execute($post);
    if(!$x)
    {
      $this->error($stmt->errorInfo());
    }
    else{
      return $con->lastInsertId();
    }
  }

  function create_image($image)
  {
    var_dump($image);
    $con = $this->connect();
    $query_img = "INSERT INTO images(image_name,file_path,thumbnail_path) VALUES(?,?,?)";
    $stmt = $con->prepare($query_img);
    $x = $stmt->execute($image);
    var_dump($stmt->errorInfo());
    var_dump($x);
    if($x)
    {
      $query = "SELECT image_id FROM images WHERE file_path = ?";
      $stmt = $con->prepare($query);
      $stmt->execute([$image[1]]);
      $result = $stmt->fetch();
      return $result['image_id'];
    }
    else
    {
      $this->error("Error: something went wrong during image upload!");
      return -1;
    }
  }
  function create_comment($comment)
  {
    $con = $this->connect();
    $query = "INSERT INTO comments(comment_text,created_on,post_id,person_id) VALUES(?,CURRENT_TIMESTAMP,?,?)";
    $stmt = $con->prepare($query);
    $x = $stmt->execute($comment);
    if(!$x)
    $this->error($stmt->errorInfo()[2]);
  }
  function tags_to_ids($tagarray)
   {
     $con = $this->connect();
     $all_elements = array();
     foreach($tagarray as $tag)
     {
        $query = "SELECT* FROM tag WHERE tag_text LIKE ?";
        $stmt = $con->prepare($query);
        $stmt->execute([$tag]);
        $result = $stmt->fetch();
        if(!empty($result))
        {
          array_push($all_elements,$result['tag_id']);
        }
     }
     return $all_elements;
   }
  function add_tags ($tags,$post_id)
  {
    $con = $this->connect();
    $id_array = array();
    foreach($tags as $tag)
    {
      $query = "SELECT * FROM tag WHERE tag_text LIKE ?";
      $stmt = $con->prepare($query);
      $x = $stmt->execute([$tag]);
      if(!$x)
      {
        $this->error($stmt->errorInfo()[2]);
        return false;
      }
      $result = $stmt->fetchAll();
      if(empty($result))
      {
        $insert_query = "INSERT INTO tag(tag_text) VALUES(?)";
        $stmt = $con->prepare($insert_query);
        $x = $stmt->execute([$tag]);
        if(!$x)
        {
          $this->error($stmt->errorInfo()[2]);
          return false;
        }
        else
        {
          $inserted_id = $con->lastInsertId();
          array_push($id_array,$inserted_id);
        }
      }
      else
      {
        $found_id = $result[0]['tag_id'];
        array_push($id_array,$found_id);
      }
    }
    foreach($id_array as $id)
    {
      $tag_query ="INSERT INTO all_tags(tag_id,post_id) VALUES(?,?)";
      $stmt = $con->prepare($tag_query);
      $x = $stmt->execute([$id,$post_id]);
      if(!$x)
      {
        $this->error($stmt->errorInfo());
        return false;
      }
    }
  }
  function add_reaction($reaction_id,$post_id,$person_id)
  {
    $con = $this->connect();
    $query = "INSERT INTO all_reactions(reaction_id,post_id,person_id,created_on) VALUES(?,?,?,CURRENT_TIMESTAMP)";
    $stmt = $con->prepare($query);
    $x = $stmt->execute([$reaction_id,$post_id,$person_id]);
    if(!$x)
    {
      $this->error($stmt->errorInfo()[2]);
      return false;
    }
    return true;

  }
  function update_post($post)
  {
    $con = $this->connect();
    $query = "UPDATE  post SET created_on=CURRENT_TIMESTAMP ,privacy_status=?,post_text =? WHERE post_id = ?";
    $stmt = $con->prepare($query);
    $x = $stmt->execute([$post['privacy_status'],$post['post_text'],$post['post_id']]);
    if($x)
    {
      return true;
    } 
    else
    {
      $this->error($stmt->errorInfo()[2]);
      return false;
    }
  }
  function add_friend($from_id,$to_id)
  {
    $con = $this->connect();
    $query = "INSERT INTO friends(status_request,from_id,to_id,viewed) VALUES(0,?,?,0)";
    $stmt = $con->prepare($query);
    $x = $stmt->execute([$from_id,$to_id]);
    if($x)
    {
      $this->success("Friend added! Wait for the Request to be accepted");
    }
    else
    {
      $this->error($stmt->errorInfo());
    }
    
  }

  function change_viewed($from_id,$to_id) {
    $con = $this->connect();
    $query = "UPDATE all_notifications SET viewed = 1 WHERE from_id = ? AND to_id = ?;";
    $stmt = $con->prepare($query);
    $x = $stmt->execute([$from_id,$to_id]);
  }

  function change_all_viewed($to_id) {
    $con = $this->connect();
    $query = "UPDATE all_notifications SET viewed = 1 WHERE to_id = ?;";
    $stmt = $con->prepare($query);
    $x = $stmt->execute([$to_id]);
  }

  function check_viewed($from_id,$to_id) {
    $result = array();
    $con = $this->connect();
    $query = "SELECT status_request FROM friends WHERE from_id = ? and to_id = ?;";
    $stmt = $con->prepare($query);
    $stmt->execute([$from_id,$to_id]);
    $result = $stmt->fetchAll();
    //var_dump($result);
    if ($result[0]['status_request'] == 0) {
      return 0;
    } else {
      return 1;
    }
  }

  function accept_friend($from_id,$to_id)
  {
    $con = $this->connect();
    $query = "UPDATE friends SET status_request = 1, viewed = 1 WHERE from_id = ? AND to_id = ? ;";
    $stmt = $con->prepare($query);
    $x = $stmt->execute([$from_id,$to_id]);
    if($x)
    {
      $this->success("Friend accepted! Now you can see his friend posts and chat with him.");
    }
    else
    {
      $this->error($stmt->errorInfo());
    }
  }
  function remove_friend($from_id,$to_id)
  {
    $con = $this->connect();
    $query = "DELETE FROM friends WHERE (from_id = ? AND to_id =?) OR (from_id = ? AND to_id = ?)";
    $stmt = $con->prepare($query);
    $x = $stmt->execute([$from_id,$to_id,$to_id,$from_id]);
    if($x)
    {
      $this->success("Friend removed!");
    }
    else
    {
      $this->error($stmt->errorInfo());
    }
  }

  function remove_friendrequest_notification($from_id,$to_id) {
    $con = $this->connect();
    $query = "DELETE FROM all_notifications WHERE (from_id = ? AND to_id =?) OR (from_id = ? AND to_id = ?) AND notification_id = 2";
    $stmt = $con->prepare($query);
    $result = $stmt->execute([$from_id,$to_id,$to_id,$from_id]);
  }

}
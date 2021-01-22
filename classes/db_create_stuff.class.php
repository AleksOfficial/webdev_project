<?php
class Db_create_stuff extends Db_con{
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
      var_dump($stmt->errorInfo());}
    var_dump($x);
    
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
    var_dump($comment);
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
  function create_tag ($tags,$id)
  {
    
  }


}
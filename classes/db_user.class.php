<?php

class Db_user extends Db_con
{

  public function prepare_input_registration($array)
  {
    $return_array = array();
    $invalid_inputs = array();
    $missing_inputs = array();
    $invalid = false;
    $missing = false;
    $check_array = array("gender", "first_name", "last_name", "password", "username", "email");
    foreach ($check_array as $x) {
      if (isset($array["$x"])) {
        if ($array["$x"] != "" && !preg_match('/[\'^£$%&*()}{#$~?>!<>,|=_+¬-]/', $array["$x"])) {
          if ($x === "password") {
            $pw = password_hash($array["$x"], PASSWORD_DEFAULT);
            array_push($return_array, $pw);
          } else {
            array_push($return_array, strtolower($array["$x"]));
          }
        } else {
          $invalid = true;
          array_push($invalid_inputs, $array["$x"]);
        }
      } else {
        $missing = true;
        array_push($missing_inputs, $x);
      }
    }
    if ($missing) {
      $this->error("Error: The following inputs are missing: ", $missing_inputs);
      return NULL;
    } else if ($invalid) {
      $this->error("Error: The following inputs have invalid Characters in them: ", $invalid_inputs);
      return NULL;
    } else {
      return $return_array;
    }
  }

  function register_user($user) //comes in as an array
  {
    $user = $this->prepare_input_registration($user);
    if ($user == NULL)
      return;
    else {
      $query = "INSERT INTO person(profile_pic,gender,first_name,last_name,password_hash,username,email,last_login,active,is_admin) VALUES(1, ?, ?, ?, ?, ?, ?, CURRENT_TIMESTAMP, 1,0)";
      $con = $this->connect();
      $stmt = $con->prepare($query);
      if ($stmt->execute($user)) {
        $this->success("User sucessfully registered!");
        return true;
      } else {
        $this->error("Could not Insert into Database: " . $stmt->errorInfo()[2]);
        return false;
      }
    }
  }

  function login_user($username, $password)
  {
    $username = strtolower($username);
    $user = $this->get_user_by_name($username);
    if($user !=NULL)
    {
      if (password_verify($password, $user['password_hash'])) {
        //$this->update_timestamp($username); On logout it should be updated though.
        return true;
      }
    }
    return false;

  }

  function get_user_by_name($username)
  {
    $con = $this->connect();
    $query = "SELECT * FROM person LEFT JOIN images ON person.profile_pic = images.image_id WHERE username LIKE ?";
    $stmt = $con->prepare($query);
    $stmt->execute([$username]);
    $results = $stmt->fetch(); // Perhaps its better to return it into a user class
    return $results;
  }
  function get_user_by_id($userid)
  {
    $con = $this->connect();
    $query = "SELECT * FROM person LEFT JOIN images ON person.profile_pic = images.image_id WHERE person.person_id LIKE ?";
    $stmt = $con->prepare($query);
    $stmt->execute([$userid]);
    $results = $stmt->fetch();
    return $results;
  }
  function get_user_by_email($useremail)
  {
    $con = $this->connect();
    $query = "SELECT * FROM person LEFT JOIN images ON person.profile_pic = images.image_id WHERE email LIKE ?";
    $stmt = $con->prepare($query);
    $stmt->execute([$useremail]);
    $results = $stmt->fetch();
    return $results;
  }

  function update_timestamp($username)
  {
    $con = $this->connect();
    $query = "UPDATE person SET last_login = CURRENT_TIMESTAMP WHERE username = ?";
    $stmt = $con->prepare($query);
    return $stmt->execute([$username]);
  }
  
  function check_friends($user_id1, $user_id2)
  {
    $con = $this->connect();
    $query = "SELECT * FROM friends WHERE (from_id = ? AND to_id = ?) OR (from_id = ? AND to_id = ?)";
    $stmt = $con->prepare($query);
    $stmt->execute([$user_id1,$user_id2,$user_id2,$user_id1]);
    $result = $stmt->fetch();
    if(!empty($result))
    {
      if($result['status_request'])
      {
        return true;
      }
    }
    return false;
  }

  function get_friends($user_id)
  {
    $con = $this->connect();
    $query = "SELECT from_id, to_id FROM friends WHERE (from_id = ? OR to_id = ?) AND status_request = 1";
    $stmt = $con->prepare($query);
    $stmt->execute([$user_id,$user_id]);
    $result = $stmt->fetchAll();
    $friends_ids = array();
    foreach($result as $key => $array)
    {
      $other_id=$this->get_not_user($array,$user_id);
      $friends_ids[$key] = $other_id;
    }
    return $friends_ids;
  }
  function count_friends($user_id)
  {
    $con = $this->connect();
    $query = "SELECT COUNT(*) FROM friends WHERE from_id = ? or to_id = ?";
    $stmt = $con->prepare($query);
    $stmt->execute([$user_id,$user_id]);
    $result = $stmt->fetch();
    
    if(empty($result))
    {
      return 0;
    }
    else
    {
      return $result['COUNT(*)'];
    }
  }

  function print_result_card($user_id,$dots)
  {
    $user = $this->get_user_by_id($user_id);
    $username = $user['username'];
    $thumbnail_path = $user['thumbnail_path'];
    $names = $user['first_name']." ".$user['last_name'];
    $filename = $user['image_name'];
    
    echo "      <div class='card text-white bg-dark m-2 search_result_card'>
    <img class='card-img-top profile_pic' src='../$thumbnail_path' alt='$filename'>
  <div class='card-body'>
  <div class='card-title username'>
  <h3>$username's profile</h3>
</div>
<div class='card-text names'>
  <span>$names</span>
</div>
    <div class='card-text buttons'>
    <div class='col'>
       <a href='$dots/index.php?site=show_chat&chat=$user_id' class='btn message_button msg_button '><img src='$dots/res/icons/mail.png'></a></li>
    </div>
    <div class='col'>
       <a href='profile.php?user=$user_id&friend_request=1' class='btn message_button fr_button'><img src='$dots/res/icons/friendrequest.png'></a></li>
    </div>
  </div>
</div>
</div>";
  }

  function print_friend_card($user_id,$dots)
  {
    $user = $this->get_user_by_id($user_id);
    $username = $user['username'];
    $thumbnail_path = $user['thumbnail_path'];
    $names = $user['first_name']." ".$user['last_name'];
    $filename = $user['image_name'];
    
    echo "      <div class='card text-white bg-dark m-2 search_result_card'>
    <img class='card-img-top profile_pic' src='../$thumbnail_path' alt='$filename'>
  <div class='card-body'>
  <div class='card-title username'>
  <h3>$username's profile</h3>
</div>
<div class='card-text names'>
  <span>$names</span>
</div>
    <div class='card-text buttons'>
    <div class='col'>
       <a href='$dots/index.php?site=show_chat&chat=$user_id' class='btn message_button msg_button '><img src='$dots/res/icons/mail.png'></a></li>
    </div>
    <!--<div class='col'>
       <a href='profile.php?user=$user_id&friend_request=1' class='btn message_button fr_button'><img src='$dots/res/icons/friendrequest.png'></a></li>
    </div>-->
  </div>
</div>
</div>";
  }

  function search_user($username)
  {
    
    $con = $this->connect();
    $query = "SELECT * FROM person LEFT JOIN images ON person.profile_pic = images.image_id WHERE person.username LIKE ? ORDER BY person.person_id ASC";
    $stmt = $con->prepare($query);
    $stmt->execute(["%".$username."%"]);
    $result = $stmt->fetchAll();    
    return $result;
  }


  function get_all_users()
  {
    
    $con = $this->connect();
    $query = "SELECT * FROM person LEFT JOIN images ON person.profile_pic = images.image_id ORDER BY person.person_id ASC";
    $stmt = $con->prepare($query);
    $stmt->execute();
    $result = $stmt->fetchAll();    
    
    
    return $result;
  }

  function get_not_admin_users()
  {
    
    $con = $this->connect();
    $query = "SELECT * FROM person LEFT JOIN images ON person.profile_pic = images.image_id WHERE person.is_admin = 0 ORDER BY person.person_id ASC";
    $stmt = $con->prepare($query);
    $stmt->execute();
    $result = $stmt->fetchAll();    
    
    
    return $result;
  }

  function count_array($array) {
    $count = 0;
    foreach ($array as $arr) {
      $count++;
    
    }
    return $count;
  }
  function update_user($userarray,$update_id)
  {
    $con = $this->connect();
    $query = "UPDATE person SET first_name = ?, last_name = ?, username = ?, email = ?, gender = ? WHERE person_id = ?";
    $query_img = "UPDATE person SET first_name = ?, last_name = ?, username = ?, email = ?, gender = ?, profile_pic = ? WHERE person_id = ?";
    if(isset($userarray[5]))
    {
      $stmt = $con->prepare($query_img);
    }
    else
    {
      $stmt = $con->prepare($query);
    }
    array_push($userarray,$update_id);
    $x = $stmt->execute($userarray);
    if($x)
    {
      $this->success("Update successful! - refresh the page");
      return True;
    }
    else
    {
      $this->error($stmt->errorInfo()[2]);
      return false;
    }
  }


  function print_admin_card($user_id,$dots)
  {
    $user = $this->get_user_by_id($user_id);
    $username = $user['username'];
    $thumbnail_path = $user['thumbnail_path'];
    $names = $user['first_name']." ".$user['last_name'];
    $filename = $user['image_name'];
    $is_active = $user['active'];
    
    echo "      <div class='card text-white bg-dark m-2 search_result_card'>
    <a href='$dots/sites/profile.php?user=$user_id'><img class='card-img-top profile_pic' src='$dots/$thumbnail_path' alt='$filename'></a>
  <div class='card-body'>
  <div class='card-title username'>
  <h3>$username's profile</h3>
</div>
<div class='card-text names'>
  <p class='card-names "; if ($is_active == 1){echo "activated";} else {echo "deactivated";} echo" '>"; if ($is_active == 1) {echo "active";} else {echo "inactive";} echo "</p>
</div>
    <div class='card-text buttons'>
    <div class='col'>
      <a href='$dots/index.php?site=admin&action="; if ($is_active == 1) {echo "deactivate-" . $user_id;} else {echo "activate-" . $user_id;} echo"' class='btn btn-primary message_button'>activate/deactivate user</a>
    </div>
    
  </div>
</div>
</div>";
    /**/
  }



  function change_status($action, $user_id)
  {
    $con = $this->connect();
    if ($action == 1) {
      $query = "UPDATE person SET active = 1 WHERE person_id = ?;";
    } else if ($action == 0) {
      $query = "UPDATE person SET active = 0 WHERE person_id = ?;";
    }
    $stmt = $con->prepare($query);
    $stmt->execute([$user_id]);
    
  }


  
}

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
      $query = "INSERT INTO person(profile_pic,gender,first_name,last_name,password_hash,username,email,last_login,active,is_admin) VALUES(NULL, ?, ?, ?, ?, ?, ?, CURRENT_TIMESTAMP, 1,0)";
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
    var_dump($result);
    if(empty($result))
    {
      return 0;
    }
    else
    {
      return $result['COUNT(*)'];
    }
  }

  function print_result_card($user_id)
  {
    $user = $this->get_user_by_id($user_id);
    $username = $user['username'];
    $thumbnail_path = $user['thumbnail_path'];
    $names = $user['first_name']." ".$user['last_name'];
    $filename = $user['image_name'];
    
    echo "<div class='col-md-3 searchResultContainer'>
    <div class='card searchResultCard'>
    <img src='$thumbnail_path'class='card-img-top' alt='$filename'>
        <div class='card-body'>
            <h5 class='card-title'>$username</h5>
            <p class='card-names'>$names</p>
            <div class='row'>
            <div class='col-3'>
            <a href='index.php?site=show_chat&chat=$user_id' class='btn btn-primary message_button'><img src='res/icons/mail_smaller.png'></a>
            </div>
            <div class='col'>
            <a href='sites/profile.php&user=$user_id' class='btn btn-primary'>Visit profile</a>
            </div>
            </div>
        </div>
    </div>
</div>";
    /**/
  }

  function search_user($username)
  {
    var_dump($username);
    
    $con = $this->connect();
    $query = "SELECT * FROM person LEFT JOIN images ON person.profile_pic = images.image_id WHERE person.username LIKE ? ORDER BY person.person_id ASC";
    $stmt = $con->prepare($query);
    $stmt->execute(["%".$username."%"]);
    $result = $stmt->fetchAll();    
    //$result = array_unique($result);
    //asort($result);
    //var_dump($result);
    return $result;
  }


  function count_array($array) {
    $count = 0;
    foreach ($array as $arr) {
      $count++;
    
    }
    return $count;
  }

  
/*
    function updateUser($user)
  {
    $user_array = $user->convert_to_array();
    $u_id = $user_array[0];
    $query = "UPDATE users SET vorname = ? ,nachname = ? ,email = ? ,adresse= ? ,plz = ?,ort = ? ,username = ? , password_hash= ? 
    WHERE id = :id";
    $con = $this->connect();
    $stmt = $con->prepare($query);
    $stmt->bindParam(':id', $u_id, PDO::PARAM_INT);
    return $stmt->execute($user_array);
  }
  function deleteUser($UserId)
  {
    $query = "DELETE FROM users WHERE id = ?";
    $con = $this->connect();
    $stmt = $con->prepare($query);
    return $stmt->execute([$UserId]);
  }
  */
}

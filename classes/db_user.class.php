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
    $query = "SELECT * FROM person WHERE username LIKE ?";
    $stmt = $con->prepare($query);
    $stmt->execute([$username]);
    $results = $stmt->fetch(); // Perhaps its better to return it into a user class
    return $results;
  }
  function get_user_by_id($userid)
  {
    $con = $this->connect();
    $query = "SELECT * FROM person WHERE person_id LIKE ?";
    $stmt = $con->prepare($query);
    $stmt->execute([$userid]);
    $results = $stmt->fetch();
    return $results;
  }
  function get_user_by_email($useremail)
  {
    $con = $this->connect();
    $query = "SELECT * FROM person WHERE email LIKE ?";
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
  function get_profile_thumbnail_path($userid)
  {
    $con = $this->connect();
    $query = "SELECT * FROM person WHERE person_id = ? JOIN images ON person.profile_pic = image_id";
    $stmt = $con->prepare($query);
    
  }
  /*
  function getUserList()
  {
    $con = $this->connect();
    var_dump($con);

    $query = "SELECT * FROM users";
    $stmt = $con->query($query);
    $userlist = $stmt->fetchAll(PDO::FETCH_CLASS, "User");
    return $userlist;
  }

*/

  function search_user($username)
  {

    $result = array();
    $con = $this->connect();
    $query = "SELECT * FROM person JOIN images ON profile_pic=image_id WHERE username LIKE ? ORDER BY id ASC";
    $stmt = $con->prepare($query);
    $stmt->execute([$username]);

    foreach ($stmt->fetchAll() as $user) {
      array_push($result, $user);
    }
    $stmt->execute(["%" . $username]);
    foreach ($stmt->fetchAll() as $user) {
      array_push($result, $user);
    }

    $stmt->execute([$username . "%"]);
    foreach ($stmt->fetchAll() as $user) {
      array_push($result, $user);
    }

    $stmt->execute(["%" . $username . "%"]);
    foreach ($stmt->fetchAll() as $user) {
      array_push($result, $user);
    }
    $result = array_unique($result);
    asort($result);
    return $result;
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

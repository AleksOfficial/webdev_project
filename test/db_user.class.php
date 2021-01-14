<?php

class Db_user extends Dbh
{

  public function prepare_($array)
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
          }
          else {
            array_push($return_array, $array["$x"]);
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

  function registerUser($user) //comes in as an array
  {
    $user = $this->prepare_($user);
    if ($user == NULL)
      return;
    else {
      $query = "INSERT INTO person(profile_pic,gender,first_name,last_name,password_hash,username,email,last_login,active) VALUES(NULL, ?, ?, ?, ?, ?, ?, CURRENT_TIMESTAMP, 1)";
      $con = $this->connect();
      $stmt = $con->prepare($query);
      if ($stmt->execute($user)) {
        $this->success("User sucessfully inserted and logged in!");
        return true;
      } else {
        $this->error("Could not Insert into Database: " . $stmt->errorInfo()[2]);
        return false;
      }
    }
  }

  function loginUser($username, $password)
  {
    $user = $this->getUser($username);
    var_dump($user);
    if (password_verify($password, $user['password_hash'])) {
      $this->success("User Logged in!");
      return true;
    } else {
      
      return false;
    }
  }

  function getUser($username)
  {
    $con = $this->connect();
    $query = "SELECT * FROM users WHERE username LIKE ?";
    $stmt = $con->prepare($query);
    #$stmt->setFetchMode(PDO::FETCH_ASSOC);
    $stmt->execute([$username]);
    $results = $stmt->fetch();
    return $results;
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



  function searchUser($username)
  {

    $result = array();
    $con = $this->connect();
    $query = "SELECT * FROM users WHERE username LIKE ? ORDER BY id ASC";
    $stmt = $con->prepare($query);
    $stmt->setFetchMode(PDO::FETCH_CLASS, "User");
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

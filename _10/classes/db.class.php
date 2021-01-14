<?php

class Db extends Dbh
{
  function getUserList()
  {
    $con = $this->connect();
    var_dump($con);

    $query = "SELECT * FROM users";
    $stmt = $con->query($query);
    $userlist = $stmt->fetchAll(PDO::FETCH_CLASS, "User");
    return $userlist;
  }

  function getUser($username)
  {
    $con = $this->connect();
    $query = "SELECT * FROM users WHERE username LIKE ?";
    $stmt = $con->prepare($query);
    #$stmt->setFetchMode(PDO::FETCH_ASSOC);
    $stmt->execute([$username]);
    $results =$stmt->fetch();
    return $results;
    
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
  function registerUser($user)
  {
    $user_array = $user->convert_to_array_r();
    var_dump($user_array);
    $query = "INSERT INTO users(anrede,vorname,nachname,email,adresse,plz,ort,username,password_hash) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $con = $this->connect();
    $stmt = $con->prepare($query);
    return $stmt->execute($user_array);
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
  function loginUser($username, $password)
  {
    $user = $this->getUser($username);
    var_dump($user);
    if (password_verify($password, $user['password_hash'])) {
      return true;
    } else {
      echo "wrong";
      return false;
    }
  }
}

<?php


  $selector = $_POST['selector'];
  $validator = $_POST['validator'];
  $pwd = $_POST['pwd'];
  $pwd_confirm = $_POST['pwd_confirm'];
  if (empty($pwd) || empty($pwd_confirm)) {
    header("create-new-password.php?pwderr=empty&selector" . $selector . "&validator=" . $validator);
  } else if (!($pwd === $pwd_confirm)) {
    header("create-new-password.php?pwderr=no_match&selector" . $selector . "&validator=" . $validator);
  }

  $currentDate = date("U");

  $con = $db->connect();
  $query = "SELECT * FROM pwdreset WHERE pwdresetselector=? AND pwdresetexpires>= ?";
  $stmt = $con->prepare($query);
  if(!$stmt)
  {
    echo "There was an error!";
    exit();
  }
  $stmt->execute([$selector,$currentDate]);
  $result = $stmt->fetch();
  if($result === NULL)
  {
    echo "Error: Your token doesn't exist";
  }
  else if(($stmt->fetch())!= false)
  {
    echo "Error: Multiple reset-tokens exist!";
  }
  else
  {
    $result = $result[0]; 
  }
    $tokenBin = hex2bin($validator);
    $tokenCheck = password_verify($tokenBin,$result['pwdResetToken']);
    if(!$tokenCheck)
    {
      echo "An error has occured during comparison";
      exit();
    }
    else if($tokenCheck)
    {
      $tokenEmail = $result['pwdresetemail'];

      $query = "SELECT * FROM users WHERE emailUsers=?";
      $stmt = $con->prepare($query);
      if(!$stmt)
      {
        echo "There was an error!";
        exit();
      }
      $stmt->execute([$tokenEmail]);
      $result = $stmt->fetch();
      if($result == NULL)
      {
        echo "mail not found!";
        exit();
      }  
      $query = "UPDATE users SET password_hash = ? WHERE email =?";
      $stmt = $con->prepare($query);
      if(!$stmt)
      {
        echo "There was an error with perp of update!";
        exit();
      }
      $new_pwd_hash = password_hash($pwd,PASSWORD_DEFAULT);
      $stmt->execute([$new_pwd_hash,$tokenEmail]);

      $query = "DELETE FROM pwdreset WHERE pwdResetEmail = ?";
      $stmt = $con->connect();
      $stmt->execute([$tokenEmail]);
      header("Location: ../index.php?pwderr=none");
    }

  
  


<?php
  if(isset($_POST['reset-request-submit']))
  {
    $selector = bin2hex(random_bytes(8));
    $token = random_bytes(32);
    $sendtoken = bin2hex($token);

    $url="localhost/webtech/_10/create-new-password.php?selector=$selector&validator=$sendtoken";

    $expires = date("U")+900;
    
    $con = $db->connect();
    $userEmail = $_POST["email"];

    $query1 = "DELETE FROM pwdreset WHERE pwdResetEmail = ?";
    
    $stmt = $con->prepare($query1);
    if(!$stmt)
      {
        echo "There was an error!";
        exit();
      }
    $stmt->execute([$userEmail]);

    $query2 = "INSERT INTO pwdreset (pwdresetemail,pwdresetselector,pwdresettoken,pwdresetexpire) VALUES (?,?,?,?)";

    $stmt = $con->prepare($query2);
    if(!$stmt)
    {
      echo "There was an error!";
      exit();
    } else
    {
      $hashedToken = password_hash($token,PASSWORD_DEFAULT);
      $stmt->execute([$userEmail,$selector,$hashedToken,$expires]);

    }
    $to = $userEmail;

    $subject = "Reset your password for <socialmedianame>";

    $message = '<p>We received a password reset request. The link to reset your password is below. if you didn\'t request a reset, you can ignore this email </p>.';
    $message .= '<p>Here is your password reset link: </br>';
    $message .= '<a href="'.$url.'">'.$url.'</a></p>';

    $headers ="From: \r\n";
    $headers .="Reply-To: \r\n";
    $headers .="Content-type: text/html\r\n";

    mail($to,$subject,$message,$headers);

    header("Location: ../index.php?reset-password=success");


  } else
    header("Location: ../index.php");
?>
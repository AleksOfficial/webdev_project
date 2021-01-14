<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
  <link href = "res/css/registerform.css" rel="stylesheet">
  <title>Document</title>
</head>
<body>
  <?php
    $selector = $_GET['selector'];
    $validator = $_GET['validator'];
    if(empty($selector) || empty($validator))
    {
      echo "Could not validate your request!";
    }else
    {
      if(ctype_xdigit($selector) && ctype_digit($valdiator))
      {
        //HTML FORM HERE?>
        <form action="res/script/reset-password.script.php" method="post">
          <input type="hidden" name="selector" value="<?php echo $selector;?>">
          <input type="hidden" name="validator" value="<?php echo $validator;?>">
          <input type="password" name="pwd" placeholder="Enter new password. " value ="">
          <input type="password" name="pwd_confirm" placeholder ="Enter new password again." value="">
          <button type = "submit" name="reset-password-submit">Reset password</button>
      </form> 
        <?php
      }
    }
  ?>
</body>
</html>
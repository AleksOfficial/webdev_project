<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Reset your Password</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
  <link rel="stylesheet" href="../res/css/base.css">
  <link rel="stylesheet" href="../res/css/reset_pw.css">
  <?php
  $file = basename(__FILE__);
  include "../inc/class-autoload.inc.php";
  $submission = true;
  $reset = new Db_pw_reset();
  if (isset($_POST['reset-request-submit'])) {
    $reset->send_request_reset($_POST);
  }
  if (isset($_GET['selector']) && isset($_GET['validator'])) {
    if ($reset->token_checker($_GET['selector'], $_GET['validator'])) {
      if(isset($_POST['reset-change-submit']))
      {
        $reset->password_reset($_POST['password'],$_POST['password_confirm'],$_GET['selector']);
        //header("../index.php?pwreset=0");
      }
      else{
        $submission = false;
      }
      
    }
    else if(isset($_POST['reset-change-submit']))
    {
      //header("../index.php?pwreset=1");
    }
    
  }
  
  echo '</head>';

if ($submission) {
  //HERE COMES THE EMAIL RESET FORM

echo'
  <body>
    <div class="container">
      <div class="d-flex justify-content-center h-100">
        <div class="card">
          <div class="card-header">
            <h3>Password Reset </h3>
          </div>
          <div class="card-body">
            <form action="reset_pw.php" method="POST">
              <div class="input-group form-group">
                <p>Enter your E-Mail address to reset your password</p>
                <div class="input-group-prepend">

                  <span class="input-group-text"><i class="fas fa-user"><img src="../res/icons/user.png"></i></span>
                </div>
                <input type="email" class="form-control" name="email" placeholder="Enter your E-Mail">
              </div>
              <div class="form-group _button">
                <input type="submit" name="reset-request-submit" value="Request Reset" class="btn float-right login_btn">
              </div>
            </form>
          </div>
          <div class="card-footer">
            <div class="d-flex justify-content-end social_icon">
              <a href="../index.php">
                <span><i class="fab fa-text">Go back ...</i>
                  <i class="fab fa-logo"><img src="../res/icons/logo.png"></i></span></a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </body>
</html>';
} else {
  //HERE COMES THE PASSWORD RESET FORM
  $selector = $_GET['selector'];
  $validator = $_GET['validator'];
  echo'
  <body>
    <div class="container">
      <div class="d-flex justify-content-center h-100">
        <div class="card">
          <div class="card-header">
            <h3>Password Reset </h3>
          </div>
          <div class="card-body">
            <form action="reset_pw.php?selector='.$selector.'&validator='.$validator.'" method="POST">
            <p>Enter a new password and confirm it by entering it again.</p>
              <div class="input-group form-group">
                
                <div class="input-group-prepend">
                  <span class="input-group-text"><i class="fas fa-user"><img src="../res/icons/lock.png"></i></span>
                </div>
                <input type="password" class="form-control" name="password" placeholder="Enter new password">
</div><div class="input-group form-group">
              <div class="input-group-prepend">
                <span class="input-group-text"><i class="fas fa-user"><img src="../res/icons/lock.png"></i></span>
              </div>
              <input type="password" class="form-control" name="password_confirm" placeholder="Re-Enter your password">
          </div>
          <div class="form-group _button">
            <input type="submit" name="reset-change-submit" value="Change Password" class="btn float-right login_btn">
          </div>
          </form>
        </div>
        <div class="card-footer">
          <div class="d-flex justify-content-end social_icon">
            <a href="../index.php">
              <span><i class="fab fa-text">Go back ...</i>
                <i class="fab fa-logo"><img src="../res/icons/logo.png"></i></span></a>
          </div>
        </div>
      </div>
    </div>
  </body>

  </html>';
}

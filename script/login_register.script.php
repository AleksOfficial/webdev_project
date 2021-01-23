<?php
$user = new Db_user();
//Register
if(!($_SESSION['logged'])&& isset($_POST['register']))
{
    if(!empty($_POST['username']) && !empty($_POST['password']) && !empty($_POST['password_repeat']) && !empty($_POST['email']))
    {
      if($_POST['password'] == $_POST['password_repeat'])
      {
        $user->register_user($_POST);
        $navigator = "login";
      }
      
    }
}
else if( isset($_POST['register'])){
  $user->error("error: cannot create a user - you are currently logged in");
  $navigator = "home";
}



//Login
if(isset($_POST['login']))
{
  if(!empty($_POST['username']) && !empty($_POST['password']))
  {
    $un = stripslashes(htmlspecialchars($_POST['username']));
    $pw = stripslashes(htmlspecialchars($_POST['password']));
    if($user->login_user($un,$pw))
    {
      $_SESSION['user']=$user->get_user_by_name($un);
      $_SESSION['logged'] = true;
      $user->success("User Logged in!");
    }
    else
    {
      $navigator = "login";
      $user->error("Error: Invalid Login Credentials.");
    }
  }
  else
{
  $user->error("Error: Cannot leave username or password empty!");
  $navigator = "login";
}
}




?>
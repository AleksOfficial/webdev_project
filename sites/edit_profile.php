<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
  <link rel="stylesheet" href="../res/css/base.css">
  <link rel="stylesheet" href="../res/css/registerform.css">
  <link rel="stylesheet" href="../res/css/edit_profile.css">
  <title>🌍 RIFT - Edit Profile</title>
  <?php
  //Initial setup
  session_start();
  $file = basename(__FILE__);
  $dots = "..";
  $navigator = "profile";
  include "../inc/class-autoload.inc.php";
  include '../inc/navigation.inc.php';
  $db_user = new Db_user();
  $user_id = 0;
  if(isset($_GET['user']))
  {
    if(!empty($_GET['user']))
    {
      $user_id=$_GET['user'];
    
    }
  }
  //print closing tags for head and print body?>

  </head>
  <body>
    <div class='container'>
      <div class='row'>

  <?php
  if($user_id>0)
  {
  if($_SESSION['logged'])
  {
    $user = $_SESSION['user'];
    $vorname= $user['first_name'];
    $nachname= $user['last_name'];
    $username = $user['username'];
    $email = $user['email'];
    $image_path = $user['thumbnail_path'];
    $file_name = $user['image_name'];
  }//realpath funktion für background image url
        echo"
 
              <form action='$dots/index.php' enctype='multipart/form-data' method=\"POST\">
              
                <h3>Change your Profile here</h3>
                <div class='row'>
                <div class='col'>
                <a href='#' aria-label='Change Profile Picture'>
                  <div class='profile_pic ' style=\"background-image: url('$dots/$image_path')\">
                  
                  
                    <input type='file' name='image' class='file_upload'>
                    <span class='edit_text'>Change Image</span>
                  </div>
                </a>
                </div>
                </div>
                <div class='row'>
                  <div class='col'>
                    <div class='form-radio'>
                      <label for='gender'>Anrede</label>
                      <div class='form-flex'>
                        <input type='radio' name='gender' value='m' id='male' checked='checked' />
                        <label id='labelm' for='male'>Herr</label>
                        <input type='radio' name='gender' value='w' id='female' />
                        <label id='labelw'  for='female'>Frau</label>
                      </div>
                      </div>
                    </div>
                    </div>
                    <div class='wrap row'>
                      <div class='input-group'>
                        <div class='col-12 col-sm-5 '>
            
                          <label for='vorname'>Vorname: </label>
                          <div class='input-group'>
                            <div class='input-group-prepend'>
                              <span class='input-group-text'><i class='fas fa-key'><img src='$dots/res/icons/name.png'></i></span>
                            </div>
                            <input type='text' class='form-control' name='first_name' placeholder='Vorname' value='$vorname'>
                          </div>
            
                          <label for='nachname'>Nachname: </label>
                          <div class='input-group'>
                            <div class='input-group-prepend'>
                              <span class='input-group-text'><i class='fas fa-key'><img src='$dots/res/icons/name.png'></i></span>
                            </div>
                            <input type='text' class='form-control' name='last_name' placeholder='Nachname' value='$nachname'>
                          </div>
            
                        </div>
            
                        <div class='col-12 col-sm-5 offset-sm-2'>
                          <label for='username'>Username: </label>
                          <div class='input-group'>
                            <div class='input-group-prepend'>
                              <span class='input-group-text'><i class='fas fa-key'><img src='$dots/res/icons/user.png'></i></span>
                            </div>
                            <input type='text' class='form-control' name='username' placeholder='bobby96' value='$username'>
                          </div>
                          <label for='email'>E-Mail-Adresse: </label>
                          <div class='input-group'>
                            <div class='input-group-prepend'>
                              <span class='input-group-text'><i class='fas fa-key'><img src='$dots/res/icons/email.png'></i></span>
                            </div>
                            <input type='email' class='form-control' name='email' value='$email'placeholder='sample@gmail.com'>
                          </div>
                        </div>
                      </div>
            
                    </div>
                    <input type = 'hidden' name='user_id' value='$user_id'>
                    <input type='submit' class=' btn float-right register_btn' name='update_profile' value='Update Profile'>
                  </div>
                </form>
                </div>

                </div>
              </div>
            </div>
      
      
";
              }
            else{
              echo"
              <h1>(╯ ͠° ͟ʖ ͡°)╯┻━┻</h1>
              <p>There is no ID provided!</p>";
            }
              ?>
              </div>
        </div>
      </body>
      
      </html>
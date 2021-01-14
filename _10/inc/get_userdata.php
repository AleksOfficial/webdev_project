<?php
require_once('./mysqli_connect.php');

if(isset($_GET['del']))
{
  $del = $_GET['del'];
  $query = "DELETE FROM users WHERE ID = $del";
  @mysqli_query($dbc,$query);
}

if(isset($_POST['id']))
{

    echo "hello";
    $update = $_POST['id'];
    $query = "UPDATE users SET
    vorname = '".$_POST['vorname']."',
    nachname = '".$_POST['nachname']."',
    adresse = '".$_POST['adresse']."',
    plz = '".$_POST['plz']."',
    ort = '".$_POST['ort']."',
    username = '".$_POST['username']."',
    password_hash = '".$_POST['password_hash']."',
    email = '".$_POST['email']."'
    WHERE
    id = $update";

    if(mysqli_query($dbc,$query))
      echo 'Success';
    else
      echo "Error: ".mysqli_error($dbc); 
  
}

$query = "SELECT * FROM users";

$response = @mysqli_query($dbc,$query);

if($response)
{
  echo '<table align = "left" cellspacing ="5" cellpadding="8"
  <tr>
    <td align="left"><b>ID</b></td>
    <td align="left"><b>Vorname</b></td>
    <td align="left"><b>Nachname</b></td>
    <td align="left"><b>Adresse</b></td>
    <td align="left"><b>PLZ</b></td>
    <td align="left"><b>Ort</b></td>
    <td align="left"><b>Username</b></td>
    <td align="left"><b>email</b></td>
    <td align="left"><b>ACTION</b></td>
  </tr>';
  while($row = mysqli_fetch_array($response)){

    echo '<tr>'.
    '<td align="left">'.
        $row['id'].'</td>'.
      '<td align="left">'.
        $row['vorname'].'</td>'.
      '<td align="left">'.
        $row['nachname'].'</td>'.
      '<td align="left">'.
        $row['adresse'].'</td>'.
      '<td align="left">'.
        $row['plz'].'</td>'.
      '<td align="left">'.
        $row['ort'].'</td>'.
      '<td align="left">'.
        $row['username'].'</td>'.
      '<td align="left">'.
        $row['email'].'</td>'.
        
      '<td align ="left"><a href="./get_userdata.php?del='.$row['id'].'">Delete</a></td>'.
      '<td align ="left"><a href="./update.php?update='.$row['id'].'">Edit</a></td>'
    .'</tr>';
  }

} else{

  echo "Couldn't issue database query";

  echo mysqli_error($dbc);

}

mysqli_close($dbc);
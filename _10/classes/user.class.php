<?php
class User
{
  private $id;
  private $anrede;
  private $vorname;
  private $nachname;
  private $email;
  private $adresse;
  private $plz;
  private $ort;
  private $username;
  private $password_hash;


  function __construct($array)
  {
    $fields = array("anrede", "vorname", "nachname", "email", "adresse", "plz", "ort", "username", "password_hash");
    $new_array = array();
    foreach ($fields as $field) {
      if (isset($array["$field"]))
        $new_array["$field"] = $array["$field"];
      else
        $new_array["$field"] = NULL;
    }

    $this->convert_to_user($new_array);
  }
  function convert_to_user($array)
  {
    $this->anrede = $array['anrede'];
    $this->vorname = $array['vorname'];
    $this->nachname = $array['nachname'];
    $this->email = $array['email'];
    $this->adresse = $array['adresse'];
    $this->plz = $array['plz'];
    $this->ort = $array['ort'];
    $this->username = $array['username'];
    $this->password_hash = password_hash($array['password_hash'], PASSWORD_DEFAULT);
  }
  function get_id()
  {
    return $this->id;
  }
  function __toString()
  {
    return $this->id;
  }
  function convert_to_array()
  {
    return array($this->id, $this->anrede, $this->vorname, $this->nachname, $this->email, $this->adresse, $this->plz, $this->ort, $this->username, $this->password_hash);
  }
  function convert_to_array_r()
  {
    return array($this->anrede, $this->vorname, $this->nachname, $this->email, $this->adresse, $this->plz, $this->ort, $this->username, $this->password_hash);
  }
  function get_username()
  {
    return $this->username;
  }

  function get_full_name()
  {
    return $this->vorname + " " + $this->nachname;
  }

  function get_email()
  {
    return $this->email;
  }

  function get_street()
  {
    return $this->adresse;
  }

  function get_place()
  {
    return $this->ort;
  }

  function get_pwhash()
  {
    return $this->password_hash;
  }

  function get_plz()
  {
    return $this->plz;
  }
}
?>
<form action="./index.php" method="POST">
  <div class="container">
    <h1 class="display-1">register yourself!</h1>
    <form action="index.php" method="POST">
      <div class="form-group">

        <div class="form-radio">
          <label for="gender">Anrede</label>
          <div class="form-flex">
            <input type="radio" name="anrede" value="m" id="male" checked="checked" />
            <label for="male">Herr</label>

            <input type="radio" name="anrede" value="w" id="female" />
            <label for="female">Frau</label>

          </div>
        </div>
        <label for="vorname">Vorname: </label>
        <input type="text" class="form-control" name="vorname" placeholder="Vorname">
        <label for="nachname">Nachname: </label>
        <input type="text" class="form-control" name="nachname" placeholder="Nachname">
        <label for="vorname">Adresse: </label>
        <input type="text" class="form-control" name="adresse" placeholder="Beispielstraße 1">
        <label for="plz">PLZ: </label>
        <input type="text" class="form-control" name="plz" placeholder="1100">
        <label for="ort">Ort: </label>
        <input type="text" class="form-control" name="ort" placeholder="Wien">
        <label for="username">Username: </label>
        <input type="text" class="form-control" name="username" placeholder="bobby96">
        <label for="password_hash">Password: </label>
        <input type="password" class="form-control" name="password_hash">
        <label for="email">E-Mail-Adresse: </label>
        <input type="email" class="form-control" name="email" placeholder="sample@gmail.com">
        <input type="submit" name="register" value="send">
      </div>
  </div>
</form>
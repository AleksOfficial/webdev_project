<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
  <link rel="stylesheet" href="../res/css/base.css">
  <title>🌍 RIFT - Search Result</title>
  <?php
  //Initial setup
  session_start();
  $file = basename(__FILE__);
  $dots = "..";
  $navigator = "home";
  include "../inc/class-autoload.inc.php";
  include '../inc/navigation.inc.php';
  //Suchfunktion
  if (isset($_GET['search_submit'])) {
  }


  ?>
</head>

<body>
  <div class="container">
    <div class="row">
      <div class="col-3">

      </div>
      <div class="col">
        <div class="row">
          <div class="col">

          </div>
          <div class="row">
            <div class="col">

            </div>
          </div>
        </div>
      </div>
      <div class="col-3">

      </div>

    </div>
  </div>
</body>

</html>
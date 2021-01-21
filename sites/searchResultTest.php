<?php 
session_start();

include "../inc/class-autoload.inc.php";
include "../inc/navigation.inc.php";
$navigator = 'search';
?>
 <!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
    <link rel="stylesheet" href="../res/css/base.css">
    <link rel="styelsheet" href="../res/css/profile.css">
    <title>🌍 RIFT - <?php echo ucwords($navigator) ?></title>
</head>

<body>
    <?php include '../inc/feed.inc.php'; ?>
</body>

</html>
    

    
  <?php

  header("Location: ../index.php?error=1");
?>
<?php
if ($_SESSION['logged']) {
    //only logged users can view profiles
?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
        <link rel="stylesheet" href="../res/css/base.css">
        <link rel="styelsheet" href="../res/css/profile.css">
        <title>Document</title>
    </head>

    <body>
        <?php
        $db_user = new db_user();
        $db_post = new db_post();
        $user_id = $_SESSION['user']['person_id'];
        $user = $db_user->get_user_by_id($user_id);
        
        ?>
        <div class="main-section">
            <div class="container">
                <div class = "main-section-data">
                    <div
                </div>
            </div>

    </body>

    </html>
    ?>
<?php
} else {
    header("Location: ../index.php?error=1");
}

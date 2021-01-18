<?php
$db_messages = new Db_messages();
if ($_SESSION['logged']) {
  //Headline with the table content
?>
  <div class="container">
    <div class="d-flex justify-content-end social_icon">
      <a href="index.php">
        <span><i class="fab fa-text">Go back ...</i>
          <i class="fab fa-logo"><img src="res/icons/logo.png"></i></span></a>
    </div>
    <table class="table table -striped table-dark table-hover">
      <thead>
        <tr>
          <th colspan="4">
            <h3>Messages</h3>
          </th>
        </tr>
      </thead>
      <?php
      $list_messages = $db_messages->get_messages_list($_SESSION['user']);
      var_dump($list_messages);
      if (empty($list_messages)) {

      } else {
       $db_user = new db_user();
       foreach($list_messages as $message)
       {
        //$user = $db_user->get_user_by_id($col['recipient_id']); //not sure if this is efficient or not. Might want to change it to a collective statement in order to make it easier for the DB. instead of n connections, you have 1 connection with 1 Statement and n OR extensions to the query.
        $db_messages->print_list_element($message['recipient_id'],$message);
         
       }
      }
      ?>
    </table>
  </div>

<?php
} else {
  $db_messages->error("Error: You are not logged in!");
}
?>
<?php
$db_messages = new Db_messages();
if ($_SESSION['logged']) {
  //Headline with the table content
?>
  <div class="container bg-dark text-white message_list">

    <div class="row">
      <div class="col headline">
        <h3>Messages</h3>
      
        <div class="social_icon">
          <a class="btn send_msg_btn btn-secondary"href="index.php?site=start_chat">
            <img src="./res/icons/new_conversation.png"></a>

        </div>
      </div>
    </div>
    <?php
    $list_messages = $db_messages->get_messages_list($_SESSION['user']);
    if (empty($list_messages)) {
    } else {
      //$db_user = new db_user();
      foreach ($list_messages as $message) {
        //$user = $db_user->get_user_by_id($col['recipient_id']); //not sure if this is efficient or not. Might want to change it to a collective statement in order to make it easier for the DB. instead of n connections, you have 1 connection with 1 Statement and n OR extensions to the query.
        $db_messages->print_list_element($_SESSION['user']['person_id'], $message);
      }
    }

    ?>
  </div>


<?php
} else {
  $db_messages->error("Error: You are not logged in!");
}
?>
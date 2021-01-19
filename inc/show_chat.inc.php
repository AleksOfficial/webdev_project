<?php



if (isset($_GET['chat'])) {

  $recipient_id = $_GET['chat'];
  $db_messages = new db_messages();
  $db_messages->update_viewed($_SESSION['user']['person_id'],$recipient_id);
  //Message sent?
  if (isset($_POST['send'])) {
    include "./script/add_message.script.php";
  }
  //print all messages
  $all_messages = $db_messages->get_chat($_SESSION['user'], $recipient_id);
  $db_user = new db_user();
  $user = $db_user->get_user_by_id($recipient_id);
  $username = $user['username'];
  $thumbnail_path = $user['thumbnail_path'];
  $timestamp = $db_user->get_timestring($user['last_login']);
  echo "<div class='container message_list'>
    <div class='row'>
      <div class='col-1 thumbnail_profile_pic'><img class = 'thumbnail_profile' src='$thumbnail_path'></div>
      <div class='col-3 chat_username'><h3>$username</h3><div class='timestamp_last_login'><i>Last Time Online: $timestamp</i></div>
    </div>
  </div>";
  foreach ($all_messages as $message) {
    $db_messages->print_message($message, $_SESSION['user']['person_id']);
  }

  echo "<form action ='index.php?site=show_chat&chat=$recipient_id' method = 'POST'>
        <div class='row input_of_message'>
        <div class='col-11 input_field'>
        <textarea rows=3 class = 'form-control' name='content' placeholder='Enter your Message here ...' required></textarea></div>
        <div class='col-1 button_container'><button type='submit' class='btn send_btn' name='send'><img src='res/icons/send-mail.png'></button>
        </form>";
  echo '</div>';
} else {
  header("Location: index.php?site=messages&chaterror=1");
}
/*<input type='textarea' rows=3 class = 'form-control' name='content' placeholder='Enter your Message here ...' required>*/
<?php
  $db_messages = new Db_messages();
  if($_SESSION['logged'])
  {
    //Headline with the table content?>
    <div class="container">
      <table class ="table table -striped table-dark table-hover">
      <thead>
      <tr>
        <th colspan ="3"><h3>Messages</h3></th>
      </tr>
      </thead>
      <?php
        $list_messages = $db_messages->get_messages_list($_SESSION['user']);
        if(empty($list_messages))
        echo "hello :)";
      ?>
      </table>
    </div>
  
  <?php
  }
  else{
    $db_messages->error("Error: You are not logged in!");
  }
?>

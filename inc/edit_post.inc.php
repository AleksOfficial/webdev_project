<?php
if ($_SESSION['logged']) {
  if (isset($_GET['post'])) {
    $post_id = $_GET['post'];
    $db_post = new Db_posts();
    $db_create_stuff = new Db_create_stuff();
    $post = $db_post->get_post_from_id($post_id);
    $value = $post['post_text'];
    if ($post) {
      // Uploading a new image won't be possible for simplicity. 
      echo "
        <div class='card bg-dark text-white post_bar mb-3'>
        <form action='single_post.php?post=$post_id method='GET'>
        <div class='card-title' style='padding:16px;'> 
        <div class='col'>
        <h3Edit your post</h3>
        </div>
        <div class='col'>
        <select class='form-select' name='privacy_status_post' aria-label='Default select example'>
          <option selected value='1'>Public</option>
          <option value='2'>Friends</option>
          <option value='3'>Private</option>
        </select>
        </div>
        </div>
      
        <div class='card-body'>
        <div class='row'>
        
        <div class='input-group'>
            <textarea class='form-control' name='content_post' maxlength='500' placeholder='Enter your new text!'>$value</textarea>
            <button class='btn send_btn' type='submit' name='update_post'><img src='../res/icons/send-mail.png'></button>
            <input type = 'hidden' name='post' value='$post_id'>
        </form>
        </div>";
    }
  }
}

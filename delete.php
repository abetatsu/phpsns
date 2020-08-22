<?php
session_start();
require('connectDB.php');

if (isset($_SESSION['id'])) {
     $id = $_REQUEST['id'];

     $messages = $db->prepare('SELECT * FROM posts WHERE id=?');
     $messages->execute($id);
     $message = $messages->fetch();

     if ($message['member_id'] === $SESSION['id']) {
          $delete = $db->prepare('DELETE FROM posts WHERE id=?');
          $delete->execute(array($id));
     }
}

header('Location: index.php');
exit();



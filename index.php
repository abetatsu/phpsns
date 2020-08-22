<?php
session_start();
require('connectDB.php');

if ($_SESSION['id'] && $_SESSION['time'] + 3600 > time()) {
     $_SESSION['time'] = time();
     $members = $db->prepare('SELECT * FROM members WHERE id=?');
     $members->execute(array($_SESSION['id']));
     $member = $members->fetch();
} else {
     header('Location: login.php');
     exit();
}

if (!empty($_POST)) {

     if ($_POST['message'] !== '' && $_POST['reply_post_id']) {

          $messages = $db->prepare('INSERT INTO posts SET member_id=?, message=?, reply_message_id=?, created=now()');
          $messages->execute(array(
               $member['id'],
               $_POST['message'],
               $_POST['reply_post_id']
          ));
     } else {

          $messages = $db->prepare('INSERT INTO posts SET member_id=?, message=?, reply_message_id=0, created=now()');
          $messages->execute(array(
               $member['id'],
               $_POST['message']
          ));
     }
     header('Location: index.php');
     exit();
}

$posts = $db->query('SELECT m.name, m.picture, p.* FROM members m, posts p WHERE m.id=p.member_id ORDER BY p.created DESC');

if (isset($_REQUEST['res'])) {
     $response = $db->prepare('SELECT m.name, m.picture, p.* FROM members m, posts p WHERE m.id=p.member_id AND p.id=?');
     $response->execute(array($_REQUEST['res']));
     $table = $response->fetch();
     $message = '@' . $table['name'] . ' ' . $table['message'] . ' ' . '>>>';
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
     <meta charset="UTF-8">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
     <title>phpsns</title>
</head>

<body class="bg-info text-center">
     <h1 class="text-white my-5">投稿画面</h1>
     <div class="card mx-auto col-sm-6 my-5">
          <h3 class="my-3"><?php print(htmlspecialchars($member['name'], ENT_QUOTES)); ?>さん、今起こっていることを伝えよう！</h3>
          <form action="" method="post">
               <textarea name="message" id="" cols="50" rows="10" class="mx-auto"><?php print(htmlspecialchars($message, ENT_QUOTES)); ?></textarea>
               <input type="hidden" name="reply_post_id" value="<?php print(htmlspecialchars($_REQUEST['res'], ENT_QUOTES)); ?>">
               <input type="submit" value="投稿する" class="btn btn-primary">
          </form>
     </div>
     <?php foreach ($posts as $post) : ?>
          <div class="card col-sm-6 mx-auto my-3 text-left">
               <img src="member_picture/<?php print(htmlspecialchars($post['picture'], ENT_QUOTES)); ?>" alt="<?php print(htmlspecialchars($post['image'], ENT_QUOTES)); ?>" width="48" height="48">
               <p><?php print(htmlspecialchars($post['name'], ENT_QUOTES)); ?></p>
               <p><?php print(htmlspecialchars($post['message'], ENT_QUOTES)); ?></p>
               <p><?php print(htmlspecialchars($post['created'], ENT_QUOTES)); ?></p>
               <a href="index.php?res=<?php print(htmlspecialchars($post['id'], ENT_QUOTES)); ?>">返信</a>
          </div>
     <?php endforeach; ?>
</body>

</html>
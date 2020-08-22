<?php
require('connectDB.php');

if (empty($_REQUEST['id'])) {
     header('Location: index.php');
     exit();
}

$posts = $db->prepare('SELECT m.name, m.picture, p.* FROM members m, posts p WHERE m.id=p.member_id AND p.id=?');
$posts->execute(array($_REQUEST['id']));
$post = $posts->fetch();

?>
<!DOCTYPE html>
<html lang="ja">

<head>
     <meta charset="UTF-8">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
     <title>PHPSNS</title>
</head>

<body class="bg-info text-center">
     <h1 class="text-white my-5">投稿詳細画面</h1>

     <?php if($post): ?>
     <div class="card col-sm-6 mx-auto my-3 text-left">
          <img src="member_picture/<?php print(htmlspecialchars($post['picture'], ENT_QUOTES)); ?>" alt="<?php print(htmlspecialchars($post['image'], ENT_QUOTES)); ?>" width="48" height="48">
          <p><?php print(htmlspecialchars($post['name'], ENT_QUOTES)); ?></p>
          <p><?php print(htmlspecialchars($post['message'], ENT_QUOTES)); ?></p>
          <p><?php print(htmlspecialchars($post['created'], ENT_QUOTES)); ?></p>
          <a href="index.php">投稿画面に戻る</a>
     </div>
     <?php else: ?>
     <div class="card col-sm-6 mx-auto my-3 text-center text-danger">
          <p>* その投稿は削除されたか、URLが間違えています</p>
     </div>
     <?php endif; ?>
</body>

</html>
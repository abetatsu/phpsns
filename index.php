<?php
require('connectDB.php');
session_start();

if ($_SESSION['id'] && $_SESSION['time'] + 3600 > time()) {
     $_SESSION['time'] =time();
     $members = $db->prepare('SELECT * FROM members WHERE id=?');
     $members->execute(array($_SESSION['id']));
     $member = $members->fetch();

} else {
     header('Location: login.php');
     exit();
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
               <textarea name="message" id="" cols="50" rows="10" class="mx-auto"></textarea>
               <input type="submit" value="投稿する" class="btn btn-primary">
          </form>
     </div>
</body>
</html>
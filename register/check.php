<?php
session_start();
require('../connectDB.php');
// ini_set('display_errors', 1);

if (!isset($_SESSION['join'])) {
     header('Location: register.php');
     exit();
}

if (!empty($_POST)) {
     // $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
     // $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
     $statement = $db->prepare('INSERT INTO members SET name=?, email=?, password=?, picture=?, created=NOW()');
     echo $statement->execute(array(
          $_SESSION['join']['name'],
          $_SESSION['join']['email'],
          sha1($_SESSION['join']['password']),
          $_SESSION['join']['image']
     ));
     unset($_SESSION['join']);

     header('Location: thanks.php');
     exit();
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
     <meta charset="UTF-8">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
     <title>phpsns</title>
</head>
<body class="bg-info">
     <h1 class="text-center text-white py-4">確認画面</h1>
     <div class="col-sm-6 mx-auto card mt-5">
          <form action="" method="post">
               <input type="hidden" name="action" value="submit"/>
               <div class="form-group">
                    <label for="exampleInputName">Name</label>
                    <p class="text-primary"><?php print(htmlspecialchars($_SESSION['join']['name'], ENT_QUOTES)); ?></p>
               </div>
               <div class="form-group">
                    <label for="exampleInputEmail1">Email address</label>
                    <p class="text-primary"><?php print(htmlspecialchars($_SESSION['join']['email'], ENT_QUOTES)); ?></p>
               </div>
               <div class="form-group">
                    <label for="exampleInputPassword1">Password</label>
                    <p class="text-primary">パスワードは表示されません</p>
               </div>
               <div class="form-group">
                    <label for="exampleInputImage1">Image</label><br>
                    <?php if ($_SESSION['join']['image'] !== ''): ?>
                         <img src="../member_picture/<?php print(htmlspecialchars($_SESSION['join']['image'], ENT_QUOTES)); ?>">
                    <?php endif; ?>
               </div>
               <a href="register.php?action=rewrite" class="btn btn-success">書き直す</a>
               <button type="submit" class="btn btn-primary col-sm-2">Register</button>
          </form>
     </div>
</body>
</html>
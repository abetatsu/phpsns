<?php
session_start();
require('../connectDB.php');

if (!empty($_POST)) {

     if ($_POST['name'] === '')
     {
          $error['name'] = 'Blank';
     }

     if ($_POST['email'] === '')
     {
          $error['email'] = 'Blank';
     }

     if (strlen($_POST['password']) < 4)
     {
          $error['password'] = 'Length';
     }

     if ($_POST['password'] === '')
     {
          $error['password'] = 'Blank';
     }
     $fileName = $_FILES['image']['name'];
     if (!empty($fileName)) {
          $ext = substr($fileName, -3);
          if ($ext != 'jpg' && $ext != 'png' && $ext != 'gif') {
               $error['image'] = 'type';
          }
     }
     
     if (empty($error)) {
          $image = date('YmdHis' . $_FILES['image']['name']);
          move_uploaded_file($_FILES['image']['tmp_name'], '../member_picture/' . $image);
          $_SESSION['join'] = $_POST;
          $_SESSION['join']['image'] = $image;
          header('Location: check.php');
          exit();
     }
}

if ($_REQUEST['action'] === 'rewrite' && isset($_SESSION['join'])) {
     $_POST = $_SESSION['join'];
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
     <h1 class="text-white text-center py-4">登録画面</h1>
     <div class="col-sm-6 mx-auto card mt-5">
          <form action="" method="post" enctype="multipart/form-data">
               <div class="form-group">
                    <label for="exampleInputName">Name</label>
                    <small id="nameHelp" class="form-text text-danger">required</small>
                    <input name="name" type="text" class="form-control" id="exampleInputName" aria-describedby="nameHelp" placeholder="Enter your name" value="<?php print(htmlspecialchars($_POST['name'])); ?>">
                    <?php if ($error['name'] === 'Blank'): ?>
                    <p class="text-danger">* 名前を入力してください</p>
                    <?php endif; ?>
               </div>
               <div class="form-group">
                    <label for="exampleInputEmail1">Email address</label>
                    <small id="emailHelp" class="form-text text-danger">required</small>
                    <input name="email" type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email" value="<?php print(htmlspecialchars($_POST['email'])); ?>">
                    <?php if ($error['email'] === 'Blank'): ?>
                    <p class="text-danger">* Eメールを入力してください</p>
                    <?php endif; ?>
               </div>
               <div class="form-group">
                    <label for="exampleInputPassword1">Password</label>
                    <small id="passwordHelp" class="form-text text-danger">required</small>
                    <input name="password" type="password" class="form-control" id="exampleInputPassword1" placeholder="Password" value="<?php print(htmlspecialchars($_POST['password'])); ?>">
                    <?php if ($error['password'] === 'Length'): ?>
                    <p class="text-danger">* パスワードを4文字以上で入力してください</p>
                    <?php endif; ?>
                    <?php if ($error['password'] === 'Blank'): ?>
                    <p class="text-danger">* パスワードを入力してください</p>
                    <?php endif; ?>
               </div>
               <div class="form-group">
                    <input type="file" name="image" size="35" value="test">
                    <?php if ($error['image'] === 'type'): ?>
                         <p class="text-danger">* .jpg,.png,.gifの画像を指定してください</p>
                    <?php endif; ?>
                    <?php if (!empty($error) || $_REQUEST['action'] === 'rewrite'): ?>
                         <p class="text-danger">* 恐れ入りますが、画像を再度入力してください</p>
                    <?php endif; ?>
               </div>
               <button type="submit" class="btn btn-primary">Go To Check</button>
          </form>
     </div>
</body>
</html>
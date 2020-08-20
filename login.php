<?php
require('connectDB.php');

if (!empty($_POST)) {

     if ($_POST['email'] === '')  {
          $error['email'] = 'Blank';
     }

     if ($_POST['password'] === '') {
          $error['password'] = 'Blank';
     }

     $login = $db->prepare('SELECT * FROM members WHERE email=? AND password=?');
     $login->execute(array(
          $_POST['email'],
          sha1($_POST['password'])
     ));
     $member = $login->fetch();

     if ($member) {
          $_SESSION['email'] = $_POST['email'];
          $_SESSION['time'] = time();
          header('Location: index.php');
          exit();
     } else {
          $error['login'] = 'failed';
     }
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
     <h1 class="text-white text-center py-4">ログイン画面</h1>
     <div class="col-sm-6 mx-auto card mt-5">
          <form action="" method="post">
               <?php if ($error['login'] === 'failed'): ?>
                    <p class="text-danger">* ログインに失敗しました。正しくご記入ください</p>
               <?php endif; ?>
               <div class="form-group">
                    <label for="exampleInputEmail1">Email address</label>
                    <input name="email" type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter your email" value="<?php print(htmlspecialchars($_POST['email'])); ?>">
                    <?php if ($error['email'] === 'Blank'): ?>
                         <p class="text-danger">* Eメールを入力してください</p>
                    <?php endif; ?>
               </div>
               <div class="form-group">
                    <label for="exampleInputPassword1">Password</label>
                    <input name="password" type="password" class="form-control" id="exampleInputPassword1" placeholder="Password" value="<?php print(htmlspecialchars($_POST['password'])); ?>">
                    <?php if ($error['password'] === 'Blank'): ?>
                    <p class="text-danger">* パスワードを入力してください</p>
                    <?php endif; ?>
               </div>
               <button type="submit" class="btn btn-primary">Login</button>
               <a href="register/register.php">登録する</a>
          </form>
     </div>
</body>
</html>
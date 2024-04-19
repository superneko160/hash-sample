<?php
require_once 'Models/User.php';
session_start();

// フォームからPOST送信されてきた場合
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $errors = [];  // エラーメッセージを格納する配列

    // ユーザ名とパスワードが未入力の場合
    if (empty($_POST['name'])) {
        $errors[] = 'ユーザー名が未入力です';
    }
    if (empty($_POST['password'])) {
        $errors[] = 'パスワードが未入力です';
    }

    // ユーザ名とパスワードが入力されている場合
    if (!empty($_POST['name']) && !empty($_POST['password'])) {

        // ユーザ情報登録
        $user = new User();
        $result = $user->create($_POST['name'], $_POST['password']);

        // 登録に成功した場合、ログイン画面へ遷移
        //（本当はユーザが登録に成功したとわかりやすいようにメッセージ出したり、結果画面に遷移する必要有）
        if (!is_null($result)) {
            header("Location: login.php");
            exit();  // 上手く遷移しなかったときのための強制終了
        }

        // 正常に登録できなかった場合
        $errors[] = '正常にユーザが登録できませんでした';
    }
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SignUp</title>
</head>
<body>
    <!-- ユーザ名表示 -->
    <?php if (isset($_SESSION['name'])): ?>
        <p>ユーザ名：<?=$_SESSION['name']?>様</p>
    <?php endif; ?>

    <p>新規登録</p>
    <!-- 新規登録フォーム -->
    <form action="" method="post">
        ユーザ名：<input type="text" name="name" id="name"><br>
        パスワード：<input type="text" name="password" id="password"><br>
        <input type="submit" value="新規登録">
    </form>

    <!-- エラーメッセージ表示 -->
    <?php if (isset($errors)): ?>
        <ul>
        <?php foreach ($errors as $error): ?>
            <li style="color:red"><?=$error?></li>
        <?php endforeach; ?>
        </ul>
    <?php endif; ?>

    <a href="login.php">ログイン画面へ</a>
</body>
</html>
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

        // ユーザ名からユーザ情報取得
        $user = new User();
        $result = $user->getUserByName($_POST['name'], $_POST['password']);

        // ユーザ名とパスワードが一致しているか判定
        if (password_verify($_POST['password'], $result['password'])) {
            // ユーザ名とパスワードが一致していた場合、セッション変数にユーザ名を追加
            $_SESSION["name"] = $result['name'];

            // ここも本当が無事に完了できた旨を伝えるメッセージ等が必要
        }
        else {
            $errors[] = 'ユーザ名とパスワードが一致しませんでした';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>
    <!-- ユーザ名表示 -->
    <?php if (isset($_SESSION['name'])): ?>
        <p>ユーザ名：<?=$_SESSION['name']?>様</p>
    <?php endif; ?>

    <p>ログイン</p>
    <!-- ログインフォーム -->
        <form action="" method="post">
        ユーザ名：<input type="text" name="name" id="name"><br>
        パスワード：<input type="text" name="password" id="password"><br>
        <input type="submit" value="ログイン">
    </form>

        <!-- エラーメッセージ表示 -->
        <?php if (isset($errors)): ?>
        <ul>
        <?php foreach ($errors as $error): ?>
            <li style="color:red"><?=$error?></li>
        <?php endforeach; ?>
        </ul>
    <?php endif; ?>

    <a href="signup.php">新規登録画面へ</a>
</body>
</html>
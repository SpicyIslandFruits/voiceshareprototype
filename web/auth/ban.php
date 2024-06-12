<?php

require __DIR__ . '/middleware.php';

$session = getSession();

if ($session->role != \auth\Role::ADMIN) {
    http_response_code(400);
    echo "Access Denied";
    exit();
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>アカウント作成</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .signup-container {
            background-color: #fff;
            padding: 30px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        h1 {
            margin-top: 0;
        }

        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 12px 20px;
            margin: 8px 0;
            display: inline-block;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        button {
            background-color: #4CAF50;
            color: white;
            padding: 14px 20px;
            margin: 8px 0;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            width: 100%;
        }
    </style>
</head>
<body>
<div class="signup-container">
    <h1>アカウントBan</h1>
    <form action="handle-ban.php" method="post" enctype="multipart/form-data">
        <label for="username">ユーザーネーム(メールアドレス)</label>
        <input type="email" id="username" name="username" placeholder="ユーザーネームを入力" required>
        <button type="submit">Banする</button>
    </form>
</div>
</body>
</html>

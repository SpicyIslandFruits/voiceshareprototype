<?php

require __DIR__ . '/middleware.php';

$controller = getController();
$controller->handleSignin($_POST);

$session = getSession();
if ($session->role == \auth\Role::ADMIN) {
    echo '<a href="signup.php">管理者はこちらからアカウントを作成できます</a>';
} else if ($session->role == \auth\Role::ACTOR) {
    echo '<a href="../actor/profile.php">マイページはこちら</a>';
} else {
    echo "ログインに失敗しました";
}

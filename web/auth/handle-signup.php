<?php

require __DIR__ . '/middleware.php';

$authController = getController();

try {
    $id = $authController->handleSignup($_POST);
    echo "ID " . $id . 'のアカウントを作成しました';
    echo "<a href='../guest/profile.php?id=$id'>プロフィール画面を表示</a>";
} catch (\Exception $e) {
    \logger\err($e->getMessage());
}

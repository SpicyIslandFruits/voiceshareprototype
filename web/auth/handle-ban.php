<?php

require __DIR__ . '/middleware.php';

$session = authenticate();

if ($session->role->value === \auth\Role::ADMIN) {
    $controller = getController();
    $controller->handleDeleteAccountByAdmin($_POST);
    echo "管理者としてアカウントを削除しました";
    exit();
}

$controller = getController();
$controller->handleDeleteAccount($_POST);

$sessionRepo = new \filesystem\SessionRepo();
$sessionRepo->delete();

echo "アカウントを削除しました";

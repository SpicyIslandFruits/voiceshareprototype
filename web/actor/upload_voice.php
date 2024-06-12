<?php

require __DIR__ . '/middleware.php';

$session = authenticate();

if ($session->role != \auth\Role::ACTOR) {
    exit();
}

$storage = new \filesystem\VoiceStorage();
var_dump($_POST);
var_dump($_FILES);
getVoiceController()->upload($storage, $_POST, $_FILES, $session->accountId);

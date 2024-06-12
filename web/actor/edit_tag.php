<?php

require __DIR__ . '/middleware.php';

$session = authenticate();
$controller = getVoiceController();

$controller->editTag($_POST, $session->accountId);
echo "edit tag";

<?php

require __DIR__ . '/../vendor/autoload.php';

$sessionRepo = new \filesystem\SessionRepo();

var_dump($sessionRepo->get());

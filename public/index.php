<?php

include_once(__DIR__ . '/../bootstrap.php');

$service = new TKr\PassGen('test');
$passwords = $service->getPasswords();
var_dump($passwords);

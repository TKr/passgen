<?php

include_once(__DIR__ . '/../bootstrap.php');

$service = new TKr\PassGen('tost');
$passwords = $service->getPasswords();
var_dump($passwords);

var_dump(TKr\PassGen\Verify::verify('abcde'));
var_dump(TKr\PassGen\Verify::verify('a2C%e'));

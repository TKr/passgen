<?php

use TKr\PassService;
require_once __DIR__.'/bootstrap.php';

$service = new PassService;

$pass1 = $service->generateSecurePasswordString(6);
$pass2 = $service->generateSecurePasswordString(8);
$pass3 = $service->generateSecurePasswordString(10);
$pass4 = $service->generateSecurePasswordString(12);
$pass5 = $service->generateSecurePasswordString(14);
$pass6 = $service->generateSecurePasswordString(16);

?><!DOCTYPE html>
<html>
    <head>
        <style>
            body, input {
                font: normal 0.875rem/1.5rem "Fira Mono", "Source Code Pro", monospace;
            }
        </style>
    </head>
    <body>
        <span>6: <input onClick="this.select();" type="text" value="<?php echo $pass1?>"/></span><br/>
        <span>8: <input onClick="this.select();" type="text" value="<?php echo $pass2?>"/></span><br/>
        <span>10:<input onClick="this.select();" type="text" value="<?php echo $pass3?>"/></span><br/>
        <span>12:<input onClick="this.select();" type="text" value="<?php echo $pass4?>"/></span><br/>
        <span>14:<input onClick="this.select();" type="text" value="<?php echo $pass5?>"/></span><br/>
        <span>16:<input onClick="this.select();" type="text" value="<?php echo $pass6?>"/></span><br/>
    </body>
</html>

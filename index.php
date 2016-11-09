<?php

use TKr\PassService;
require_once __DIR__.'/bootstrap.php';

$service = new PassService;

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
        <span>6: <input onClick="this.select();" type="text" value="<?php echo $service->generateSecurePasswordString(6); ?>"/></span><br/>
        <span>8: <input onClick="this.select();" type="text" value="<?php echo $service->generateSecurePasswordString(8); ?>"/></span><br/>
        <span>10:<input onClick="this.select();" type="text" value="<?php echo $service->generateSecurePasswordString(10); ?>"/></span><br/>
        <span>12:<input onClick="this.select();" type="text" value="<?php echo $service->generateSecurePasswordString(12); ?>"/></span><br/>
        <span>14:<input onClick="this.select();" type="text" value="<?php echo $service->generateSecurePasswordString(14); ?>"/></span><br/>
        <span>16:<input onClick="this.select();" type="text" value="<?php echo $service->generateSecurePasswordString(16); ?>"/></span><br/>
    </body>
</html>

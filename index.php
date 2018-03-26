<?php

use TKr\PassService;
use TKr\ShannonEntropy;

require_once __DIR__.'/bootstrap.php';

$service = new PassService;

$pass1 = $service->generateSecurePasswordString(6);
$pass2 = $service->generateSecurePasswordString(8);
$pass3 = $service->generateSecurePasswordString(10);
$pass4 = $service->generateSecurePasswordString(12);
$pass5 = $service->generateSecurePasswordString(14);
$pass6 = $service->generateSecurePasswordString(16);
$pass7 = $service->generateSecurePasswordString(18);
$pass8 = $service->generateSecurePasswordString(20);

?><!DOCTYPE html>
<html>
    <head>
        <style>
            body, input {
                font: normal 0.875rem/1.5rem "Fira Mono", "Source Code Pro", monospace;
            }

            .worse {
                background-color: #ffeeee;
            }
            .bad {
                background-color: #fff8ee;
            }
            .acceptable {
                background-color: #eeffee;
            }




        </style>
    </head>
    <body>
    <span>6: <input class="worse" onClick="this.select();" type="text" value="<?php echo $pass1?>"/> Entropy: <?php echo ShannonEntropy::value($pass1); ?></span><br/>
        <span>8: <input class="worse" onClick="this.select();" type="text" value="<?php echo $pass2?>"/> Entropy: <?php echo ShannonEntropy::value($pass2); ?></span><br/>
        <span>10:<input class="bad" onClick="this.select();" type="text" value="<?php echo $pass3?>"/> Entropy: <?php echo ShannonEntropy::value($pass3); ?></span><br/>
        <span>12:<input class="bad" onClick="this.select();" type="text" value="<?php echo $pass4?>"/> Entropy: <?php echo ShannonEntropy::value($pass4); ?></span><br/>
        <span>14:<input class="bad" onClick="this.select();" type="text" value="<?php echo $pass5?>"/> Entropy: <?php echo ShannonEntropy::value($pass5); ?></span><br/>
        <span>16:<input class="acceptable" onClick="this.select();" type="text" value="<?php echo $pass6?>"/> Entropy: <?php echo ShannonEntropy::value($pass6); ?></span><br/>
        <span>18:<input class="acceptable" onClick="this.select();" type="text" value="<?php echo $pass7?>"/> Entropy: <?php echo ShannonEntropy::value($pass7); ?></span><br/>
        <span>20:<input class="acceptable" onClick="this.select();" type="text" value="<?php echo $pass8?>"/> Entropy: <?php echo ShannonEntropy::value($pass8); ?></span><br/>
    </body>
</html>
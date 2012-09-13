<?php

require_once "Sausage.php";

$s = new Sauce\Sausage(getenv('SAUCE_USERNAME'), getenv('SAUCE_ACCESS_KEY'));

$s->updateJob('0e2ae11933664d0ba26948d379fc67a6', array('passed'=>TRUE));

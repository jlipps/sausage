<?php

require_once "Sauce_Sausage.php";

$s = new Sauce\Sausage(getenv('SAUCE_USERNAME'), getenv('SAUCE_ACCESS_KEY'));

//$res = $s->updateJob('0e2ae11933664d0ba26948d379fc67a6', array('passed'=>TRUE));
//print_r($res);
//$res = $s->getAccountDetails();
//print_r($res);
//$res = $s->getAccountLimits();
//print_r($res);
$res = $s->createSubaccount(array('username'=>'jlippstest', 'email'=>'jlipps2@adsf.com', 'password'=>'testpass', 'name'=>"New Guy"));
print_r($res);

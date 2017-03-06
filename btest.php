<?php
$flag = "login";
$murl = "http://localhost/cs490/midcontrol.php";
//$marr = array ("flag" => $flag, 'ucid' => 'kenny', 'pass' => 'pizza');
$marr = array ("flag" => 'task', 'mode' => 'receive');

$ch = curl_init($murl);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $marr);
$chout = curl_exec($ch);
$rval = json_decode($chout, 1);

print('<pre>');
print_r($rval);
print('</pre>');

curl_close($ch);

?>
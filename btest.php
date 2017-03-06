<?php
//$flag = "login";

$murl = "http://localhost/cs490/midcontrol.php";
//$marr = array ("flag" => $flag, 'ucid' => 'kenny', 'pass' => 'pizza');
$marr = array ("flag" => 'task', 'mode' => 'checktask', 'cat' => 'statement', 'diff' => 0, 'quest' => 'Print the text: [Hello World] as output to the terminal.');

$burn = 0;
if($burn == 1){
	$marr = array ("flag" => 'test', 'mode' => 'burn');
}

$ch = curl_init($murl);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $marr);
$chout = curl_exec($ch);
$rval = json_decode($chout, 1);

print('<pre>');
//print_r($rval);
print('</pre>');

curl_close($ch);



?>
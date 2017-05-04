<?php
/*
getexampoints.php
Return points.
Created By: Oscar Rodriguez
*/

$backURL = "http://afsaccess2.njit.edu/~em244/CS490/getScore.php";
$jsonData = array('exam' => 'QQ');

$ch = curl_init($backURL);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
$result = curl_exec($ch);
curl_close($ch);

echo $result;

?>
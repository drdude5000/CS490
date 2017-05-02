<?php

$backURL = "http://afsaccess3.njit.edu/~em244/CS490/getFirstGrade.php";
$testData = array('studentName' => 'oscar');
$ch = curl_init($backURL);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $testData);
$result = curl_exec($ch);
curl_close($ch);

echo $result;

?>
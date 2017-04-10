<?php

$backURL = "http://afsaccess3.njit.edu/~em244/CS490/deleteQuestions.php";

$jsonData = array('prof' => 'profx'); 

$ch = curl_init($backURL);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
$result = curl_exec($ch);
curl_close($ch);

?>
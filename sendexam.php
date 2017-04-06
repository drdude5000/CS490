<?php

$backURL = "http://afsaccess3.njit.edu/~em244/CS490/createExam.php";
$ch2 = curl_init($backURL);
curl_setopt($ch2, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch2, CURLOPT_POST, true);
curl_setopt($ch2, CURLOPT_POSTFIELDS, $_POST);
$result = json_decode(curl_exec($ch2), 1);
curl_close($ch2);

?>
<?php

$backURL = "http://afsaccess3.njit.edu/~em244/CS490/getAllQuestions.php";
$ch2 = curl_init($backURL);

curl_setopt($ch2, CURLOPT_RETURNTRANSFER, true);
$result = curl_exec($ch2);
curl_close($ch2);
echo $result;

?>
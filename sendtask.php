<?php
/* 
sendtask.php
Send one question or task to the database.
Created By: Oscar Rodriguez
*/

$backURL = "http://afsaccess3.njit.edu/~em244/CS490/addQuestion.php";
$ch = curl_init($backURL);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $_POST);
$result = curl_exec($ch);
curl_close($ch);

print($result);
?>
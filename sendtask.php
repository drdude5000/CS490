<?php

$ptask = new Task();
$ptask->assimilate($_POST['cat'], $_POST['diff'], $_POST['quest']);

$backURL = "http://afsaccess3.njit.edu/~em244/CS490/addQuestion.php";
$ch2 = curl_init($backURL);

$marr =array('category' => $_POST['cat'], 'difficulty' => $_POST['diff'], 'question' => $_POST['quest']);
curl_setopt($ch2, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch2, CURLOPT_POST, true);
curl_setopt($ch2, CURLOPT_POSTFIELDS, $marr);
$result = json_decode(curl_exec($ch2), 1);
curl_close($ch2);

?>
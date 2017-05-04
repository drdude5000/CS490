<?php

include 'jhandle.php';

// Java Handling

$floc = 'pdir/taskList.txt';
$dfile = fopen($floc, 'r');
$tarr = fread($dfile, filesize($floc));
$tarr = json_decode($tarr, 1);
fclose($dfile);

$floc2 = 'pdir/ans.txt';
$dfile2 = fopen($floc2, 'r');
$ans = fread($dfile2, filesize($floc));
fclose($dfile2);

$fstudent = new Student();
$fstudent->input_answer($ans);
$fstudent->task = new Task();
$fstudent->task->localmerge($tarr[2]);


print("<pre>");
jhandle::gradetask($fstudent);
print_r($fstudent);
print("</pre>");



// Curling
/*
 $backURL = "http://afsaccess3.njit.edu/~em244/CS490/login.php";
 $ch2 = curl_init($backURL);

 $marr =array('ucid' => $_POST['ucid'], 'pass' => $_POST['pass']);
 curl_setopt($ch2, CURLOPT_RETURNTRANSFER, true);
 curl_setopt($ch2, CURLOPT_POST, true);
 curl_setopt($ch2, CURLOPT_POSTFIELDS, $marr);
 $result = json_decode(curl_exec($ch2));
 curl_close($ch2);
 echo $result;
 */


?>
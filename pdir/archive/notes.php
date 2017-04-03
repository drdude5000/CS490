<?php

$str1 = "getthat(x,y)";
$str2 = "getthat";

echo substr_count($str1, $str2);

echo 'yo';





















//Notes for compiling java
/*
$student_ans = 'System.out.println("Java\nin\nPHP");';

$jout = substr_replace($jstr, $student_ans, $jstart, 0);

$floc2 = 'pdir/o.java';
$jfile2 = fopen($floc2, 'w');
fwrite($jfile2, $jout);
fclose($jfile2);

exec('javac '.$floc2.' 2>&1', $err);
exec('java -cp pdir o', $output);
print('<pre>');
print(jhandle::sgrade('statement', '0', 'nada', $mytask));
print('</pre>');
*/
/*
$floc = 'qlist.txt';
$dfile = fopen($floc, 'r');
$tarr = fread($dfile, filesize($floc));
$tarr = json_decode($tarr, 1);
fclose($dfile);
print("<pre>");
print_r($tarr);
print("</pre>");
*/
?>
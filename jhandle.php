<?php

$jstart = 54;
$floc = 'pdir/def.java';
$jfile = fopen($floc, 'r');
$jstr = fread($jfile, filesize($floc));
fclose($jfile);

$student_ans = 'System.out.println("Hello Worldzzzzz\noiii\niii");';

$jout = substr_replace($jstr, $student_ans, $jstart, 0);

$floc2 = 'pdir/o.java';
$jfile2 = fopen($floc2, 'w');
fwrite($jfile2, $jout);
fclose($jfile2);

exec('javac '.$floc2);
exec('java -cp pdir o', $output);
print('<pre>');
print_r($output);
print('</pre>');
?>
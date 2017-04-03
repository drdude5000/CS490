<?php

$backURL = "http://afsaccess3.njit.edu/~em244/CS490/";

$floc = 'pdir/taskList.txt';
$dfile = fopen($floc, 'r');
$marr = fread($dfile, filesize($floc));
fclose($dfile);

echo $marr;

?>
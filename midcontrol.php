<?php
if (empty($_POST)){
	$rout = array('check' => 0);
	$jrout = json_encode($rout);
	echo $jrout;
}
else{
	$rout = array('check' => 1,'user' => 'Prof X', 'pass' => 123456);
	$jrout = json_encode($rout);
	echo $jrout;

}
?>
<?php
/*
midcontrol.php
Main php file that handles mid functions and classes.
Created By; Oscar Rodriguez
*/
include 'student.php';
include 'task.php';

if (empty($_POST)){	
	echo "No Post";
}

else{
	
	if($_POST['flag'] == 'login'){
		$backURL = "http://afsaccess3.njit.edu/~em244/CS490/login.php";
		$ch2 = curl_init($backURL);
		
		$marr =array('ucid' => $_POST['ucid'], 'pass' => $_POST['pass']);
		curl_setopt($ch2, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch2, CURLOPT_POST, true);
		curl_setopt($ch2, CURLOPT_POSTFIELDS, $marr);
		$result = curl_exec($ch2);
		curl_close($ch2);
		echo $result;

	}
	
	if($_POST['flag'] == 'task' && $_POST['mode'] == 'receive'){
		//Question Tempates
		$floc = 'pdir/taskList.txt';
		$dfile = fopen($floc, 'r');
		$marr = fread($dfile, filesize($floc));
		fclose($dfile);

		echo $marr;
		
	}

	if($_POST['flag'] == 'test' && $_POST['mode'] == 'burn'){
		$floc = 'pdir/testList.txt';
		$dfile = fopen($floc, 'w');
		fwrite($dfile, '[]');
	}
	
	if($_POST['flag'] == 'test' && $_POST['mode'] == 'view'){
		$floc1 = 'pdir/testList.txt';
		$dfile1 = fopen($floc1, 'r');
		$tarr = fread($dfile1, filesize($floc1));
		fclose($dfile1);
		echo $tarr;
	}
}
?>



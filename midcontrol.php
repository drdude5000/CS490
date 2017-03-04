<?php

if (empty($_POST)){	
	echo "No Post";
}
else{
	if($_POST['flag'] == 'login'){
		$floc = 'pdir/ulist.txt';
		$dfile = fopen($floc, 'r');		
		$marr = json_decode(fread($dfile, filesize($floc)), 1);
		fclose($dfile);
		
		$check = 0;
		foreach($marr as $val){
			foreach($val as $i => $j){
				if($i == 'ucid' && $j == $_POST['ucid']){
					$check = 1;
					continue;
				}
				if($i == 'pass' && $j == $_POST['pass'] && $check == 1)
					$check = 2;
				else
					$check = 0;
			}
			if($check == 2)
				break;
		}
		
		$rout = '';
		if($check == 2){
			$rout = "Login Successful as ".$_POST['ucid'];
		}
		else
			$rout = 'Unsuccessful Login';
		
		echo json_encode($rout);
		
	}
}
?>
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
		$utype = 0;
		foreach($marr as $val){
			foreach($val as $i => $j){
				if($i == 'ucid' && $j == $_POST['ucid']){				
					$check = 1;
					continue;
				}
				if($i == 'pass' && $j == $_POST['pass'] && $check == 1){
					$check = 2;
					break;
				}
				else
					$check = 0;
			}
			if($check == 2){
				$utype = $val['utype'];
				break;
			}
		}
		
		$rout = array();
		if($check == 2){
			array_push($rout, 1);
			array_push($rout, $utype);
		}
		else
			array_push($rout, 0);
		
			
		echo json_encode($rout);
		
	}
}
?>
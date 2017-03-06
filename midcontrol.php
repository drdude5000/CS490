<?php
include 'student.php';
include 'task.php';

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
	if($_POST['flag'] == 'task' && $_POST['mode'] == 'receive'){
		//Question Tempates
		$floc = 'pdir/qlist.txt';
		$dfile = fopen($floc, 'r');
		$marr = fread($dfile, filesize($floc));
		fclose($dfile);

		echo $marr;
		
	}
	if($_POST['flag'] == 'task' && $_POST['mode'] == 'checktask'){
				
		$ptask = new Task();
		$ptask->assimilate($_POST['cat'], $_POST['diff'], $_POST['quest']);
		
		if($ptask->validate_task_s1() != 0){
			$floc1 = 'pdir/testlist.txt';
			$dfile1 = fopen($floc1, 'r');
			$tarr = fread($dfile1, filesize($floc1));
			$tarr = json_decode($tarr, 1);
			fclose($dfile1);
			
			$floc2 = 'pdir/testlist.txt';
			$dfile2 = fopen($floc2, 'w');
			
			$ptask->createsample();
			//echo json_encode("Valid");
			
			array_push($tarr, $_POST['quest']);
			fwrite($dfile2, json_encode($tarr));
			fclose($dfile2);
			echo json_encode($ptask->ans);
		}
		else {
			echo json_encode("Invalid");
		}

		
	}
	if($_POST['flag'] == 'test' && $_POST['mode'] == 'burn'){
		$floc = 'pdir/testlist.txt';
		$dfile = fopen($floc, 'w');
		fwrite($dfile, '[]');
	}
	if($_POST['flag'] == 'test' && $_POST['mode'] == 'view'){
		$floc1 = 'pdir/testlist.txt';
		$dfile1 = fopen($floc1, 'r');
		$tarr = fread($dfile1, filesize($floc1));
		fclose($dfile1);
		echo $tarr;
	}
}
?>







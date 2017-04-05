<?php
/* 
	task.php
	This php file will contain the task class. It will
 * also contain the methods needed to validate a professor's task.
 * Created By: Oscar Rodriguez
 */

class Task {

	// The category the question pertains to.
	public $category;
	// The difficulty of the question  0-Easy 1-Medium 2-Hard
	public $difficulty;
	// Raw String data the question contains.
	public $text;
	// Sample Answer
	public $ans;
	// Important words
	public $words = array();
	// Tester method for difficult questions
	public $tester = array();
	
	
	function assimilate($cat, $diff, $text){
		$this->category = $cat;
		$this->difficulty = $diff;
		$this->text = $text;
	}
	
	// Step 1 validation of an inserted task
	function validate_task_s1(){
		$floc = 'pdir/taskList.txt';
		$qfile = fopen($floc, 'r');
		$marr = json_decode(fread($qfile, filesize($floc)), 1);
		
		$check = 0;
		$template = 0;
		foreach($marr as $var){
			foreach($var as $i => $j){
				if ($i == 'category' && $j == $this->category){
					$check = 1;
					continue;
				}
				if ($i == 'difficulty' && $j == $this->difficulty && $check == 1){
					$check = 2;
					$template = $var;
					break;
				}	
			}
			if($check == 2)
				break;
		}
		
		if($check == 2){
			$text = $this->text;
			$extemp = $template['text'];
			
			$count = substr_count($text, '[');
			$excount = substr_count($extemp, '[');
			if($count != $excount)
				return 0;
			
			for($i = 0; $i < $count; $i++){
				$left = strpos($text, '[');
				$exleft = strpos($extemp, '[');
				$right = strpos($text, ']');
				$exright = strpos($extemp, ']');
				$text = substr_replace($text, '', $left, $right - $left + 1);
				$extemp = substr_replace($extemp, '', $exleft, $exright - $exleft + 1);
			}
			
			if($text == $extemp)
				return 1;
			else 
				return 0;
		}
		else
			return 0;
	}
	
	function createSample(){
		$floc = 'pdir/slist.txt';
		$sfile = fopen($floc, 'r');
		$marr = json_decode(fread($sfile, filesize($floc)), 1);
		fclose($sfile);
		$text = $this->text;
		$ctemp;
		$extract = array();
		$count;
		
		$count = substr_count($text, '[');
		for ($i = 0; $i <$count; $i++){
			$left = strpos($text, '[');
			$right = strpos($text, ']');
			$substr = substr($text, $left+1, $right - $left - 1);
			$text = substr_replace($text, '', $left, $right - $left + 1);
			array_push($extract, $substr);
		}
		
		$this->words = $extract;
		if($this->category == 'statement' && $this->difficulty == 0){
			$ctemp =  $marr[0];
			$this->ans = substr_replace($ctemp, $extract[0], 20, 0);
			
		}
		elseif($this->category == 'statement' && $this->difficulty == 1){
			$ctemp =  $marr[1];
			$this->ans = substr_replace($ctemp, $extract[0].'('.$extract[1].','.$extract[2].');' , 0, 0);
			
			array_push($this->tester , 'public static void '.$extract[0].'(String x0, String x1){System.out.println(x0 + x1);}');
			array_push($this->tester, 'String '.$extract[1].' = "TEST";'.'String '.$extract[2].' = "TEST";');
				
		}
		elseif($this->category == 'loop' && $this->difficulty ==1){
			$tans = 'while ('.$extract[2].' < '.$extract[1].'){'.$extract[0].'();'.$extract[2].'++;}';
			$this->ans = $tans;
			array_push($this->tester, 'public static void '.$extract[0].'(){System.out.println("TEST");}');
			array_push($this->tester, 'int '.$extract[2].' = 0;');
		}
		elseif($this->category == 'method' && $this->difficulty == 0){
			$ctemp =  $marr[1];
			
			$methstr = '';
			$constr = '';
			$tester = '';
			for ($i = 0; $i < $extract[1]; $i++){
				$methstr .= 'String x'."$i".', ';
				$constr .= 'x'."$i".' + ';
				$tester .= '"TEST", ';
			}
			$methstr=rtrim($methstr);
			$methstr=rtrim($methstr, ',');
			$constr=rtrim($constr);
			$constr=rtrim($constr, '+');
			$tester=rtrim($tester);
			$tester=rtrim($tester, ',');
			
			$this->ans = substr_replace($ctemp, 'public static void '.$extract[0].'('."$methstr".'){ System.out.println('.$constr.');}', 0, 0);
			array_push($this->tester, $extract[0].'('.$tester.');');
			//print_r($this->ans);
		
		}
	}
	
}



?>
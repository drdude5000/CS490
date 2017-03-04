<?php
/* This php file will contain the task class. It will
 * also contain the methods needed to score a student's response to the 
 * task.
 * Created By: Oscar Rodriguez
 */

class task {

	// The category the question pertains to.
	public $category;
	// The difficulty of the question  0-Easy 1-Medium 2-Hard
	public $difficulty;
	// Raw String data the question contains.
	public $text;
	// Sample Answer
	public $ans;
	
	
	function assimilate($cat, $diff, $text){
		$this->category = $cat;
		$this->difficulty = $diff;
		$this->text = $text;
	}
	
	// Step 1 validation of an inserted task
	function validate_task_s1(){
		$floc = 'pdir/qlist.txt';
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
}

$mytask = new task();
$mytask->assimilate('method', 0, 'Define a public static method named [calctededehis] with 2 [intededeeger] parameters. You may name the the parameters. The method must [redfdfturn] the [prodfdfduct] of the integers and it must be a/an [intedfdfger].');
echo $mytask->validate_task_s1();


?>
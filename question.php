<?php
/* This php file will contain the question class. It will
 * also contain the methods needed to score a student's response to the 
 * question.
 * Created By: Oscar Rodriguez
 */

class question {

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
	
	function validate_question(){
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
			$wquest = $var['text']
		}
		return False;
	}
}

$myquestion = new question();
$myquestion->assimilate('statement', 0, 'Print the text: [Hello Poo] as output to the terminal.');
print_r($myquestion);

?>
<?php
/* 
	task.php
  	Created By: Oscar Rodriguez
 */

class Task {

	// The category the question pertains to.
	public $category;
	
	// The difficulty of the question  0-Easy 1-Medium 2-Hard
	public $difficulty;
	
	// Raw String data the question contains.
	public $text;

	public $returntype;

	public $methodname;
	
	public $argtypes = array();
	
	public $argnames = array();
	
	public $numtests;
	
	public $tinput = array();
	
	public $toutput = array();
	
		
	function assimilate($taskdata){
		$this->category = $taskdata["category"];
		$this->difficulty = $taskdata["difficulty"];
		$this->text = $taskdata["text"];
		$this->returntype = $taskdata["returntype"];
		$this->methodname = $taskdata["methodname"];
		$this->argtypes = $taskdata["argtypes"];
		$this->argnames = $taskdata["argnames"];
		$this->numtests = $taskdata["numtests"];
		$this->tinput = $taskdata["input"];
		$this->toutput = $taskdata["output"];
	}
	
	
}

?>
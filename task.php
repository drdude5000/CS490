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
		$this->text = $taskdata["question"];
		$this->returntype = $taskdata["returnType"];
		$this->methodname = $taskdata["methodName"];
		$this->argtypes = self::commasep($taskdata["argType"]);
		$this->argnames = self::commasep($taskdata["argName"]);
		$this->tinput = self::commasep($taskdata["tests"]["testcase"]);
		$this->toutput = self::commasep($taskdata["tests"]["testanswer"]);
		$this->numtests = count($this->toutput);
		$this->tinput = array($this->tinput);
	}
	
	function commasep($string){
		$marr = explode(",", $string);
		return $marr;
	}
	
}

?>
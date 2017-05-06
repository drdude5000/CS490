<?php
/*
task.php
Task structure
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
		if (count($this->argnames) == 1){
            if (empty($this->argnames[0])) {
                $this->argnames = array();
            }
        }

		$this->toutput = self::outputarray($taskdata["tests"]);
		$this->numtests = count($this->toutput);
		$this->tinput = self::inputarray($taskdata["tests"]);
		
		/*
		$cnt = 0;
		foreach($taskdata["tests"] as $temp){
			if($temp[$cnt] == 'testanswer')
				
		}
		*/
	}
	function inputarray($arr){
	    $rarr = array();
	    for($i = 0; $i < count($arr); $i++){
	        $temp = self::commasep($arr[$i]['testcase']);
            array_push($rarr, $temp);
        }
        return $rarr;
    }
    function outputarray($arr){
        $rarr = array();
        for($i = 0; $i < count($arr); $i++){
            $temp = $arr[$i]['testanswer'];
            array_push($rarr, $temp);
        }
        return $rarr;
    }
	function commasep($string){
		$marr = explode(",", $string);
		return $marr;
	}
	
	function localmerge($taskdata){
		$this->category = $taskdata["category"];
		$this->difficulty = $taskdata["difficulty"];
		$this->text = $taskdata["text"];
		$this->returntype = $taskdata["returntype"];
		$this->methodname = $taskdata["methodname"];
		$this->argtypes = $taskdata["argtypes"];
		$this->argnames = $taskdata["argnames"];
		$this->tinput = $taskdata["input"];
		$this->toutput = $taskdata["output"];
		$this->numtests = $taskdata["numtests"];
	}
	
}

?>
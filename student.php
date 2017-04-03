<?php
// student.php
// student info
class Student{
	public $answer;
	public $grievance = array();
	public $task;
	public $grade;
	
	function input_answer($ans){
		$this->answer = $ans;
	}
	
}
?>
<?php
/*
student.php
Student structure
Created By: Oscar Rodriguez
*/

class Student{
	public $answer;
	public $grievance = array();
	public $task;
	public $grade;
	public $bonuscheck = array();
	public $checkcases = array();
	
	function input_answer($ans){
		$this->answer = $ans;
	}
	
}
?>
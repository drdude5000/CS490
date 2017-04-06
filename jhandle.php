<?php

/* 
	jhandle.php
	Java Handler 
  	Created By: Oscar Rodriguez
 */
include 'task.php';
include 'student.php';

class jhandle{
	public static function getTemplate(){
		$floc = 'pdir/def.java';
		$jfile = fopen($floc, 'r');
		$jstr = fread($jfile, filesize($floc));
		fclose($jfile);
		return $jstr;
	}
	
	public static function prepJava($ans, $prep, $testnum){
		$jtemplate = self::getTemplate();
		$jans = "";
		$meth= "";
		$args = "";
		
		if(empty($prep->methodname)){
			$meth = "meth";
		}
		else{
			$meth = $prep->methodname;
		}
		
		$count = 0;
		foreach ($prep->argtypes as $type){
			$args .= $prep->tinput[$c]. ',';
			$count += 1;
		}
		$args = rtrim($args, ',');
		
		$meth = 'System.out.print(' . $meth . '(' . $args . '))' . ';';
		$jans = substr_replace($jtemplate, $meth, 54, 0);
		$jans = substr_replace($jans, $ans, 55 + strlen($meth), 0);

		return $jans;
	}

	public static function compileJava($ans){
		$floc = 'pdir/o.java';
		$jfile = fopen($floc, 'w');
		fwrite($jfile, $ans);
		fclose($jfile);
		exec('javac '.$floc.' 2>&1', $err);
		return $err;
	}
	
	public static function runJava(){
		$output;
		exec('java -cp pdir o', $output);
		return $output;
	}
	
		
		
	public static function  gradetask($student){
		
		$grieve = array();

		$sans = self::prepJava($student->answer, $student->task, 0);

		$serr = self::compileJava($sans);
		$sout = 0;
		
		if(empty($serr)){
			$sout = self::runJava();
		}
		else{
			$sout = array('ERROR');
		}
		
		$score = 0;
		
		if(empty($student->answer)){
			$score = 0;
		}
		
		if($score < 0){
			$score = 0;
		}
		
		$grieve = array_merge($serr, $grieve);
		$student->grievance = $grieve;
		$student->grade = $score;
		
	}
}

?>
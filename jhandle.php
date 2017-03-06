<?php
/* Java Handler 
 * Created By: Oscar Rodriguez
 */
include 'task.php';
include 'student.php';

$floc = 'pdir/qlist.txt';
$dfile = fopen($floc, 'r');
$tarr = fread($dfile, filesize($floc));
$tarr = json_decode($tarr, 1);
fclose($dfile);

$fstudent = new Student();
$fstudent->input_answer('Hello Poo System.out');
$fstudent->task = new Task();
$fstudent->task->assimilate('method', 0, $tarr[6]['text']);
$fstudent->task->validate_task_s1();
$fstudent->task->createsample();


print("<pre>");
jhandle::taskgrade($fstudent, $fstudent->task);
print_r($fstudent);
print("</pre>");


class jhandle{
	public static function getTemplate(){
		$floc = 'pdir/def.java';
		$jfile = fopen($floc, 'r');
		$jstr = fread($jfile, filesize($floc));
		fclose($jfile);
		return $jstr;
	}
	
	public static function prepJava($ans, $prepid, $tester){
		$jtemplate = self::getTemplate();
		$jans;
		if($prepid == 0){
			$jans = substr_replace($jtemplate, $ans, 54, 0);
		}
		elseif ($prepid == 1) {
			$jans = substr_replace($jtemplate, $tester, 54, 0);
			$jans = substr_replace($jans, $ans, 55 + strlen($tester), 0);
		}
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
	
		
		
	public static function  taskgrade($student, $task){
		$grieve = array();
		
		$rans = self::prepJava($task->ans, 1, $task->tester);
		$sans = self::prepJava($student->answer, 1, $task->tester);

		$rerr = self::compileJava($rans);
		$rout = self::runJava();
		
		$serr = self::compileJava($sans);
		$sout = 0;
		if(empty($serr)){
			$sout = self::runJava();
		}
		else{
			$sout = array('ERROR');
		}
		
		$score = 0;
		
		if(trim($rout[0]) == trim($sout[0]) && empty($serr)){
			$score = 100;
			array_push($grieve, 'Output Matches');
			
			if(strpos($student->answer, $task->words[0]) == 0){
				$score -= 10;
				array_push($grieve, 'Keyword '.$task->words[0].' not found -10');
			}
			if(substr_count($student->answer, 'System.out') > 1){
				$score -= 10;
				array_push($grieve, 'Keyword not found -10');
			}
		}
		elseif(!empty($serr)){
			$score = 30;
			if(strpos($student->answer, $task->words[0]) == 0){
				$score -= 20;
				array_push($grieve, 'Keyword '.$task->words[0].' not found -20');
			}
			else{
				$score += 10;
				array_push($grieve, 'Keyword '.$task->words[0].' found +10');
			}
			if(strpos($student->answer, 'System.out') == 0){
				$score -= 20;
				array_push($grieve, 'Keyword not found -20');
			}
			else{
				$score += 10;
				array_push($grieve, 'Keyword found +10');
			}
		}
			
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
<?php
/* Java Handler 
 * Created By: Oscar Rodriguez
 */
include 'task.php';

$mytask = new task();
$mytask->assimilate('statement', 0, 'Print the text: [Hello Poo] as output to the terminal.');
$mytask->validate_task_s1();
$mytask->createSample();

$myans = 'Hello Poo System.out';

print("<pre>");
print_r(jhandle::sgrade('statement', 0, $myans, $mytask));
//print_r($mytask->words);
print("</pre>");


class jhandle{
	public static function getTemplate(){
		$floc = 'pdir/def.java';
		$jfile = fopen($floc, 'r');
		$jstr = fread($jfile, filesize($floc));
		fclose($jfile);
		return $jstr;
	}
	
	public static function prepJava($ans, $prepid){
		$jtemplate = self::getTemplate();
		$jans;
		if($prepid == 0){
			$jans = substr_replace($jtemplate, $ans, 54, 0);
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
	
	public static function sgrade($cat, $diff, $ans, $task){
		
		if($cat == 'statement' && $diff == 0){
			$jans = self::prepJava($ans, 0);
			$score = self::sgrade_s0($ans, $task);
			return $score;
		}
		elseif($cat == 'statement' && $diff == 1){
			$jans = self::prepJava($ans, 0);
			$score = self::sgrade_s1($ans, $task);
		}
		elseif($cat == 'method' && $diff == 1){
			$jans = self::prepJava($ans, 0);
			$score = self::sgrade_s1($ans, $task);
		}
	}
	
	public static function sgrade_s0($ans, $task){
		$grieve = array();
		
		$rans = self::prepJava($task->ans, 0);
		$sans = self::prepJava($ans, 0);
		
		$rerr = self::compileJava($rans);
		$rout = self::runJava();
		
		$serr = self::compileJava($sans);
		$sout = 0;
		if(empty($serr))
			$sout = self::runJava();
		else 
			$sout = array('ERROR');
		
		$score = 0;
		
		if(trim($rout[0]) == trim($sout[0]) && empty($serr)){
			$score = 100;
			array_push($grieve, 'Output Matches');
			if(strpos($sans, $task->words[0]) == 0){
				$score -= 10;
				array_push($grieve, 'Keyword not found -10');
			}
			if(substr_count($sans, 'System.out') > 1){
				$score -= 10;
				array_push($grieve, 'Keyword not found -10');
			}
		}
		elseif(!empty($serr)){
			$score = 30;
			if(strpos($sans, $task->words[0]) == 0){
				$score -= 20;
				array_push($grieve, 'Keyword not found -20');
			}
			else{
				$score += 10;
				array_push($grieve, 'Keyword found +10');
			}
			if(strpos($sans, 'System.out') == 0){
				$score -= 20;
				array_push($grieve, 'Keyword not found -20');
			}
			else{
				$score += 10;
				array_push($grieve, 'Keyword found +10');
			}
		}
			
		if(empty($ans))
			$score = 0;
		
		if($score < 0)
			$score = 0;
		
		return $score;
	}
	
	public static function sgrade_s1($ans, $task){
		$rans = self::prepJava($task->ans, 0);
		$sans = self::prepJava($ans, 0);
		
		$rerr = self::compileJava($task->$ans);
		$rout = self::runJava();
		
		
		return 0;
	}
}

?>
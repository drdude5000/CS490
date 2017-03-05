<?php
/* Java Handler 
 * Created By: Oscar Rodriguez
 */
include 'task.php';

$mytask = new task();
$mytask->assimilate('statement', 0, 'Print the text: [Hello Poo] as output to the terminal.');
$mytask->validate_task_s1();
$mytask->createSample();

$myans = 'System.out.println("Hello Popppoo")';

print("<pre>");
print_r(jhandle::sgrade('statement', 0, $myans, $mytask));
print("</pre>");
/*

$jstr = jhandle::getTemplate(); 
$student_ans = 'System.out.println("Java\nin\nPHP");';

$jout = substr_replace($jstr, $student_ans, $jstart, 0);

$floc2 = 'pdir/o.java';
$jfile2 = fopen($floc2, 'w');
fwrite($jfile2, $jout);
fclose($jfile2);

exec('javac '.$floc2.' 2>&1', $err);
exec('java -cp pdir o', $output);
print('<pre>');
print(jhandle::sgrade('statement', '0', 'nada', $mytask));
print('</pre>');

*/

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
	}
	
	public static function sgrade_s0($ans, $task){
		$rans = self::prepJava($task->ans, 0);
		$sans = self::prepJava($ans, 0);
		
		$rerr = self::compileJava($rans);
		$rout = self::runJava();
		
		$serr = self::compileJava($sans);
		$sout = self::runJava();
		
		$verbose = "Not Equal";
		
		if(trim($rout[0]) == trim($sout[0]))
			$verbose = 'Equal';
		
		return $serr;
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
<?php
/*Posts
 *sName
 *testName
 *[0][1] are Student Answers
 */
include 'jhandle.php';

$studentanswers = array();
$alldata = array();

foreach($_POST as $data){
	array_push($alldata, $data);
}
for($i = 2; $i < count($alldata); $i++){
	array_push($studentanswers, $alldata[$i]);
}

$examData = array();
$taskarr = array();
$taskinfoarr = array();
if(!empty($alldata)){
	//Get Task List
	$examData = array('exam'=> $alldata[1]);
	$backURL = "http://afsaccess3.njit.edu/~em244/CS490/getTestQuestions.php";
	$ch = curl_init($backURL);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_POST, true);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $examData);
	$taskarr = json_decode(curl_exec($ch), 1);
	curl_close($ch);
	
	//Get Task Data
	foreach($taskarr as $minortask){
		$questionData = array("question"=> $minortask);
		
		$backURL = "http://afsaccess3.njit.edu/~em244/CS490/getQuestionRow.php";
		$ch = curl_init($backURL);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $questionData);
		$result = json_decode(curl_exec($ch), 1);
		curl_close($ch);
		array_push($taskinfoarr, $result);
	}
}

$bonusinfo = array();
$studentarr = array();
$totalgrade = 0;
for ($i = 0; $i < count($taskinfoarr); $i++){
	$fstudent = new Student();
	$fstudent->input_answer($studentanswers[$i]);
	$fstudent->task = new Task();
	$fstudent->task->assimilate($taskinfoarr[$i]);	
	jhandle::gradetask($fstudent);
	$totalgrade += $fstudent->grade;
	array_push($studentarr, $fstudent);
}
$totalgrade = $totalgrade / count($studentanswers);


print('<pre>');
echo "MID";
echo "<br>";
print("SCORE: " . $totalgrade);
echo "<br>";
$cnt = 1;
foreach($studentarr as $stud){
	echo "<br>";
	echo "Student Info Task #" . $cnt;
	echo "<br>";
	print_r($stud);
	$cnt += 1;
}
print('<pre>');
/*
$backURL = "http://afsaccess3.njit.edu/~em244/CS490/getGradedAnswers.php";
$ch = curl_init($backURL);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $_POST);
$result = curl_exec($ch);
curl_close($ch);
*/
?>
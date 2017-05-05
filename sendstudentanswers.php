<?php
/*
sendstudentanswers.php
Send graded test to database.
Created By: Oscar Rodriguez
*/

/*
Posts
sName
testName
[0][1] are Student Answers
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
$scorearr = array();
$taskinfoarr = array();
if(!empty($alldata)){
	//Get Task List
	$examData = array('exam'=> $alldata[1]);
	$backURL = "http://afsaccess2.njit.edu/~em244/CS490/getTestQuestions.php";
	$ch = curl_init($backURL);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_POST, true);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $examData);
	$taskarr = json_decode(curl_exec($ch), 1);
	curl_close($ch);
	
	//Get Task Data
	foreach($taskarr as $minortask){
		$questionData = array("question"=> $minortask);
		
		$backURL = "http://afsaccess2.njit.edu/~em244/CS490/getQuestionRow.php";
		$ch = curl_init($backURL);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $questionData);
		$result = json_decode(curl_exec($ch), 1);
		curl_close($ch);
		array_push($taskinfoarr, $result);
	}

	//Get Score Data
    $scoreURL = "http://afsaccess2.njit.edu/~or32/xr/getexampoints.php";
    $ch = curl_init($scoreURL);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $examData);
    $scorearr = json_decode(curl_exec($ch), 1);
    curl_close($ch);
}
$wholescore = 0;
foreach ($scorearr as $j){
    $wholescore += $j;
}
$bonusinfo = array();
$studentarr = array();
$totalgrade = array();
$fstudent = new Student();
for ($i = 0; $i < count($taskinfoarr); $i++){
	$fstudent->input_answer($studentanswers[$i]);
	$fstudent->task = new Task();
	$fstudent->task->assimilate($taskinfoarr[$i]);	
	jhandle::gradetask($fstudent);
	array_push($totalgrade,  $fstudent->grade);
	array_push($studentarr, $fstudent->grievance);
}
$jsonData = array();
$returngrade = 0;
if (count($studentanswers) != 0){
	if($wholescore == 0){
	    $gsum = 0;
	    foreach($totalgrade as $k){
	        $gsum += $k;
        }
        $returngrade = $gsum / count($studentanswers);
    }
    else{
	    $gcount = 0;
        foreach($i as $totalgrade){
            $returngrade += ($i * ($scorearr[$gcount] / $wholescore));
        }
    }

	$jsonData = array(	'studentName' => $alldata[0],
						'testName' => $alldata[1],
						'grade' => $returngrade,
						'grievance' => json_encode($studentarr)
	);
}

$backURL = "http://afsaccess2.njit.edu/~em244/CS490/addGrade.php";
$ch = curl_init($backURL);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
$result = curl_exec($ch);
curl_close($ch);


print('<pre>');
print_r($jsonData);
print_r($fstudent->checkcases);
print('</pre>');

?>
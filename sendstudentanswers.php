<?php
/*Posts
 *sName
 *testName
 *[0][1] are Student Answers
 */
if(!empty($_POST)){
	$studentname = $_POST['sName'];
	$testname = $_POST['testName'];
}
$gradedata = array();
// Get Questions for a specific test
/*
$backURL = "http://afsaccess3.njit.edu/~em244/CS490/getGradedAnswers.php";
$ch = curl_init($backURL);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $testname);
$result = curl_exec($ch);
curl_close($ch);
*/

$count = count($_POST) - 2;
$studentanswers = array();
$i = 0;
while ($i < $count){
	array_push($studentanswers, $_POST[$i]);
}

$testdata = array();
foreach($studentanswers as $ans){
	$tt = 0;
}

print('<pre>');
print_r($studentanswers);
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
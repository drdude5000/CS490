<?php
/* This php file will contain the question class. It will
 * also contain the methods needed to score a student's response to the 
 * question.
 * Created By: Oscar Rodriguez
 */

class question {
	// Raw String data the question contains.
	var $text;
	// The category the question pertains to.
	var $category;
	// The difficulty of the question  0-Easy 1-Medium 2-Hard
	var $difficulty;
	// Sample Answer
	var $sanswer;
	// An array containing important words that describe the question.
	var $dtags;
}

?>
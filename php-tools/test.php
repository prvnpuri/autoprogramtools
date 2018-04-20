<?php 
$testMethod=function($str){ return $str." is a string";};
$testMethod1="st";
echo is_callable($testMethod1)? "Is callable" : "Not callable"  ;
?>
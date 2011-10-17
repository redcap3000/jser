<?php
require('jser.php');
// Simple class with public parameters, these wont be stored to json representations.
class test_obj{
	public $a = array('key_name'=>'this and that', 'and this', 1);
	public $b = array(array(1,2),array('keyz'=>array('1','jello',1),1,'hello'));
}

// Making my object as normal
$a = new test_obj();

// Making another test object
$aa = new test_obj();

// Creating parameter in 'aa' object ..
$aa->d = array('1','2','3',array('1',2));

// Creating parameter in 'a' object
$a->newParam = 'parameter';

// Putting $aa object inside of 'a' as parameter named 'newObject'
$a->newObject = $aa;

// Convert object structure to 'streamlined' version (returns object)
$a = jser::encode($a);

$a = json_encode($a,JSON_NUMERIC_CHECK);

// Json stores numbered keys as assoc. keys... Need to fix this :(

$a = json_decode($a,true);

//die(print_r($a));
// Convert JSON to back to (somewhat) original object structure (returns php object)
print_r(jser::decode($a));

// Current limitations

// defining parameters in these ways does not play nice with the encode function ...
// bug fix to come shortly
//$f = new test_obj();
// bug .. doesn't handle objects inside of parameters  inside of objects as of late....
//$f->l = 'hi world';
//$aa->d = array('1','2','3',array('1',2), $f);
//$a->newObject->b = array(1,2,3);
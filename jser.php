<?php
/* 
 jser
 
 Advanced PHP object storage/retreval in JSON.

 Tested on PHP 5.3.6
 May not work on PHP 5.2 (but should)

 This class converts (almost) any php structure to a json structure, retaining
 class names and storing associtative array keys with its value, making json code
 smaller 
 
 Allows for child objects/arrays etc, does not store default class parameters (they
 are automatically added back when the object is recreated)

 Works with two recursive functions encode , which will convert an object
 structure into a 'streamlined' json representation (adding array keys to values where 
 available), with object class names.
 
 Decode does the opposite, converting the associative arrays and number-ordered arrays,
 taking the created 'class' array element and creating an object from itself.

 Current limitations do not allow for objects within parameters within objects .. 
 demonstrated in example.php

 Created out of the need to store class names in json objects ...

*/

class jser{

	public function encode($object){
		if(is_object($object)){
			$return []=get_class($object);
			$class_vars = array_keys(get_class_vars(get_class($object)));
			foreach($object as $x=>$y){
				// remove any parameters that already exist ...
				if(in_array($x,$class_vars)) unset($object->$x);
			}
			
			foreach($object as $param=>$value){
				if(!is_array($value) && !is_object($value))
					if(is_string($param))
						$return []= "$param:$value";
					else
						$return []= $value;
				else{
					$return [$param]= self::encode($value);
				}
			}
		
		return $return;
		}elseif(is_array($object)){
			foreach($object as $x=>$y){
				if(is_object($y))
					$return [$x] = self::encode($y);
				else
					$return [$x] = $y;	
			}
			return $return;
		}
	}
	
	public function decode($array){
		if(is_string($array[0]) && class_exists($array[0])){
		// this creates a new object .. need to be more specific here and disallow
		// strings with ':' or even add a symbol to designate an array spot as 
		// a 'class'	
			$classname = $array[0];
			$new_obj = new $classname;
			unset($array[0]);
		}elseif(is_string($array) && class_exists($array[0])){
			$new_obj= new $array;
		}else{
			// returns a 'flat' value that no longer needs recursion
			return $array;
		}
		if(is_array($array) || is_object($array))
			foreach($array as $a=>$b){
				if(is_string($b) && strpos($b,':') > 0 ){
					$temp = explode(':',$b,2);
					$new_obj->$temp[0] = $temp[1];
					print_r($new_obj);
				}elseif(is_array($b)){
					$new_obj->$a = self::decode($b);
				}elseif(is_object($b)){
					$new_obj->$a = self::decode($b);
				}	
			}
			
			return $new_obj;		
		
		}
	

}
jser
====
PHP object storage/retreval in JSON.
====================================

Ronaldo Barbachano
October 2011

* Tested on PHP 5.3.6
* May not work on PHP 5.2 (but should)

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

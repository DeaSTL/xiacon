<?php

$dictionary_link = new mysqli('localhost', 'root', '', 'entries');



class dictionary{

	function escape($link, $string){
		global $dictionary_link; 

    	return $dictionary_link->real_escape_string($string);
	}
} 
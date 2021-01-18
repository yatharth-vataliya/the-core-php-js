<?php 

function old($key = NULL){
	if(!empty($key) && !empty($_SESSION[$key])){
		$value = $_SESSION[$key];
		unset($_SESSION[$key]);
		return $value;
	}else{
		return NULL;
	}
}

?>
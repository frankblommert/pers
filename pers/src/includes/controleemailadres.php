<?php

function ctrlEmailAdres($value){
/*	if (!preg_match('"^[\w-]+@([\w-]+\.)+[\w-]+"',$value)){
		return false;
	}
	return true; */
	return preg_match('"^[\w-]+@([\w-]+\.)+[\w-]+"',$value);
}
?>
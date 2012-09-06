<?php
function ctrlNumeriek($value){
	if (is_numeric($value) && $value >= 0 ){
		return true;
	}
	return false;
}
?>
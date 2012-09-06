<?php
function ctrlDatumTijd($value){
	if (preg_match('"(\d{4})-(\d{2})-(\d{2}) (\d{2}):(\d{2}):(\d{2})"',$value)) {
		return true;
	}
	return false;
}
?>
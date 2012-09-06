<?php
/**
 * @author Frank Blommert, itsFrank
 */

class DB extends PDO{
    function __construct(){
        parent::__construct('mysql:host=localhost;port=3351;dbname=persmailnl_01', "fblommertedu", "ryq#duj9");
//        parent::__construct("mysql:host=localhost;dbname=persmailnl_01", "root", "root");
//        parent::__construct("mysql:host=localhost;dbname=test", "root", "root");
        $this->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
}
?>
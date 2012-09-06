<?php
require_once 'DBClasses/clsDB.php';

/**
 * @author Frank Blommert, itsFrank
 */

class clsDBPersmailPrijzen {

	
	private $dbh;


	public function __construct() {
		$this->dbh = new DB();
	}
	public function __destruct() {
		$this->dbh = null;
	}

	public function select() {
        
            $stmt = $this->dbh->prepare("call spSelectPersmailPrijzen()");
            $stmt->execute(); 
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }

	
}
?>
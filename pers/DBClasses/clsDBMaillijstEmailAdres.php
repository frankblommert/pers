<?php
require_once 'DBClasses/clsDB.php';

/**
 * @author Frank Blommert, itsFrank
 */

class clsDBMaillijstEmailAdres {

	private $dbh;

	public function __construct() {
		$this->dbh = new DB();
	}
	public function __destruct() {
		$this->dbh = null;
	}
	public function selectAll($p_iBedrijfID, $p_iMaillijstID) {
        try {
      	
            $stmt = $this->dbh->prepare("call spSelectMaillijstEmailAdressen(:p_bedrijfid,:p_maillijstid)");
            $stmt->bindParam(":p_bedrijfid", $p_iBedrijfID);
            $stmt->bindParam(":p_maillijstid", $p_iMaillijstID);

            $stmt->execute(); 
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
      
        } catch (PDOException $e) {
            throw $e;
        }
	}

	
		public function insert( $p_iBedrijfID,
								$p_iMaillijstID,
								$p_iEmailAdresID) {
				
        try {
            $stmt = $this->dbh->prepare("call spInsertMaillijstEmailAdres(:p_bedrijfid,
            															  :p_maillijstid,
																		  :p_emailadresid)");

            $stmt->bindParam(":p_bedrijfid", $p_iBedrijfID);
            $stmt->bindParam(":p_maillijstid", $p_iMaillijstID);
			$stmt->bindParam(":p_emailadresid", $p_iEmailAdresID);
            
            $stmt->execute(); 
            return ;
        } catch (PDOException $e) {
	        if (preg_match('"SQLSTATE\[23000\]: Integrity constraint violation: 1062 Duplicate entry.*"',$e)){
				return;
	        } else {
	            throw $e;
   		    }
        }		
	}

	public function delete($p_iBedrijfID,
						   $p_iMaillijstID,
						   $p_iEmailAdresID) {
        try {
            $stmt = $this->dbh->prepare("call spDeleteMaillijstEmailAdres(:p_bedrijfid,
            													:p_maillijstid,
																:p_emailadresid)");
			$stmt->bindParam(":p_bedrijfid", $p_iBedrijfID);
			$stmt->bindParam(":p_maillijstid", $p_iMaillijstID);
			$stmt->bindParam(":p_emailadresid", $p_iEmailAdresID);
            $stmt->execute(); 
            return true;
        } catch (PDOException $e) {
            throw $e;
        }		
	}
}
?>
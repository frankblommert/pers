<?php
require_once 'DBClasses/clsDB.php';

/**
 * @author Frank Blommert, itsFrank
 */

class clsDBEmailAdres {

	private $dbh;

	public function __construct() {
		$this->dbh = new DB();
	}
	public function __destruct() {
		$this->dbh = null;
	}
	public function selectAll($p_iBedrijfID) {
        try {
            $stmt = $this->dbh->prepare("call spSelectEmailAdressenBedrijfID(:p_id)");
            $stmt->bindParam(":p_id", $p_iBedrijfID);
            $stmt->execute(); 
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw $e;
        }
	}
	public function select($p_iBedrijfID ,$p_iEmailAdresID) {
        try {
            $stmt = $this->dbh->prepare("call spSelectEmailAdres(:p_bedrijfid , :p_emaladresid)");
            $stmt->bindParam(":p_bedrijfid", $p_iBedrijfID);
            $stmt->bindParam(":p_emaladresid", $p_iEmailAdresID);
            
            $stmt->execute(); 
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw $e;
        }
	}

	public function selectEmailAdres($p_iBedrijfID ,$p_sEmailAdres) {
        try {
            $stmt = $this->dbh->prepare("call spSelectEmailAdresEmailAdres(:p_bedrijfid , :p_emaladres)");
            $stmt->bindParam(":p_bedrijfid", $p_iBedrijfID);
            $stmt->bindParam(":p_emaladres", $p_sEmailAdres);
            
            $stmt->execute(); 
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw $e;
        }
	}
	
	public function selectMaillijsten($p_iBedrijfID ,$p_iEmailAdresID) {
        try {
            $stmt = $this->dbh->prepare("call spSelectEmaillijstenEmailAdresID(:p_bedrijfid , :p_emaladresid)");
            $stmt->bindParam(":p_bedrijfid", $p_iBedrijfID);
            $stmt->bindParam(":p_emaladresid", $p_iEmailAdresID);
            $stmt->execute(); 
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw $e;
        }
	}	
	
		public function insert( $p_iBedrijfID,
								$p_sEmailAdres) {
				
        try {
            $stmt = $this->dbh->prepare("call spInsertEmailAdres(:p_bedrijfid,
																:p_emailadres)");

            $stmt->bindParam(":p_bedrijfid", $p_iBedrijfID);
			$stmt->bindParam(":p_emailadres", $p_sEmailAdres);
            
            $stmt->execute(); 
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
	        if (preg_match('"SQLSTATE\[23000\]: Integrity constraint violation: 1062 Duplicate entry.*"',$e)){
				return $this->selectEmailAdres($p_iBedrijfID,$p_sEmailAdres); // bestaat al ID moet naar object
	        } else {
	            throw $e;
   		    }
        }		
	}
	public function update(	$p_iBedrijfID,
							$p_iEmailAdresID,
							$p_sEmailAdres) {
				
        try {
            $stmt = $this->dbh->prepare("call spUpdateEmailAdres(:p_bedrijfid,
																:p_emaladresid,
																:p_emailadres)");

            $stmt->bindParam(":p_bedrijfid", $p_iBedrijfID);
			$stmt->bindParam(":p_emaladresid", $p_iEmailAdresID);
			$stmt->bindParam(":p_emailadres", $p_sEmailAdres);

            $stmt->execute(); 

            return ;
        } catch (PDOException $e) {
            throw $e;
        }		
	}
	public function delete($p_iBedrijfID,$p_iEmailAdresID) {
        try {
            $stmt = $this->dbh->prepare("call spDeleteEmailAdres(:p_bedrijfid,
																:p_emaladresid)");
			$stmt->bindParam(":p_bedrijfid", $p_iBedrijfID);
			$stmt->bindParam(":p_emaladresid", $p_iEmailAdresID);
            $stmt->execute(); 
            return true;
        } catch (PDOException $e) {
            throw $e;
        }		
	}
}
?>
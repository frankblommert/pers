<?php
require_once 'DBClasses/clsDB.php';

/**
 * @author Frank Blommert, itsFrank
 */

class clsDBMaillijst {

	
	private $dbh;


	public function __construct() {
		$this->dbh = new DB();
	}
	public function __destruct() {
		$this->dbh = null;
	}
	public function selectAll($p_iBedrijfID) {
        try {
            $stmt = $this->dbh->prepare("call spSelectMaillijstenBedrijfID(:p_id)");
            $stmt->bindParam(":p_id", $p_iBedrijfID);
            $stmt->execute(); 
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw $e;
        }
	}
	public function select($p_iBedrijfID ,$p_iMaillijstID) {
        try {
            $stmt = $this->dbh->prepare("call spSelectMaillijst(:p_bedrijfid , :p_maillijstid)");
            $stmt->bindParam(":p_bedrijfid", $p_iBedrijfID);
            $stmt->bindParam(":p_maillijstid", $p_iMaillijstID);
            $stmt->execute(); 
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw $e;
        }
	}

		public function insert( $p_iBedrijfID,
								$p_sNaam,
								$p_sStatus) {
				
        try {
            $stmt = $this->dbh->prepare("call spInsertMaillijst(:p_bedrijfid,
																:p_naam,
																:p_status)");

            $stmt->bindParam(":p_bedrijfid", $p_iBedrijfID);
			$stmt->bindParam(":p_naam", $p_sNaam);
			$stmt->bindParam(":p_status", $p_sStatus);
            
            $stmt->execute(); 
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw $e;
        }		
	}
	public function update(	$p_iBedrijfID,
							$p_iMaillijstID,
							$p_sNaam,
							$p_sStatus) {
				
        try {
            $stmt = $this->dbh->prepare("call spUpdateMaillijst(:p_bedrijfid,
																:p_maillijstid,
																:p_naam,
																:p_status)");

            $stmt->bindParam(":p_bedrijfid", $p_iBedrijfID);
			$stmt->bindParam(":p_maillijstid", $p_iMaillijstID);
			$stmt->bindParam(":p_naam", $p_sNaam);
			$stmt->bindParam(":p_status", $p_sStatus);
            
            $stmt->execute(); 

            return ;
        } catch (PDOException $e) {
            throw $e;
        }		
	}
	public function delete($p_iBedrijfID,$p_iMaillijstID) {
        try {
            $stmt = $this->dbh->prepare("call spDeleteMaillijst(:p_bedrijfid,
																:p_maillijstid)");
			$stmt->bindParam(":p_bedrijfid", $p_iBedrijfID);
			$stmt->bindParam(":p_maillijstid", $p_iMaillijstID);
            $stmt->execute(); 
            return true;
        } catch (PDOException $e) {
            throw $e;
        }		
	}
}
?>
<?php
require_once 'DBClasses/clsDB.php';

/**
 * @author Frank Blommert, itsFrank
 */

class clsDBBetaling {

	
	private $dbh;


	public function __construct() {
		$this->dbh = new DB();
	}
	public function __destruct() {
		$this->dbh = null;
	}
	public function select($p_iBedrijfID,$p_iAccountID,$p_iBetalingID) {
        try {
        	
            $stmt = $this->dbh->prepare("call spSelectBetaling(:p_bedrijfid,:p_accountid,:p_betalingid)");
            $stmt->bindParam(":p_bedrijfid", $p_iBedrijfID);
            $stmt->bindParam(":p_accountid", $p_iAccountID);
            $stmt->bindParam(":p_betalingid", $p_iBetalingID);
            $stmt->execute(); 
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw $e;
        }
	}
	public function selectAll($p_iBedrijfID,$p_iAccountID) {
        try {
        	
            $stmt = $this->dbh->prepare("call spSelectBetalingAccountID(:p_bedrijfid,:p_accountid)");
            $stmt->bindParam(":p_bedrijfid", $p_iBedrijfID);
            $stmt->bindParam(":p_accountid", $p_iAccountID);
            $stmt->execute(); 
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw $e;
        }
	}

	public function insert(	$p_iBedrijfID,
							$p_iAccountID,
							$p_iBedrag,
							$p_sOmschrijving,
							$p_sStatus) {
				
        try {
            $stmt = $this->dbh->prepare("call spInsertBetaling(:p_bedrijfid,
																:p_accountid,
																:p_bedrag,
																:p_omschrijving,
																:p_status)");

            $stmt->bindParam(":p_bedrijfid", $p_iBedrijfID);
			$stmt->bindParam(":p_accountid", $p_iAccountID);
			$stmt->bindParam(":p_bedrag", $p_iBedrag);
			$stmt->bindParam(":p_omschrijving", $p_sOmschrijving);
			$stmt->bindParam(":p_status", $p_sStatus);

            $stmt->execute(); 
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw $e;
        }		
	}
	public function update(	$p_iBedrijfID,
							$p_iAccountID,
							$p_iBetalingID,
							$p_iBedrag,
							$p_sOmschrijving,
							$p_sStatus) {
				
        try {
            $stmt = $this->dbh->prepare("call spUpdateBetaling(:p_bedrijfid,
            													:p_accountid,
																:p_betalingid,
																:p_bedrag,
																:p_omschrijving,
																:p_status)");
																

            $stmt->bindParam(":p_bedrijfid", $p_iBedrijfID);
            $stmt->bindParam(":p_accountid", $p_iAccountID);
			$stmt->bindParam(":p_betalingid", $p_iBetalingID);
			$stmt->bindParam(":p_bedrag", $p_iBedrag);
			$stmt->bindParam(":p_omschrijving", $p_sOmschrijving);
			$stmt->bindParam(":p_status", $p_sStatus);
            
            $stmt->execute(); 

            return ;
        } catch (PDOException $e) {
            throw $e;
        }		
	}

}
?>
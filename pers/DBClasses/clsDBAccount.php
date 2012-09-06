<?php
require_once 'DBClasses/clsDB.php';

/**
 * @author Frank Blommert, itsFrank
 */

class clsDBAccount {

	
	private $dbh;


	public function __construct() {
		$this->dbh = new DB();
	}
	public function __destruct() {
		$this->dbh = null;
	}

	public function select($p_iBedrijfID) {
        try {
            $stmt = $this->dbh->prepare("call spSelectAccount(:p_bedrijfid)");
            $stmt->bindParam(":p_bedrijfid", $p_iBedrijfID);
            $stmt->execute(); 
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw $e;
        }
	}

	public function insert(	$p_iBedrijfID,
							$p_iAccountid,
							$p_iCredits,
							$p_sStatus) {
				
        try {
            $stmt = $this->dbh->prepare("call spInsertAccount(:p_bedrijfid,
																:p_accountid,
																:p_credits,
																:p_status)");

            $stmt->bindParam(":p_bedrijfid", $p_iBedrijfID);
			$stmt->bindParam(":p_accountid", $p_iAccountid);
			$stmt->bindParam(":p_credits", $p_iCredits);
			$stmt->bindParam(":p_status", $p_sStatus);

            $stmt->execute(); 
            return; 
        } catch (PDOException $e) {
            throw $e;
        }		
	}
	public function update(	$p_iBedrijfID,
							$p_iAccountid,
							$p_iCredits,
							$p_sStatus) {
				
        try {
            $stmt = $this->dbh->prepare("call spUpdateAccount(:p_bedrijfid,
																:p_accountid,
																:p_credits,
																:p_status)");

            $stmt->bindParam(":p_bedrijfid", $p_iBedrijfID);
			$stmt->bindParam(":p_accountid", $p_iAccountid);
			$stmt->bindParam(":p_credits", $p_iCredits);
			$stmt->bindParam(":p_status", $p_sStatus);
            
            $stmt->execute(); 

            return ;
        } catch (PDOException $e) {
            throw $e;
        }		
	}

}
?>
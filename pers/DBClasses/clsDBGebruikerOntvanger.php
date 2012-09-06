<?php
require_once 'DBClasses/clsDB.php';

/**
 * @author Frank Blommert, itsFrank
 */

class clsDBGebruikerOntvanger {

	
	private $dbh;


	public function __construct() {
		$this->dbh = new DB();
	}
	public function __destruct() {
		$this->dbh = null;
	}

	public function select($p_iID) {
        try {
            $stmt = $this->dbh->prepare("call spSelectGebruikerOntvanger(:p_id)");
            $stmt->bindParam(":p_id", $p_iID);
            $stmt->execute(); 
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw $e;
        }
	}
	public function selectGebruikersnaam($p_sGebruikersnaam) {
        try {
            $stmt = $this->dbh->prepare("call spSelectGebruikerOntvangerGebruikersnaam(:p_id)");
            $stmt->bindParam(":p_id", $p_sGebruikersnaam);
            $stmt->execute(); 
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw $e;
        }
	}
	public function insert(	$p_iBedrijfID,
							$p_sEmailadres,
							$p_sVoornaam,
							$p_sTussenvoegsel,
							$p_sAchternaam,
							$p_sTelefoonnummer,
							$p_dDatumTijd,
							$p_sAfdeling) {
				
        try {
            $stmt = $this->dbh->prepare("call spInsertGebruikerBedrijf(:p_bedrijfid,
																	:p_emailadres,
																	:p_voornaam,
																	:p_tussenvoegsel,
																	:p_achternaam,
																	:p_telefoonnummer,
																	:p_datumTijd,
																	:p_afdeling)");
										            
            
  
            
            $stmt->bindParam(":p_bedrijfid", $p_iBedrijfID);
			$stmt->bindParam(":p_emailadres", $p_sEmailadres);
			$stmt->bindParam(":p_voornaam", $p_sVoornaam);
			$stmt->bindParam(":p_tussenvoegsel", $p_sTussenvoegsel);
			$stmt->bindParam(":p_achternaam", $p_sAchternaam);
			$stmt->bindParam(":p_telefoonnummer", $p_sTelefoonnummer);
			$stmt->bindParam(":p_datumTijd", $p_dDatumTijd);
			$stmt->bindParam(":p_afdeling", $p_sAfdeling);
            
            $stmt->execute(); 
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw $e;
        }		
	}
	public function update(	$p_iID,
							$p_iBedrijfID,
							$p_sEmailadres,
							$p_sVoornaam,
							$p_sTussenvoegsel,
							$p_sAchternaam,
							$p_sTelefoonnummer,
							$p_dDatumTijd,
							$p_sAfdeling) {
				
        try {
            $stmt = $this->dbh->prepare("call spUpdateGebruikerBedrijf(:p_id,
            														:p_bedrijfid,
																	:p_emailadres,
																	:p_voornaam,
																	:p_tussenvoegsel,
																	:p_achternaam,
																	:p_telefoonnummer,
																	:p_datumTijd,
																	:p_afdeling)");
										            
            
  
            $stmt->bindParam(":p_id", $p_iID);
            $stmt->bindParam(":p_bedrijfid", $p_iBedrijfID);
			$stmt->bindParam(":p_emailadres", $p_sEmailadres);
			$stmt->bindParam(":p_voornaam", $p_sVoornaam);
			$stmt->bindParam(":p_tussenvoegsel", $p_sTussenvoegsel);
			$stmt->bindParam(":p_achternaam", $p_sAchternaam);
			$stmt->bindParam(":p_telefoonnummer", $p_sTelefoonnummer);
			$stmt->bindParam(":p_datumTijd", $p_dDatumTijd);
			$stmt->bindParam(":p_afdeling", $p_sAfdeling);
            
            $stmt->execute(); 
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw $e;
        }		
	}
	public function delete($p_iID) {
        try {
            $stmt = $this->dbh->prepare("call spDeleteGebruikerOntvanger(:id)");
            $stmt->bindParam(":id", $p_iID);
            $stmt->execute(); 
            return true;
        } catch (PDOException $e) {
            throw $e;
        }		
	}
}
?>
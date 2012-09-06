<?php
require_once 'DBClasses/clsDB.php';

/**
 * @author Frank Blommert, itsFrank
 */

class clsDBGebruikerBedrijf {

	
	private $dbh;


	public function __construct() {
		$this->dbh = new DB();
	}
	public function __destruct() {
		$this->dbh = null;
	}
	public function selectAll($p_iBedrijfID) {
        try {
        	
            $stmt = $this->dbh->prepare("call spSelectGebruikersBedrijfBedrijfID(:p_id)");
            $stmt->bindParam(":p_id", $p_iBedrijfID);
            $stmt->execute(); 
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw $e;
        }
	}
	public function selectHoofdGebruiker($p_iBedrijfID) {
        try {
            $stmt = $this->dbh->prepare("call spSelectHoofdGebruikerBedrijfBedrijfID(:p_id)");
            $stmt->bindParam(":p_id", $p_iBedrijfID);
            $stmt->execute(); 
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw $e;
        }
	}
	public function select($p_iID) {
        try {
            $stmt = $this->dbh->prepare("call spSelectGebruikerBedrijf(:p_id)");
            $stmt->bindParam(":p_id", $p_iID);
            $stmt->execute(); 
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw $e;
        }
	}
	public function selectGebruikersnaam($p_sGebruikersnaam) {
        try {
        	
            $stmt = $this->dbh->prepare("call spSelectGebruikerBedrijfGebruikersnaam(:p_gebruikersnaam)");
            $stmt->bindParam(":p_gebruikersnaam", $p_sGebruikersnaam);
            $stmt->execute(); 
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw $e;
        }
	}

	public function insert( $p_iBedrijfID,
							$p_sGebruikersnaam,
							$p_sWachtwoord,
							$p_sStatus,
							$p_iInlogPogingen, 
							$p_sEmailadres,
							$p_sVoornaam,
							$p_sTussenvoegsel,
							$p_sAchternaam,
							$p_sTelefoonnummer,
							$p_sPersoneelsnummer,
							$p_sRechten,
							$p_sHoofdebruiker) {			
        try {
            $stmt = $this->dbh->prepare("call spInsertGebruikerBedrijf(:p_bedrijfid,
																	:p_gebruikersnaam,
																	:p_wachtwoord,
																	:p_status,
																	:p_inlogpogingen, 
																	:p_emailadres,
																	:p_voornaam,
																	:p_tussenvoegsel,
																	:p_achternaam,
																	:p_telefoonnummer,
																	:p_personeelsnummer,
																	:p_rechten,
																	:p_hoofdgebruiker)");
																						            


			$stmt->bindParam(":p_bedrijfid", $p_iBedrijfID);
			$stmt->bindParam(":p_gebruikersnaam", $p_sGebruikersnaam);
			$stmt->bindParam(":p_wachtwoord", $p_sWachtwoord);
			$stmt->bindParam(":p_status", $p_sStatus);
			$stmt->bindParam(":p_inlogpogingen", $p_iInlogPogingen); 
			$stmt->bindParam(":p_emailadres",$p_sEmailadres);
			$stmt->bindParam(":p_voornaam", $p_sVoornaam);
			$stmt->bindParam(":p_tussenvoegsel", $p_sTussenvoegsel);
			$stmt->bindParam(":p_achternaam", $p_sAchternaam);
			$stmt->bindParam(":p_telefoonnummer", $p_sTelefoonnummer);
			$stmt->bindParam(":p_personeelsnummer", $p_sPersoneelsnummer);
			$stmt->bindParam(":p_rechten", $p_sRechten);	
			$stmt->bindParam(":p_hoofdgebruiker", $p_sHoofdebruiker);
            $stmt->execute(); 
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw $e;
        }		
	}
	public function update(	$p_iID,
							$p_iBedrijfID,
							$p_sGebruikersnaam,
							$p_sWachtwoord,
							$p_sStatus,
							$p_iInlogPogingen, 
							$p_sEmailadres,
							$p_sVoornaam,
							$p_sTussenvoegsel,
							$p_sAchternaam,
							$p_sTelefoonnummer,
							$p_sPersoneelsnummer,
							$p_sRechten,
							$p_sHoofdebruiker) {
				
        try {
            $stmt = $this->dbh->prepare("call spUpdateGebruikerBedrijf(:p_id,
            														:p_bedrijfid,
																	:p_gebruikersnaam,
																	:p_wachtwoord,
																	:p_status,
																	:p_inlogpogingen, 
																	:p_emailadres,
																	:p_voornaam,
																	:p_tussenvoegsel,
																	:p_achternaam,
																	:p_telefoonnummer,
																	:p_personeelsnummer,
																	:p_rechten,
																	:p_hoofdgebruiker)");
										            
            
  
            $stmt->bindParam(":p_id", $p_iID);
            $stmt->bindParam(":p_bedrijfid", $p_iBedrijfID);
			$stmt->bindParam(":p_gebruikersnaam", $p_sGebruikersnaam);
			$stmt->bindParam(":p_wachtwoord", $p_sWachtwoord);
			$stmt->bindParam(":p_status", $p_sStatus);
			$stmt->bindParam(":p_inlogpogingen", $p_iInlogPogingen); 
			$stmt->bindParam(":p_emailadres",$p_sEmailadres);
			$stmt->bindParam(":p_voornaam", $p_sVoornaam);
			$stmt->bindParam(":p_tussenvoegsel", $p_sTussenvoegsel);
			$stmt->bindParam(":p_achternaam", $p_sAchternaam);
			$stmt->bindParam(":p_telefoonnummer", $p_sTelefoonnummer);
			$stmt->bindParam(":p_personeelsnummer", $p_sPersoneelsnummer);
			$stmt->bindParam(":p_rechten", $p_sRechten);
            $stmt->bindParam(":p_hoofdgebruiker", $p_sHoofdebruiker);
            $stmt->execute(); 
            return; 
        } catch (PDOException $e) {
            throw $e;
        }		
	}
	public function delete($p_iID) {
        try {
            $stmt = $this->dbh->prepare("call spDeleteGebruikerBedrijf(:id)");
            $stmt->bindParam(":id", $p_iID);
            $stmt->execute(); 
            return true;
        } catch (PDOException $e) {
            throw $e;
        }		
	}
}
?>
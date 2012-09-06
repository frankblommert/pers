<?php
require_once('DBClasses/clsDBGebruikerBedrijf.php');
require_once('FuncClasses/clsGebruiker.php');
require_once('src/includes/controlesgebruikerbedrijf.php');

/**
 * @access public
 * @author Frank Blommert, itsFrank
 * @package PersMailBedrijf
 */
class clsGebruikerBedrijf extends clsGebruiker {

	private $m_iBedrijfID;

	private $m_sPersoneelsnummer;

	private $m_sRechten;

	public $m_sHoofdgebruiker;


	/**
	 * @access public
	 */
	public function __construct($p_iID = 0) {
		parent::__construct();
		if ($p_iID != 0){
			$this->laad($p_iID);
		}
	}
	
	public function __destruct() {
		$m_iBedrijfID = null;
		$m_sPersoneelsnummer = null;
		$m_sRechten = null;
		$m_sHoofdgebruiker = null;
		parent::__destruct();
	}
	
	public function laad($p_iID) {
		try {
	   	$objDBGebruikerBedrijf = new clsDBGebruikerBedrijf();
		$rs = $objDBGebruikerBedrijf->select($p_iID);
        $this->setm_iBedrijfID($rs['BedrijfID']);
        $this->setm_sGebruikernaam($rs['Gebruikersnaam']);
        $this->setm_sWachtwoord($rs['Wachtwoord']);
		$this->setm_sStatus($rs['Status']);
		$this->setm_iInlogPogingen($rs['InlogPogingen']);
		$this->setm_sEmailAdres($rs['Emailadres']);
		$this->setm_sVoornaam($rs['Voornaam']);			
		$this->setm_sTussenvoegsel($rs['Tussenvoegsel']);
		$this->setm_sAchternaam($rs['Achternaam']);
		$this->setm_sTelefoonnummer($rs['Telefoonnummer']);
        $this->setm_sPersoneelsnummer($rs['Personeelsnummer']);
		$this->setm_sRechten($rs['Rechten']);
		$this->setm_sHoofdgebruiker($rs['Hoofdgebruiker']);
		$this->setm_iID($rs['ID']);
		return;
		}
	catch (Exception $e) {
	echo ("Fatal Error: " . $e->getMessage() );
}
		
	}
	
	public function voegToe() {
		try {
			$objDBGebruikerBedrijf = new clsDBGebruikerBedrijf();
			
			$rs = $objDBGebruikerBedrijf->insert($this->getm_iBedrijfID(),		
												$this->getm_sGebruikernaam(),
												$this->getm_sWachtwoord(),
												$this->getm_sStatus(),
												$this->getm_iInlogPogingen(),							        
												$this->getm_sEmailAdres(),							
												$this->getm_sVoornaam(),
												$this->getm_sTussenvoegsel(),
												$this->getm_sAchternaam(),
												$this->getm_sTelefoonnummer(),
												$this->getm_sPersoneelsnummer(),
												$this->getm_sRechten(),
												$this->getm_sHoofdgebruiker()); 
			$this->setm_iID($rs['ID']);
	        return;
		} catch (PDOException $e) {
            throw $e;
        }		
	}
	
	public function wijzig() {
		try{
			
			$objDBGebruikerBedrijf = new clsDBGebruikerBedrijf();
			$objDBGebruikerBedrijf->update($this->getm_iID(),
								        $this->getm_iBedrijfID(),
										$this->getm_sGebruikernaam(),
										$this->getm_sWachtwoord(),
										$this->getm_sStatus(),
										$this->getm_iInlogPogingen(),							        
										$this->getm_sEmailAdres(),							
										$this->getm_sVoornaam(),
										$this->getm_sTussenvoegsel(),
										$this->getm_sAchternaam(),
										$this->getm_sTelefoonnummer(),
										$this->getm_sPersoneelsnummer(),
										$this->getm_sRechten(),
										$this->getm_sHoofdgebruiker()); 
			
	        return;
        } catch (PDOException $e) {
            throw $e;
        }		
	}
	
		public function hoofdGebruiker($p_iID) {
			try {
			   	$objDBGebruikerBedrijf = new clsDBGebruikerBedrijf();			   	
				$rs = $objDBGebruikerBedrijf->selectHoofdGebruiker($p_iID);
		        $this->setm_iBedrijfID($rs['BedrijfID']);
		        $this->setm_sGebruikernaam($rs['Gebruikersnaam']);
		        $this->setm_sWachtwoord($rs['Wachtwoord']);
				$this->setm_sStatus($rs['Status']);
				$this->setm_iInlogPogingen($rs['InlogPogingen']);
				$this->setm_sEmailAdres($rs['Emailadres']);
				$this->setm_sVoornaam($rs['Voornaam']);			
				$this->setm_sTussenvoegsel($rs['Tussenvoegsel']);
				$this->setm_sAchternaam($rs['Achternaam']);
				$this->setm_sTelefoonnummer($rs['Telefoonnummer']);
		        $this->setm_sPersoneelsnummer($rs['Personeelsnummer']);
				$this->setm_sRechten($rs['Rechten']);
				$this->setm_sHoofdgebruiker($rs['Hoofdgebruiker']);
				$this->setm_iID($rs['ID']);
				return;
			}
			catch (Exception $e) {
				echo ("Fatal Error: " . $e->getMessage() );
			}
		}
		
	
		public function GebruikerGebruikersnaam($p_sGebruikersnaam) {
			try { 
			   	$objDBGebruikerBedrijf = new clsDBGebruikerBedrijf();			   	
				$rs = $objDBGebruikerBedrijf->selectGebruikersnaam($p_sGebruikersnaam);
		        $this->setm_iBedrijfID($rs['BedrijfID']);
		        $this->setm_sGebruikernaam($rs['Gebruikersnaam']);
		        $this->setm_sWachtwoord($rs['Wachtwoord']);
				$this->setm_sStatus($rs['Status']);
				$this->setm_iInlogPogingen($rs['InlogPogingen']);
				$this->setm_sEmailAdres($rs['Emailadres']);
				$this->setm_sVoornaam($rs['Voornaam']);			
				$this->setm_sTussenvoegsel($rs['Tussenvoegsel']);
				$this->setm_sAchternaam($rs['Achternaam']);
				$this->setm_sTelefoonnummer($rs['Telefoonnummer']);
		        $this->setm_sPersoneelsnummer($rs['Personeelsnummer']);
				$this->setm_sRechten($rs['Rechten']);
				$this->setm_sHoofdgebruiker($rs['Hoofdgebruiker']);
				$this->setm_iID($rs['ID']);
				return true;
			}
			catch (Exception $e) {
				echo ("Fatal Error: " . $e->getMessage() );
			}
		}
		
		
	public function getm_iBedrijfID() {
		return $this->m_iBedrijfID;
	}

	public function setm_iBedrijfID($value) {
		if(ctrlBedrijfID($value)){
			$this->m_iBedrijfID = $value;
		} else {
			throw new exception('BedrijfID bevat ongeldige waarde');
		}
	}

	public function getm_sPersoneelsnummer() {
		return $this->m_sPersoneelsnummer;
	}

	public function setm_sPersoneelsnummer($value) {
		
		if(ctrlPersoneelsnummer($value || $value == null)){
			$this->m_sPersoneelsnummer = $value;
		} else {
			throw new exception('Personeelsnummer bevat ongeldige waarde');
		}		
	}

	public function getm_sRechten() {
		return $this->m_sRechten;
	}

	public function setm_sRechten($value) {
		if(ctrlRechten($value)){
			$this->m_sRechten = $value;			
		} else {
			throw new exception('Rechten bevat ongeldige waarde');
		}
	}

	public function getm_sHoofdgebruiker() {
		return $this->m_sHoofdgebruiker;
	}

	public function setm_sHoofdgebruiker($value) {
		if(ctrlHoofdgebruiker($value)){
			$this->m_sHoofdgebruiker = $value;			
		} else {
			throw new exception('Hoofdgebruiker bevat ongeldige waarde');
		}
	}
}
?>
<?php

require_once ('FuncClasses/clsPersoon.php');
require_once ('DBClasses/clsDBContactpersoon.php');
require_once ('src/includes/controlescontactpersoon.php');

/**
 * @access public
 * @author Frank Blommert, itsFrank
 * @package PersMailBedrijf
 */
class clsContactpersoon extends clsPersoon {

	private $m_iBedrijfID;

	private $m_sAfdeling;

	public function laad($p_iID) {
		try {
		   	$objDBContactpersoon = new clsDBContactpersoon();
			$rs = $objDBContactpersoon->select($p_iID);
			$this->setm_iID($rs['ID']);
	        $this->setm_iBedrijfID($rs['BedrijfID']);
	        $this->setm_sAfdeling($rs['Afdeling']);
			$this->setm_sEmailAdres($rs['Emailadres']);
			$this->setm_sVoornaam($rs['Voornaam']);
			$this->setm_sTussenvoegsel($rs['Tussenvoegsel']);
			$this->setm_sAchternaam($rs['Achternaam']);
			$this->setm_sTelefoonnummer($rs['Telefoonnummer']);

	        return;
        } catch (PDOException $e) {
            throw $e;
        }		
	}
	

	public function voegToe() {
		try {
			$objDBContactpersoon = new clsDBContactpersoon();
			
			$rs = $objDBContactpersoon->insert($this->getm_iBedrijfID(),
										$this->getm_sEmailAdres(),
										$this->getm_sVoornaam(),
										$this->getm_sTussenvoegsel(),
										$this->getm_sAchternaam(),
										$this->getm_sTelefoonnummer(),
										$this->getm_sAfdeling()); 
			$this->setm_iID($rs['ID']); 
	        return;
		} catch (PDOException $e) {
            throw $e;
        }		
	}
	
	public function wijzig() {
		try{
		
			$objDBContactpersoon = new clsDBContactpersoon();
			$objDBContactpersoon->update($this->getm_iID(),
								        $this->getm_iBedrijfID(),
										$this->getm_sEmailAdres(),
										$this->getm_sVoornaam(),
										$this->getm_sTussenvoegsel(),
										$this->getm_sAchternaam(),
										$this->getm_sTelefoonnummer(),
										$this->getm_sAfdeling());
	        return;
        } catch (PDOException $e) {
            throw $e;
        }		
	}
	/**
	 * @access public
	 */
	public function __construct($p_iID=0) {
		parent::__construct();
		if($p_iID !=0){
			$this->laad($p_iID);
		}
	}
	public function __destruct() {
		$m_iBedrijfID = null;
		$m_sAfdeling = null;
		parent::__destruct();
	}
	/**
	 * @return the $m_iBedrijfID
	 */
	public function getm_iBedrijfID() {
		return $this->m_iBedrijfID;
	}

	/**
	 * @param field_type $m_iBedrijfID
	 */
	public function setm_iBedrijfID($value) {
		if(ctrlBedrijfID($value)){
			$this->m_iBedrijfID = $value;
		} else {
			throw new Exception('BedrijfID bevat ongeldige waarde');
		}
	}

	/**
	 * @return the $m_sAfdeling
	 */
	public function getm_sAfdeling() {
		return $this->m_sAfdeling;
	}

	/**
	 * @param field_type $m_sAfdeling
	 */
	public function setm_sAfdeling($value) {
		if(ctrlAfdeling($value)){
			$this->m_sAfdeling = $value;
		} else {
			throw new Exception('Afdeling bevat ongeldige waarde');
		}
	}

}
?>
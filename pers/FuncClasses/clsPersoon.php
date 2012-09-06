<?php

require_once('src/includes/controlespersoon.php');

/**
 * @access public
 * @author Frank Blommert, itsFrank
 * @package PersMailBedrijf
 */

class clsPersoon {

	private $m_sEmailAdres;

	private $m_sVoornaam;

	private $m_sTussenvoegsel;

	private $m_sAchternaam;

	private $m_sTelefoonnummer;

	private $m_iID;
	
	public function getNaam() {
		return trim($this->getm_sVoornaam()).' '.trim($this->getm_sTussenvoegsel()).' '.trim($this->getm_sAchternaam());
	}

	/**
	 * @access public
	 */
	public function __construct() {
		// Not yet implemented
	}
	public function __destruct() {
		$m_sEmailAdres = null;;
		$m_sVoornaam = null;
		$m_sTussenvoegsel = null;
		$m_sAchternaam = null;
		$m_sTelefoonnummer = null;
		$m_iID = null;
	}
	/**
	 * @return the $m_sEmailAdres
	 */
	public function getm_sEmailAdres() {
		return $this->m_sEmailAdres;
	}

	/**
	 * @param field_type $m_sEmailAdres
	 */
	public function setm_sEmailAdres($value) {
		if(ctrlEmailAdres($value)){
				$this->m_sEmailAdres = $value;
			} else {
				throw new exception('Emailadres bevat ongeldige waarde');
			}	
	}

	/**
	 * @return the $m_sVoornaam
	 */
	public function getm_sVoornaam() {	
		return $this->m_sVoornaam;
	}

	/**
	 * @param field_type $m_sVoornaam
	 */
	public function setm_sVoornaam($value) {
		if(ctrlVoornaam($value)){
			$this->m_sVoornaam = $value;
		} else {
			throw new exception('Voornaam bevat ongeldige waarde');	
		}
	}

	/**
	 * @return the $m_sTussenvoegsel
	 */
	public function getm_sTussenvoegsel() {
		return $this->m_sTussenvoegsel;
	}

	/**
	 * @param field_type $m_sTussenvoegsel
	 */
	public function setm_sTussenvoegsel($value) {
		if(ctrlTussenvoegsel($value)){
			$this->m_sTussenvoegsel = $value;
		} else {
			throw new exception('Tussemvoegsel bevat ongeldige waarde');	
		}
	}

	/**
	 * @return the $m_sAchternaam
	 */
	public function getm_sAchternaam() {
		return $this->m_sAchternaam;
	}

	/**
	 * @param field_type $m_sAchternaam
	 */
	public function setm_sAchternaam($value) {
		if(ctrlAchternaam($value)){
			$this->m_sAchternaam = $value;
		} else {
			throw new exception('Achternaam bevat ongeldige waarde');	
		}
	}

	/**
	 * @return the $m_sTelefoonnummer
	 */
	public function getm_sTelefoonnummer() {
		return $this->m_sTelefoonnummer;
	}

	/**
	 * @param field_type $m_sTelefoonnummer
	 */
	public function setm_sTelefoonnummer($value) {
		if(ctrlTelefoonnummer($value)){
			$this->m_sTelefoonnummer = $value;
		} else {
			throw new exception('Telefoonummer bevat ongeldige waarde');	
		}	
	}

	/**
	 * @return the $m_iID
	 */
	public function getm_iID() {
		return $this->m_iID;
	}

	/**
	 * @param field_type $m_iID
	 */
	public function setm_iID($value) {
		if(ctrlID($value)){
			$this->m_iID = $value;
		} else {
			throw new exception('Persoon ID bevat ongeldige waarde');	
		}
	}

}
?>
<?php

require_once('FuncClasses/clsPersoon.php');
require_once('src/includes/controlesgebruiker.php');
/**
 * @access public
 * @author Frank Blommert, itsFrank
 * @package PersMailBedrijf
 */
class clsGebruiker extends clsPersoon {

	private $m_sGebruikernaam;

	private $m_sWachtwoord;

	private $m_sStatus;

	private $m_iInlogPogingen;

	public function __construct() {
		parent::__construct();
	}
	public function __destruct() {
		$m_sGebruikernaam = null;
		$m_sWachtwoord = null;
		$m_sStatus = null;
		$m_iInlogPogingen = null;

		parent::__destruct();
	}
	
	public function getm_sGebruikernaam() {
		return $this->m_sGebruikernaam;
	}

	public function setm_sGebruikernaam($value) {
		if(ctrlGebruikersnaam($value)){
			$this->m_sGebruikernaam = $value;
		} else {
			throw new exception('Gebruikernaam bevat onfgeldige waarde');
		}
	}

	public function getm_sWachtwoord() {
		return $this->m_sWachtwoord;
	}

	public function setm_sWachtwoord($value) {
		if(ctrlWachtwoord($value)){
			$this->m_sWachtwoord = $value;
		} else {
			throw new exception('Wachtwoord bevat onfgeldige waarde');
		}
		
	}

	public function getm_sStatus() {
		return $this->m_sStatus;
	}

	public function setm_sStatus($value) {
		if (ctrlStatusGebruiker($value)){
			$this->m_sStatus = $value;
		} else {
			throw new exception('Status gebruiker bevat onfgeldige waarde');	
		}	
	}

	public function getm_iInlogPogingen() {
		return $this->m_iInlogPogingen;
	}

	public function setm_iInlogPogingen($value) {
		if(ctrlInlogPogingen($value)){
			$this->m_iInlogPogingen = $value;	
		} else {
			$this->setm_sStatus('geblokkeerd');
			$this->wijzig();
			throw new exception('Gebruiker geblokkeerd! Teveel inlogpogingen');
		}
	}

}
?>
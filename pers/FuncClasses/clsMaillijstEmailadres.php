<?php
require_once('DBClasses/clsDBMaillijstEmailAdres.php');
require_once ('src/includes/controlesmaillijstemailadres.php');

/**
 * @access public
 * @author Frank Blommert, itsFrank
 * @package PersMailBedrijf
 */
class clsMaillijstEmailAdres {

	private $m_iBedrijfID;

	private $m_iMaillijstID;

	private $m_iEmailAdresID;

	public function voegToe() {
	   	$objDBMaillijstEmailAdres = new clsDBMaillijstEmailAdres();
		$objDBMaillijstEmailAdres->insert($this->getm_iBedrijfID(),
								$this->getm_iMaillijstID(),
								$this->getm_iEmailAdresID());
		return true;
	}
	public function verwijder() {
	   	$objDBMaillijstEmailAdres = new clsDBMaillijstEmailAdres();
		$objDBMaillijstEmailAdres->delete($this->getm_iBedrijfID(),
								$this->getm_iMaillijstID(),
								$this->getm_iEmailAdresID());
		return;
	}
	public function __construct($p_iBedrijfID = 0,$p_iMaillijstID = 0,$p_iEmailAdresID = 0) {
		if($p_iBedrijfID != 0 && $p_iMaillijstID != 0 && $p_iEmailAdresID != 0){
			$this->laad($p_iBedrijfID,$p_iMaillijstID,$p_iEmailAdresID);
		}
	}
	public function __destruct() {
		$m_iBedrijfID = null;
		$m_iMaillijstID = null;
		$m_iEmailAdresID = null;
	}
	
	public function laad($p_iBedrijfID,$p_iMaillijstID,$p_iEmailAdresID) {
		$this->setm_iBedrijfID($p_iBedrijfID);
		$this->setm_iMaillijstID($p_iMaillijstID);
		$this->setm_iEmailAdresID($p_iEmailAdresID);
		return;
	}
	
	public function getm_iBedrijfID() {
		return $this->m_iBedrijfID;
	}

	public function setm_iBedrijfID($value) {
		if(ctrlBedrijfID($value)){
			$this->m_iBedrijfID = $value;
		} else {
			throw new exception('BedrijfID ongeldig of ongelijk BedrijfID gebruiker '.$value);
		}
	}

	public function getm_iMaillijstID() {
		return $this->m_iMaillijstID;
	}

	public function setm_iMaillijstID($value) {
		if(ctrlMaillijstID($value)){
			$this->m_iMaillijstID = $value;
		} else {
			throw new exception('MaillijstID bevat ongeldige waarde '.$value);
		}
	}

	public function getm_iEmailAdresID() {
		return $this->m_iEmailAdresID;
	}

	public function setm_iEmailAdresID($value) {
		if(ctrlEmailAdresID($value)){
			$this->m_iEmailAdresID = $value;
		} else {
			throw new exception('EmailAdresID MaillijstEmailAdres bevat ongeldige waarde '.$value);
		}
	}
}
?>

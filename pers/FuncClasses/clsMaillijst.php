<?php

require_once('DBClasses/clsDBMaillijst.php');
require_once('FuncClasses/clsMaillijstEmailAdres.php');
require_once('FuncClasses/clsEmailAdres.php');
require_once('src/includes/controlesmaillijst.php');

/**
 * @access public
 * @author Frank Blommert, itsFrank
 * @package PersMailBedrijf
 */
class clsMaillijst {

	private $m_iBedrijfID;

	private $m_iMaillijstID;

	private $m_sNaam;

	private $m_sStatus;

	private $m_colEmailAdressen = array();
	
	public function __construct($p_iBedrijfID = 0, $p_iMaillijstID = 0) {
		if ($p_iBedrijfID != 0 && $p_iMaillijstID != 0){
			$this->laad($p_iBedrijfID ,$p_iMaillijstID);
		}
		$m_colEmailAdressen = array();
	}
	
	public function __destruct() {
		$m_iBedrijfID = null;
		$m_iMaillijstID = null;
		$m_sNaam = null;
		$m_sStatus = null;
		$m_colEmailAdressen = null;
		$objDBMaillijst = null;
		$objDBMaillijstEmailAdres  = null;
		$objEmailAdres = null;
		$rs = null;
	}

	public function laad($p_iBedrijfID , $p_iMaillijstID) {
		
	   	$objDBMaillijst = new clsDBMaillijst();
		$rs = $objDBMaillijst->select($p_iBedrijfID ,$p_iMaillijstID);
		$this->setm_iMaillijstID($rs['MaillijstID']);
        $this->setm_iBedrijfID($rs['BedrijfID']);
        $this->setm_sNaam($rs['Naam']);	
        $this->setm_sStatus($rs['Status']);
        return;
	}
	
	public function voegToe() {
	   	$objDBMaillijst = new clsDBMaillijst();
		$rs = $objDBMaillijst->insert($this->getm_iBedrijfID(),
						        	$this->getm_sNaam(),
									$this->getm_sStatus());

		$this->setm_iMaillijstID($rs['MaillijstID']);
		return;
	}
	
	public function wijzig($p_iMaillijstID) {
	   	$objDBMaillijst = new clsDBMaillijst();
		$objDBMaillijst->update($this->getm_iBedrijfID(),
							$this->getm_iMaillijstID(),
					        $this->getm_sNaam(),
							$this->getm_sStatus());
		return;
	}
	
	public function verwijder($p_iMaillijstID) {
	   	$objDBMaillijst = new clsDBMaillijst();
		$objDBMaillijst->delete($this->getm_iMaillijstID());
		return;
	}
// opbouw collection emailadressen bij een maillijst	
	public function emailadressen() {
		$objDBMaillijstEmailAdres = new clsDBMaillijstEmailAdres();
		foreach($objDBMaillijstEmailAdres->selectAll($this->getm_iBedrijfID(), $this->getm_iMaillijstID()) as $rs){
			array_push($this->m_colEmailAdressen,new clsEmailAdres($rs['BedrijfID'],$rs['EmailAdresID'])); // voeg object MaillijstEmailAdres toe aan emailadressen collection
		};
	 	return $this->m_colEmailAdressen;
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

	public function getm_sNaam() {
		return $this->m_sNaam;
	}

	public function setm_sNaam($value) {
		if(ctrlNaamMaillijst($value)){
			$this->m_sNaam = $value;
		} else {
			throw new exception('Naam maillijst niet gevuld of bevat ongeldige waarde '.$value);
		}
	}

	public function getm_sStatus() {
		return $this->m_sStatus;
	}

	public function setm_sStatus($value) {
		if(ctrlStatusMaillijst($value)){
			$this->m_sStatus = $value;
		} else {
			throw new exception('Status maillijst bevat ongeldige waarde '.$value);
		}
	}
}
?>
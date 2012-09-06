<?php

require_once ('src/includes/controlesemailadres.php');
require_once('DBClasses/clsDBEmailAdres.php');

/**
 * @access public
 * @author Frank Blommert, itsFrank
 * @package PersMailBedrijf
 */
class clsEmailAdres {

	private $m_iBedrijfID;

	private $m_iEmailAdresID;
	
	private $m_sEmailAdres;

	/**
	 * @access public
	 */
	public function __construct($p_iBedrijfID = 0 , $p_iEmailAdresID = 0 ) {
		if ($p_iBedrijfID != 0 && $p_iEmailAdresID != 0){
				$this->laad($p_iBedrijfID ,$p_iEmailAdresID);
			}
	}
	public function __destruct() {
		$m_iBedrijfID = null;
		$m_iEmailAdresID = null;
		$m_sEmailAdres = null;
		
	}
	
	public function laad($p_iBedrijfID , $p_iEmailAdresID) {
  
	   	$objDBEmailAdres = new clsDBEmailAdres();

		$rs = $objDBEmailAdres->select($p_iBedrijfID ,$p_iEmailAdresID);
		$this->setm_iEmailAdresID($rs['EmailAdresID']);
        $this->setm_iBedrijfID($rs['BedrijfID']);
        $this->setm_sEmailAdres($rs['EmailAdres']);	
        return;
	}
	
	public function voegToe() {
	   	$objDBEmailAdres = new clsDBEmailAdres();
		$rs = $objDBEmailAdres->insert($this->getm_iBedrijfID(),
									$this->getm_sEmailAdres());
		$this->setm_iEmailAdresID($rs['EmailAdresID']);
		return true;
	}
	
	public function wijzig() {
	   	$objDBEmailAdres = new clsDBEmailAdres();
		$objDBEmailAdres->update($this->getm_iBedrijfID(),
							$this->getm_iEmailAdresID(),
							$this->getm_sEmailAdres());
		return;
	}
	
	public function verwijder() {
	   	$objDBEmailAdres = new clsDBEmailAdres();
		$objDBEmailAdres->delete($this->getm_iBedrijfID() ,$this->getm_iEmailAdresID());
		return;
	}
	
	
	public function getm_iBedrijfID() {
		return $this->m_iBedrijfID;
	}

	public function setm_iBedrijfID($value) {
		if(ctrlBedrijfID($value)){
			$this->m_iBedrijfID = $value;
		} else {
			throw new Exception('BedrijfID bevat ongeldige waarde');
		}
	}

	public function getm_iEmailAdresID() {
		return $this->m_iEmailAdresID;
	}

	public function setm_iEmailAdresID($value) {
		if(ctrlEmailAdresID($value)){
			$this->m_iEmailAdresID = $value;
		} else {
			throw new Exception('EmailAdresID bevat ongeldige waarde');
		}
	}	
	
	public function getm_sEmailAdres() {
		return $this->m_sEmailAdres;
	}

	public function setm_sEmailAdres($value) {
		if(ctrlEmailAdres($value)){
				$this->m_sEmailAdres = $value;
			} else {
				throw new exception('Emailadres bevat ongeldige waarde');
			}
	}
}
?>

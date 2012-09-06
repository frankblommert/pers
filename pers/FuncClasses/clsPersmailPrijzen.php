<?php
require_once('DBClasses/clsDBPersmailPrijzen.php');
require_once('FuncClasses/clsBetaling.php');
require_once('src/includes/controlenumeriek.php');

/**
 * @access public
 * @author Frank Blommert, itsFrank
 * @package PersMailBedrijf
 */
class clsPersmailPrijzen {

	private $m_iAbonnement;

	private $m_iCredit;



	public function __construct() {
		
		   	$objDBPersmailPrijzen = new clsDBPersmailPrijzen();
			$rs = $objDBPersmailPrijzen->select($p_iBedrijfID);
	        $this->setm_iAbonnement($rs['Abonnement']);
	        $this->setm_iCredit($rs['Credit']);
			return;
	}

		

	public function __destruct() {
		$m_iAbonnement = null;
		$m_iCredit = null;

	}

	public function getm_iAbonnement() {
		return $this->m_iAbonnement;
	}

	private function setm_iAbonnement($value) {
		if(ctrlNumeriek($value)){
			$this->m_iAbonnement = $value;
		} else {
			throw new exception('Abonnementprijs bevat ongeldige waarde clsPersmailPrijzen');
		}
		
	}

	public function getm_iCredit() {
		return $this->m_iCredit;
	}

	private function setm_iCredit($value) {
		if(ctrlNumeriek($value)){
			$this->m_iCredit = $value;
		} else {
			throw new exception('Creditprijs bevat ongeldige waarde clsPersmailPrijzen');
		}
	}

}
?>
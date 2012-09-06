<?php
require_once(realpath(dirname(__FILE__)) . '/../PersMailBedrijf/clsCategorieOntvanger.php');
require_once(realpath(dirname(__FILE__)) . '/../PersMailBedrijf/clsGebruiker.php');

/**
 * @access public
 * @author Frank Blommert, itsFrank
 * @package PersMailBedrijf
 */
class clsGebruikerOntvanger extends clsGebruiker {
	/**
	 * @AttributeType string
	 */
	private $m_sStraatnaam;
	/**
	 * @AttributeType int
	 */
	private $m_iHuisnummer;
	/**
	 * @AttributeType string
	 */
	private $m_im_sHuisnummerToev;
	/**
	 * @AttributeType string
	 */
	private $m_sPostcode;
	/**
	 * @AttributeType string
	 */
	private $m_sPlaats;
	/**
	 * @AttributeType string
	 */
	private $m_sLand;
	/**
	 * @AssociationType PersMailBedrijf.clsCategorieOntvanger
	 * @AssociationMultiplicity 1..*
	 */
	public $unnamed_clsCategorieOntvanger_ = array();

	/**
	 * @access public
	 */
	public function getm_sStraatnaam() {
		// Not yet implemented
	}

	/**
	 * @access public
	 * @param $value
	 * @return void
	 * 
	 * @ReturnType void
	 */
	public function setm_sStraatnaam($_value) {
		// Not yet implemented
	}

	/**
	 * @access public
	 * @return int
	 * @ReturnType int
	 */
	public function getm_iHuisnummer() {
		// Not yet implemented
	}

	/**
	 * @access public
	 * @param $value
	 * @return void
	 * 
	 * @ReturnType void
	 */
	public function setm_iHuisnummer($_value) {
		// Not yet implemented
	}

	/**
	 * @access public
	 * @return string
	 * @ReturnType string
	 */
	public function getm_sPostcode() {
		// Not yet implemented
	}

	/**
	 * @access public
	 * @param $value
	 * @return void
	 * 
	 * @ReturnType void
	 */
	public function setm_sPostcode($_value) {
		// Not yet implemented
	}

	/**
	 * @access public
	 * @return string
	 * @ReturnType string
	 */
	public function getm_sPlaats() {
		// Not yet implemented
	}

	/**
	 * @access public
	 * @param $value
	 * @return void
	 * 
	 * @ReturnType void
	 */
	public function setm_sPlaats($_value) {
		// Not yet implemented
	}

	/**
	 * @access public
	 */
	public function getm_sHuisnummerToev() {
		// Not yet implemented
	}

	/**
	 * @access public
	 * @param $value
	 * @return void
	 * 
	 * @ReturnType void
	 */
	public function setm_sHuisnummerToev($_value) {
		// Not yet implemented
	}

	/**
	 * @access public
	 * @return string
	 * @ReturnType string
	 */
	public function getm_sLand() {
		// Not yet implemented
	}

	/**
	 * @access public
	 * @param string m_sLand
	 * @return void
	 * @ParamType m_sLand string
	 * @ReturnType void
	 */
	public function setm_sLand($m_sLand) {
		// Not yet implemented
	}

	/**
	 * @access public
	 */
	public function __construct() {
		// Not yet implemented
	}
}
?>
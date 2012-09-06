<?php
require_once(realpath(dirname(__FILE__)) . '/../PersMailBedrijf/clsCategorie.php');
require_once(realpath(dirname(__FILE__)) . '/../PersMailBedrijf/clsGebruikerOntvanger.php');

/**
 * @access public
 * @author Frank Blommert, itsFrank
 * @package PersMailBedrijf
 */
class clsCategorieOntvanger {
	/**
	 * @AttributeType int
	 */
	private $m_iCategorieID;
	/**
	 * @AttributeType string
	 */
	private $m_sGebruikersnaam;
	/**
	 * @AttributeType string
	 */
	private $m_sEmailBerichtInd;
	/**
	 * @AssociationType PersMailBedrijf.clsCategorie
	 * @AssociationMultiplicity 1..*
	 */
	public $unnamed_clsCategorie_;
	/**
	 * @AssociationType PersMailBedrijf.clsGebruikerOntvanger
	 * @AssociationMultiplicity 1
	 */
	public $unnamed_clsGebruikerOntvanger_;

	/**
	 * @access public
	 * @return int
	 * @ReturnType int
	 */
	public function getm_iCategorieID() {
		// Not yet implemented
	}

	/**
	 * @access public
	 * @param $value
	 * @return void
	 * 
	 * @ReturnType void
	 */
	public function setm_iCategorieID($_value) {
		// Not yet implemented
	}

	/**
	 * @access public
	 * @return string
	 * @ReturnType string
	 */
	public function getm_sGebruikersnaam() {
		// Not yet implemented
	}

	/**
	 * @access public
	 * @param $value
	 * @return void
	 * 
	 * @ReturnType void
	 */
	public function setm_sGebruikersnaam($_value) {
		// Not yet implemented
	}

	/**
	 * @access public
	 * @return string
	 * @ReturnType string
	 */
	public function getm_sEmailBerichtInd() {
		// Not yet implemented
	}

	/**
	 * @access public
	 * @param $value
	 * @return void
	 * 
	 * @ReturnType void
	 */
	public function setm_sEmailBerichtInd($_value) {
		// Not yet implemented
	}

	/**
	 * @access public
	 */
	public function __construct() {
		// Not yet implemented
	}

	/**
	 * @access public
	 * @param PersMailBedrijf.clsCategorie unnamed_clsCategorie_
	 * @return void
	 * @ParamType unnamed_clsCategorie_ PersMailBedrijf.clsCategorie
	 * @ReturnType void
	 */
	public function setUnnamed_clsCategorie_(clsCategorie $unnamed_clsCategorie_) {
		$this->unnamed_clsCategorie_ = $unnamed_clsCategorie_;
	}

	/**
	 * @access public
	 * @return PersMailBedrijf.clsCategorie
	 * @ReturnType PersMailBedrijf.clsCategorie
	 */
	public function getUnnamed_clsCategorie_() {
		return $this->unnamed_clsCategorie_;
	}

	/**
	 * @access public
	 * @param PersMailBedrijf.clsGebruikerOntvanger unnamed_clsGebruikerOntvanger_
	 * @return void
	 * @ParamType unnamed_clsGebruikerOntvanger_ PersMailBedrijf.clsGebruikerOntvanger
	 * @ReturnType void
	 */
	public function setUnnamed_clsGebruikerOntvanger_(clsGebruikerOntvanger $unnamed_clsGebruikerOntvanger_) {
		$this->unnamed_clsGebruikerOntvanger_ = $unnamed_clsGebruikerOntvanger_;
	}

	/**
	 * @access public
	 * @return PersMailBedrijf.clsGebruikerOntvanger
	 * @ReturnType PersMailBedrijf.clsGebruikerOntvanger
	 */
	public function getUnnamed_clsGebruikerOntvanger_() {
		return $this->unnamed_clsGebruikerOntvanger_;
	}
}
?>
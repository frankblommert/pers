<?php

// Smarty kan niet overweg met geneste objecten !
// Deze class is alleen een container voor de collectie van categorieen

require_once 'DBClasses/clsDBCategorie.php';
require_once 'FuncClasses/clsCategorie.php';


class clsCategorielijst  {

	
	private $m_colCategorielijst = array();	// collection
    private $m_aLijst = array(); 	// lijst categorieen
    private $rs;  					// resultsets
    private $m_iStartNivo;

    public function toon($p_iCategorieID){
    	$objDBCategorie = new clsDBCategorie();
		$this->bepaalStartNivo($p_iCategorieID, $objDBCategorie);
		$rs = $objDBCategorie->select($p_iCategorieID) ;
		$this->Add(new clsCategorie($rs['CategorieID'] , $rs['Naam'], $rs['Omschrijving'] , 0 ));
    	$this->getSubcategorie($p_iCategorieID,$objDBCategorie, $this->getm_iStartNivo());
    	$this->m_colCategorielijst = &$this->m_aLijst;
		return $this->m_colCategorielijst;
    }
    
//  Maak een simpele lijst van een categorie met zijn subcategorieen
	private function getSubcategorie($p_iCategorieID,$p_objDBCategorie, $p_iStartNivo) {
		$objDBCategorie = $p_objDBCategorie;
		foreach($objDBCategorie->SelectSubcategorieen($p_iCategorieID) as $rs){
			$this->Add(new clsCategorie($rs['SubcategorieID'] , $rs['Naam'], $rs['Omschrijving'] , ($rs['Nivo'] - $p_iStartNivo) ));
			$this->getSubcategorie($rs['SubcategorieID'],$objDBCategorie, $p_iStartNivo);
		};
	}
//  Maak een simpele lijst van een categorie met zijn bovenliggende categorieen
    public function toonOuders($p_iCategorieID){
    	$objDBCategorie = new clsDBCategorie();
		$rs = $objDBCategorie->select($p_iCategorieID) ;
		$this->Add(new clsCategorie($rs['CategorieID'] , $rs['Naam'], $rs['Omschrijving']));
    	$this->getOuderCategorie($p_iCategorieID,$objDBCategorie);
    	$this->m_colCategorielijst = &$this->m_aLijst;
		return $this->m_colCategorielijst;
    }
//  Haal van een categorie zijn bovenliggende categorieën op en maak er een collection van
	private function getOuderCategorie($p_iCategorieID,$p_objDBCategorie) {
		$objDBCategorie = $p_objDBCategorie;
		foreach ($objDBCategorie->selectOuderCategorie($p_iCategorieID) as $rs ){
			array_push($this->m_aLijst,new clsCategorie($rs['CategorieID'] , $rs['Naam'], $rs['Omschrijving']  )); // voeg categorie toe aan collection
			$this->getOuderCategorie($rs['CategorieID'],$objDBCategorie);
		};
	}
	
	private function getm_iStartNivo() {
		return $this->m_iStartNivo;
	}
	private function setm_iStartNivo($value) {
		$this->m_iStartNivo = $value;
	}
	public function bepaalStartNivo($p_iCategorieID, $p_objDBCategorie) {
		$objDBCategorie = $p_objDBCategorie;
		if ($rs = $objDBCategorie->selectNivo($p_iCategorieID)) {
			$this->setm_iStartNivo($rs['Nivo']);
		} else  {
			$this->setm_iStartNivo(0);
		}
	}
	
	public function __construct() {
					
	}
	
	public function __destruct() {
		$this->m_cCategorielijst = null;
		$this->rs = null;
		$this->m_aLijst = null;
		$this->m_iStartNivo = null;
	}
}
?>
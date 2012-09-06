<?php
require_once 'DBClasses/clsDB.php';

/**
 * @author Frank Blommert, itsFrank
 */


class clsDBCategorie {
	private $m_iCategorieID;
	private $m_sNaam;
	private $m_sOmschrijving;
	private $m_iNivo;
	private $dbh;
		
	
	
	public function __construct() {
		$this->dbh = new DB();
	}
	public function __destruct() {
		$this->m_iCategorieID = null;
		$this->m_sNaam = null;
		$this->m_sOmschrijving = null;
		$this->m_iNivo = null;
		$this->dbh = null;
	}
    public function getCategorieID() {
    	return $this->m_iCategorieID;
    }
    public function setCategorieID($value){
        $this->m_iCategorieID = $value;
    }
    public function getNaam() {
    	return $this->m_sNaam;
    }
    public function setNaam($value){
        $this->m_sNaam = $value;
    }
    public function getOmschrijving() {
    	return $this->m_sOmschrijving;
    }
    public function setOmschrijving($value){
        $this->m_sOmschrijving = $value;
    }
    public function getNivo() {
    	return $this->m_iNivo;
    }
    public function setNivo($value){
        $this->m_iNivo = $value;
    }
    
    public function select($p_iCategorieID) {
        try {
            $stmt = $this->dbh->prepare("call spSelectCategorie(:id)");
            $stmt->bindParam(":id", $p_iCategorieID);
            $stmt->execute(); 
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw $e;
        }
    }
    public function selectNivo($p_iCategorieID) {
        try {
            $stmt = $this->dbh->prepare("call spSelectCategorieNivo(:id)");
            $stmt->bindParam(":id", $p_iCategorieID);
            $stmt->execute(); 
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw $e;
        }
    }

    public function selectSubcategorieen($p_iCategorieID) {
        try {
            $stmt = $this->dbh->prepare("call spSelectSubcategorieen(:id)");
            $stmt->bindParam(":id", $p_iCategorieID);
            $stmt->execute();
         	return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw $e;
        }
    }
    public function selectOuderCategorie($p_iCategorieID) {
        try {
            $stmt = $this->dbh->prepare("call spSelectOuderCategorie(:id)");
            $stmt->bindParam(":id", $p_iCategorieID);
            $stmt->execute();
         	return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw $e;
        }
    }
}
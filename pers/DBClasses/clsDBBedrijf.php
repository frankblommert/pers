<?php
require_once 'DBClasses/clsDB.php';

/**
 * @author Frank Blommert, itsFrank
 */

class clsDBBedrijf {

	
	private $dbh;


	public function __construct() {
		$this->dbh = new DB();
	}
	public function __destruct() {
		$this->dbh = null;
	}
	public function select($p_iBedrijfID) {
        try {
            $stmt = $this->dbh->prepare("call spSelectBedrijf(:p_id)");
            $stmt->bindParam(":p_id", $p_iBedrijfID);
            $stmt->execute(); 
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw $e;
        }
	}
	public function insert(	$p_sBedrijfsnaam,
							$p_sKvkNummer,
							$p_sRekeningnummer,
							$p_sBtwNummer,
							$p_sStraatnaam,
							$p_iHuisnummer,
							$p_sHuisnummerToev,
							$p_sPostcode,
							$p_sPlaats,
							$p_sLand,
							$p_sStraatnaamPost,
							$p_iHuisnummerPost,
							$p_sHuisnummerToevPost,
							$p_sPostcodePost,
							$p_sPlaatsPost,
							$p_sLandPost,
							$p_sAlgVoorwaarden,
							$p_sIncasso) {
        try {
            $stmt = $this->dbh->prepare("call spInsertBedrijf(:p_nm,
															 :p_kvknr,
															 :p_btwnr,
															 :p_reknr,
															 :p_straat,
															 :p_huisnr,
															 :p_huisnrtv,
															 :p_pk,
															 :p_plts,
															 :p_lnd,
															 :p_straatpost,
															 :p_huisnrpost,
															 :p_huisnrtvpost,
															 :p_pkpost,
															 :p_pltspost,
															 :p_lndpost,
															 :p_algvoorwaarden,
															 :p_incasso)");
            
            $stmt->bindParam(":p_nm", $p_sBedrijfsnaam);
			$stmt->bindParam(":p_kvknr", $p_sKvkNummer);
			$stmt->bindParam(":p_btwnr", $p_sBtwNummer);
			$stmt->bindParam(":p_reknr", $p_sRekeningnummer);
			$stmt->bindParam(":p_straat", $p_sStraatnaam);
			$stmt->bindParam(":p_huisnr", $p_iHuisnummer);
			$stmt->bindParam(":p_huisnrtv", $p_sHuisnummerToev);
			$stmt->bindParam(":p_pk", $p_sPostcode);
			$stmt->bindParam(":p_plts", $p_sPlaats);
			$stmt->bindParam(":p_lnd", $p_sLand);
			$stmt->bindParam(":p_straatpost", $p_sStraatnaamPost);
			$stmt->bindParam(":p_huisnrpost", $p_iHuisnummerPost);
			$stmt->bindParam(":p_huisnrtvpost", $p_sHuisnummerToevPost);
			$stmt->bindParam(":p_pkpost", $p_sPostcodePost);
			$stmt->bindParam(":p_pltspost", $p_sPlaatsPost);
			$stmt->bindParam(":p_lndpost", $p_sLandPost);
			$stmt->bindParam(":p_algvoorwaarden", $p_sAlgVoorwaarden);
            $stmt->bindParam(":p_incasso", $p_sIncasso);
            
            $stmt->execute(); 
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw $e;
        }		
	}
	public function update($p_iBedrijfID,
							$p_sBedrijfsnaam,
							$p_sKvkNummer,
							$p_sRekeningnummer,
							$p_sBtwNummer,
							$p_sStraatnaam,
							$p_iHuisnummer,
							$p_sHuisnummerToev,
							$p_sPostcode,
							$p_sPlaats,
							$p_sLand,
							$p_sStraatnaamPost,
							$p_iHuisnummerPost,
							$p_sHuisnummerToevPost,
							$p_sPostcodePost,
							$p_sPlaatsPost,
							$p_sLandPost,
							$p_sStatus){ 
        try {
            $stmt = $this->dbh->prepare("call spUpdateBedrijf(	:p_id,
													            :p_nm, 
																:p_kvknr, 
																:p_btwnr, 
																:p_reknr, 
																:p_straat, 
																:p_huisnr, 
																:p_huisnrtv, 
																:p_pk, 
																:p_plts, 
																:p_lnd, 
																:p_straatpost, 
																:p_huisnrpost, 
																:p_huisnrtvpost, 
																:p_pkpost, 
																:p_pltspost, 
																:p_lndpost,
																:p_status)");       
            
            $stmt->bindParam(":p_id", $p_iBedrijfID);
            $stmt->bindParam(":p_nm", $p_sBedrijfsnaam);
			$stmt->bindParam(":p_kvknr", $p_sKvkNummer);
			$stmt->bindParam(":p_btwnr", $p_sBtwNummer);
			$stmt->bindParam(":p_reknr", $p_sRekeningnummer);
			$stmt->bindParam(":p_straat", $p_sStraatnaam);
			$stmt->bindParam(":p_huisnr", $p_iHuisnummer);
			$stmt->bindParam(":p_huisnrtv", $p_sHuisnummerToev);
			$stmt->bindParam(":p_pk", $p_sPostcode);
			$stmt->bindParam(":p_plts", $p_sPlaats);
			$stmt->bindParam(":p_lnd", $p_sLand);
			$stmt->bindParam(":p_straatpost", $p_sStraatnaamPost);
			$stmt->bindParam(":p_huisnrpost", $p_iHuisnummerPost);
			$stmt->bindParam(":p_huisnrtvpost", $p_sHuisnummerToevPost);
			$stmt->bindParam(":p_pkpost", $p_sPostcodePost);
			$stmt->bindParam(":p_pltspost", $p_sPlaatsPost);
			$stmt->bindParam(":p_lndpost", $p_sLandPost);
			$stmt->bindParam(":p_status", $p_sStatus);
            $stmt->execute(); 
            return;
        } catch (PDOException $e) {
            throw $e;
        }		
	}
	
	public function delete($p_iBedrijfID) {
        try {
            $stmt = $this->dbh->prepare("call spDeleteBedrijf(:id)");
            $stmt->bindParam(":id", $p_iBedrijfID);
            $stmt->execute(); 
            return; 
        } catch (PDOException $e) {
            throw $e;
        }		
	}
	public function updateStatusActief($p_iBedrijfID) {
        try {
            $stmt = $this->dbh->prepare("call spUpdateBedrijfActief(:id)");
            $stmt->bindParam(":id", $p_iBedrijfID);
            $stmt->execute(); 
            return; 
        } catch (PDOException $e) {
            throw $e;
        }		
	}
	public function updateStatusAfgemeld($p_iBedrijfID) {
        try {
            $stmt = $this->dbh->prepare("call spUpdateBedrijfAfgemeld(:id)");
            $stmt->bindParam(":id", $p_iBedrijfID);
            $stmt->execute(); 
            return; 
        } catch (PDOException $e) {
            throw $e;
        }		
	}
}
?>
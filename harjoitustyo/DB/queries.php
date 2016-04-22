<?php
ini_set('display_startup_errors',1);
ini_set('display_errors',1);
error_reporting(-1);
Class Queries {

	function __constructor(){
	}

	function GetProduct($unitId){
	try {
		require_once('/home/H9577/php-dbconfig/db-init2.php');
		$stmt = $db->query('SELECT * FROM Tuote WHERE TuoteOsId ='.$unitId);
		return $stmt;
	} 
	catch (Exception $e) {
		return $e;
	}
	}

	function LogIn($username){
	try{
		require_once('/home/H9577/php-dbconfig/db-init2.php');
		$stmt = $db->prepare("SELECT * FROM Asiakas WHERE Kayttajatunnus = :username");
		$stmt->bindValue(':username', $username, PDO::PARAM_STR);		
		$stmt->execute();   
		return $stmt;
	}
	catch(Exception $e){
		return $e;
	}
	}

	function Register($username, $password, $wholename, $pnumber, $address, $postnum){
	try{
		$returning;
		require_once('/home/H9577/php-dbconfig/db-init2.php');
		$stmt = $db->prepare("SELECT * FROM Asiakas WHERE Kayttajatunnus = :username");
		$stmt->bindValue(':username', $username, PDO::PARAM_STR);
		$stmt->execute();   
		$rc = $stmt->rowCount();
		if($rc == 0 ){
			$stmt = $db->prepare("INSERT INTO Asiakas (Kayttajatunnus, Salasana, ToimId , AsiakasNimi, AsiakasPuhNmro, AsiakasOsoite, AsiakasPostiNmro) VALUES (:f1, :f2, 1, :f3, :f4, :f5,
				:f6 )");
			$stmt->bindValue(':f1', $username, PDO::PARAM_STR);
			$stmt->bindValue(':f2', $password, PDO::PARAM_STR);
			$stmt->bindValue(':f3', $wholename, PDO::PARAM_STR);
			$stmt->bindValue(':f4', $pnumber, PDO::PARAM_STR);
			$stmt->bindValue(':f5', $address, PDO::PARAM_STR);
			$stmt->bindValue(':f6', $postnum,PDO::PARAM_INT);
			$stmt->execute();  
			$rc = $stmt->rowCount();
			return $rc; 
		}
		else{
			return 0;
		}
	}
	catch(Exception $e){
		return $e;
	}
	}

	function UpdateProfile( $password, $wholename, $pnumber, $address, $postnum){
	try{
		include('/home/H9577/php-dbconfig/db-init2.php');
		$stmt = $db->prepare("UPDATE Asiakas SET  Salasana =:f2, AsiakasNimi =:f3, AsiakasPuhnmro=:f4 , AsiakasOsoite=:f5 , AsiakasPostiNmro=:f6
			WHERE AsiakasId =:f7");
			
			$stmt->bindValue(':f2', $password, PDO::PARAM_STR);
			$stmt->bindValue(':f3', $wholename, PDO::PARAM_STR);
			$stmt->bindValue(':f4', $pnumber, PDO::PARAM_STR);
			$stmt->bindValue(':f5', $address, PDO::PARAM_STR);
			$stmt->bindValue(':f6', $postnum,PDO::PARAM_INT);
			$stmt->bindValue(':f7', $_SESSION['uid'],PDO::PARAM_INT);
			$stmt->execute();  
			$rc = $stmt->rowCount();
			if($rc == 0 ){
				return 0;
			}	 
			else{				
				$_SESSION['sala'] = $password;
				$_SESSION['asiakasnimi'] = $wholename;
				$_SESSION['asiakaspuh'] = $pnumber;
				$_SESSION['asiakasosoite'] = $address;
				$_SESSION['asiakaspostinro'] = $postnum;			
				return $rc;
			}
	}
	catch(Exception $e){
		return $e;
	}
	}


function getMyOrders($id, $help){
	try{
		if($help == 1){
			include('/home/H9577/php-dbconfig/db-init2.php');
			$stmt = $db->query('SELECT TilausId FROM Tilaus WHERE AsiakasId ='.$id);
			return $stmt;
		}
		if($help == 2){
			include('/home/H9577/php-dbconfig/db-init2.php');
			$stmt = $db->query(' SELECT Tilaus.TilausId, Tilaus.TilausOsoite, Tilaus.TilausTila, Tilaus.TilausPostiNmro,
			 Tilaustuote.Lkm, Tuote.TuoteNimi, Tuote.TuoteHinta,Tuote.TuoteKuvaus,Tuote.TuoteId
			 FROM Tilaus  
			 LEFT JOIN  Tilaustuote ON Tilaus.TilausId = Tilaustuote.TilausId 
			 LEFT JOIN  Tuote ON Tilaustuote.TuoteId = Tuote.TuoteId WHERE
			 Tilaus.TilausId = "'.$id.'"');
			return $stmt;
		}
	}
	catch (Exception $e) {
		return $e;
	}
}
function AddOrder($state, $address, $postnum, $uid){
try{
		include('/home/H9577/php-dbconfig/db-init2.php');
		$stmt = $db->prepare("INSERT INTO Tilaus(TilausOsoite, TilausTila, AsiakasId, TilausPostiNmro) VALUES (:f1,:f2,:f3,:f4)");
		$stmt->bindValue(':f1', $address, PDO::PARAM_STR);
		$stmt->bindValue(':f2', $state, PDO::PARAM_INT);
		$stmt->bindValue(':f3', $uid, PDO::PARAM_INT);
		$stmt->bindValue(':f4', $postnum, PDO::PARAM_STR);
		$stmt->execute();
		$stmt = $db->lastInsertId();
		return $stmt; //Tilaus id
	}
	catch (Exception $e) {
		return $e;
	}
}
function AddProdToOrd($prodid, $ordid, $lkm){
	try{
		include('/home/H9577/php-dbconfig/db-init2.php');
		$stmt = $db->prepare("INSERT INTO Tilaustuote(TuoteId, TilausId, Lkm) VALUES (:f1,:f2,:f3)");
		$stmt->bindValue(':f1', $prodid, PDO::PARAM_STR);
		$stmt->bindValue(':f2', $ordid, PDO::PARAM_INT);
		$stmt->bindValue(':f3', $lkm, PDO::PARAM_INT); 
		$stmt->execute();
	}
	catch (Exception $e) {
		return $e;
	}
}

function LogMainUsers($username){
	try{
		require_once('/home/H9577/php-dbconfig/db-init2.php');
		$stmt = $db->prepare("SELECT * FROM Toimittaja WHERE Kayttajatunnus = :username");
		$stmt->bindValue(':username', $username, PDO::PARAM_STR);
		$stmt->execute();   
		return $stmt;
	}
	catch(Exception $e){
		return $e;
	}
}
function GetAllProducts(){
		try {
		include('/home/H9577/php-dbconfig/db-init2.php');
		$stmt = $db->query('SELECT * FROM Tuote');
		return $stmt;
	} 
	catch (Exception $e) {
		return $e;
	}
}
function DeleteProduct($id){
	try {
		include('/home/H9577/php-dbconfig/db-init2.php');
		$stmt = $db->query('DELETE FROM Tuote WHERE TuoteId ='.$id);
		$rc = $stmt->rowCount(); 
		return $rc;
	} 
	catch (Exception $e) {
		return $e;
	}
}
function AddProduct($name, $price, $availability, $prodsection, $description){
	try {
		require_once('/home/H9577/php-dbconfig/db-init2.php');
		$stmt = $db->prepare("INSERT INTO Tuote(TuoteNimi,TuoteHinta,TuoteSaatavuus,TuoteOsId,TuoteKuvaus) VALUES (:f1, :f2, :f3, :f4, :f5)");
		$stmt->bindValue(':f1', $name, PDO::PARAM_STR);
		$stmt->bindValue(':f2', $price, PDO::PARAM_INT);
		$stmt->bindValue(':f3', $availability, PDO::PARAM_INT);
		$stmt->bindValue(':f4', $prodsection, PDO::PARAM_INT);
		$stmt->bindValue(':f5', $description, PDO::PARAM_STR);
		$stmt->execute(); 
		$rc = $stmt->rowCount();  
		return $rc;
	} 
	catch (Exception $e) {
		return $e;
	}

}
function getAllOrders($i){
	try {
		include('/home/H9577/php-dbconfig/db-init2.php');
		if($i == 2){
			$stmt = $db->query(" SELECT * FROM Asiakas 
			LEFT JOIN Tilaus ON  Asiakas.AsiakasId = Tilaus.AsiakasId
			LEFT JOIN  Tilaustuote ON Tilaus.TilausId = Tilaustuote.TilausId WHERE Tilaus.TilausTila =".$i."");		
			return $stmt;
		}
		if($i == 1 ){
			$stmt = $db->query(" SELECT * FROM Tilaus 
				LEFT JOIN Asiakas ON Tilaus.AsiakasId = Asiakas.AsiakasId
			");		
			return $stmt;
		}

	} 
	catch (Exception $e) {
		return $e;
	}
}
function GetWantedOrder($id){
	try {
		include('/home/H9577/php-dbconfig/db-init2.php');
		$stmt = $db->prepare("SELECT * FROM Tilaus 
			LEFT JOIN Asiakas ON Tilaus.AsiakasId = Asiakas.AsiakasId 
			LEFT JOIN Tilaustuote ON Tilaus.TilausId = Tilaustuote.TilausId  
			LEFT JOIN Tuote ON Tilaustuote.TuoteId = Tuote.TuoteId WHERE Tilaus.TilausId = :f1");
		$stmt->bindValue(':f1', $id, PDO::PARAM_INT);
		$stmt->execute(); 
		return $stmt;
	} 
	catch (Exception $e) {
		return $e;
	}
}
function ChangeOrderState($oid,$state){
	try {
		include('/home/H9577/php-dbconfig/db-init2.php');
		$stmt = $db->query('UPDATE Tilaus SET TilausTila = '.$state.' WHERE TilausId ='.$oid);
		$rc = $stmt->rowCount(); 
		return $rc;
	} 
	catch (Exception $e) {
		return $e;
	}
}
}

?>
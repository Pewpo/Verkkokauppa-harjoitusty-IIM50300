<?php
include('/home/H9577/public_html/WWW-palvelinohjelmointi/harjoitustyo/classes/product_order_row.php');

class Registeration {
	
	function __construct(){	
	}
	function LogIn($username, $password){
		require_once('/home/H9577/public_html/WWW-palvelinohjelmointi/harjoitustyo/classes/hash_class.php');
		require_once('/home/H9577/public_html/WWW-palvelinohjelmointi/harjoitustyo/DB/queries.php');
		try{
		if($username != "" &&  $password != ""){
			 $username = htmlspecialchars($username);
			  $password = htmlspecialchars($password);
			//DB
			$query = new Queries();
			$stmt=$query->LogIn($username);
			//
			$row = $stmt->fetch(PDO::FETCH_ASSOC);
			$makehash	= new PasswordCrypt();
			$encryptAnswer = $makehash->EncryptBlowFish($password, $row['Salasana'] );

			if($row['Kayttajatunnus'] === $username && $encryptAnswer == true){
				$_SESSION['app1_islogged'] = true;
				$_SESSION['uid'] = $row['AsiakasId'];
				$_SESSION['sala'] = $row['Salasana'];
				$_SESSION['kayt_tun'] = $row['Kayttajatunnus'];
				$_SESSION['asiakasnimi'] = $row['AsiakasNimi'];
				$_SESSION['asiakaspuh'] = $row['AsiakasPuhNmro'];
				$_SESSION['asiakasosoite'] = $row['AsiakasOsoite'];
				$_SESSION['asiakaspostinro'] = $row['AsiakasPostinmro'];			
			 	header('Location: /~H9577/WWW-palvelinohjelmointi/harjoitustyo/ ');
			 	exit;		 	
			}
		    else{
		    	return $text =  "<font color = 'red'>Käyttäjätunnus tai salasana väärin</font>";
		    }
		}
		else{
			return  $text = "<font color = 'red'>Aseta ensin Käyttäjätunnus ja salasana</font>";
		}
	}
	catch (Exception $e) {
		echo "virhe tapahtui : ".$e->getMessage();
	}	      
	}
	function LogOut(){
		try{
		if (isset($_SESSION['app1_islogged'])) {
	    unset($_SESSION['app1_islogged']);
	    unset($_SESSION['uid']);		
		unset ($_SESSION['sala']);
		unset($_SESSION['kayt_tun']);
		unset($_SESSION['asiakasnimi']);
		unset($_SESSION['asiakaspuh']);
		unset($_SESSION['asiakasosoite']);
		unset($_SESSION['asiakaspostinro']);
	 	header('Location: /~H9577/WWW-palvelinohjelmointi/harjoitustyo/ ');
	}
	}
	catch (Exception $e) {
		echo "virhe tapahtui : ".$e->getMessage();
	}
	}
	function Register($username, $upassword, $wholename, $pnumber, $address, $postnum){
		try{
		require_once('/home/H9577/public_html/WWW-palvelinohjelmointi/harjoitustyo/classes/hash_class.php');
		require_once('/home/H9577/public_html/WWW-palvelinohjelmointi/harjoitustyo/DB/queries.php');
		$query = new Queries();
		$upassword = htmlspecialchars($upassword);
		$makehash	= new PasswordCrypt();
		$hashedpassword = $makehash->BlowFishHash($upassword);
		$stmt = $query->Register(htmlspecialchars($username),$hashedpassword, htmlspecialchars($wholename), 
			htmlspecialchars($pnumber), htmlspecialchars($address), htmlspecialchars($postnum));
		if($stmt == 0){
			return "<font color = 'red'>Käyttäjätunnus on jo varattu</font>";
		}
		else{
			return "<font color = 'green'>$stmt käyttäjätunnus luotu onnistuneesti</font>";
		}
	}
	catch (Exception $e) {
		echo "virhe tapahtui : ".$e->getMessage();
	}
	}
}
?>
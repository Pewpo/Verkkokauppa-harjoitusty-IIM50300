<?php 
session_start();
//Tämä login on työntekijöitä ja pääkäyttäjiä varten
echo "<h2>työntekijöiden ja pääkäyttäjien kirjautuminen</h2>";
echo "<table>";
echo "<form method='post' action={$_SERVER['PHP_SELF']}>";
echo"	<tr><td>Tunnus: </td><td><input  type='text' name='username' size='30'><td></tr>";
echo "	<tr><td>salasana :	</td><td><input  type='password' name='password' size='30'></td></tr>";
echo "	<tr><td><input type='submit' name='login' value='Kirjaudu sisään'></td></tr>";
echo "</form>";
echo "</table>";
require_once('/home/H9577/public_html/WWW-palvelinohjelmointi/harjoitustyo/classes/hash_class.php');
require_once('/home/H9577/public_html/WWW-palvelinohjelmointi/harjoitustyo/DB/queries.php');
		if(isset($_POST['login']) && $_POST['username'] != "" && $_POST['password'] != ""){
		try{	

			//DB
			$query = new Queries();
			$stmt=$query->LogMainUsers( htmlspecialchars($_POST['username']));
			//			
			$makehash	= new PasswordCrypt();
			$password = htmlspecialchars($_POST['password']);
			$row = $stmt->fetch(PDO::FETCH_ASSOC);

			$encryptAnswer = $makehash->EncryptBlowFish($password, $row['Salasana'] );
			//salasanan oikeellisuuden taristus
			if($row['Kayttajatunnus'] === $_POST['username'] && $encryptAnswer == true){
				$_SESSION['app2_islogged'] = true;
				$_SESSION['toimid'] = $row['ToimId'];
				$_SESSION['osoite'] = $row['ToimOsoite'];
				$_SESSION['toiminimi'] = $row['ToimNimi'];
				$_SESSION['puhnmro'] = $row['ToimPuhNmro'];
				$_SESSION['sposti'] = $row['ToimSposti'];
				$_SESSION['kayttajatunnus'] = $row['Kayttajatunnus'];
				$_SESSION['sala'] = $row['Salasana'];
			
			 	header('Location: /~H9577/WWW-palvelinohjelmointi/harjoitustyo/view/workersmain.php ');
			 	exit;			 	
			}
		    else{
		    	echo  "<font color = 'red'>Käyttäjätunnus tai salasana väärin</font>";
		    }		
	}
	catch (Exception $e) {
		echo "virhe tapahtui : ".$e->getMessage();
	}	   
	}   
			else{
			echo "Aseta ensin Käyttäjätunnus ja salasana";
		}


?>
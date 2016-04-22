

<?php 
session_start();
include ('/home/H9577/public_html/WWW-palvelinohjelmointi/harjoitustyo/BL/BLmain.php'); 
$bl = new BLmain();
if(isset($_SESSION['app2_islogged']) == true){
	$text = "";
	$text2 = "";
	$text3 = "";
	$text4 = "";
	//Tuotteiden lisäys kun painetaan lisäys nappulaa
	if(isset($_POST['lisaatuote']) ){
		if( $_POST['nimi'] != "" && $_POST['hinta'] != 0 && $_POST['saatavuus'] != 0  && $_POST['tuoteosid'] != null && $_POST['kuvaus'] != ""){
		$answer =	$bl->AddProduct( htmlspecialchars($_POST['nimi']), htmlspecialchars($_POST['hinta']),  htmlspecialchars($_POST['saatavuus']),  htmlspecialchars($_POST['tuoteosid']),  htmlspecialchars( $_POST['kuvaus'] ));
		if($answer != 0){
			$arra = $bl->get_AllProducts();
			$text = "lisäys onnistui";}
		}
		else{ $text = "täytä ensin kaikki kentät"; }
	}
	//Tuotteiden poisto kun painetaan poista nappulaa
	$arra = $bl->get_AllProducts();
	if(isset($_POST['poistatuote'])){
		if(isset($_POST['tilaukset'])){
			$id = $arra[($_POST['tilaukset'])]->getId();
			$answer = $bl->DeleteProduct($id);
			if($answer != 0){
				$text2 = "poisto onnistui";
				$arra = $bl->get_AllProducts();
			}
			else
			{
				$text2 = "poisto epäonnistui";
			}
		}
		else{
			$text2 = "valitse ensin poistettava tuote";
		}
	}
	//Jos ollaan painettu lähetettyjen tilausten tarkastelu nappulaa
	if(isset($_POST['tarkastele1'])){
		if(isset($_POST['kasitellyt'])){
		header("Location: /~H9577/WWW-palvelinohjelmointi/harjoitustyo/view/orderexamine.php?wantedId={$_POST['kasitellyt']}&change=false");		
		}
		else{ $text3 = "Valitse ensin tarkasteltava tilaus";}
	}

	//Jos ollaan painettu Lähettämättömien tilausten tarkatstelua
	if(isset($_POST['tarkastele2'])){
		if(isset($_POST['kasitellyt2'])){
		header("Location: /~H9577/WWW-palvelinohjelmointi/harjoitustyo/view/orderexamine.php?wantedId={$_POST['kasitellyt2']}&change=true");		
		}
		else{ $text4 = "Valitse ensin tarkasteltava tilaus";}
	}

	echo "<h2>Pääkäyttäjän pääikkuna</h2><hr><hr>";

//lisäys
	echo "<h3>Lisää uusi tuote</h3><br><form method='post' action={$_SERVER['PHP_SELF']}>";
	echo "<table>";
	echo"	<tr><td>Nimi:</td><td> <input  type='text' name='nimi' size='30'></td></tr>";
	echo"	<tr><td>Hinta: </td><td><input  type='text' name='hinta' size='30'></td></tr>";
	echo"	<tr><td>Saatavuus: </td><td><input  type='text' name='saatavuus' size='30'></td></tr>";
	echo"	<tr><td>tuoteOsId: </td><td><input  type='text' name='tuoteosid' size='30'></td></tr>";
	echo"	<tr><td>kuvaus: </td><td><textarea rows='4' type='text' maxlength='198'  name='kuvaus' cols='50' ></textarea></td></tr>";
	echo "	<tr><td><input type='submit' name='lisaatuote' value='Lisää Tuote'></td></tr>";
	echo "</table>";
	echo "</form> <br>{$text}<hr>";


//Poisto
	echo "<h3>selaile ja poista tuotteita</h3><br>";
	echo "<form method='post' action={$_SERVER['PHP_SELF']}>";
	echo"<select name='tilaukset' size='17' style='width:40%;'>";	
		$help = 0;
		foreach($arra as $value){		
			$id = $value->getId();
			$nimi = $value->getName();
			$hinta = $value->getPrice(); 
			echo $hinta;
	echo    "<option value={$help}>id : {$id} | nimi : {$nimi} | hinta : {$hinta}</option>";	
			$help++;
		}
	echo 	'</select><br>';

	echo "	<input type='submit' name='poistatuote' value='poista valittu tuote'>";
	echo "</form><br> {$text2}";
	echo "<br><hr>";
	
	//Toimitettujen tilausten katselmointi
	$allorders = $bl->getAllOrders(1);
	echo "<h3>Toimitetut tilaukset </h3>";
	echo "<form method='post' action={$_SERVER['PHP_SELF']}>";
	echo"<select name='kasitellyt' size='17' style='width:40%;' style='width:100%;'>";	
	while($row = $allorders->fetch(PDO::FETCH_ASSOC)) {
		if($row['TilausTila'] == 1){
			echo 	"<option value={$row['TilausId']}>Tilaus id: {$row['TilausId']} |  Tilaaja : {$row['AsiakasNimi']} | TilausOsoite : {$row['TilausOsoite']}
			 | Tilauksen postinumero : {$row['TilausPostiNmro']}</option>";
		}			
	}									
	echo 	'</select><br>';
	echo "	<input type='submit' name='tarkastele1' value='tarkastele tilausta Tuote'>";
	echo "</form><br><br>{$text3}";

	//Tilausten hallinta
	$allorders = $bl->getAllOrders(1);
	echo "<h3>Toimittamattomat tilaukset </h3>";
	echo "<form method='post' action={$_SERVER['PHP_SELF']}>";
	echo"<select name='kasitellyt2' size='17' style='width:40%;' style='width:100%;'>";	
	while($row = $allorders->fetch(PDO::FETCH_ASSOC)) {
		if($row['TilausTila'] == 0){
			echo 	"<option value={$row['TilausId']}>Tilaus id: {$row['TilausId']} |  Tilaaja : {$row['AsiakasNimi']} | TilausOsoite : {$row['TilausOsoite']}
			 | Tilauksen postinumero : {$row['TilausPostiNmro']}</option>";
		}			
	}									
	echo 	'</select><br>';
	echo "	<input type='submit' name='tarkastele2' value='tarkastele tilausta Tuote'>";
	echo "</form><br><br>{$text4}";
	}
else{
		header('Location: /~H9577/WWW-palvelinohjelmointi/harjoitustyo/workerlogin.php');
}

?>









<?php
include('/home/H9577/public_html/WWW-palvelinohjelmointi/harjoitustyo/classes/product_class.php');
include('/home/H9577/public_html/WWW-palvelinohjelmointi/harjoitustyo/classes/xml_tool.php');

class BLmain {
private $arr = array();
function __construct(){}

function get_AllProducts(){
	require_once('/home/H9577/public_html/WWW-palvelinohjelmointi/harjoitustyo/DB/queries.php');
		try{
			$query = new Queries();
			$stmt  = $query->GetAllProducts();
			while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
				//luodaan oliot jotka työnnetään arrayhin
				$product = new Product($row['TuoteId'], $row['TuoteNimi'], $row['TuoteHinta'], 
				$row['TuoteSaatavuus'], $row['TuoteKuvaus']);
				$this->arr[] = $product;
			}	
			return $this->arr;
		}
		catch (Exception $e) {
			echo "virhe tapahtui : ".$e->getMessage();
		}
}

function get_Products($unitId){
	require_once('/home/H9577/public_html/WWW-palvelinohjelmointi/harjoitustyo/DB/queries.php');
	try{
	$xml = new XMLTool();
	//db yhteys
	$query = new Queries();
	$stmt  = $query->GetProduct($unitId);
	//tarkistetaan onko käyttäjä kirjautunut jos on nii "lisää" nappuloita voi painaa
	$helptext = "";
	if(isset($_SESSION['app1_islogged'] )== true){
		$display = "";
		$helptext = "";
		$color = "green";
	}
	else{
		$display = 'disabled="disabled"';
		$helptext = "Jotta voit lisätä ostoksia ostoskoriin sinun on ensin kirjauduttava sisälle";
		$color = "red";
	}

	//Taulun luonti
	echo "<table class='table table-striped'>\n";
	echo '<thead>
		<tr>
		<th>ID</th>
		<th>Tuote Nimi</th>
		<th>Hinta</th>
		<th>Saatavuus</th>
		<th>Kuvaus</th>
		</tr>
		</thead>
		<tbody>';
	
	while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
		//luodaan oliot jotka työnnetään arrayhin
		$product = new Product($row['TuoteId'], $row['TuoteNimi'], $row['TuoteHinta'], 
		$row['TuoteSaatavuus'], $row['TuoteKuvaus']);
		$this->arr[] = $product;
	}
	$help = 0;
	foreach($this->arr as $value){		
		echo "<tr><td>{$value->getId()}</td><td>{$value->getName()}</td>
		<td>{$value->getPrice()} €</td><td>{$value->getAvailability()} kpl</td>
		 <td>{$value->getDescription()}</td><td><form method='post' action={$_SERVER['PHP_SELF']}>
		 <input type='hidden' name='productsecret' size='40' value='{$value->getId()}'>
		 <input type='hidden' name='productsecret2' size='40' value='{$help}'>
		 <input $display type='submit' class = 'btn'  name='addtocart' value='Lisää Ostoskoriin'>
		 </form></td></tr>";		
		 $help++;
	}
	echo "</tbody></table>";
	//saadaan halutun tuotteen tiedot
	if(isset($_POST['addtocart'])){

		$wanted = $this->arr[($_POST['productsecret2'])];
		//kirjoittetaan xml tiedostoon haluttu tuote
		$xml->WriteXml($_SESSION['uid'], $wanted->getId(), $wanted->getName(), $wanted->getPrice(), $wanted->getAvailability(), $wanted->getDescription());
		$helptext = "Tuote : <b>".$wanted->getName()."</b> Lisättiin ostoskoriin";
		
	}
	echo "<p style='color:$color;'>{$helptext}</p>";
}
catch (Exception $e) {
		echo "virhe tapahtui : ".$e->getMessage();
}
}

function UpdateProfile( $password, $wholename, $pnumber, $address, $postnum){
	try{
		require_once('/home/H9577/public_html/WWW-palvelinohjelmointi/harjoitustyo/classes/hash_class.php');
		require_once('/home/H9577/public_html/WWW-palvelinohjelmointi/harjoitustyo/DB/queries.php');
		//db yhteys
		$query = new Queries();
		$makehash	= new PasswordCrypt();
		$hashedpassword = $makehash->BlowFishHash($password);
		$returning =  $query->UpdateProfile( $hashedpassword, $wholename, $pnumber, $address, $postnum);
		if($returning == 0){
			return "<font color = 'red'>Tietojen päivitys epäonnistui</font>";
		}
		else{
			return "<font color = 'green'>Tietojen päivitys onnistui</font>";
		}
	}
	catch (Exception $e) {
		echo "virhe tapahtui : ".$e->getMessage();
	}
}

function getMyOrders($id, $help){
	try{
	require_once('/home/H9577/public_html/WWW-palvelinohjelmointi/harjoitustyo/DB/queries.php');
	$query = new Queries();
	$returning = $query->getMyOrders($id, $help);
	return $returning;
}
catch (Exception $e) {
		echo "virhe tapahtui : ".$e->getMessage();
}
}

function AddOrder($status, $addres, $postnum, $uid){
try{
	include('/home/H9577/public_html/WWW-palvelinohjelmointi/harjoitustyo/DB/queries.php');
	$xml = new XMLTool();
	$query = new Queries();
	$answer = $query->AddOrder($status, $addres, $postnum, $uid);
	$rc = 0;
	$arr = $xml->WriteIt($_SESSION['uid']);	
	foreach($arr as $value){		
		$id = $value->getId();
		$lkm = 1;
		$query->AddProdToOrd($id,$answer, $lkm);		
		}
		return "<font color = 'green'><b>Tilaus tallennettiin onnistuneesti.</b></font>";
	}
	catch (Exception $e) {
		echo "virhe tapahtui : ".$e->getMessage();
}
}

function DeleteProduct($id){
	try{
		require_once('/home/H9577/public_html/WWW-palvelinohjelmointi/harjoitustyo/DB/queries.php');
		$query = new Queries();
		$answer = $query->DeleteProduct($id);
		return $answer;
	}
	catch (Exception $e) {
		echo "virhe tapahtui : ".$e->getMessage();
	}
} 

function AddProduct($name, $price, $availability, $prodsection, $description){
	try{
		require_once('/home/H9577/public_html/WWW-palvelinohjelmointi/harjoitustyo/DB/queries.php');
		$query = new Queries();
		$answer = $query->AddProduct($name, $price, $availability, $prodsection, $description);
		return $answer;
	} 
	catch (Exception $e) {
		echo "virhe tapahtui : ".$e->getMessage();
	}

}

function getAllOrders($i){
	try{
		require_once('/home/H9577/public_html/WWW-palvelinohjelmointi/harjoitustyo/DB/queries.php');
		$query = new Queries();
		$answer = $query->getAllOrders($i);
		return $answer;
	} 
	catch (Exception $e) {
		echo "virhe tapahtui : ".$e->getMessage();
	}
}
function GetWantedOrder($id, $state){
	try{
		include('/home/H9577/public_html/WWW-palvelinohjelmointi/harjoitustyo/DB/queries.php');
		$query = new Queries();
		$answer = $query->GetWantedOrder($id);
		$button = "";
		$text = "";

		if($state == 1){			
			$button = "	<td> <input type='submit' name='confirm' value = 'Toimita tilaus'></td>";			
		}
		else{
		$button = "";
		}
		if(isset($_POST['confirm'])){
			$returningAnswer = $query->ChangeOrderState($_POST['productsecret3'], $_POST['productsecret1']);
			if($returningAnswer == null){
				$text = "Tilauksen statuksen muuttaminen epäonnistui";
			}
 			else{
 				$text = "Tilauksen statuksen muuttaminen onnistui";
 			}
		}		
		//Taulun luonti
	echo "<table class='table table-striped'>\n";
	echo '<thead>
		<tr>
		<th>ID</th>
		<th>Tuote Nimi</th>
		<th>Hinta</th>
		<th>Kuvaus</th>
		</tr>
		</thead>
		<tbody>';
	
	while($row = $answer->fetch(PDO::FETCH_ASSOC)) {
		//luodaan oliot jotka työnnetään arrayhin
		$product = new Product($row['TuoteId'], $row['TuoteNimi'], $row['TuoteHinta'], 
		$row['TuoteSaatavuus'], $row['TuoteKuvaus']);
		$this->arr[] = $product;
	}
	$wholeprice = 0;
	foreach($this->arr as $value){		
		echo "<tr><td>{$value->getId()}</td><td>{$value->getName()}</td>
		<td>{$value->getPrice()} €</td>
		 <td>{$value->getDescription()}</td></tr>";	
		$wholeprice +=	 $value->getPrice();	
	}
	echo "</table>";
	echo "</tbody>";
		echo"<b>Kokonais hinta = {$wholeprice} euroa</b><hr>";

		$answer = $query->GetWantedOrder($id);
		$i = 0;
	while($row = $answer->fetch(PDO::FETCH_ASSOC) ) {
		if($i == 0){
		echo "<table>";
		echo "<h2>Tilauksen lähetys tiedot</h2>";
		echo "<tr><td>Tilaus Id: </td><td>{$row['TilausId']}</td> </tr>";
		echo "<tr><td>Tilaaja Id: </td><td>{$row['AsiakasId']}</td> </tr>";
		echo "<tr><td>Tilaaja :</td><td>{$row['AsiakasNimi']}</td> </tr>";
		echo "<tr><td>Tilaaja puhelinnumero:</td><td>{$row['AsiakasPuhNmro']}</td> </tr>";
		echo "<tr><td>Toimitus osoite:</td><td>{$row['TilausOsoite']}</td> </tr>";
		echo "<tr><td>Postinumero : </td><td>{$row['TilausPostiNmro']}</td></tr>";
		echo "<form method='post' action=".'"'.$_SERVER['PHP_SELF']."?wantedId={$row['TilausId']}&change=true".'"'.">
			 <input type='hidden' name='productsecret1'  value = '1'>
			 <input type='hidden' name='productsecret3'  value = '{$row['TilausId']}'>
			 <input type='hidden' name='productsecret2' value = '0'>";
		echo $button;
		echo "</form> <td><b>$text</b></td>	</table><br><br>";
		}		
		$i++;
	}
		
		return $answer;
	} 
	catch (Exception $e) {
		echo "virhe tapahtui : ".$e->getMessage();
	}
}
}
?>
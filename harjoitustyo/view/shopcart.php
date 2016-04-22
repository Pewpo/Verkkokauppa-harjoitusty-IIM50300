<head>
	<title>Shopcart</title>
	<link rel="stylesheet" type="text/css" href="/~H9577/WWW-palvelinohjelmointi/harjoitustyo/css/shape.css">
</head>
<?php
session_start();

include ('/home/H9577/public_html/WWW-palvelinohjelmointi/harjoitustyo/BL/BLmain.php'); 
include('header.php');
include('footer.php');


$xml = new XMLTool();


if(isset($_SESSION['app1_islogged'] ) == true ){
echo $head;

$bl  = new BLmain();
$arr =$xml->WriteIt($_SESSION['uid']);

//tapahtumat kun halutaan poistaa tuote listalta
if(isset($_POST['DeleteOrder'])){
	if(isset($_POST['products'])){
	
		$wanted =  $arr[($_POST['products'])];
		$id = $wanted->getId();
		$answer = $xml->DeleteXml($id, $_SESSION['uid']);
		if($answer == true){
			$text = "<font color = 'green'>Tuote : <b>{$wanted->getName()}</b> Poistettu onnistuneesti</font>";
			$arr =$xml->WriteIt($_SESSION['uid']);
		}
		else {$text = "<font color = 'red'>Tuotteen poisto epäonnistui</font>";}
	}
	else{
		$text =  "<font color = 'red'>Valitse ensin listalta tuote jonka haluat poistaa</font>";
	}
}
//Tapahtuma kun "Lähetä tilaus" painiketta painetaan
if(isset($_POST['send'])){
		if($_POST['sendingaddress'] != "" && $_POST['postnumber'] != ""){
	$text = 	$bl->AddOrder("0", htmlspecialchars($_POST['sendingaddress'] ), htmlspecialchars($_POST['postnumber']), $_SESSION['uid'] );

	}
	else{
		$text =  "<font color = 'red'>Täytä ensin kaikki kentät</font>";
	}
}

//MAIN NÄKYMÄ
echo '<div class=content>
		<div class=main >
		<hr>
		<div style = "float:right; margin-left:3%; margin-right: 0%" >
		<form  method="post" action='.$_SERVER["PHP_SELF"].'>
			<h3>Tilattavat tuotteet</h3>
			<select name="products" size="17" style="width:100%;">';
		$cost = 0;
		$help = 0;
		foreach($arr as $value){		
echo 	"<option value=".$help.">ID:".$value->getId()." | Tuote : ".$value->getName()." | Hinta: ".$value->getPrice()."</option>";
		$help++;
		$cost += $value->getPrice();
		}
echo 	'</select>
		<input style="width:100%; height: 5%;"  type="submit" class = "btn"  name="DeleteOrder" value="Poista valittu tuote">
		</form>
		</div>

		<form method="post" action='.$_SERVER["PHP_SELF"].'>
		<table>
		<h3>Lähetystiedot</h3><br>
			
				<tr>
					<th>Lähetys osoite :</th><td><input  type="text" name="sendingaddress" size="30" ></td></tr>
				<tr>	
					<th>Postinumero :</th><td><input  type="text" name="postnumber" size="30"  ></td>
				</tr>
				<tr>
					<th>Tilauksen tila:</th><td><input  type="text" name="space" value="Luonti" size="30" readonly > </td></tr>					
				
				</table>
				<div style= "height:20%;  vertical-align: bottom;" >Tilauksen yhteishinta : '.$cost.' euroa</div>
				<div>
					<input type="submit" class = "btn"  name="send" value="Lähetä tilaus">
				</div>
			</form>

		<hr>
		'.$text.'
		</div>
		</div>';
echo $footer;
} 
else{
	header('Location: /~H9577/WWW-palvelinohjelmointi/harjoitustyo/view/register.php?regfirst=true');
}
?>
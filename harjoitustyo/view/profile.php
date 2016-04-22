<head>
	<title>Register screen</title>
	<link rel="stylesheet" type="text/css" href="/~H9577/WWW-palvelinohjelmointi/harjoitustyo/css/shape.css">
</head>
<?php
session_start();


include ('/home/H9577/public_html/WWW-palvelinohjelmointi/harjoitustyo/BL/BLmain.php'); 
include('header.php');
include('footer.php');
if(isset($_SESSION['app1_islogged'] ) == true ){
echo $head;
$status = "readonly";
$display = 'disabled="disabled"';
$text = "";
if(isset($_GET['changestatus']) == true){
	$status = "";
	$display = "";
}
$bl  = new BLmain();
//PÄIVITYS
if(isset($_POST['save'])){
	//Jos kaikki on asetettu oikein nii yritetään päivittää tunnusta
	if( $_POST['psw1'] === $_POST['psw2'] && $_POST['psw1'] != "" && $_POST['psw2'] != "" && $_POST['wholename'] != "" && $_POST['pnumber'] != "" && $_POST['uname'] != ""){
		$pattern = "/{$_POST['malli']}/";
		$pattern2 = "/{$_POST['nimivalidiot']}/";
		$pattern3 = "/{$_POST['salasanavalidiot']}/";
	  	if (preg_match($pattern, $_POST['pnumber'])){
	  		if (preg_match($pattern2, $_POST['wholename'])){
				if (preg_match($pattern3, $_POST['psw1'])){
			$text = "";
			$text = $bl-> UpdateProfile(htmlspecialchars($_POST['psw1']),htmlspecialchars($_POST['wholename']),htmlspecialchars($_POST['pnumber']),
			htmlspecialchars($_POST['address']),htmlspecialchars($_POST['postnum']));
				}
				else{$text =  "<font color = 'red'>Salasanasi tulee olla vähintään 8 merkkiä pitkä</font>";}
			}
			else{$text =  "<font color = 'red'>Tarkista kokonimesi oikeinkirjoitus. Esimerkki: Matti Meikäläinen</font>";}
		}
		else{$text =  "<font color = 'red'>Puhelin numerosi on väärää laatua, kokeile esim muodossa +35840 550 7702</font>";}
	}
	else{$text =  "<font color = 'red'>Tiedostoa ei tallennettu. Tarkista että olet täyttänyt varmasti kaikki kentät ja että kirjoitit salasanan oikein</font>"; }
}
//tapahtumat kun "tarkastele tilausta nappia painetaan"
if(isset($_POST['SeeOrders'])){
	if(isset($_POST['Orders'])){
		header("Location: /~H9577/WWW-palvelinohjelmointi/harjoitustyo/view/myorders.php?valuehelp={$_POST['Orders']}");
	}
	else{
		$text =  "<font color = 'red'>Valitse ensin haluttu tilaus</font>";
	}
}

//haetaan tiedot oikeanpuoleiseen "tilaukset" listaan
//Eli oikeapuoli sivusta
$returning = $bl->getMyOrders($_SESSION['uid'], 1);
echo '<div class=content>
		<div class=main>
		<hr>
		<div style = "float:right; margin-left:3%; margin-right: 15%" >
		<form  method="post" action='.$_SERVER["PHP_SELF"].'>
			<h3>tehdyt tilaukset</h3>
			<select name="Orders" size="17" style="width:100%;">';
		while($row = $returning->fetch(PDO::FETCH_ASSOC)) {
echo 	"<option value={$row['TilausId']}>Tilausnumero : {$row['TilausId']}</option>";
		echo $row;
		}
echo 	'</select>
		<input style="width:100%; height: 5%;"  type="submit" class = "btn"  name="SeeOrders" value="Tarkastele tilausta">
		</form>
		</div>

		<form method="post" action='.$_SERVER["PHP_SELF"].'>
		<table>
		<h3>Profiilin tiedot</h3><br>
			
				<tr>
					<th>Kokonimi :</th><td><input  type="text" name="wholename" size="30" value ="'.$_SESSION['asiakasnimi'].'" '.$status.'></td></tr>
				<tr>	
					<th>Puhelinnumero :</th><td><input  type="text" name="pnumber" size="30" value ="'.$_SESSION['asiakaspuh'].'" '.$status.'></td>
				</tr>
				<tr>
					<th>Osoite (vapaehtoinen) :</th><td><input  type="text" name="address" size="30" value ="'.$_SESSION['asiakasosoite'].'" '.$status.'></td></tr>
				<tr>	
					<th>Postinumero (vapaehtoinen) :</th><td><input  type="text" name="postnum" size="30" value ="'.$_SESSION['asiakaspostinro'].'" '.$status.'></td>
				</tr>
				<tr>
					<th>käyttäjätunnus :</th><td><input  type="text" name="uname" size="30"  value ="'.$_SESSION['kayt_tun'].'"  readonly></td>
				</tr>
				<tr>
					<th>Salasana :</th><td><input  type="password" name="psw1" size="30"  value ="'.$_SESSION['sala'].'"  '.$status.'></td>
				</tr>
				<tr>
					<th>Salasana uudestaan :</th><td><input type="password" name="psw2" size="30"  value ="'.$_SESSION['sala'].'"  '.$status.'></td>
				</tr>
				<tr>				
				  <td><a  style="width:90%; height: 100%;"  class = "btn" href= "profile.php?changestatus=true" >Muokkaa tietoja</a></td>
				   <td><input style="width:100%; height: 145%;" '.$display.' type="submit" class = "btn"  name="save" value="Tallenna"></td>
				</tr>
				</table>
				<input type="hidden" name="malli" size="40"
				value="^((\+358)|(0)|(\+358 ))((50)|(40)|(44))(((( [0-9]{3}))(( [0-9]{4})|( [0-9]{3} [0-9]{1})))|( [0-9]{7})|([0-9]{7}))">
				<input type="hidden" name="nimivalidiot" size="40" value="^[A-Za-z]+ [A-Za-z]+$">
				<input type="hidden" name="salasanavalidiot" size="40" value=".{8,}">
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
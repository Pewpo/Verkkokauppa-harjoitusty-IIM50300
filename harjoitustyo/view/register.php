<head>
	<title>Register screen</title>
	<link rel="stylesheet" type="text/css" href="/~H9577/WWW-palvelinohjelmointi/harjoitustyo/css/shape.css">
</head>
<?php
session_start();
include ('/home/H9577/public_html/WWW-palvelinohjelmointi/harjoitustyo/BL/registration.php'); 
include('header.php');
include('footer.php');
echo $head;
$text = "";
//Jos kaikki on asetettu oikein nii yritetään luoda uusi tunnus
//ellei ole jo olemassa..
if(isset($_POST['reg']) && $_POST['psw1'] === $_POST['psw2'] && $_POST['psw1'] != "" && $_POST['psw2'] != "" && $_POST['wholename'] != "" && $_POST['pnumber'] != "" && $_POST['uname'] != ""){
	$pattern = "/{$_POST['malli']}/";
	$pattern2 = "/{$_POST['nimivalidiot']}/";
	$pattern3 =	"/{$_POST['salasanavalidiot']}/";
  	if (preg_match($pattern, $_POST['pnumber'])){
  		if (preg_match($pattern2, $_POST['wholename'])){
  			if (preg_match($pattern3, $_POST['psw1'])){

				$text = "";
				$rg  = new Registeration();
				$text = $rg-> Register(htmlspecialchars($_POST['uname']),htmlspecialchars($_POST['psw1']),htmlspecialchars($_POST['wholename']),htmlspecialchars($_POST['pnumber']),
					htmlspecialchars($_POST['address']),htmlspecialchars($_POST['postnum']));
			}
			else{
					$text =  "<font color = 'red'>Salasanasi tulee olla vähintään 8 merkkiä pitkä</font>";
			}
			}		
		else{
			$text =  "<font color = 'red'>Tarkista kokonimesi oikeinkirjoitus. Esimerkki: Matti Meikäläinen</font>";
		}
}
else{
	$text =  "<font color = 'red'>Puhelin numerosi on väärää laatua, kokeile esim muodossa +35840 550 7702</font>";
}
}
else{
	$text =  "<font color = 'red'>Täytä ensin kaikki kentät ja tarkista salasanojen vastaavuus</font>";
}
//******Virheilmoituksia*********
if(isset($_POST['reg']) && $_POST['psw1'] != $_POST['psw2'] ){
	$text =  "<font color = 'red'>Salasanat eivät täsmänneet</font>";
}
if(isset($_POST['reg']) && $_POST['wholename'] == "" | $_POST['pnumber'] == "" | $_POST['uname'] == "" | $_POST['psw1'] == "" | $_POST['psw2'] == "" ){
	$text =  "<font color = 'red'>Täytä ensin kaikki kentät</font>";
}
if(isset($_GET['regfirst']) == true){
	$text = "<font color = 'red'>Jotta voit selailla profiilisivuasi sinun on rekisteröidyttävä ensin</font>";
}
//********************************
echo '<div class=content>
		<div class=main>
		<hr>
		<form method="post" action='.$_SERVER["PHP_SELF"].'>
		<table>
		<h3>Rekisteröi uusi käyttäjätunnus</h3><br>
			
				<tr>
					<th>Kokonimi :</th><td><input  type="text" name="wholename" size="30"></td></tr>
				<tr>	
					<th>Puhelinnumero :</th><td><input  type="text" name="pnumber" size="30"></td>
				</tr>
				<tr>
					<th>Osoite (vapaehtoinen) :</th><td><input  type="text" name="address" size="30"></td></tr>
				<tr>	
					<th>Postinumero (vapaehtoinen) :</th><td><input  type="text" name="postnum" size="30"></td>
				</tr>
				<tr>
					<th>käyttäjätunnus :</th><td><input  type="text" name="uname" size="30"></td>
				</tr>
				<tr>
					<th>Salasana :</th><td><input  type="password" name="psw1" size="30"></td>
				</tr>
				<tr>
					<th>Salasana uudestaan :</th><td><input type="password" name="psw2" size="30"></td>
				</tr>
				<tr>
				 <td><input  type="submit" name="reg" value="Rekisteröi"></td>
				</tr>
				</table>
				<input type="hidden" name="malli" size="40"
				value="^((\+358)|(0)|(\+358 ))((50)|(40)|(44))(((( [0-9]{3}))(( [0-9]{4})|( [0-9]{3} [0-9]{1})))|( [0-9]{7})|([0-9]{7}))">
				<input type="hidden" name="nimivalidiot" size="40" value="^[A-Za-z]+ [A-Za-z]+$">
				<input type="hidden" name="salasanavalidiot" size="40" value=".{8,}">
			</form>
		<hr>
		</div>
		'.$text.'
		</div>';
echo $footer;
?>
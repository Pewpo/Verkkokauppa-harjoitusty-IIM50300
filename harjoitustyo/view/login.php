<head>
	<title>Log in screen</title>
	<link rel="stylesheet" type="text/css" href="/~H9577/WWW-palvelinohjelmointi/harjoitustyo/css/shape.css">
</head>
<?php
session_start();
include('header.php');
include('footer.php');
include ('/home/H9577/public_html/WWW-palvelinohjelmointi/harjoitustyo/BL/registration.php'); 
$lg = new Registeration();
$text = "";
//tarkistetaan että molemmat ketät on täytetty --> kutsutaan functiota
if(isset($_POST['log_in'])){
	if(isset($_POST['uname']) != "" && isset($_POST['psw']) != ""){
		$text = $lg->LogIn(htmlspecialchars($_POST['uname']), htmlspecialchars($_POST['psw']));	
		$loginmark = "Log Out";
	}
	else{
		$text =  "<font color = 'red'>Täytä molemmat kentät</font>";
	}
}

echo $head;
echo '<div class=content>
		<div class=main>
		<hr>
		<h3>Kirjaudu sisään</h3><br>
			<form method="post" action='.$_SERVER["PHP_SELF"].'>
				Tunnus &nbsp; : <input type="text" name="uname" size="30"><br><br>
				Salasana: <input type="password" name="psw" size="30"><br><br>
				<input  type="submit" name="log_in" value="Kirjaudu">
			</form>
		<hr>'.$text.'
		</div>
		</div>';
echo $footer;


?>
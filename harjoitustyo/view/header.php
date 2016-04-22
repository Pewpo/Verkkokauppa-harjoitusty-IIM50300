<?php
$loginmark;
if(isset($_SESSION['app1_islogged'] )== true){
	$loginmark = "Log out";
	$uname = "<b  style='font-size: 0.45em; float: right; '> Olet kirjautunut käyttäjällä : ". $_SESSION['kayt_tun']."</b>";
	$url = ' href="/~H9577/WWW-palvelinohjelmointi/harjoitustyo/index.php?logout=true"';
}
else{
	$loginmark = "Log In";	
	$uname = "";
	$url = 'href="/~H9577/WWW-palvelinohjelmointi/harjoitustyo/view/login.php"';
}
$head = <<<HEADER
<html>
	<body>
		<header class="header">
			<h1>Verkkokauppa $uname</h1>
		</header>
		<nav class="nav-bar">
			<ul class= "list-inline">
				<li class ="nav"><a href='/~H9577/WWW-palvelinohjelmointi/harjoitustyo/'>Etusivu</a></li> |
				<li class ="nav"><a onclick="window.location.href='/~H9577/WWW-palvelinohjelmointi/harjoitustyo/category.php'">Tuotekategoria</a></li> |
				<li class ="nav"><a href='/~H9577/WWW-palvelinohjelmointi/harjoitustyo/view/profile.php'>Profiili</a></li> |
				<li class ="nav"><a href='/~H9577/WWW-palvelinohjelmointi/harjoitustyo/view/shopcart.php' >Ostoskori</a></li> |
			    <li style ="float: right"  ><a class = "btn" href="/~H9577/WWW-palvelinohjelmointi/harjoitustyo/view/register.php"> Register</a></li>
			    <li style ="float: right" ><a class = "btn" $url >$loginmark</a></li>			
			</ul>
		</nav>
HEADER;

?>

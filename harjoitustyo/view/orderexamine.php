<title>order examin</title>
<style>
<?php

 include ('/home/H9577/public_html/WWW-palvelinohjelmointi/harjoitustyo/css/shape.css');

include('/home/H9577/public_html/WWW-palvelinohjelmointi/harjoitustyo/view/footer.php');
include('/home/H9577/public_html/WWW-palvelinohjelmointi/harjoitustyo/BL/BLmain.php');
$bl = new BLmain();
 ?>
</style>
<html>
	<body>
		<header class="header">
			<h1>Tilauksen katselmointi </h1>
		</header>
		<div class=content>
		<div class=main>
			<h2>Toimitetut tuotteet</h2>
			<?php 
			if(isset($_GET['wantedId']) && isset($_GET['change']) && $_GET['change'] == "false"){ 
				$answer = 	$bl->GetWantedOrder(htmlspecialchars($_GET['wantedId']), "0");									
			}
			if(isset($_GET['wantedId']) && isset($_GET['change']) && $_GET['change'] == "true"){ 
				$answer = 	$bl->GetWantedOrder(htmlspecialchars($_GET['wantedId']), "1");
			}
			?>
			<a href="/~H9577/WWW-palvelinohjelmointi/harjoitustyo/view/workersmain.php" class= "btn">Takaisin</a>
		</div>
		</div>

</body>
</html>
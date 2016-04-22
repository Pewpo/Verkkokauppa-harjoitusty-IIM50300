<head>
<title>Category</title>
<link rel="stylesheet" type="text/css" href="css/shape.css">
</head>

<?php
session_start();
include ('BL/BLmain.php');
include ('BL/registration.php');
include('view/header.php');
include('view/footer.php');
echo $head;
?>
<div class=content>
	<div class=main>			
		<fieldset  class = 'fieldset' onclick="window.location.href='categories/kitchen.php'" ><h3 >Keittiö</h3></fieldset>
		<fieldset  	class = 'fieldset' onclick="window.location.href='categories/entertainment.php'"><h3>Viihde</h3></fieldset>
		<fieldset   class = 'fieldset'onclick="window.location.href='categories/garden.php'" ><h3>Puutarha</H3></fieldset>		
		<fieldset 	class = 'fieldset' onclick="window.location.href='categories/bedroom.php'"><h3>Makuuhuone</H3></fieldset>
		<fieldset  	class = 'fieldset' onclick="window.location.href='categories/livingroom.php'"><h3>Olohuone</H3></fieldset>
		<fieldset   class = 'fieldset' onclick="window.location.href='categories/home_appliance.php'"><h3>Kodinkoneet</H3></fieldset>
		<fieldset   class = 'fieldset' onclick="window.location.href='categories/sauna.php'"><h3>Sauna</H3></fieldset>
		<fieldset   class = 'fieldset' onclick="window.location.href='categories/outdoor.php'"><h3>Ulkoilu</H3></fieldset>			
	</div>
</div>		
<?php
echo $footer;

?>
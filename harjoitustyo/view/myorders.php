<head>
	<title>My Orders</title>
	<link rel="stylesheet" type="text/css" href="/~H9577/WWW-palvelinohjelmointi/harjoitustyo/css/shape.css">
</head>
<?php
session_start();

include ('/home/H9577/public_html/WWW-palvelinohjelmointi/harjoitustyo/BL/BLmain.php'); 
include('header.php');
include('footer.php');
echo $head;
$bl  = new BLmain();
if(isset($_GET['valuehelp'])){
	$value =  htmlspecialchars($_GET['valuehelp']);
	$returning = $bl->getMyOrders($value, 2);
}

$row = $returning->fetch(PDO::FETCH_ASSOC);
echo '<div class=content>
		<div class=main style="height:60%;">
		<hr>	

		<table style= "width:50%; float:left;" >
			<h3>Tilauksen tiedot</h3><br>
			<tr>
				<th>Tilauksen Id :</th><td><input  type="text"  size="30" value ="'.$row['TilausId'].'" readonly></td>
			</tr>
			<tr>
				<th>Tilauksen osoite :</th><td><input  type="text"  size="30" value ="'.$row['TilausOsoite'].'" readonly></td></tr>
			<tr>	
				<th>Tilauksen tila :</th><td><input  type="text"  size="30" value ="'.$row['TilausTila'].'" readonly></td>
			</tr>
			<tr>
				<th>Tilauksen postinro</th><td><input  type="text" size="30" value ="'.$row['TilausPostiNmro'].'" readonly></td></tr>
		</table>
				<div style = "float:right; width:40%; ">
		<select name="Orders" size="10" style="width:100%;" >';	
		while($row = $returning->fetch(PDO::FETCH_ASSOC)) {
	echo 	"<option>Tuote ID: {$row['TuoteId']}  | Tuotteen nimi : {$row['TuoteNimi']} | lkm:{$row['Lkm']} | hinta:{$row['TuoteHinta']} </option>";
			echo $row;
		}	
echo '	</select>	
		</div>				
		</div>
		<hr>
		<a  class = "btn"  href = "/~H9577/WWW-palvelinohjelmointi/harjoitustyo/view/profile.php"> Takaisin</a>
		</div>';

echo $footer;
?>
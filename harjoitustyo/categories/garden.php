<title>Garden products</title>
<style>
<?php 
session_start();
include ('/home/H9577/public_html/WWW-palvelinohjelmointi/harjoitustyo/css/shape.css'); ?>
</style>

<?php
	include('/home/H9577/public_html/WWW-palvelinohjelmointi/harjoitustyo/view/header.php');
	include('/home/H9577/public_html/WWW-palvelinohjelmointi/harjoitustyo/view/footer.php');
	include('/home/H9577/public_html/WWW-palvelinohjelmointi/harjoitustyo/BL/BLmain.php');
	$bl = new BLmain();
	echo $head;
	$bl->get_Products(8);
	echo $footer;
?>

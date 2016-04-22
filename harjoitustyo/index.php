<head>
<title>Mainpage</title>
<link rel="stylesheet" type="text/css" href="css/shape.css">
</head>

<?php
session_start();
include ('BL/registration.php');
include ('BL/BLmain.php');
include('view/header.php');
include('view/footer.php');
$lg = new Registeration();
echo $head;

echo '<div class=content>
		<div class=main>
			<h3>Paragraph</h3>
			<p>Ut wisi enim ad minim veniam, <a href="#">quis nostrud exerci tation ullamcorper</a> suscipit lobortis nisl ut aliquip ex ea commodo consequat. Duis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie consequat, vel illum dolore eu feugiat nulla facilisis at vero eros et accumsan et iusto odio dignissim qui blandit praesent luptatum zzril delenit augue duis dolore te feugait nulla facilisi. Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.</p>
			<p>Duis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie consequat, vel illum dolore eu feugiat nulla facilisis at vero eros et accumsan et iusto odio dignissim qui blandit praesent luptatum zzril delenit augue duis dolore te feugait nulla facilisi. Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat.</p>
			<hr>
			<h3>Responsive image</h3>
			<p><img class=img-responsive src="http://placehold.it/800x350" alt=""></p>
		</div>
		</div>
		';
echo $footer;
if(isset($_GET['logout']) == true){
	$lg->LogOut();
}
?>